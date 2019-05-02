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
  //包含解token的部分及資料庫的部分
  include "DB_information.php";
  include "../php/verifyToken.php";
	require "first.php";
  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time

$DBname = 'wtlab108';//資料庫名稱
    $connection = mysqli_connect($DBhost, $DBuser, $DBpass);//or die('Error with MySQL connection');
    mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
    header('Content-Type: application/json;charset=utf-8');
    //建立一個用來放回傳資料的陣列
    $return_arr = array();


    $token = $_COOKIE["token"];
    $storeID = $_GET["storeID"];

    //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
    if(verifyToken($token)){
      $data = getToken($token);
    }else{
    }
    $acc = $data->UserName;  //將data內的username取出放入acc

    //從資料庫獲得資料
    $sql = "SELECT *  FROM `cart_product` Where `customer`='$acc' AND `store`='$storeID'";

    $result = mysqli_query($connection, $sql);
    //這邊將抓到的資料放入陣列
    while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
        $row_array = $row;
        array_push($return_arr,$row_array);
    }


    //先把以前訂單編號最大找出來
    $sql = "SELECT MAX(orderNumber) FROM `storeorder_detail`";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_NUM);
    $ordernumber=$row[0]+1;
    //echo $ordernumber;


    //建立一個放總價的變數
    $totalPrice=0;
    //開始把每樣商品丟進storeorder_detail
	  for($i=0;$i<count($return_arr);$i++){

            //先把價格抓出來
            $name=$return_arr[$i][2];
            $unitprice=$return_arr[$i][3];
            $amount=$return_arr[$i][4];
            $remark=$return_arr[$i][6];

            //算單樣總價
            $temp=$amount*$unitprice;
            $totalPrice+=$temp;

            //寫進資料庫
            $sql = "INSERT INTO `storeorder_detail`(`orderNumber`,`product`,`unitprice`, `amount`,`totalPrice`,`remark`)" .
                   "VALUES ('$ordernumber','$name','$unitprice','$amount','$temp','$remark')";
            mysqli_query($connection, $sql);


            //先把以前庫存找出來
            $sql = "SELECT `stock` FROM `product` WHERE `productName`='$name'";
            $result = mysqli_query($connection,$sql);
            $sqlStock = mysqli_fetch_array($result,MYSQLI_NUM);
            $stock=(int)$sqlStock[0]-(int)$amount;
            echo $stock;
            $sql = "UPDATE `product` SET `stock`='$stock' WHERE `productName`='$name'";
            mysqli_query($connection, $sql);
            //刪除掉購物車的東西
    }


    //這邊需要做出把購買人跟店家跟總額丟進訂單的功能
    date_default_timezone_set('Asia/Taipei');
    $date=date('Y-m-d  h:i:sa');
    $sql = "INSERT INTO `storeorder`(`orderNumber`,`status`, `customer`,`store`,`price`,`date`)".
           "VALUES ('$ordernumber','0','$acc','$storeID','$totalPrice',NOW())";
    mysqli_query($connection, $sql);

    $sql = "DELETE FROM `cart_product` WHERE customer='$acc' AND `store`='$storeID'";
    mysqli_query($connection, $sql);
    header("Location:https://127.0.0.1/wtlab108/orderWithIOTA/paypal/paypal.php");

    mysqli_free_result($result);
    mysqli_close($connection);

  //Paypal 版本
 $payer = new Payer(); 
$payer->setPaymentMethod('paypal'); 
$item = new Item(); 
$item->setName($storeID) ->setCurrency('USD') ->setQuantity(1) ->setPrice($price); 
$itemList = new ItemList(); $itemList->setItems([$item]); 
$details = new Details(); $details->setSubtotal($price); 
$amount = new Amount(); $amount->setCurrency('USD') ->setTotal($totalPrice) ->setDetails($details); 
$transaction = new Transaction(); 
$transaction->setAmount($amount) ->setItemList($itemList) ->setDescription("支付描述内容") ->setInvoiceNumber(uniqid()); 
$redirectUrls = new \PayPal\Api\RedirectUrls();
//https://www.paypal.com/cgi-bin/webscr
$redirectUrls->setReturnUrl("https://127.0.0.1/wtlab108/orderWithIOTA/paypal/pay.php?success=true")
//$redirectUrls->setReturnUrl("https://www.sandbox.paypal.com/cgi-bin/webscr")
    ->setCancelUrl("https://127.0.0.1/wtlab108/index.html");
$payment = new Payment(); 
$payment->setIntent('sale') ->setPayer($payer) ->setRedirectUrls($redirectUrls) ->setTransactions([$transaction]); 
try { 
    $payment->create($paypal);

     } 
catch (PayPalConnectionException $e) { echo $e->getData(); die(); } $approvalUrl = $payment->getApprovalLink(); header("Location: {$approvalUrl}");

?>
