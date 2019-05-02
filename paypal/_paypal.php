<?php
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Common\PayPalModel;
use PayPal\Validation\UrlValidator;

require "checkout.php";  
$payer = new Payer(); 
$payer->setPaymentMethod('paypal'); 
$item = new Item(); 
$item->setName($product) ->setCurrency('USD') ->setQuantity(1) ->setPrice($price); 
$itemList = new ItemList(); $itemList->setItems([$item]); 
$details = new Details(); $details->setShipping($shipping) ->setSubtotal($price); 
$amount = new Amount(); $amount->setCurrency('USD') ->setTotal($total) ->setDetails($details); 
$transaction = new Transaction(); 
$transaction->setAmount($amount) ->setItemList($itemList) ->setDescription("支付描述内容") ->setInvoiceNumber(uniqid()); 
$redirectUrls = new \PayPal\Api\RedirectUrls();
//https://www.paypal.com/cgi-bin/webscr
$redirectUrls->setReturnUrl("https://127.0.0.1/paypal123/pay.php?success=true")
//$redirectUrls->setReturnUrl("https://www.sandbox.paypal.com/cgi-bin/webscr")
    ->setCancelUrl("https://127.0.0.1/paypal123/index.html");
$payment = new Payment(); 
$payment->setIntent('sale') ->setPayer($payer) ->setRedirectUrls($redirectUrls) ->setTransactions([$transaction]); 
try { 
    $payment->create($paypal);

     } 
catch (PayPalConnectionException $e) { echo $e->getData(); die(); } $approvalUrl = $payment->getApprovalLink(); header("Location: {$approvalUrl}");