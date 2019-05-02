<?php
	include "../../php/DB_information.php";
	include "../../php/verifyToken.php";
	
	$token = $_COOKIE["token"];

	if(verifyToken($token)){
		$data = getToken($token);
	}else{
	}
	$acc = $data->UserName; 
	
	
	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');
	
	$return_arr = array();
	$clickVal = $_GET['clickVal'];
	
	$sql = "SELECT * FROM card WHERE owner LIKE '".$acc."' AND account='".$acc."' AND name='".$clickVal."'"; //現在點擊哪張卡片的資訊
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