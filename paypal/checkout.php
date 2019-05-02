<?php
// 1. Autoload the SDK Package. This will include all the files and classes to your autoloader

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
require "first.php";
if (!isset($_POST['product'], $_POST['price'])) 
 { 
	die("lose some params");
 } 
$product = $_POST['product']; 
$price = $_POST['price']; 
$shipping = 0.5; //运费 
$total = $price+$shipping; 

