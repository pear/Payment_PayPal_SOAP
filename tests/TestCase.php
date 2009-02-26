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
 * Copyright (c) 2008-2009 silverorange
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
 * @copyright 2008-2009 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
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
require_once 'Payment/PayPal/SOAP.php';

/**
 * Base class for testing Payment_PayPal_SOAP.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2009 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
abstract class Payment_PayPal_SOAP_TestCase extends PHPUnit_Framework_TestCase
{
    // {{{ protected properties

    /**
     * @var Payment_PayPal_SOAP
     */
    protected $client = null;

    /**
     * @var array
     */
    protected $config = array();

    // }}}
    // {{{ setUp()

    public function setUp()
    {
        $configFilename = dirname(__FILE__).'/config.php';

        if (!file_exists($configFilename)) {
            $this->markTestSkipped('Unit test configuration is missing. ' .
                'Please read the documentation in TestCase.php and create a ' .
                'configuration file. See the configuration in ' .
                '\'config.php.dist\' for an example.');
        }

        include $configFilename;

        if (   !isset($GLOBALS['Payment_PayPal_SOAP_Unittest_Config'])
            || !is_array($GLOBALS['Payment_PayPal_SOAP_Unittest_Config'])
        ) {
            $this->markTestSkipped('Unit test configuration is incorrect. ' .
                'Please read the documentation in TestCase.php and fix the ' .
                'configuration file. See the configuration in ' .
                '\'config.php.dist\' for an example.');
        }

        $this->config = $GLOBALS['Payment_PayPal_SOAP_Unittest_Config'];
        $this->client = new Payment_PayPal_SOAP($this->config);
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
