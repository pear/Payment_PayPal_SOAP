<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PHPUnit3.2 test framework script for the Payment_PayPal_SOAP package.
 *
 * These tests require the PHPUnit 3.2 package to be installed. PHPUnit is
 * installable using PEAR. See the
 * {@link http://www.phpunit.de/pocket_guide/3.2/en/installation.html manual}
 * for detailed installation instructions.
 *
 * Note:
 *
 *   These tests require a private API key and/or local certificate from PayPal.
 *   Enter your API key and certificate details in config.php to run these
 *   tests. If config.php is missing, these tests will refusse to run. A sample
 *   configuration is provided in the file config.php.dist.
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
 * PHPUnit3 framework
 */
require_once 'PHPUnit/Framework.php';

/**
 * The class to test
 */
require_once 'Payment/PayPal/SOAP/Client.php';

/**
 * Base class for testing Payment_PayPal_SOAP.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
abstract class TestCase extends PHPUnit_Framework_TestCase
{
    // {{{ protected properties

    /**
     * @var Payment_PayPal_SOAP_Client
     */
    protected $client = null;

    /**
     * @var array
     */
    protected $config = array();

    // }}}
    // {{{ __construct()

    public function __construct($name = null)
    {
        parent::__construct($name);

        if (!file_exists(dirname(__FILE__).'/config.php')) {
            throw new Exception('Unit test configuration file is missing. ' .
                'Please read the documentation in TestCase.php and create ' .
                'a configuration file. See the example configuration provided '.
                'in config.php.dist for an example.');
        }

        include_once dirname(__FILE__).'/config.php';

        $this->config = $GLOBALS['Payment_PayPal_SOAP_Unittest_Config'];
    }

    // }}}
    // {{{ setUp()

    public function setUp()
    {
        $this->client = new Payment_PayPal_SOAP_Client($this->config);
    }

    // }}}
    // {{{ tearDown()

    public function tearDown()
    {
        unset($this->client);
    }

    // }}}
}

?>
