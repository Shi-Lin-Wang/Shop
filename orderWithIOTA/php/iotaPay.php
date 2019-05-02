<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";
  include "../php/verifyToken.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');


  $price = $_GET['price'];
  $storeID = $_GET['storeID'];
	$token = $_COOKIE['token'];
	$return_arr = array();

  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time

	if(verifyToken($token)){
	  $data = getToken($token);

    $acc = $data->UserName;  //將data內的username取出放入acc
    //echo $acc;
  	$sql = "SELECT `seed` FROM `account` Where `account` = '$acc' ";
    $result = mysqli_query($conn, $sql);

    //這邊將抓到的資料放入陣列
  	$seed = mysqli_fetch_array($result,MYSQLI_NUM);

  	mysqli_free_result($result);
  	mysqli_close($conn);

	}

  //IOTA 版本
  $url="Location:http://127.0.0.1:3000/iotaPay?".
       "Seed=".$seed[0].
       "&CustomerID=".$acc.
       "&StoreID=$storeID".
       "&IOTAPay=$price";
       echo $url;
  header($url);

?>
