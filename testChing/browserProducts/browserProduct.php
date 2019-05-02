<?php

	include "../DB.php";
	
	include "../../php/verifyToken.php";

	$token = $_COOKIE["token"];
	//這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
	if(verifyToken($token)){
		$data = getToken($token);
	}else{
	}
	$acc = $data->UserName;  //將data內的username取出放入acc
	
	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');
	
	$return_arr = array();
	$id = $_POST['id'];
	
	$sql = "SELECT `productName` ,`productPrice`,`productImage`, `productID` FROM `product` WHERE `supplierID`=".$id;
    $result = $conn->query($sql);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$row_array = $row;
		array_push($return_arr,$row_array);
    }
	//回傳json形式
	echo json_encode($return_arr);
	mysqli_free_result($result);

	mysqli_close($conn);

?>