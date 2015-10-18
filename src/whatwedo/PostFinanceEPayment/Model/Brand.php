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
 * Payment method brands.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class Brand
{
    // credit cards
    const VISA = 'Visa';
    const MASTERCARD = 'MasterCard';

    // post finance
    const POSTFINANCE_EFINANCE = 'PostFinance e-finance';
    const POSTFINANCE_CARD = 'PostFinance Card';

    // others (or not yet implemented)
    const UNKNOWN = 'Unknown';
}
