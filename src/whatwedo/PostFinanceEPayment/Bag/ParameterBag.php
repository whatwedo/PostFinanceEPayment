<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Bag;

/**
 * bag to easily manage the parameters.
 *
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
class ParameterBag implements \Countable, \IteratorAggregate
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * @param string|int|float $key
     *
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * @param string|int|float $key
     * @param mixed            $value
     * @param bool             $addEmpty add empty value parameters?
     *
     * @return $this
     */
    public function add($key, $value, $addEmpty = false)
    {
        if (!$addEmpty
            && empty($value)) {
            return $this;
        }

        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * @param string|int|float $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $this->parameters[$key];
        }

        return;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->parameters;
    }

    /**
     * @param string|int|float $key
     *
     * @return $this
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            unset($this->parameters[$key]);
        }

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function contains($value)
    {
        return array_search($value, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->parameters);
    }
}
