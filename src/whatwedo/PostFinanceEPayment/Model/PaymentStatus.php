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
 * payment status codes (see «Technical information concerning payment management» in PostFinance Back-Office)
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
final class PaymentStatus
{
    const INCOMPLETE = 1;
    const DECLINED = 2;
    const SUCCESS = 5;

    /**
     * @var array
     */
    public static $codes = array(
        0   => "Invalid or incomplete",
        1   => "Cancelled by customer",
        2   => "Authorisation declined",

        4   => "Order stored",
        40  => "Stored waiting external result",
        41  => "Waiting for client payment",

        5   => "Authorised",
        50  => "Authorized waiting external result",
        51  => "Authorisation waiting",
        52  => "Authorisation not known",
        55  => "Standby",
        56  => "OK with scheduled payments",
        57  => "Not OK with scheduled payments",
        59  => "Authorisation to be requested manually",

        6   => "Authorised and cancelled",
        61  => "Authorisation deletion waiting",
        62  => "Authorisation deletion uncertain",
        63  => "Authorisation deletion refused",
        64  => "Authorised and cancelled",

        7   => "Payment deleted",
        71  => "Payment deletion pending",
        72  => "Payment deletion uncertain",
        73  => "Payment deletion refused",
        74  => "Payment deleted",
        75  => "Deletion handled by merchant",

        8   => "Refund",
        81  => "Refund pending",
        82  => "Refund uncertain",
        83  => "Refund refused",
        84  => "Refund",
        85  => "Refund handled by merchant",

        9   => "Payment requested",
        91  => "Payment processing",
        92  => "Payment uncertain",
        93  => "Payment refused",
        94  => "Refund declined by the acquirer",
        95  => "Payment handled by merchant",
        96  => "Refund reversed",
        99  => "Being processed",
    );
}