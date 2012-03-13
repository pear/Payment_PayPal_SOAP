<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Payment_PayPal_SOAP is a package to easily use PayPal's SOAP API from PHP
 *
 * This file contains various package-specific exception class definitions.
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2008-2012 silverorange
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
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */

/**
 * Error class
 */
require_once 'Payment/PayPal/SOAP/Error.php';

// {{{ interface Payment_PayPal_SOAP_Exception

/**
 * Base interface for exceptions thrown by the Payment_PayPal_SOAP package
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
interface Payment_PayPal_SOAP_Exception
{
}

// }}}
// {{{ class Payment_PayPal_SOAP_InvalidModeException

/**
 * Exception thrown when an invalid mode is used in the client constructor
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_InvalidModeException
    extends InvalidArgumentException
    implements Payment_PayPal_SOAP_Exception
{
    // {{{ protected properties

    /**
     * The invalid mode that was used
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_InvalidModeException::getMode()
     */
    protected $_mode = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new invalid mode exception
     *
     * @param string  $message the exception message.
     * @param integer $code    the exception code.
     * @param string  $mode    the invalid mode that was used.
     */
    public function __construct($message, $code = 0, $mode = '')
    {
        parent::__construct($message, $code);
        $this->_mode = $mode;
    }

    // }}}
    // {{{ getMode()

    /**
     * Gets the invalid mode that was used
     *
     * @return string the invalid mode that was used.
     *
     * @see PaymentPayPal_SOAP_InvalidModeException::$_mode
     */
    public function getMode()
    {
        return $this->_mode;
    }

    // }}}
}

// }}}
// {{{ class Payment_PayPal_SOAP_InvalidRequestNameException

/**
 * Exception thrown when an invalid request name is used in the
 * {@link Payment_PayPal_SOAP_Client::call()} method
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_InvalidRequestNameException
    extends InvalidArgumentException
    implements Payment_PayPal_SOAP_Exception
{
    // {{{ protected properties

    /**
     * The invalid request name that was used
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_InvalidRequestNameException::getRequestName()
     */
    protected $_requestName = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new invalid request name exception
     *
     * @param string  $message     the exception message.
     * @param integer $code        the exception code.
     * @param string  $requestName the invalid request name that was used.
     */
    public function __construct($message, $code = 0, $requestName = '')
    {
        parent::__construct($message, $code);
        $this->_requestName = $requestName;
    }

    // }}}
    // {{{ getRequestName()

    /**
     * Gets the invalid request name that was used
     *
     * @return string the invalid request name that was used.
     *
     * @see PaymentPayPal_SOAP_InvalidRequestNameException::$_requestName
     */
    public function getRequestName()
    {
        return $this->_requestName;
    }

    // }}}
}

// }}}
// {{{ class Payment_PayPal_SOAP_MissingPropertyException

/**
 * Exception thrown when a required request property is missing in the
 * arguments parameter of a {@link Payment_PayPal_SOAP::call()} method
 * call
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_MissingPropertyException
    extends InvalidArgumentException
    implements Payment_PayPal_SOAP_Exception
{
    // {{{ protected properties

    /**
     * The name of the property that is missing
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_MissingPropertyNameException::getPropertyName()
     */
    protected $_propertyName = '';

    // }}}
    // {{{ __construct()

    /**
     * Creates a new missing property exception
     *
     * @param string  $message      the exception message.
     * @param integer $code         the exception code.
     * @param string  $propertyName the name of the property that is missing.
     */
    public function __construct($message, $code = 0, $propertyName = '')
    {
        parent::__construct($message, $code);
        $this->_propertyName = $propertyName;
    }

    // }}}
    // {{{ getRequestName()

    /**
     * Gets the name of the property that is missing
     *
     * @return string the name of the property that is missing.
     *
     * @see PaymentPayPal_SOAP_MissingPropertyNameException::$_propertyName
     */
    public function getPropertyName()
    {
        return $this->_propertyName;
    }

    // }}}
}

// }}}
// {{{ class Payment_PayPal_SOAP_FaultException

/**
 * Exception thrown when a SOAP fault occurs
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_FaultException
    extends Exception
    implements Payment_PayPal_SOAP_Exception
{
    // {{{ protected properties

    /**
     * The original SoapFault that caused this exception to be thrown
     *
     * @var SoapFault
     * @see Payment_PayPal_SOAP_FaultException::getSoapFault()
     */
    protected $_soapFault = null;

    /**
     * The SOAP client that caused the exception
     *
     * @var SoapClient
     * @see Payment_PayPal_SOAP_FaultException::getSoapClient()
     */
    protected $_soapClient = null;

    // }}}
    // {{{ public function __construct()

    /**
     * Creates a new PayPal SOAP fault exception
     *
     * @param string     $message    the exception message.
     * @param integer    $code       the exception code.
     * @param SoapFault  $soapFault  the original SoapFault.
     * @param SoapClient $soapClient the SOAP client that caused the fault.
     */
    public function __construct($message, $code, SoapFault $soapFault,
        SoapClient $soapClient)
    {
        parent::__construct($message, $code);
        $this->_soapFault  = $soapFault;
        $this->_soapClient = $soapClient;
    }

    // }}}
    // {{{ getSoapFault()

    /**
     * Gets the original SoapFault that caused this exception to be thrown
     *
     * @return SoapFault the original SoapFault that caused this exception to
     *                   be thrown.
     */
    public function getSoapFault()
    {
        return $this->_soapFault;
    }

    // }}}
    // {{{ getSoapClient()

    /**
     * Gets the original SOAP client that caused the exception
     *
     * @return SoapClient the SOAP client that caused the exception.
     */
    public function getSoapClient()
    {
        return $this->_soapClient;
    }

    // }}}
}

// }}}
// {{{ class Payment_PayPal_SOAP_ErrorException

/**
 * Exception thrown when the SOAP response contains one or more Error elements
 *
 * A detailed error message is present in the message field. Individual errors
 * can be retrieved using the iterator interface. For example:
 *
 * <code>
 * <?php
 * foreach ($exception as $error) {
 *     echo $error->getMessage(), "\n";
 *     echo $error->getCode(), "\n";
 *     echo $error->getSeverity(), "\n";
 *     echo $error->getType(), "\n";
 * }
 * ?>
 * </code>
 *
 * The full response object may be retrieved using the
 * {@link Payment_PayPal_SOAP_ErrorException::getResponse()} method.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2012 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 * @see       Payment_PayPal_SOAP_Error
 */
class Payment_PayPal_SOAP_ErrorException
    extends Exception
    implements Payment_PayPal_SOAP_Exception, IteratorAggregate, Countable
{
    // {{{ protected properties

    /**
     * The errors aggregated by this exception
     *
     * @var array
     *
     * @see Payment_PayPal_SOAP_ErrorException::addError()
     * @see Payment_PayPal_SOAP_ErrorException::getIterator()
     * @see Payment_PayPal_SOAP_ErrorException::getSeverity()
     */
    protected $errors = array();

    /**
     * The response object that contains the PayPal error(s)
     *
     * @var stdClass
     *
     * @see Payment_PayPal_SOAP_ErrorException::getResponse()
     */
    protected $response = null;

    // }}}
    // {{{ __construct()

    /**
     * Creates a new error exception
     *
     * @param string   $message  the exception message.
     * @param integer  $code     the exception code.
     * @param stdClass $response the response object that contains the PayPal
     *                           error(s).
     */
    public function __construct($message, $code, $response)
    {
        parent::__construct($message, $code);
        $this->response = $response;
    }

    // }}}
    // {{{ addError()

    /**
     * Adds an error to this exception
     *
     * @param string|Payment_PayPal_SOAP_Error $message  either an error object
     *                                                   or a string containing
     *                                                   the error message.
     * @param integer                          $code     optional. The error
     *                                                   code. If first argument
     *                                                   is an object, this is
     *                                                   ignored.
     * @param integer                          $severity optional. The error
     *                                                   severity. If first
     *                                                   argument is an object,
     *                                                   this is ignored.
     * @param integer                          $type     optional. The error
     *                                                   type. If first
     *                                                   argument is an object,
     *                                                   this is ignored.
     *
     * @return Payment_PayPal_SOAP_ErrorException the current object for fluent
     *                                            interface.
     */
    public function addError($message, $code = null, $severity = null,
        $type = null
    ) {
        if (!($message instanceof Payment_PayPal_SOAP_Error)) {
            $message = new Payment_PayPal_SOAP_Error(
                $message,
                $code,
                $severity,
                $type
            );
        }

        $this->errors[] = $message;
    }

    // }}}
    // {{{ hasType()

    /**
     * Gets whether or not this exception has an aggregated error of the
     * specified type
     *
     * For example:
     * <code>
     * <?php
     * if ($e->hasType(Payment_PayPal_SOAP_Error::TYPE_EXPIRED_TOKEN)) {
     *     echo 'Your token has expired!';
     * }
     * ?>
     * </code>
     *
     * @param integer $type the type for which to check.
     *
     * @return boolean true if this exception has an aggregated error of the
     *                 specified type. Otherwise false.
     */
    public function hasType($type)
    {
        $hasType = false;

        foreach ($this->errors as $error) {
            if ($error->getType() == $type) {
                $hasType = true;
                break;
            }
        }

        return $hasType;
    }

    // }}}
    // {{{ hasSeverity()

    /**
     * Gets whether or not this exception has an aggregated error of the
     * specified severity
     *
     * For example:
     * <code>
     * <?php
     * if ($e->hasSeverity(Payment_PayPal_SOAP::ERROR_ERROR)) {
     *     echo 'Uh oh! Something went terribly wrong!';
     * }
     * ?>
     * </code>
     *
     * @param integer $severity the severity for which to check.
     *
     * @return boolean true if this exception has an aggregated error of the
     *                 specified severity. Otherwise false.
     */
    public function hasSeverity($severity)
    {
        $hasSeverity = false;

        foreach ($this->errors as $error) {
            if ($error->getSeverity() == $severity) {
                $hasSeverity = true;
                break;
            }
        }

        return $hasSeverity;
    }

    // }}}
    // {{{ getSeverity()

    /**
     * Gets the severity of the PayPal error
     *
     * Will be one of the following:
     *
     * - {@link Payment_PayPal_SOAP::ERROR_WARNING},
     * - {@link Payment_PayPal_SOAP::ERROR_ERROR}, or
     * - {@link Payment_PayPal_SOAP::ERROR_UNKNOWN}
     *
     * @param integer $index optional. The index of the error for which to get
     *                       the severity. If not specified, the severity of
     *                       the first error is returned.
     *
     * @return integer the severity level of the PayPal error.
     */
    public function getSeverity($index = 0)
    {
        $severity = Payment_PayPal_SOAP::ERROR_UNKNOWN;

        if (isset($this->errors[$index])) {
            $severity = $this->errors[$index]->getSeverity();
        }

        return $severity;
    }

    // }}}
    // {{{ getResponse()

    /**
     * Gets the response object containing the PayPal error
     *
     * Additional information about the error may be present here.
     *
     * @return stdClass the response object containing the PayPal error.
     */
    public function getResponse()
    {
        return $this->response;
    }

    // }}}
    // {{{ getIterator()

    /**
     * Gets an iterator object for the errors of this exception
     *
     * Fulfills the IteratorAggregate interface.
     *
     * @return array an iterator object for the errors of this exception.
     */
    public function getIterator()
    {
        return new ArrayObject($this->errors);
    }

    // }}}
    // {{{ getCount()

    /**
     * Gets the number of errors aggregated by this exception
     *
     * Fulfills the Countable interface.
     *
     * @return integer the number of errors aggregated by this exception
     */
    public function count()
    {
        return count($this->errors);
    }

    // }}}
}

// }}}
// {{{ class Payment_PayPal_SOAP_ExpiredTokenException

/**
 * Deprecated exception that used to be thrown when a request was made with
 * an expired checkout token
 *
 * This exception class is no longer used. See
 * {@link Payment_PayPal_SOAP_ErrorException} and the
 * {@link Payment_PayPal_SOAP_ErrorException::hasType()} method.
 *
 * @category   Payment
 * @package    Payment_PayPal_SOAP
 * @author     Michael Gauthier <mike@silverorange.com>
 * @copyright  2008-2012 silverorange
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @link       http://pear.php.net/package/Payment_PayPal_SOAP
 * @deprecated Use {@link Payment_PayPal_SOAP_ErrorException} and the
 *             {@link Payment_PayPal_SOAP_ErrorException::hasType()} method
 *             instead.
 */
class Payment_PayPal_SOAP_ExpiredTokenException extends
    Payment_PayPal_SOAP_ErrorException
{
}

// }}}

?>
