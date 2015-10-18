<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Model;

/**
 * Payment methods.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class PaymentMethod
{
    const CREDITCARD = 'CreditCard';
    const POSTFINANCE_EFINANCE = 'PostFinance e-finance';
    const POSTFINANCE_CARD = 'PostFinance Card';
    const UNKNOWN = 'Unknown';
}
