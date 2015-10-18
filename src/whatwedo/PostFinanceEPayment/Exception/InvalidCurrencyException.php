<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Exception;

use whatwedo\PostFinanceEPayment\Environment\Environment;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class InvalidCurrencyException extends InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($inputCurrency, $allowedCurrencies = null)
    {
        if (null === $allowedCurrencies) {
            $allowedCurrencies = Environment::$ALLOWED_CURRENCIES;
        }

        parent::__construct(sprintf(
                'Invalid currency given (%s), allowed: %s',
                $inputCurrency,
                implode(', ', $allowedCurrencies)
            ));
    }
}
