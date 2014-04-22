<?php

/*
 * This file is part of the whatwedo PostFinance E-Payment library.
 *
 * (c) 2014 whatwedo GmbH (https://whatwedo.ch)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace whatwedo\PostFinanceEPayment\Form;

/**
 * @author Ueli Banholzer <ueli@whatwedo.ch>
 */
final class Form
{
    const METHOD_POST   = "post";
    const METHOD_GET    = "get";

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $hiddenFields = array();

    /**
     * @param string $method
     * @return Form
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $action
     * @return Form
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param array $hiddenFields
     * @return Form
     */
    public function setHiddenFields($hiddenFields)
    {
        $this->hiddenFields = $hiddenFields;

        return $this;
    }

    /**
     * @return array
     */
    public function getHiddenFields()
    {
        return $this->hiddenFields;
    }

    /**
     * @return string
     */
    public function getHtml($inner = "", $submit = null)
    {
        $result = array(
            sprintf('<form action="%s" method="%s">', $this->getAction(), $this->getMethod()),
            $inner,
            $submit === null ? '<input type="submit">' : $submit,
        );

        foreach($this->getHiddenFields() as $key => $value) {
            $result[] = sprintf('<input type="hidden" name="%s" value="%s">', $key, $value);
        }
        $result[] = '</form>';

        return implode(PHP_EOL, $result);
    }
}