<?php
	include "../php/DB_information.php";
	include "../php/verifyToken.php";

	$DBname = "wtlab108";
	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
	mysqli_query($conn,"SET NAMES utf8");
	mysqli_select_db($conn,$DBname);
	header('Content-Type: application/json;charset=utf-8');

	 $token = $_COOKIE["token"];
	//這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
	if(verifyToken($token)){
		$data = getToken($token);
	}else{
	}
	$acc = $data->UserName;  //將data內的username取出放入acc

	//update SQL
	$sql = "UPDATE card SET name='".$_POST['name']."', phone='".$_POST['phone']."', address='".$_POST['address']."',
			company='".$_POST['company']."', email='".$_POST['email']."',position='".$_POST['position']."',
			companyTel='".$_POST['companyTel']."', fax='".$_POST['fax']."' WHERE account='$acc' AND name='".$_POST['modifyName']."'";

	$result = mysqli_query( $conn, $sql );
	if(! $result ){
		die('无法更新数据: ' . mysqli_error($conn));
	}
	mysqli_close($conn);

	header("Location:https://wtlab.ddns.net/wtlab108/viewCard/view.html");
?>
