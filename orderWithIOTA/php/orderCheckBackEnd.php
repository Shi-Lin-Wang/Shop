<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  $orderID=$_GET['orderID'];

  //去資料庫更新資料
  $sql = "UPDATE `storeorder` SET `status`='1' WHERE `orderNumber`='$orderID'";


  header("Location:http://127.0.0.1/wtlab108/orderWithIOTA/complete.php?view=0&orderID=$orderID");

  mysqli_query($conn, $sql);
  mysqli_close($conn);
?>
