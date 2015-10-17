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

use whatwedo\PostFinanceEPayment\Exception\InvalidArgumentException;

/**
 * system-specific things for the PostFinance API
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
abstract class Environment implements EnvironmentInterface
{
    const HASH_SHA1 = "sha1";
    const HASH_SHA256 = "sha256";
    const HASH_SHA512 = "sha512";

    const CHARSET_ISO_8859_1 = "iso_8859-1";
    const CHARSET_UTF_8 = "utf-8";

    /**
     * @var string|null
     */
    protected $pspid = null;

    /**
     * @var string hashing method
     */
    protected $hashAlgorithm = self::HASH_SHA1;

    /**
     * @var string|null
     */
    protected $shaIn = null;

    /**
     * @var string|null
     */
    protected $shaOut = null;

    /**
     * @var string client charset
     */
    protected static $CHARSET = self::CHARSET_ISO_8859_1;

    /**
     * @var string|null
     */
    protected $homeUrl = null;

    /**
     * @var string|null
     */
    protected $catalogUrl = null;

    /**
     * @var string|null
     */
    protected $acceptUrl = null;

    /**
     * @var string|null
     */
    protected $declineUrl = null;

    /**
     * @var string|null
     */
    protected $exceptionUrl = null;

    /**
     * @var string|null
     */
    protected $cancelUrl = null;

    /**
     * @var string|null
     */
    protected $templateUrl = null;

    /**
     * @var array allowed currencies based on PostFinance E-Payment
     */
    public static $ALLOWED_CURRENCIES = array(
        'AED',
        'ANG',
        'ARS',
        'AUD',
        'AWG',
        'BGN',
        'BRL',
        'BYR',
        'CAD',
        'CHF',
        'CNY',
        'CZK',
        'DKK',
        'EEK',
        'EGP',
        'EUR',
        'GBP',
        'GEL',
        'HKD',
        'HRK',
        'HUF',
        'ILS',
        'ISK',
        'JPY',
        'KRW',
        'LTL',
        'LVL',
        'MAD',
        'MXN',
        'NOK',
        'NZD',
        'PLN',
        'RON',
        'RUB',
        'SEK',
        'SGD',
        'SKK',
        'THB',
        'TRY',
        'UAH',
        'USD',
        'XAF',
        'XOF',
        'XPF',
        'ZAR'
    );

    /**
     * @var array allowed hashs for sha-in and sha-out
     */
    public static $ALLOWED_HASHES = array(
        self::HASH_SHA1,
        self::HASH_SHA256,
        self::HASH_SHA512,
    );

    /**
     * @var array allowed charsets
     */
    public static $ALLOWED_CHARSETS = array(
        self::CHARSET_ISO_8859_1,
        self::CHARSET_UTF_8,
    );

    public function __construct($pspid, $shaIn, $shaOut)
    {
        $this->setPSPID($pspid);
        $this->setShaIn($shaIn);
        $this->setShaOut($shaOut);
    }

    /**
     * {@inheritdoc}
     */
    public static function getGatewayUrl()
    {
        switch (static::$CHARSET) {
            case static::CHARSET_UTF_8:
                return static::BASE_URL . "/orderstandard_utf8.asp";

            default:
                return static::BASE_URL . "/orderstandard.asp";
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getDirectLinkMaintenanceUrl()
    {
        return static::BASE_URL . "/maintenancedirect.asp";
    }

    /**
     * @param string $pspid
     * @return Environment
     */
    public function setPSPID($pspid)
    {
        $this->pspid = $pspid;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPSPID()
    {
        return $this->pspid;
    }

    /**
     * @param null $shaIn
     * @return Environment
     */
    public function setShaIn($shaIn)
    {
        $this->shaIn = $shaIn;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShaIn()
    {
        return $this->shaIn;
    }

    /**
     * @param null $shaOut
     * @return Environment
     */
    public function setShaOut($shaOut)
    {
        $this->shaOut = $shaOut;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getShaOut()
    {
        return $this->shaOut;
    }

    /**
     * Set charset
     *
     * @param string $charset
     */
    public function setCharset($charset)
    {
        if (!in_array($charset, self::$ALLOWED_CHARSETS)) {
            throw new InvalidArgumentException(sprintf(
                "Invalid charset specified (%s), allowed: %s",
                $charset,
                implode(", ", self::ALLOWED_CHARSETS)
            ));
        }
        self::$CHARSET = $charset;

        return $this;
    }

    /**
     * Get charset
     *
     * @return string
     */
    public function getCharset()
    {
        return self::$CHARSET;
    }

    /**
     * @param null|string $homeUrl
     * @return Environment
     */
    public function setHomeUrl($homeUrl)
    {
        $this->homeUrl = $homeUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getHomeUrl()
    {
        return $this->homeUrl;
    }

    /**
     * @param null|string $acceptUrl
     * @return Environment
     */
    public function setAcceptUrl($acceptUrl)
    {
        $this->acceptUrl = $acceptUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getAcceptUrl()
    {
        return $this->acceptUrl;
    }

    /**
     * @param null|string $cancelUrl
     * @return Environment
     */
    public function setCancelUrl($cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCancelUrl()
    {
        return $this->cancelUrl;
    }

    /**
     * @param null|string $catalogUrl
     * @return Environment
     */
    public function setCatalogUrl($catalogUrl)
    {
        $this->catalogUrl = $catalogUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCatalogUrl()
    {
        return $this->catalogUrl;
    }

    /**
     * @param null|string $declineUrl
     * @return Environment
     */
    public function setDeclineUrl($declineUrl)
    {
        $this->declineUrl = $declineUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDeclineUrl()
    {
        return $this->declineUrl;
    }

    /**
     * @param null|string $exceptionUrl
     * @return Environment
     */
    public function setExceptionUrl($exceptionUrl)
    {
        $this->exceptionUrl = $exceptionUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExceptionUrl()
    {
        return $this->exceptionUrl;
    }

    /**
     * @param null|string $templateUrl
     * @return Environment
     */
    public function setTemplateUrl($templateUrl)
    {
        $this->templateUrl = $templateUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTemplateUrl()
    {
        return $this->templateUrl;
    }

    /**
     * @param $hash
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setHashAlgorithm($hash)
    {
        if (!in_array($hash, self::$ALLOWED_HASHES)) {
            throw new InvalidArgumentException(sprintf(
                "Invalid hash method specified (%s), allowed: %s",
                $hash,
                implode(", ", self::$ALLOWED_HASHES)
            ));
        }

        $this->hashAlgorithm = $hash;

        return $this;
    }

    /**
     * @return string
     */
    public function getHashAlgorithm()
    {
        return $this->hashAlgorithm;
    }
}