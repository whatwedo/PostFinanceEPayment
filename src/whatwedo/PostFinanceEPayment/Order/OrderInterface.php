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

/**
 * contains all information of an order
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
interface OrderInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return float
     */
    public function getAmount();

    /**
     * @return integer amount multiplied by 100 (to avoid problems with decimal point)
     */
    public function getIntegerAmount();


    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @return string
     */
    public function getOrderText();
}