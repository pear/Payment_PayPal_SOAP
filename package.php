<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * This is the package.xml generator for Payment_PayPal_SOAP
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
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$api_version     = '0.2.0';
$api_state       = 'alpha';

$release_version = '0.2.0';
$release_state   = 'alpha';
$release_notes   = 'First PEAR release.';

$description =
    "This package provides an easy-to-use wrapper of PHP 5's SOAP client " .
    "for use with the PayPal SOAP API.\n\n" .
    "This package requires PHP 5.1.0 or greater, built with the SOAP " .
    "extension enabled.";

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
$package->setLicense('LGPL', 'http://www.gnu.org/copyleft/lesser.html');

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

$package->setPhpDep('5.1.0', false,
    array('5.2.2', '5.2.3', '5.2.4', '5.2.5', '5.2.6'));

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
