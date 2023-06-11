<?php 
namespace sample;
require 'vendor/autoload.php';
require 'process.php';
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Sample\CaptureIntentExamples\CreateOrder;
$orderId = $_GET['orderID'];
class GetOrder
{

    /**
     * This function can be used to retrieve an order by passing order Id as argument.
     */
    public static function getOrder($orderId)
    {
        
        $client = PayPalClient::client();
        $response = $client->execute(new OrdersGetRequest($orderId));
        $orderId = $response->result->id;
        $email = $response->result->payer->address;
        $name = $response->result->purchase_units[0]->shipping->name;
        header("location : success.php");
    }
}

 
if (!count(debug_backtrace()))
{
    $createdOrder = CreateOrder::createOrder()->result;
    GetOrder::getOrder($orderId ,true);
}