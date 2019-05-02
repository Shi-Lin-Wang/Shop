<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');


  $orderID=$_GET['orderID'];
  echo $orderID;
  //去資料庫更新資料
  $sql = "UPDATE `storeorder` SET `status`='2' WHERE `orderNumber`='$orderID'";
  $result = mysqli_query($conn, $sql);

  $sql = "SELECT *  FROM `storeorder` Where `orderNumber`='$orderID'";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  $row = mysqli_fetch_array($result,MYSQLI_NUM);
echo json_encode($row);
  //從資料庫獲得seed
  $sql = "SELECT `seed`  FROM `account` Where `account`='$row[2]'";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  $seed = mysqli_fetch_array($result,MYSQLI_NUM);
  echo json_encode($seed);


  //IOTA 版本
  $url="Location:http://wtlab.ddns.net:3000/send?".
       "Seed=".$seed[0].
       "&OrderID=".$orderID.
       "&CustomerID=".$row[2].
       "&StoreID=$row[3]".
       "&Point=".floor($row[4]/10);
       //echo $url;
  header($url);

  mysqli_query($conn, $sql);
  mysqli_close($conn);
?>
