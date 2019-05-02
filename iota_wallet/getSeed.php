<?php
  //包含解token的部分及資料庫的部分
  include "DB_information.php";
  include "../php/verifyToken.php";

  $DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

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
  	while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
  		$row_array = $row;
      array_push($return_arr,$row_array);
    }

    //回傳json形式
  	echo json_encode($return_arr);

  	mysqli_free_result($result);
  	mysqli_close($conn);

	}else{
    $guest = array();
    array_push($guest,"noSeed");
    array_push($return_arr,$guest);
    echo json_encode($return_arr);
	}
?>
