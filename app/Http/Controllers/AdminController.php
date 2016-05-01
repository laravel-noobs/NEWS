<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use App\Province;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin');
    }

    private function getBaseUrl()
    {
        return 'http://http://shop.app';
    }

    public function dev()
    {
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AXbzo0_5V-MdQnJrXsdwmRM30zusyCOecj8Y5Yf2AH96IFao0efKqmZIS2czTZH-nCuHXhpB9QqJdrgS',     // ClientID
                'EK1vUK-dF02wuiUq6mLCYrPm64OAh10QqLaS8Mu0MDWA9SzpczIzggGNnb3lkuPvF7qTKRZ4Z_HSFDPv'      // ClientSecret
            )
        );


        // ### Payer
        // A resource representing a Payer that funds a payment
        // For paypal account payments, set payment method
        // to 'paypal'.
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        // ### Itemized information
        // (Optional) Lets you specify item wise
        // information
        $item1 = new Item();
        $item1->setName('Ground Coffee 40 oz')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice(7.5);
        $item2 = new Item();
        $item2->setName('Granola bars')
            ->setCurrency('USD')
            ->setQuantity(5)
            ->setSku("321321") // Similar to `item_number` in Classic API
            ->setPrice(2);
        $itemList = new ItemList();
        $itemList->setItems(array($item1, $item2));
        // ### Additional payment details
        // Use this optional field to set additional
        // payment information such as tax, shipping
        // charges etc.
        $details = new Details();
        $details->setShipping(1.2)
            ->setTax(1.3)
            ->setSubtotal(17.50);
        // ### Amount
        // Lets you specify a payment amount.
        // You can also specify additional details
        // such as shipping, tax.
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20)
            ->setDetails($details);
        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it.
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());
        // ### Redirect urls
        // Set the urls that the buyer must be redirected to after
        // payment approval/ cancellation.
        $baseUrl = $this->getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/approved?success=true")
            ->setCancelUrl("$baseUrl/approved?success=false");
        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent set to 'sale'
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // For Sample Purposes Only.
        $request = clone $payment;
        // ### Create Payment
        // Create a payment by calling the 'create' method
        // passing it a valid apiContext.
        // (See bootstrap.php for more on `ApiContext`)
        // The return object contains the state and the
        // url to which the buyer must be redirected to
        // for payment approval
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            return $ex;
        }

        try {
            $payment->create($apiContext);
        } catch (\Paypal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode(); // Prints the Error Code
            echo $ex->getData(); // Prints the detailed error message
            die($ex);
        }

        return response()->json([$payment->getApprovalLink(), json_decode($payment)])->header('Content-Type', 'application/json');
    }

    public function approved()
    {
        return $_REQUEST;
    }

    public function testTLS()
    {

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AXbzo0_5V-MdQnJrXsdwmRM30zusyCOecj8Y5Yf2AH96IFao0efKqmZIS2czTZH-nCuHXhpB9QqJdrgS',     // ClientID
                'EK1vUK-dF02wuiUq6mLCYrPm64OAh10QqLaS8Mu0MDWA9SzpczIzggGNnb3lkuPvF7qTKRZ4Z_HSFDPv'      // ClientSecret
            )
        );

        // ## TLS Check
        // We will add a separate unique endpoint specifically set for testing TLS check instead of using
        // our conventional sandbox endpoint.
        // TLS ENDPOINT: https://test-api.sandbox.paypal.com
        // To test your own implementation to verify it TLS is successfully supported in your application, you can follow
        // the following steps.
        // 1. Create an APIContext object as usual. (No Change Required).
        // 2. Add Configs as shown below to your apiContext object
        // Note: Explicitly disabling caching for specific testing.
        $apiContext->setConfig(array('service.EndPoint'=>"https://test-api.sandbox.paypal.com", 'cache.enabled'=>false));

        // 3. Thats it. Run your code, and see if it works as normal.
        // 4. You can check sdk logs to verify it is infact pointing to the above URL instead of default sandbox one.
        // ### Create a Payment for testing
        // We will create a conventional paypal payment to verify its creation
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal(20);
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $baseUrl = $this->getBaseUrl();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
            ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        // For Sample Purposes Only.
        $request = clone $payment;
        $curl_info = curl_version();
        try {
            $payment->create($apiContext);
        } catch (Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            //ResultPrinter::printError("FAILURE: SECURITY WARNING: TLSv1.2 is not supported on this system. Please upgrade your curl to atleast 7.34.0.<br /> - Current Curl Version: " . $curl_info['version'] . "<br /> - Current OpenSSL Version:" . $curl_info['ssl_version'], "Payment", null, $request, $ex);
            return false;
        }
        // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
        //ResultPrinter::printResult("<b>SUCCESS</b>: Your server supports TLS protocols required for secure connection to PayPal Servers. <br /> - Current Curl Version: " . $curl_info['version'] . "<br /> - Current OpenSSL Version:" . $curl_info['ssl_version'], null, null, null, "SUCCESS. Your system supports TLSv1.2");
        return $payment;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function debug()
    {
        // please dont delete this for god sake :))
        return;
    }

    /**
     * @param $name
     * @return array
     */
    public function permalink($name = null)
    {
        // @TODO
        if(!$name)
            abort(400);

        $slug = str_slug($name);
        $link = array('permalink'=> $slug);
        return $link;
    }
}
