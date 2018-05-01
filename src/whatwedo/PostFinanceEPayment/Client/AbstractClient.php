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

use whatwedo\PostFinanceEPayment\Exception\InvalidArgumentException;
use whatwedo\PostFinanceEPayment\Exception\InvalidCountryException;

/**
 * implementation of ClientInterface to store all client information.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
abstract class AbstractClient implements ClientInterface
{
    const REGEXP_LANGUAGE = '/^([a-z]{2})_([A-Z]{2})$/';

    /**
     * @var string unique id of the client
     */
    protected $id = null;

    /**
     * @var string name of the client
     */
    protected $name = null;

    /**
     * @var string email address of the client
     */
    protected $email = null;

    /**
     * @var string address of the client
     */
    protected $address = null;

    /**
     * @var string zip code of the client
     */
    protected $zip = null;

    /**
     * @var string city of the client
     */
    protected $town = null;

    /**
     * @var string phone number of the client
     */
    protected $tel = null;

    /**
     * @var string ISO 3166 Alpha-2 acronym of the country
     */
    protected $country = null;

    /**
     * @var string Locale of the user: ISO 639-1 (lowercase) underscore ISO 3166-1 (uppercase), ex. de_CH
     */
    protected $locale = 'en_US';

    /**
     * @param string $id
     *
     * @return AbstractClient
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return AbstractClient
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $email
     *
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function setEmail($email)
    {
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid e-mail address specified');
        }

        $this->email = strtolower($email);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $address
     *
     * @return AbstractClient
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $zip
     *
     * @return AbstractClient
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $town
     *
     * @return AbstractClient
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $tel
     *
     * @return AbstractClient
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param $country
     *
     * @return $this
     *
     * @throws InvalidCountryException
     */
    public function setCountry($country)
    {
        if (strlen($country) !== 2) {
            throw new InvalidCountryException($country);
        }

        $this->country = strtoupper($country);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param $locale
     *
     * @return $this
     *
     * @throws \whatwedo\PostFinanceEPayment\Exception\InvalidArgumentException
     */
    public function setLocale($locale)
    {
        if (!preg_match(self::REGEXP_LANGUAGE, $locale)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid language given (%s) - language code must match %s',
                $locale,
                self::REGEXP_LANGUAGE
            ));
        }

        $this->locale = $locale;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        return $this->locale;
    }
}
