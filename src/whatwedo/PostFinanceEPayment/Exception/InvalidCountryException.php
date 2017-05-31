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

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class InvalidCountryException extends InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($inputCountry, $allowedCountries = null)
    {
        parent::__construct(sprintf(
                'Invalid country given (%s), must be an ISO-3166 Alpha 2 acronym',
                $inputCountry
            ));
    }
}
