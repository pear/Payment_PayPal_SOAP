<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

require_once 'TestCase.php';

/**
 * Tests getLastRequest() and getLastResponse() methods using
 * Payment_PayPal_SOAP
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Debug extends Payment_PayPal_SOAP_TestCase
{
    // {{{ private properties

    /**
     * @var DOMXPath
     */
    private $_xpath;

    // }}}
    // {{{ testGetLastRequest()

    public function testGetLastRequest()
    {
        $this->_doRequest();
        $soapXml = $this->client->getLastRequest();
        $this->_buildXPath($soapXml);

        $this->_assertElementCountEquals(1, '/soap:Envelope');

        // header
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header');
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials/ebl:Username');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials/ebl:Password');

        // body 
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body');
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutReq');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutReq/pp:SetExpressCheckoutRequest');
    }

    // }}}
    // {{{ testGetLastResponse()

    public function testGetLastResponse()
    {
        $this->_doRequest();
        $soapXml = $this->client->getLastResponse();
        $this->_buildXPath($soapXml);

        $this->_assertElementCountEquals(1, '/soap:Envelope');

        // header
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header');
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'security:Security');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials/ebl:Username');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Header/' .
            'pp:RequesterCredentials/ebl:Credentials/ebl:Password');

        // body
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body');
        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutResponse');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutResponse/ebl:Timestamp');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutResponse/ebl:Ack');

        $this->_assertElementCountEquals(1, '/soap:Envelope/soap:Body/' .
            'pp:SetExpressCheckoutResponse/pp:Token');
    }

    // }}}
    // {{{ testGetLastRequestFalse()

    public function testGetLastRequestFalse()
    {
        $request = $this->client->getLastRequest();
        $this->assertFalse($request);
    }

    // }}}
    // {{{ testGetLastResponseFalse()

    public function testGetLastResponseFalse()
    {
        $response = $this->client->getLastResponse();
        $this->assertFalse($response);
    }

    // }}}
    // {{{ _doRequest ()

    private function _doRequest()
    {
        $this->client->call('SetExpressCheckout', array(
            'SetExpressCheckoutRequest' => array(
                'Version' => '50.0',
                'SetExpressCheckoutRequestDetails' => array(
                    'OrderTotal' => array(
                        '_' => '1000.00',
                        'currencyID' => 'USD'
                    ),
                    'ReturnURL' => 'http://example.com/confirm/',
                    'CancelURL' => 'http://example.com/cart/',
                ),
            ),
        ));
    }

    // }}}
    // {{{ _buildXPath()

    private function _buildXPath($xml)
    {
        $document = new DOMDocument();
        $document->loadXML($xml);

        $this->_xpath = new DOMXPath($document);

        $this->_xpath->registerNamespace('ebl',
            'urn:ebay:apis:eBLBaseComponents');

        $this->_xpath->registerNamespace('pp',
            'urn:ebay:api:PayPalAPI');

        $this->_xpath->registerNamespace('security',
            'http://schemas.xmlsoap.org/ws/2002/12/secext');

        $this->_xpath->registerNamespace('soap',
            'http://schemas.xmlsoap.org/soap/envelope/');
    }

    // }}}
    // {{{ _assertElementCountEquals()

    private function _assertElementCountEquals($value, $xpath)
    {
        $list = $this->_xpath->query($xpath);
        $this->assertEquals($value, $list->length);
    }

    // }}}
    // {{{ _assertElementCountGreaterThan()

    private function _assertElementCountGreaterThan($value, $xpath)
    {
        $list = $this->_xpath->query($xpath);
        $this->assertTrue($list->length > $value);
    }

    // }}}
}

?>
