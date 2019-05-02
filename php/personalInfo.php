<?php

  include "DB_information.php";
  include "verifyToken.php";

  $DBname = "wtlab108";
	//connect to database
	$connection = mysqli_connect($DBhost,$DBuser,$DBpass);
	//echo "connect correct"
	mysqli_query($connection,"SET NAMES utf8");
  mysqli_select_db($connection,$DBname);
  header('Content-Type: application/json;charset=utf-8');
  $return_arr = array();

  $token = $_COOKIE["token"];
  //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
  if(verifyToken($token)){
   $data = getToken($token);
  }else{
  }
  $acc = $data->UserName;  //將data內的username取出放入acc

	$sql_acc = "SELECT * FROM card WHERE account='$acc' AND cardType='0'"; //所選的卡片資訊
	$result = mysqli_query($connection,$sql_acc);

  while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
   	$row_array = $row;
   	array_push($return_arr,$row_array);
  }
  //回傳json形式
  echo json_encode($return_arr);
	mysqli_free_result($result);
  mysqli_close($connection);

?>
