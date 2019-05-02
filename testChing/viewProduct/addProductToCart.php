<?php
	include "../DB.php";
	include "../../php/verifyToken.php";

    $DBname = 'wtlab108';//資料庫名稱
    $connection = mysqli_connect($DBhost, $DBuser, $DBpass);//or die('Error with MySQL connection');
    mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
    header('Content-Type: application/json;charset=utf-8');

	  echo var_dump($_POST);

    $token = $_COOKIE["token"];
    //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
    if(verifyToken($token)){
     $data = getToken($token);
    }else{
    }
    $acc = $data->UserName;  //將data內的username取出放入acc


	$unitprice=$_POST['productPrice']; //單價
	$number=$_POST['number'];  //數量
	$temp=$number*$unitprice;  //總價
	$productName=$_POST['productName']; //名稱
	$productID=$_POST['productID'];
	$remark=$_POST['remark'];

	$sql = "SELECT `supplierID` FROM `product` WHERE `productID`='$productID'";
	$result = mysqli_query($connection, $sql);
	//這邊將抓到的資料放入陣列
	$row = mysqli_fetch_array($result,MYSQLI_NUM);
  $storeID = $row[0];

	$sql = "SELECT * FROM `cart_product` WHERE `customer` = '$acc' AND `product`='$productName'";

	$result = mysqli_query($connection,$sql);
	if($result->num_rows > 0){
		$row = mysqli_fetch_array($result,MYSQLI_NUM);
		$number=$row[4]+$number;
		$temp=$number*$unitprice;  //總價
		$sql = "UPDATE `cart_product` SET `amount`=$number,`totalPrice`=$temp WHERE `customer` = '$acc' AND `product`='$productName'";
		mysqli_query($connection, $sql);

	}else{
		//寫進資料庫
		$sql = "INSERT INTO `cart_product`(`customer`,`store`,`product`,`unitprice`, `amount`,`totalPrice`,`remark`)" .
						"VALUES ('$acc','$storeID','$productName','$unitprice','$number','$temp','$remark')";
		mysqli_query($connection, $sql);
	}



    //全部做完後返回
    header("Location:https://127.0.0.1/wtlab108/orderWithIOTA/cart.php?storeID=$storeID");
    mysqli_free_result($result);
    mysqli_close($connection);

?>
