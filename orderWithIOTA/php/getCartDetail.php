<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";
  include "verifyToken.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  //建立一個用來放回傳資料的陣列
	$return_arr = array();

  $token = $_COOKIE["token"];
  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
  if(verifyToken($token)){
    $data = getToken($token);
  }else{
  }
  $acc = $data->UserName;  //將data內的username取出放入acc


  $storeID=$_GET['storeID']; //單價
  //從資料庫獲得資料
  $sql = "SELECT *  FROM `cart_product` Where `customer`='$acc' AND `store`='$storeID' ";


  $result = mysqli_query($conn, $sql);

  //這邊將抓到的資料放入陣列
  while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
    $row_array = $row;
    array_push($return_arr,$row_array);
  }

  //回傳json形式
  echo json_encode($return_arr);

  mysqli_free_result($result);
  mysqli_close($conn);
?>
