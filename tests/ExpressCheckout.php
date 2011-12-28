<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

require_once dirname(__FILE__) . '/TestCase.php';

/**
 * Tests PayPal Express Checkout payments using Payment_PayPal_SOAP
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class ExpressCheckout extends Payment_PayPal_SOAP_TestCase
{
    // {{{ testSetExpressCheckout()

    public function testSetExpressCheckout()
    {
        $result = $this->client->call('SetExpressCheckout', array(
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

        $this->assertType('stdClass', $result);
        $this->assertObjectNotHasAttribute('Errors', $result);
        $this->assertObjectHasAttribute('Token', $result);
    }

    // }}}
    // {{{ testGetExpressCheckoutDetails()

    public function testGetExpressCheckoutDetails()
    {
        // a token from set express checkout is required first
        $result = $this->client->call('SetExpressCheckout', array(
            'SetExpressCheckoutRequest' => array(
                'Version' => '1.0',
                'SetExpressCheckoutRequestDetails' => array(
                    'OrderTotal' => array(
                        '_' => '1000.00',
                        'currencyID' => 'USD'
                    ),
                    'ReturnURL' => 'http://example.com/confirm/',
                    'CancelURL' => 'http://example.com/cart/'
                )
            )
        ));

        $this->assertType('stdClass', $result);
        $this->assertObjectNotHasAttribute('Errors', $result);
        $this->assertObjectHasAttribute('Token', $result);

        $token = $result->Token;

        $result = $this->client->call('GetExpressCheckoutDetails', array(
            'GetExpressCheckoutDetailsRequest' => array(
                'Version' => '1.0',
                'Token'   => $token
            )
        ));

        $this->assertType('stdClass', $result);
        $this->assertObjectNotHasAttribute('Errors', $result);
        $this->assertObjectHasAttribute(
            'GetExpressCheckoutDetailsResponseDetails', $result);

        $details = $result->GetExpressCheckoutDetailsResponseDetails;

        $this->assertType('stdClass', $details);
        $this->assertObjectHasAttribute('PayerInfo', $details);

        $payerInfo = $details->PayerInfo;
        $this->assertType('stdClass', $payerInfo);
    }

    // }}}
    // {{{ testDoExpressCheckoutPayment()

    public function testDoExpressCheckoutPayment()
    {
        $caughtException = false;

        // a token from set express checkout is required first
        $result = $this->client->call('SetExpressCheckout', array(
            'SetExpressCheckoutRequest' => array(
                'Version' => '1.0',
                'SetExpressCheckoutRequestDetails' => array(
                    'OrderTotal' => array(
                        '_' => '1000.00',
                        'currencyID' => 'USD'
                    ),
                    'ReturnURL' => 'http://example.com/confirm/',
                    'CancelURL' => 'http://example.com/cart/'
                )
            )
        ));

        $this->assertType('stdClass', $result);
        $this->assertObjectNotHasAttribute('Errors', $result);
        $this->assertObjectHasAttribute('Token', $result);

        $token = $result->Token;

        try {

            // do payment request
            $result = $this->client->call('DoExpressCheckoutPayment', array(
                'DoExpressCheckoutPaymentRequest' => array(
                    'Version' => '1.0',
                    'DoExpressCheckoutPaymentRequestDetails' => array(
                        'Token' => $token,
                        'PaymentAction' => 'Sale',
                        // We can't have a real payer for automated unit tests
                        // since it would reuqire interacting with a webpage.
                        'PayerID' => 'bad-payer-id',
                        'PaymentDetails' => array(
                            'OrderTotal' => array(
                                '_' => '38.07',
                                'currencyID' => 'USD'
                            ),
                            'ItemTotal' => array(
                                '_' => '34.27',
                                'currencyID' => 'USD'
                            ),
                            'TaxTotal' => array(
                                '_' => '3.8',
                                'currencyID' => 'USD'
                            ),
                            'PaymentDetailsItem' => array(
                                array(
                                    'Name' => 'Cool Tapes',
                                    'Amount' => array(
                                        '_' => '10.95',
                                        'currencyID' => 'USD'
                                    ),
                                    'Number' => 'SKU-0001',
                                    'Quantity' => '2',
                                    'Tax' => '1.24'
                                ),
                                array(
                                    'Name' => 'Strong Bad Sings',
                                    'Amount' => array(
                                        '_' => '12.37',
                                        'currencyID' => 'USD'
                                    ),
                                    'Number' => 'SKU-0002',
                                    'Quantity' => '1',
                                    'Tax' => '1.32'
                                )
                            )
                        )
                    )
                )
            ));
        } catch (Payment_PayPal_SOAP_ErrorException $e) {
            // we expect an error because the payer has not confirmed the
            // transaction
            $caughtException = true;

            $message = 'Error present in PayPal SOAP response: The customer ' .
                'has not yet confirmed payment for this Express Checkout ' .
                'session.';

            $this->assertEquals($message, $e->getMessage());
            $this->assertEquals(10435, $e->getCode());

            $response = $e->getResponse();
            $this->assertObjectHasAttribute(
                'DoExpressCheckoutPaymentResponseDetails', $response);
        }

        $this->assertTrue(
            $caughtException,
            'Expected error exception was not thrown by the ' .
            'DoExpressCheckout call.'
        );
    }

    // }}}
}

?>
