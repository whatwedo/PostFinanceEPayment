<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Order;

use whatwedo\PostFinanceEPayment\Environment\Environment;
use whatwedo\PostFinanceEPayment\Exception\InvalidCurrencyException;

/**
 * implementation of OrderInterface.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
abstract class AbstractOrder implements OrderInterface
{
    /**
     * @var string unique order id
     */
    protected $id;

    /**
     * @var float amount
     */
    protected $amount = 0;

    /**
     * @var string currency
     */
    protected $currency = 'CHF';

    /**
     * @var string short order description (f.ex «three telephone numbers»)
     */
    protected $orderText = null;

    /**
     * @param string $id
     *
     * @return AbstractOrder
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param float $amount
     *
     * @return AbstractOrder
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function getIntegerAmount()
    {
        return $this->amount * 100;
    }

    /**
     * @param string $currency
     *
     * @throws InvalidCurrencyException
     *
     * @return AbstractOrder
     */
    public function setCurrency($currency)
    {
        $currency = strtoupper($currency);

        if (!in_array($currency, Environment::$ALLOWED_CURRENCIES)) {
            throw new InvalidCurrencyException($currency);
        }

        $this->currency = $currency;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $orderText
     *
     * @return AbstractOrder
     */
    public function setOrderText($orderText)
    {
        $this->orderText = $orderText;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderText()
    {
        return $this->orderText;
    }
}
