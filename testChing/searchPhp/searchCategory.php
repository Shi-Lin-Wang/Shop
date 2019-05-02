<?php

	include "../DB.php";
	
	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');
	
	$return_arr = array();
	$sel1 = $_POST['sel1'];
	$sel2 = $_POST['sel2'];
	$sel3 = $_POST['sel3'];
	$shopID = $_POST['shopID'];
	
	$sql = "select `productName` ,`productPrice`,`productImage`,`productID` from `product` NATURAL JOIN `category_product` WHERE `supplierID`=".$shopID." AND `categoryID` in (".$sel1.",".$sel2.",".$sel3.") group by `productID` having count(distinct `categoryID`) = 3";
	
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