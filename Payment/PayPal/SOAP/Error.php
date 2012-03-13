<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Payment_PayPal_SOAP is a package to easily use PayPal's SOAP API from PHP
 *
 * This file contains an error object
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2012 silverorange
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */

/**
 * Error raised by the PayPal SOAP API
 *
 * Errors are aggregated by the {@link Payment_PayPal_SOAP_ErrorException}
 * exception class.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 * @see       Payment_PayPal_SOAP_ErrorException
 */
class Payment_PayPal_SOAP_Error
{
    // {{{ class constants

    /**
     * Default error type
     */
    const TYPE_DEFAULT = 0;

    /**
     * Error type for expired PayPal Express Checkout tokens
     */
    const TYPE_EXPIRED_TOKEN = 1;

    // }}}
    // {{{ protected properties

    /**
     * Error message
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_Error::getMessage()
     * @see Payment_PayPal_SOAP_Error::setMessage()
     */
    protected $message = '';

    /**
     * Error code as specified in the PayPal API error codes
     *
     * @var integer
     *
     * @see Payment_PayPal_SOAP_Error::getCode()
     * @see Payment_PayPal_SOAP_Error::setCode()
     */
    protected $code = 0;

    /**
     * Error severity
     *
     * One of:
     *
     * - {@link Payment_PayPal_SOAP::ERROR_WARNING},
     * - {@link Payment_PayPal_SOAP::ERROR_ERROR}, or
     * - {@link Payment_PayPal_SOAP::ERROR_UNKNOWN}
     *
     * @var integer
     *
     * @see Payment_PayPal_SOAP_Error::getSeverity()
     * @see Payment_PayPal_SOAP_Error::setSeverity()
     */
    protected $severity = Payment_PayPal_SOAP::ERROR_UNKNOWN;

    /**
     * Error type
     *
     * One of:
     *
     * - {@link Payment_PayPal_SOAP_Error::TYPE_DEFAULT}, or
     * - {@link Payment_PayPal_SOAP_Error::TYPE_EXPIRED_TOKEN}
     *
     * @var integer
     *
     * @see Payment_PayPal_SOAP_Error::getType()
     * @see Payment_PayPal_SOAP_Error::setType()
     */
    protected $type = Payment_PayPal_SOAP_Error::TYPE_DEFAULT;

    // }}}
    // {{{ __construct()

    /**
     * Creates a new error object
     *
     * @param string  $message  the message of this error.
     * @param integer $code     the code of this error.
     * @param integer $severity the severity of this error.
     * @param integer $type     the type of this error.
     */
    public function __construct($message, $code, $severity, $type)
    {
        $this->setMessage($message);
        $this->setCode($code);
        $this->setSeverity($severity);
        $this->setType($type);
    }

    // }}}
    // {{{ setMessage()

    /**
     * Sets the message of this error
     *
     * @param string $message the message of this error.
     *
     * @return Payment_PayPal_SOAP_Error this object, for fluent interface.
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    // }}}
    // {{{ setCode()

    /**
     * Sets the code of this error
     *
     * Should be a valid API error code as specified in the PayPal SOAP API.
     *
     * @param integer $code the code of this error.
     *
     * @return Payment_PayPal_SOAP_Error this object, for fluent interface.
     */
    public function setCode($code)
    {
        $this->code = (integer)$code;
        return $this;
    }

    // }}}
    // {{{ setSeverity()

    /**
     * Sets the severity of this error
     *
     * Valid severities are:
     *
     * - {@link Payment_PayPal_SOAP::ERROR_WARNING},
     * - {@link Payment_PayPal_SOAP::ERROR_ERROR}, or
     * - {@link Payment_PayPal_SOAP::ERROR_UNKNOWN}
     *
     * @param integer $severity the severity of this error.
     *
     * @return Payment_PayPal_SOAP_Error this object, for fluent interface.
     */
    public function setSeverity($severity)
    {
        $this->severity = (integer)$severity;
        return $this;
    }

    // }}}
    // {{{ setType()

    /**
     * Sets the type of this error
     *
     * Valid types are:
     *
     * - {@link Payment_PayPal_SOAP_Error::TYPE_DEFAULT}, or
     * - {@link Payment_PayPal_SOAP_Error::TYPE_EXPIRED_TOKEN}
     *
     * @param integer $type the type of this error.
     *
     * @return Payment_PayPal_SOAP_Error this object, for fluent interface.
     */
    public function setType($type)
    {
        $this->type = (integer)$type;
        return $this;
    }

    // }}}
    // {{{ getMessage()

    /**
     * Gets the message of this error
     *
     * @return string the message of this error.
     */
    public function getMessage()
    {
        return $this->message;
    }

    // }}}
    // {{{ getCode()

    /**
     * Gets the code of this error
     *
     * @return integer the code of this error.
     */
    public function getCode()
    {
        return $this->code;
    }

    // }}}
    // {{{ getSeverity()

    /**
     * Gets the severity of this error
     *
     * @return integer the severity of this error.
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    // }}}
    // {{{ getType()

    /**
     * Gets the type of this error
     *
     * @return integer the type of this error.
     */
    public function getType()
    {
        return $this->type;
    }

    // }}}
}

?>
