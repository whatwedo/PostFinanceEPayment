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
 * PostFinance parameters (most used parameters)
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
final class Parameter
{
    // PostFinance configuration
    const PSPID                     = "PSPID";
    const SIGNATURE                 = "SHASIGN";
    const SIGNATURE_DATE            = "SIGNDATE";
    const MANDATE_ID                = "MANDATEID";

    // Money
    const AMOUNT                    = "AMOUNT";
    const CURRENCY                  = "CURRENCY";

    // Order
    const ORDER_ID                  = "ORDERID";
    const ORDER_TEXT                = "COM";
    const COMPLUS                   = "COMPLUS";
    const PARAMPLUS                 = "PARAMPLUS";

    // Client
    const LANGUAGE                  = "LANGUAGE";
    const CLIENT_ID                 = "USERID";
    const CLIENT_NAME               = "CN";
    const CLIENT_EMAIL              = "EMAIL";
    const CLIENT_ADDRESS            = "OWNERADDRESS";
    const CLIENT_TOWN               = "OWNERTOWN";
    const CLIENT_COUNTRY            = "OWNERCTY";
    const CLIENT_TEL                = "OWNERTELNO";
    const IP_COUNTRY                = "IPCTY";
    const IP                        = "IP";

    // URL's
    const HOME_URL                  = "HOMEURL";
    const CATALOG_URL               = "CATALOGURL";
    const ACCEPT_URL                = "ACCEPTURL";
    const DECLINE_URL               = "DECLINEURL";
    const EXCEPTION_URL             = "EXCEPTIONURL";
    const CANCEL_URL                = "CANCELURL";

    // Design
    const TEMPLATE_URL              = "TP";

    // Adress
    const AAV_CHECK                 = "AAVCHECK";
    const AAV_ADDRESS               = "AAVADDRESS";
    const AAV_NAME                  = "AAVNAME";
    const AAV_ZIP                   = "AAVZIP";
    const AAV_MAIL                  = "AAVMAIL";
    const AAV_PHONE                 = "AAVPHONE";

    // Status
    const ACCEPTANCE                = "ACCEPTANCE";
    const NC_ERROR                  = "NCERROR";
    const NC_ERROR_PLUS             = "NCERRORPLUS";
    const NC_STATUS                 = "NCSTATUS";
    const STATUS                    = "STATUS";
    const ECI                       = "ECI";

    // Bank / Card
    const ALIAS                     = "ALIAS";
    const BIC                       = "BIC";
    const CARD_BIN                  = "BIN";
    const CARD_BRAND                = "BRAND";
    const CARD_BRAND_SUB            = "BRANDSUB";
    const CARD_COUNTRY              = "CCCTY";
    const CARD_HOLDER               = "CN";
    const CARD_NUMBER               = "CARDNO";
    const CARD_VIRTUAL              = "VC";
    const CVC_CHECK                 = "CVCCHECK";
    const DIGEST_CARD_NUMBER        = "DIGESTCARDNO";
    const EXPIRATION_DATE           = "ED";

    // eDCC
    const DCC_COMMPERCENTAGE        = "DCC_COMMPERCENTAGE";
    const DCC_CONVAMOUNT            = "DCC_CONVAMOUNT";
    const DCC_CONVCCY               = "DCC_CONVCCY";
    const DCC_EXCHRATE              = "DCC_EXCHRATE";
    const DCC_EXCHRATESOURCE        = "DCC_EXCHRATESOURCE";
    const DCC_EXCHRATETS            = "DCC_EXCHRATETS";
    const DCC_INDICATOR             = "DCC_INDICATOR";
    const DCC_MARGINPERCENTAGE      = "DCC_MARGINPERCENTAGE";
    const DCC_VALIDHOURS            = "DCC_VALIDHOURS";
    const HTML_ANSWER               = "HTML_ANSWER";

    // Direct Debit NL
    const SEQUENCE_TYPE             = "SEQUENCETYPE";

    // Payment
    const PAYMENT_ID                = "PAYID";
    const PAYMENT_ID_SUB            = "PAYIDSUB";
    const PAYMENT_METHOD            = "PM";
    const SCORING                   = "SCORING";
    const SCORING_CATEGORY          = "SCO_CATERY";
    const TRANSACTION_DATE          = "TRXDATE";

    // Subscription
    const SUBSCRIPTION_ID           = "SUBSCRIPTION_ID";

    /**
     * @var array Post-Sale parameters used to create Signature
     */
    public static $postSaleParameters = array(
        self::AAV_ADDRESS,
        self::AAV_CHECK,
        self::AAV_MAIL,
        self::AAV_NAME,
        self::AAV_PHONE,
        self::AAV_ZIP,
        self::ACCEPTANCE,
        self::ALIAS,
        self::AMOUNT,
        self::BIC,
        self::CARD_BIN,
        self::CARD_BRAND,
        self::CARD_NUMBER,
        self::CARD_COUNTRY,
        self::CARD_HOLDER,
        self::COMPLUS,
        self::CURRENCY,
        self::CVC_CHECK,
        self::DCC_COMMPERCENTAGE,
        self::DCC_CONVAMOUNT,
        self::DCC_CONVCCY,
        self::DCC_EXCHRATE,
        self::DCC_EXCHRATESOURCE,
        self::DCC_EXCHRATETS,
        self::DCC_INDICATOR,
        self::DCC_MARGINPERCENTAGE,
        self::DCC_VALIDHOURS,
        self::DIGEST_CARD_NUMBER,
        self::ECI,
        self::EXPIRATION_DATE,
        self::IP,
        self::IP_COUNTRY,
        self::NC_ERROR,
        self::NC_ERROR_PLUS,
        self::ORDER_ID,
        self::PAYMENT_ID,
        self::PAYMENT_ID_SUB,
        self::PAYMENT_METHOD,
        self::SCORING_CATEGORY,
        self::SCORING,
        self::STATUS,
        self::CARD_BRAND_SUB,
        self::SUBSCRIPTION_ID,
        self::TRANSACTION_DATE,
        self::CARD_VIRTUAL,
    );

    /**
     * @var array required Post-Sale parameters to create our Response-object
     */
    public static $requiredPostSaleParameters = array(
        self::ORDER_ID,
        self::AMOUNT,
        self::CURRENCY,
        self::PAYMENT_METHOD,
        self::ACCEPTANCE,
        self::STATUS,
        self::CARD_NUMBER,
        self::PAYMENT_ID,
        self::NC_ERROR,
        self::CARD_BRAND,
        self::TRANSACTION_DATE,
        self::CARD_HOLDER,
        self::SIGNATURE,
        self::IP
    );
}