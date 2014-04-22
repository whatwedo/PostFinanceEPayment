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

use Exception;


/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class NotValidSignatureException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        if (empty($message)) {
            $message = "PostFinance signature does not match";
        }
        parent::__construct($message, $code, $previous);
    }

} 