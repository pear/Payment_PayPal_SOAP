<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Payment_PayPal_SOAP is a package to easily use PayPal's SOAP API from PHP
 *
 * The main class you want to use in this package is
 * {@link Payment_PayPal_SOAP_Client}.
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
 * @link      https://www.paypal.com/en_US/pdf/PP_APIReference.pdf
 */

/**
 * This non-instantiable class contains package-level constants for the
 * Payment_PayPal_SOAP package
 *
 * See the {@link Payment_PayPal_SOAP_Client} for using this package to make
 * PayPal SOAP API requests.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
abstract class Payment_PayPal_SOAP
{
    // {{{ class constants

    /**
     * Warning or informational error.
     */
    const ERROR_WARNING = 1;

    /**
     * Application-level error.
     */
    const ERROR_ERROR = 2;

    /**
     * Unknown error type reserved for future internal use by PayPal
     */
    const ERROR_UNKNOWN = 3;

    // }}}
    // {{{ __construct()

    /**
     * Private constructor to prevent instantiation of this class
     */
    private function __construct()
    {
    }

    // }}}
}

?>
