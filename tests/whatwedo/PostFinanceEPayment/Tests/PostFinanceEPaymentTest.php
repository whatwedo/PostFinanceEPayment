<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Tests;

use Faker\Factory;
use Faker\Generator;
use whatwedo\PostFinanceEPayment\Client\Client;
use whatwedo\PostFinanceEPayment\Environment\Environment;
use whatwedo\PostFinanceEPayment\Environment\TestEnvironment;
use whatwedo\PostFinanceEPayment\Model\Brand;
use whatwedo\PostFinanceEPayment\Model\Parameter;
use whatwedo\PostFinanceEPayment\Model\PaymentMethod;
use whatwedo\PostFinanceEPayment\Model\PaymentStatus;
use whatwedo\PostFinanceEPayment\Order\Order;
use whatwedo\PostFinanceEPayment\Payment\Payment;
use whatwedo\PostFinanceEPayment\PostFinanceEPayment;
use whatwedo\PostFinanceEPayment\Response\Response;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class PostFinanceEPaymentTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @var Generator
     */
    protected $faker;

    protected function setUp()
    {
        $this->environment = new TestEnvironment(
            'phpunitTEST',
            'ABCD*_/1234',
            'ABCD*_/1234'
        );

        $this->faker = Factory::create();
    }

    public function testFormBuilder()
    {
        $payment = $this->getRandomPayment();
        $order = $payment->getOrder();
        $client = $payment->getClient();

        $form = $payment->getForm();

        $this->assertEquals($this->environment->getGatewayUrl(), $form->getAction());
        $this->assertEquals('post', $form->getMethod());

        $fields = $form->getHiddenFields();

        $this->assertEquals($fields[Parameter::PSPID], $this->environment->getPSPID());

        $this->assertEquals($fields[Parameter::ORDER_ID], $order->getId());
        $this->assertEquals($fields[Parameter::AMOUNT], $order->getIntegerAmount());
        $this->assertEquals($fields[Parameter::CURRENCY], $order->getCurrency());
        $this->assertEquals($fields[Parameter::ORDER_TEXT], $order->getOrderText());

        $this->assertEquals($fields[Parameter::LANGUAGE], $client->getLocale());
        $this->assertEquals($fields[Parameter::CARD_HOLDER], $client->getName());
        $this->assertEquals($fields[Parameter::CLIENT_ADDRESS], $client->getAddress());
        $this->assertEquals($fields[Parameter::CLIENT_TOWN], $client->getTown());
        $this->assertEquals($fields[Parameter::CLIENT_TEL], $client->getTel());
        $this->assertEquals($fields[Parameter::CLIENT_COUNTRY], $client->getCountry());
        $this->assertEquals($fields[Parameter::CLIENT_EMAIL], $client->getEmail());
    }

    public function testSignature()
    {
        foreach (Environment::$ALLOWED_HASHES as $hash) {
            $this->environment->setHashAlgorithm($hash);

            $payment = $this->getRandomPayment();
            $parameters = $payment->getParameters()->getAll();

            $fields = $payment->getForm()->getHiddenFields();

            $hash = $this->createHash(
                $parameters,
                $this->environment->getShaIn(),
                $this->environment->getHashAlgorithm()
            );

            $this->assertEquals($fields[Parameter::SIGNATURE], $hash);

            // if getForm() is triggered twice, the signature should be the same
            // @see https://github.com/whatwedo/PostFinanceEPayment/pull/6
            $fields = $payment->getForm()->getHiddenFields();
            $this->assertEquals($fields[Parameter::SIGNATURE], $hash);
        }
    }

    public function testResponse()
    {
        foreach (array(PaymentStatus::SUCCESS, PaymentStatus::DECLINED, PaymentStatus::INCOMPLETE) as $status) {
            $response = array(
                'orderID' => $this->faker->randomNumber(4),
                'currency' => 'CHF',
                'amount' => $this->faker->randomFloat(2, 1, 100),
                'PM' => $this->faker->randomElement(array(
                            PaymentMethod::POSTFINANCE_EFINANCE,
                            PaymentMethod::CREDITCARD,
                            PaymentMethod::POSTFINANCE_CARD,
                        )),
                'ACCEPTANCE' => 'test123',
                'STATUS' => $status,
                'CARDNO' => 'XXXXXXXXXXXX'.$this->faker->randomNumber(4),
                'ED' => $this->faker->numberBetween(10, 12).$this->faker->numberBetween(10, 99),
                'CN' => $this->faker->name,
                'TRXDATE' => $this->faker->date('m/d/Y'),
                'PAYID' => $this->faker->randomNumber(8),
                'IPCTY' => $this->faker->countryCode,
                'CCCTY' => $this->faker->countryCode,
                'ECI' => '5',
                'CVCCheck' => 'NO',
                'AAVCheck' => 'NO',
                'VC' => 'NO',
                'IP' => $this->faker->ipv4,
                'NCERROR' => '0',
            );

            if ($response['PM'] === PaymentMethod::CREDITCARD) {
                $response['BRAND'] = $this->faker->randomElement(array(
                        Brand::MASTERCARD,
                        Brand::VISA,
                    ));
            } elseif ($response['PM'] === PaymentMethod::POSTFINANCE_CARD) {
                $response['BRAND'] = PaymentMethod::POSTFINANCE_CARD;
            } elseif ($response['PM'] === PaymentMethod::POSTFINANCE_EFINANCE) {
                $response['BRAND'] = PaymentMethod::POSTFINANCE_EFINANCE;
            }

            $response['SHASIGN'] = $this->createHash(
                $response,
                $this->environment->getShaOut(),
                $this->environment->getHashAlgorithm()
            );

            $ePayment = new PostFinanceEPayment($this->environment);
            $response = $ePayment->getResponse($response);

            $this->assertTrue($response instanceof Response);

            if ($status === PaymentStatus::SUCCESS) {
                $this->assertFalse($response->hasError());
            } else {
                $this->assertTrue($response->hasError());
            }
        }
    }

    /**
     * @param $parameters
     * @param $secret
     * @param $algorithm
     *
     * @return string
     */
    protected function createHash($parameters, $secret, $algorithm)
    {
        $parameters = array_change_key_case($parameters, CASE_UPPER);
        ksort($parameters);
        $string = '';

        foreach ($parameters as $key => $value) {
            $string .= sprintf('%s=%s%s', $key, $value, $secret);
        }

        //echo $string;

        return strtoupper(hash($algorithm, $string));
    }

    /**
     * @return Payment
     */
    public function getRandomPayment()
    {
        $ePayment = new PostFinanceEPayment($this->environment);

        $client = $this->getRandomClient();
        $order = $this->getRandomOrder();

        return $ePayment->createPayment($client, $order);
    }

    /**
     * @return Client
     */
    protected function getRandomClient()
    {
        $client = new Client();
        $client->setId($this->faker->numerify('####'))
            ->setName($this->faker->name)
            ->setAddress(sprintf('%s %s', $this->faker->streetName, $this->faker->numerify('##')))
            ->setTown(sprintf('%s %s', $this->faker->postcode, $this->faker->city))
            ->setCountry('CH')
            ->setTel($this->faker->phoneNumber)
            ->setEmail($this->faker->email)
            ->setLocale($this->faker->randomElement(array(
                        'de_DE',
                        'de_CH',
                        'fr_FR',
                        'it_IT',
                    )));

        return $client;
    }

    /**
     * @return Order
     */
    protected function getRandomOrder()
    {
        $order = new Order();
        $order->setId($this->faker->numerify('####'))
            ->setAmount($this->faker->randomFloat(2, 1, 100))
            ->setCurrency('CHF')
            ->setOrderText($this->faker->sentence(4));

        return $order;
    }
}
