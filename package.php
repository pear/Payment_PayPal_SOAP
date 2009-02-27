<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This is the package.xml generator for Payment_PayPal_SOAP
 *
 * PHP version 5
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
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$api_version     = '0.2.0';
$api_state       = 'alpha';

$release_version = '0.2.0';
$release_state   = 'alpha';
$release_notes   = "Second PEAR release. Changes include:\n\n" .
    " * cleaned up exceptions\n" .
    " * merge Client class into SOAP class\n" .
    " * API documentation and coding-standards cleanups\n";

$description =
    "This package provides an easy-to-use wrapper of PHP 5's SOAP client " .
    "for use with the PayPal SOAP API.\n\n" .
    "This package requires PHP 5.1.0 or greater, built with the SOAP " .
    "extension enabled.\n\n" .
    "Note: Due to a PHP bug, PHP versions 5.2.2 to 5.2.6 are incompatible " .
    "with this package.";

$package = new PEAR_PackageFileManager2();

$package->setOptions(
    array(
        'filelistgenerator'       => 'cvs',
        'simpleoutput'            => true,
        'baseinstalldir'          => '/',
        'packagedirectory'        => './',
        'dir_roles'               => array(
            'Payment'             => 'php',
            'Payment/PayPal'      => 'php',
            'Payment/PayPal/SOAP' => 'php',
            'tests'               => 'test'
        ),
        'ignore'                  => array(
            'package.php'
        )
    )
);

$package->setPackage('Payment_PayPal_SOAP');
$package->setSummary('PayPal SOAP API client');
$package->setDescription($description);
$package->setChannel('pear.php.net');
$package->setPackageType('php');
$package->setLicense(
    'MIT',
    'http://www.opensource.org/licenses/mit-license.html'
);

$package->setNotes($release_notes);
$package->setReleaseVersion($release_version);
$package->setReleaseStability($release_state);
$package->setAPIVersion($api_version);
$package->setAPIStability($api_state);

$package->addMaintainer(
    'lead',
    'gauthierm',
    'Mike Gauthier',
    'mike@silverorange.com'
);

$package->setPhpDep(
    '5.1.0',
    false,
    array('5.2.2', '5.2.3', '5.2.4', '5.2.5', '5.2.6')
);

$package->addExtensionDep('required', 'soap');
$package->setPearinstallerDep('1.4.0');
$package->generateContents();

if (   isset($_GET['make'])
    || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')
) {
    $package->writePackageFile();
} else {
    $package->debugPackageFile();
}

?>
