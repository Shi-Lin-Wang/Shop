<?php

	include "../DB.php";
	
	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');
		
	$return_arr = array();
	
	//$sql = "SELECT `categoryID` ,`categoryName` FROM `category`";
	//$sql = "SELECT `category`.categoryID ,`categoryName`,`parentID` FROM `category_parent` JOIN `category` ON `category`.categoryID=`category_parent`.categoryID";
    $sql = "SELECT `categoryID` ,`categoryName`,`parentID` FROM `category_parent` NATURAL JOIN `category`";
	$result = $conn->query($sql);

	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$row_array = $row;
		array_push($return_arr,$row_array);
    }

	
	
	//https://stackoverflow.com/questions/18178114/making-a-json-tree-from-a-flat-php-sql-table
    
	//回傳json形式
	echo json_encode($return_arr);
	mysqli_free_result($result);


	mysqli_close($conn);
		
?>