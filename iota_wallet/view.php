<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

  //建立一個用來放回傳資料的陣列
	$return_arr = array();


  $seed=$_GET['seed'];
  //從資料庫獲得資料
  $sql = "SELECT *  FROM `iota_wallet` Where `seed`='$seed' ";
  $result = mysqli_query($conn, $sql);
  //這邊將抓到的資料放入陣列
  while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
    $row_array = $row;
    array_push($return_arr,$row_array);
  }

  //回傳json形式
  echo json_encode($return_arr);

  mysqli_free_result($result);
  mysqli_close($conn);
?>
