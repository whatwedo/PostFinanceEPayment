<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Environment;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class ProductionEnvironment extends Environment
{
    const BASE_URL = "https://e-payment.postfinance.ch/ncol/prod";

    /**
     * {@inheritdoc}
     */
    public static function getGatewayUrl()
    {
        switch (self::$charset) {
            case self::CHARSET_UTF_8:
                return self::BASE_URL . "/orderstandard_utf8.asp";

            default:
                return self::BASE_URL . "/orderstandard.asp";
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDirectLinkMaintenanceUrl()
    {
        return self::BASE_URL . "/maintenancedirect.asp";
    }
}