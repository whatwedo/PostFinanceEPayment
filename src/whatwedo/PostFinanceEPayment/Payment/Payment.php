<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Payment;

use whatwedo\PostFinanceEPayment\Bag\ParameterBag;
use whatwedo\PostFinanceEPayment\Client\ClientInterface;
use whatwedo\PostFinanceEPayment\Environment\Environment;
use whatwedo\PostFinanceEPayment\Form\Form;
use whatwedo\PostFinanceEPayment\Order\OrderInterface;
use whatwedo\PostFinanceEPayment\Model\Parameter;

/**
 * creates a payment request.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class Payment
{
    /**
     * @var ParameterBag Payment parameters
     */
    protected $parameters;

    /**
     * @var ClientInterface|null
     */
    protected $client = null;

    /**
     * @var OrderInterface|null
     */
    protected $order = null;

    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param ClientInterface $client
     * @param OrderInterface  $order
     * @param ParameterBag    $parameterBag
     * @param Environment     $environment
     */
    public function __construct(
        ClientInterface &$client,
        OrderInterface &$order,
        ParameterBag $parameterBag,
        Environment &$environment
    ) {
        $this->parameters = $parameterBag;
        $this->client = $client;
        $this->order = $order;
        $this->environment = $environment;

        $this->buildParameters();
    }

    protected function buildParameters()
    {
        // PostFinance configuration
        $this->parameters->add(Parameter::PSPID,            $this->environment->getPSPID());

        // payment
        $this->parameters->add(Parameter::AMOUNT,           $this->order->getIntegerAmount());
        $this->parameters->add(Parameter::CURRENCY,         $this->order->getCurrency());

        // order
        $this->parameters->add(Parameter::ORDER_ID,         $this->order->getId());
        $this->parameters->add(Parameter::ORDER_TEXT,       $this->order->getOrderText());

        // client information for fraud prevention and appearance
        $this->parameters->add(Parameter::LANGUAGE,         $this->client->getLocale());
        $this->parameters->add(Parameter::CLIENT_NAME,      $this->client->getName());
        $this->parameters->add(Parameter::CLIENT_ADDRESS,   $this->client->getAddress());
        $this->parameters->add(Parameter::CLIENT_TOWN,      $this->client->getTown());
        $this->parameters->add(Parameter::CLIENT_TEL,       $this->client->getTel());
        $this->parameters->add(Parameter::CLIENT_COUNTRY,   $this->client->getCountry());
        $this->parameters->add(Parameter::CLIENT_NAME,      $this->client->getName());

        // URL's
        $this->parameters->add(Parameter::HOME_URL,         $this->environment->getHomeUrl());
        $this->parameters->add(Parameter::CATALOG_URL,      $this->environment->getCatalogUrl());
        $this->parameters->add(Parameter::ACCEPT_URL,       $this->environment->getAcceptUrl());
        $this->parameters->add(Parameter::DECLINE_URL,      $this->environment->getDeclineUrl());
        $this->parameters->add(Parameter::EXCEPTION_URL,    $this->environment->getExceptionUrl());
        $this->parameters->add(Parameter::CANCEL_URL,       $this->environment->getCancelUrl());

        // Design
        $this->parameters->add(Parameter::TEMPLATE_URL,     $this->environment->getTemplateUrl());
    }

    /**
     * adds sha signature to the parameters.
     *
     * @return $this
     */
    protected function addSignature()
    {
        $parameters = $this->parameters->getAll();
        ksort($parameters);
        $string = '';

        foreach ($parameters as $key => $value) {
            $string .= sprintf('%s=%s%s', $key, $value, $this->environment->getShaIn());
        }

        $this->parameters->add(Parameter::SIGNATURE, strtoupper(hash($this->environment->getHashAlgorithm(), $string)));

        return $this;
    }

    /**
     * finalizes the parameters.
     *
     * @return $this
     */
    private function finalizeParameters()
    {
        if (!$this->parameters->has(Parameter::SIGNATURE)) {
            $this->addSignature(); // adds the hashed signature
        }

        return $this;
    }

    /**
     * gets all form data for the checkout process.
     *
     * @return Form
     */
    public function getForm()
    {
        $this->finalizeParameters();

        $form = new Form();
        $form->setAction($this->environment->getGatewayUrl());
        $form->setMethod(Form::METHOD_POST);
        $form->setHiddenFields($this->parameters->getAll());

        return $form;
    }

    /**
     * returns an URL for a GET request to the payment process.
     *
     * @return string
     */
    public function getUrl()
    {
        $this->finalizeParameters();

        return sprintf('%s?%s',
            $this->environment->getGatewayUrl(),
            http_build_query($this->parameters->getAll())
        );
    }

    /**
     * @return ParameterBag
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }
}
