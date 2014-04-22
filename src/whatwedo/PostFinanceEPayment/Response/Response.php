<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Response;

use DateTime;
use whatwedo\PostFinanceEPayment\Model\Brand;
use whatwedo\PostFinanceEPayment\Model\ErrorCode;
use whatwedo\PostFinanceEPayment\Model\Parameter;
use whatwedo\PostFinanceEPayment\Model\PaymentMethod;
use whatwedo\PostFinanceEPayment\Model\PaymentStatus;
use whatwedo\PostFinanceEPayment\Environment\Environment;
use whatwedo\PostFinanceEPayment\Exception\InvalidArgumentException;
use whatwedo\PostFinanceEPayment\Exception\NotValidSignatureException;


/**
 * handles the PostFinance response
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class Response
{
    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var string
     */
    protected $paymentMethod;

    /**
     * @var string
     */
    protected $acceptance;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var string
     */
    protected $cardNumber;

    /**
     * @var string
     */
    protected $paymentId;

    /**
     * @var string
     */
    protected $error;

    /**
     * @var string
     */
    protected $ip;

    /**
     * @var string
     */
    protected $brand;

    /**
     * @var string
     */
    protected $cardExpirationDate;

    /**
     * @var DateTime
     */
    protected $transactionDate;

    /**
     * @var string
     */
    protected $cardHolderName;

    /**
     * @param $parameters
     * @param Environment $environment
     * @param bool $skipSignature skip signature check true / false
     * @return Response
     * @throws InvalidArgumentException
     * @throws NotValidSignatureException
     */
    public static function create($parameters, Environment $environment, $skipSignature = false)
    {
        $response = new Response();

        $parameters = array_change_key_case($parameters, CASE_UPPER);

        $missing = array_diff(Parameter::$requiredPostSaleParameters, array_keys($parameters));

        if (count($missing) > 0) {
            throw new InvalidArgumentException(sprintf(
                "Missing parameter(s) %s of PostFinance post-sale response",
                implode(", ", $missing)
            ));
        }

        if (!$skipSignature) {
            $string = "";
            $p = Parameter::$postSaleParameters;
            sort($p);
            foreach($p as $key)
            {
                if ($key === Parameter::SIGNATURE
                    || !isset($parameters[$key])
                    || $parameters[$key] === "") {
                    continue;
                }

                $string .= sprintf("%s=%s%s", $key, $parameters[$key], $environment->getShaOut());
            }

            if (strtoupper(hash($environment->getHashAlgorithm(), $string)) !== $parameters[Parameter::SIGNATURE]) {
                throw new NotValidSignatureException();
            }
        }

        $response->setOrderId($parameters[Parameter::ORDER_ID])
            ->setAmount($parameters[Parameter::AMOUNT])
            ->setCurrency($parameters[Parameter::CURRENCY])
            ->setAcceptance($parameters[Parameter::ACCEPTANCE])
            ->setStatus($parameters[Parameter::STATUS])
            ->setCardNumber($parameters[Parameter::CARD_NUMBER])
            ->setPaymentId($parameters[Parameter::PAYMENT_ID])
            ->setError($parameters[Parameter::NC_ERROR])
            ->setCardExpirationDate($parameters[Parameter::EXPIRATION_DATE])
            ->setTransactionDate(\DateTime::createFromFormat("m/d/Y", $parameters[Parameter::TRANSACTION_DATE]))
            ->setCardHolderName($parameters[Parameter::CARD_HOLDER])
            ->setIp($parameters[Parameter::IP]);

        switch($parameters['PM']) {
            case "CreditCard":
                $response->setPaymentMethod(PaymentMethod::CREDITCARD);
                switch($parameters['BRAND']) {
                    case "MasterCard":
                        $response->setBrand(Brand::MASTERCARD);
                        break;
                    case "Visa":
                        $response->setBrand(Brand::VISA);
                        break;
                }
                break;
            case "PostFinance e-finance":
                $response->setPaymentMethod(PaymentMethod::POSTFINANCE_EFINANCE);
                $response->setBrand(Brand::POSTFINANCE_EFINANCE);
                break;
            case "PostFinance Card":
                $response->setPaymentMethod(PaymentMethod::POSTFINANCE_CARD);
                $response->setBrand(Brand::POSTFINANCE_CARD);
                break;
        }
        ;

        return $response;
    }

    /**
     * @param string $orderId
     * @return Response
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param float $amount
     * @return Response
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $currency
     * @return Response
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $paymentMethod
     * @return Response
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $acceptance
     * @return Response
     */
    public function setAcceptance($acceptance)
    {
        $this->acceptance = $acceptance;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcceptance()
    {
        return $this->acceptance;
    }

    /**
     * @param integer $status
     * @return Response
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $cardNumber
     * @return Response
     */
    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    /**
     * @param string $cardExpirationDate
     * @return Response
     */
    public function setCardExpirationDate($cardExpirationDate)
    {
        $this->cardExpirationDate = $cardExpirationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardExpirationDate()
    {
        return $this->cardExpirationDate;
    }

    /**
     * @param string $paymentId
     * @return Response
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param string $error
     * @return Response
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        if (!empty($this->error)) {
            if (isset(ErrorCode::$codes[$this->error])) {
                return sprintf("%s (%s)", ErrorCode::$codes[$this->error], $this->error);
            } else {
                return $this->error;
            }
        } elseif (!empty($this->status)) {
            if (isset(PaymentStatus::$codes[$this->status])) {
                return sprintf("%s (%s)", PaymentStatus::$codes[$this->status], $this->status);
            } else {
                return $this->status;
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function isRetryError()
    {
        return ErrorCode::isRetryCode($this->error);
    }

    /**
     * @return bool
     */
    public function hasError()
    {
        if ($this->getStatus() === PaymentStatus::SUCCESS) {
            return false;
        }
        return true;
    }

    /**
     * @param string $ip
     * @return Response
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $brand
     * @return Response
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param string $transactionDate
     * @return Response
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * @param string $cardHolderName
     * @return Response
     */
    public function setCardHolderName($cardHolderName)
    {
        $this->cardHolderName = $cardHolderName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCardHolderName()
    {
        return $this->cardHolderName;
    }
}