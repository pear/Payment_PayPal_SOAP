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
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation; either version 2.1 of the
 * License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */

/**
 * PEAR exception handler and base class
 */
require_once 'PEAR/Exception.php';

// {{{ class Payment_PayPal_SOAP_Exception

/**
 * Base class for exceptions thrown by the Payment_PayPal_SOAP package
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
abstract class Payment_PayPal_SOAP_Exception extends PEAR_Exception
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
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_InvalidModeException extends
    Payment_PayPal_SOAP_Exception
{
    // {{{ private properties

    /**
     * The invalid mode that was used
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_InvalidModeException::getMode()
     */
    private $_mode = '';

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
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_InvalidRequestNameException extends
    Payment_PayPal_SOAP_Exception
{
    // {{{ private properties

    /**
     * The invalid request name that was used
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_InvalidRequestNameException::getRequestName()
     */
    private $_requestName = '';

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
 * arguments parameter of a {@link Payment_PayPal_SOAP_Client::call()} method
 * call
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_MissingPropertyException extends
    Payment_PayPal_SOAP_Exception
{
    // {{{ private properties

    /**
     * The name of the property that is missing
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_MissingPropertyNameException::getPropertyName()
     */
    private $_propertyName = '';

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
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_FaultException extends
    Payment_PayPal_SOAP_Exception
{
}

// }}}
// {{{ class Payment_PayPal_SOAP_ErrorException

/**
 * Exception thrown when the SOAP response contains one or more Error elements
 *
 * A detailed error message is present in the message field and the error
 * severity is present in the code field.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_ErrorException extends
    Payment_PayPal_SOAP_Exception
{
}

// }}}
// {{{ class Payment_PayPal_SOAP_ExpiredTokenException

/**
 * Exception thrown when a requests is made with an expired checkout token
 *
 * A detailed error message is present in the message field and the error
 * severity is present in the code field.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP_ExpiredTokenException extends
    Payment_PayPal_SOAP_ErrorException
{
}

// }}}

?>
