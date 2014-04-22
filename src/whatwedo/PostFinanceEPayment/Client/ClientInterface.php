<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Client;

/**
 * contains all necessary things of a client
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
interface ClientInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @return string
     */
    public function getAddress();

    /**
     * @return string
     */
    public function getTown();

    /**
     * @return string
     */
    public function getTel();

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @return string
     */
    public function getLocale();
} 