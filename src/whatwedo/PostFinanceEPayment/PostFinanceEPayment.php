<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment;

use whatwedo\PostFinanceEPayment\Bag\ParameterBag;
use whatwedo\PostFinanceEPayment\Client\ClientInterface;
use whatwedo\PostFinanceEPayment\Environment\Environment;
use whatwedo\PostFinanceEPayment\Order\OrderInterface;
use whatwedo\PostFinanceEPayment\Payment\Payment;
use whatwedo\PostFinanceEPayment\Response\Response;

/**
 * PostFinance E-Payment PHP library
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class PostFinanceEPayment 
{
    const POSTFINANCE_VERSION = 04.101;

    /**
     * @var null|Environment
     */
    protected $environment = null;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment &$environment)
    {
        $this->environment = $environment;
    }

    /**
     * create a new payment request
     * @param ClientInterface $client
     * @param OrderInterface  $order
     * @param array           $additionalParameters
     * @return Payment
     */
    public function createPayment(ClientInterface $client, OrderInterface $order, $additionalParameters = [])
    {
        $parameterBag = new ParameterBag($additionalParameters);

        return new Payment($client, $order, $parameterBag, $this->environment);
    }

    /**
     * parses PostFinance response
     * @param array|null $parameters
     * @param bool $skipSignature skip signature check?
     * @return Response
     */
    public function getResponse($parameters = null, $skipSignature = false)
    {
        if (null === $parameters) {
            $parameters = $_GET;
        }

        return Response::create($parameters, $this->environment, $skipSignature);
    }
}