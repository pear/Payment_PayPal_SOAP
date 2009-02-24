<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Payment_PayPal_SOAP is a package to easily use PayPal's SOAP API from PHP
 *
 * By itself, this package isn't very useful. It should be used in combination
 * with the documentation provided by PayPal at
 * {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf}. This package
 * makes it easier to get up and running, and allows you to begin integration by
 * making requests rather than by figuring out how to set SOAP authentication
 * headers.
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
 * Package-specific exceptions classes.
 */
require_once 'Payment/PayPal/SOAP/Exceptions.php';

/**
 * Package-level constants
 */
require_once 'Payment/PayPal/SOAP.php';

// {{{ class Payment_PayPal_SOAP_Client

/**
 * An easy to use SOAP client for the PayPal SOAP API
 *
 * By itself, this class isn't very useful. It should be used in combination
 * with the documentation provided by PayPal at
 * {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf}. This class
 * makes it easier to get up and running, and allows you to begin integration by
 * making requests rather than by figuring out how to set SOAP authentication
 * headers.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 * @link      https://www.paypal.com/en_US/pdf/PP_APIReference.pdf
 */
class Payment_PayPal_SOAP_Client
{
    // {{{ private properties

    /**
     * Mode to use for PayPal API
     *
     * Valid modes are:
     * - sandbox: for development and testing.
     * - live:    for processing live payments.
     *
     * Defaults to 'sandbox'.
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::setMode()
     */
    private $_mode = 'sandbox';

    /**
     * PayPal API username
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::setUsername()
     */
    private $_username = '';

    /**
     * PayPal API password
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::setPassword()
     */
    private $_password = '';

    /**
     * PayPal signature
     *
     * Only set if using signature-based authentication instead of
     * local-certificate-based authentication.
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::setSignature()
     */
    private $_signature = '';

    /**
     * WSDL files for the PayPal SOAP API indexed by mode
     *
     * @var array
     */
    static private $_wsdlFiles = array(
        'sandbox' => 'https://www.sandbox.paypal.com/wsdl/PayPalSvc.wsdl',
        'live'    => 'https://www.paypal.com/wsdl/PayPalSvc.wsdl'
    );

    /**
     * API endpoints indexed by mode and security mode
     *
     * Certificate-based authentication uses a different API endpoint than
     * signature (3 token)-based authentication.
     *
     * @var array
     *
     * @see https://ppmts.custhelp.com/cgi-bin/ppdts.cfg/php/enduser/popup_adp.php?p_sid=undefined&p_lva=undefined&p_faqid=391&p_created=1169502818
     */
    static private $_apiEndpoints = array(
        'sandbox' => array(
            'certificate' => 'https://api.sandbox.paypal.com/2.0/',
            'signature'   => 'https://api.sandbox.paypal.com/2.0/'
        ),
        'live'    => array(
            'certificate' => 'https://api.paypal.com/2.0/',
            'signature'   => 'https://api-3t.paypal.com/2.0/'
        )
    );

    // }}}
    // {{{ protected properties

    /**
     * SOAP client used to make PayPal SOAP requests
     *
     * @var SoapClient
     *
     * @see Payment_PayPal_SOAP_Client::getSoapClient()
     */
    protected $soapClient = null;

    /**
     * SOAP header values specific to PayPal SOAP API
     *
     * This contains PayPal authentication values.
     *
     * @var SoapHeader
     *
     * @see Payment_PayPal_SOAP_Client::getSoapHeader()
     */
    protected $soapHeader = null;

    /**
     * Options passed to the SOAP client when it is created
     *
     * PayPal's SOAP implementation uses SOAP 1.1 so the SOAP version option
     * is specified by default. If using local certificates for authentication,
     * the local certificate file is also included in these options.
     *
     * The API endpoint location is also specified in these options as the
     * endpoint in the WSDL file is not always correct depending on the
     * authentication mechanism used.
     *
     * @var array
     *
     * @see Payment_PayPal_SOAP_Client::setCertificateFile()
     * @see Payment_PayPal_SOAP_Client::__construct()
     */
    protected $soapOptions = array(
        'trace'        => true,
        'soap_version' => SOAP_1_1
    );

    // }}}
    // {{{ __construct()

    /**
     * Creates a new PayPal SOAP client
     *
     * Either signature-based or certificate-based authentication options
     * are required. The username, password and optional signature fields may
     * be retrieved from your PayPal account in the 'API Credentials' section.
     *
     * Sandbox and live modes require different PayPal accounts so all option
     * values will require changing if you select a different mode.
     *
     * The available options are:
     *
     * - <code>mode</code>         - optional. The mode to use for PayPal API
     *                               calls. Valid modes are <code>sandbox</code>
     *                               for development and testing, and
     *                               <code>live</code> for live payments. If not
     *                               specified, <em><code>sandbox</code></em> is
     *                               used.
     * - <code>username</code>     - the username used for authentication.
     * - <code>password</code>     - the password used for authentication.
     * - <code>signature</code>    - optional. The signature used for signature-
     *                               based authentication. Not required if
     *                               certificate-based authentication is used.
     * - <code>certificate</code>  - optional. The local certificate filename
     *                               used for certificate-based authentication.
     *                               Not required if signature-based
     *                               authentication is used.
     *
     * @param array $options array of options.
     *
     * @throws InvalidArgumentException if neither a signature nor a
     *         certificate file is specified in the options array, or if the
     *         username or password options are not specified in the options
     *         array.
     */
    public function __construct(array $options)
    {
        $hasSignature   = false;
        $hasCertificate = false;

        foreach ($options as $key => $value) {
            switch ($key) {
            case 'mode':
                $this->setMode($value);
                break;

            case 'username':
                $this->setUsername($value);
                break;

            case 'password':
                $this->setPassword($value);
                break;

            case 'signature':
                $hasSignature = true;
                $this->setSignature($value);
                break;

            case 'certificate':
                $hasCertificate = true;
                $this->setCertificateFile($value);
                break;
            }
        }

        if (!$this->_username) {
            throw new InvalidArgumentException('A username is required.');
        }

        if (!$this->_password) {
            throw new InvalidArgumentException('A password is required.');
        }

        if (!$hasSignature && !$hasCertificate) {
            throw new InvalidArgumentException(
                'Either a signature or a local certificate file is required.');
        }

        // set appropriate API endpoint
        if ($this->_signature) {
            $this->soapOptions['location'] =
                self::$_apiEndpoints[$this->_mode]['signature'];
        } else {
            $this->soapOptions['location'] =
                self::$_apiEndpoints[$this->_mode]['certificate'];
        }
    }

    // }}}
    // {{{ call()

    /**
     * Makes a PayPal SOAP request
     *
     * If a structured array is used as the arguments, WSDL types with
     * attributes may be specified as:
     *
     * <code>
     * $arguments = array(
     *     'OrderTotal' => array(    // 'OrderTotal' is a type with attributes
     *         '_' => '1000.00',     // this is the element value
     *         'currencyID' => 'USD' // this is an attribute value
     *     )
     * );
     * </code>
     *
     * @param string $requestName the name of the request. This should be a
     *                            request documented in the PayPal SOAP API
     *                            reference manual. Sending a request of an
     *                            invalid type will cause a SoapFault to be
     *                            thrown.
     * @param mixed  $arguments   optional. Either a structured array or an
     *                            object representing the SOAP request
     *                            arguments. If the request requires no
     *                            arguments, this parameter may be ommitted.
     *
     * @return mixed the PayPal SOAP response. If only one value is returned
     *               for the request, a simple value (e.g. an integer, a
     *               string, etc) is returned. For requests that return multiple
     *               values or complex types, a data structure composed of
     *               stdClass objects is returned.
     *
     * @throws Payment_PayPal_SOAP_InvalidRequestNameException if the specified
     *         request name is not a valid PayPal SOAP API request name.
     *
     * @throws Payment_PayPal_SOAP_MissingPropertyException if a required
     *         property for a request type is not specified in the request
     *         arguments. Refer to the PayPal SOAP API documentation at
     *         {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf} for
     *         information about required fields.
     *
     * @throws Payment_PayPal_SOAP_ErrorException if a SOAP response contains
     *         one or more Error elements. A detailed error message will be
     *         present in the exception message and the severity code will be
     *         in the exception code. See the {@link Payment_PayPal_SOAP} class
     *         for severity code constants.
     *
     * @throws Payment_PayPal_SOAP_FaultException if a SOAP initialization
     *         error occurs or an unknown SOAP error occurs.
     */
    public function call($requestName, $arguments = array())
    {
        try {
            $client = $this->getSoapClient();
            $response = $client->__soapCall($requestName, array($arguments),
                null, $this->getSoapHeader());

            if (isset($response->Errors)) {
                if (is_array($response->Errors)) {
                    $error = reset($response->Errors);
                } else {
                    $error = $response->Errors;
                }

                $message = (isset($error->LongMessage)) ?
                    $error->LongMessage : $error->ShortMessage;

                switch ($error->SeverityCode) {
                case 'Warning':
                    $severity = Payment_PayPal_SOAP::ERROR_WARNING;
                    break;
                case 'Error':
                    $severity = Payment_PayPal_SOAP::ERROR_ERROR;
                    break;
                default:
                    $severity = Payment_PayPal_SOAP::ERROR_UNKNOWN;
                    break;
                }

                $expiredTokenExp = '/Token value is no longer valid\.$/';
                if (preg_match($expiredTokenExp, $message) === 1) {
                    throw new Payment_PayPal_SOAP_ExpiredTokenException(
                        'Expired token used for PayPal SOAP request: ' .
                        $message,
                        $error->ErrorCode,
                        $severity,
                        $response
                    );
                } else {
                    throw new Payment_PayPal_SOAP_ErrorException(
                        'Error present in PayPal SOAP response: ' . $message,
                        $error->ErrorCode,
                        $severity,
                        $response
                    );
                }
            }

            return $response;
        } catch (SoapFault $e) {
            $message = $e->getMessage();

            $badFunctionExp = '/^Function \(".*?"\) is not a valid method ' .
                'for this service$/';

            if (preg_match($badFunctionExp, $message) === 1) {
                throw new Payment_PayPal_SOAP_InvalidRequestNameException(
                    'Request name "' . $requestName . '" is not a valid ' .
                    'request name for the PayPal API.',
                    $e->getCode(), $requestName);
            }

            $badArgumentExp = '/^SOAP-ERROR: Encoding: object hasn\'t ' .
                '\'(.*?)\' property$/';

            $matches = array();
            if (preg_match($badArgumentExp, $message, $matches) === 1) {
                $propertyName = $matches[1];
                throw new Payment_PayPal_SOAP_MissingPropertyException(
                    'Arguments for "' . $requestName . '" request is missing ' .
                    'a "' . $propertyName . '" property. See the PayPal SOAP ' .
                    'API reference for details on required request properties.',
                    $e->getCode(), $propertyName);
            }

            // Unknown SOAP exception, pass it along.
            throw new Payment_PayPal_SOAP_FaultException('PayPal SOAP Error: ' .
                $e->getMessage(), $e, $e->getCode());
        }
    }

    // }}}
    // {{{ getLastRequest()

    /**
     * Gets the XML sent in the last SOAP request
     *
     * @return boolean|string the XML sent in the last SOAP request. If no
     *                        request has been performed, false is returned.
     */
    public function getLastRequest()
    {
        if ($this->soapClient === null) {
            $request = false;
        } else {
            $request = $this->soapClient->__getLastRequest();
        }

        return $request;
    }

    // }}}
    // {{{ getLastResponse()

    /**
     * Gets the XML returned in the last SOAP response
     *
     * @return boolean|string the XML used in the last SOAP response. If no
     *                        response has been retrieved, false is returned.
     */
    public function getLastResponse()
    {
        if ($this->soapClient === null) {
            $response = false;
        } else {
            $response = $this->soapClient->__getLastResponse();
        }

        return $response;
    }

    // }}}
    // {{{ getSoapHeader()

    /**
     * Gets the SOAP header required for PayPal authentication
     *
     * If the header doesn't exist, it is created and stored in the protected
     * property {@link PaymentPayPal_SOAP_Client::$soapHeader}.
     *
     * This header is passed to all PayPal SOAP calls.
     *
     * @return SoapHeader the SOAP header required for PayPal authentication.
     *
     * @see Payment_PayPal_SOAP_Client::call()
     * @see Payment_PayPal_SOAP_Client::setUsername()
     * @see Payment_PayPal_SOAP_Client::setPassword()
     * @see Payment_PayPal_SOAP_Client::setSignature()
     */
    protected function getSoapHeader()
    {
        if ($this->soapHeader === null) {
            $credentials = array(
                'Credentials' => array(
                    'Username'  => $this->_username,
                    'Password'  => $this->_password
                )
            );

            if ($this->_signature) {
                $credentials['Credentials']['Signature'] = $this->_signature;
            }

            $this->soapHeader = new SoapHeader('urn:ebay:api:PayPalAPI',
                'RequesterCredentials', $credentials);
        }

        return $this->soapHeader;
    }

    // }}}
    // {{{ getSoapClient()

    /**
     * Gets the SOAP client used to make PayPal SOAP calls
     *
     * If the client doesn't exist, it is created and stored in the protected
     * property {@link PaymentPayPal_SOAP_Client::$soapClient}.
     *
     * @return SoapClient the SOAP client used to make PayPal SOAP calls.
     *
     * @see Payment_PayPal_SOAP_Client::call()
     */
    protected function getSoapClient()
    {
        if ($this->soapClient === null) {
            $this->soapClient = new SoapClient(self::$_wsdlFiles[$this->_mode],
                $this->soapOptions);
        }

        return $this->soapClient;
    }

    // }}}
    // {{{ setUsername()

    /**
     * Sets the API username used for authentication
     *
     * @param string $username the API username used for authentication.
     *
     * @return void
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::$_username
     */
    protected function setUsername($username)
    {
        $this->_username = (string)$username;
    }

    // }}}
    // {{{ setPassword()

    /**
     * Sets the API password used for authentication
     *
     * @param string $password the API password used for authentication.
     *
     * @return void
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::$_password
     */
    protected function setPassword($password)
    {
        $this->_password = (string)$password;
    }

    // }}}
    // {{{ setSignature()

    /**
     * Sets the API signature used for signature-based authentication
     *
     * @param string $signature the API signature used for signature-based
     *                          authentication.
     *
     * @return void
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::$_signature
     */
    protected function setSignature($signature)
    {
        $this->_signature = (string)$signature;
    }

    // }}}
    // {{{ setCertificateFile()

    /**
     * Sets the local certificate file used for certificate-based
     * authentication
     *
     * This file is downloaded from your API credentials page when logged into
     * your PayPal account.
     *
     * @param string $certificateFile the local certificate file used for
     *                                certificate-based authentication.
     *
     * @return void
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     * @see Payment_PayPal_SOAP_Client::$soapOptions
     */
    protected function setCertificateFile($certificateFile)
    {
        $certificateFile = (string)$certificateFile;
        if ($certificateFile) {
            $this->soapOptions['local_cert'] = $certificateFile;
        }
    }

    // }}}
    // {{{ setMode()

    /**
     * Sets the mode to use for API calls
     *
     * @param string $mode the mode to use for PayPal API calls. Valid modes
     *                     are <code>sandbox</code> for development and
     *                     testing, and <code>live</code> for live payments.
     *
     * @return void
     *
     * @throws Payment_PayPal_SOAP_InvalidModeException if an invalid mode is
     *         specified.
     *
     * @see Payment_PayPal_SOAP_Client::__construct()
     */
    protected function setMode($mode)
    {
        $mode = (string)$mode;

        $validModes = array('sandbox', 'live');
        if (!in_array($mode, $validModes)) {
            throw new Payment_PayPal_SOAP_InvalidModeException(
                'Mode "' . $mode . '" is invalid. Mode must be either ' .
                '"sandbox" or "live".', 0, $mode);
        }

        $this->_mode = $mode;
    }

    // }}}
}

// }}}

?>
