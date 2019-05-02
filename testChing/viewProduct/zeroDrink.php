<?php

	include "../DB.php";
	
	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');
	
	$return_arr = array();
	
	$sql = "SELECT `product`, COUNT(*) FROM storeorder_detail WHERE `product`='chingTestUpload' GROUP BY `product`"; //測試chingTestUpload
    $result = $conn->query($sql);

	while ($row = mysqli_fetch_array($result,MYSQLI_BOTH)) {
		$row_array = $row;
		array_push($return_arr,$row_array);
    }

    
	//回傳json形式
	echo json_encode($return_arr);
	mysqli_free_result($result);

	mysqli_close($conn);

?>