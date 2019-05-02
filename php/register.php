<?php

    include "DB_information.php";
	  //$DBname = 'test';
    $DBname = "wtlab108";
		//connect to database
		$connection = mysqli_connect($DBhost,$DBuser,$DBpass);
		//echo "connect correct"
	  mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
	  header('Content-Type: application/json;charset=utf-8');

	  $account = $_POST["signup-account"];
	  $password = $_POST["signup-password"];
    $name= $_POST["myname"];
    //$position = $_POST["position"];
    //$company = $_POST["company"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    //$address = $_POST["address"];
    //$companyTel = $_POST["companyTel"];
    //$fax = $_POST["fax"];

	  $sql_acc = "SELECT * FROM `account` WHERE `account` = '$account'";
	  $result = mysqli_query($connection,$sql_acc);

    $sql_acc = "SELECT * FROM `account` WHERE `phone` = '$phone'";
    $result2 = mysqli_query($connection,$sql_acc);
	  if($result->num_rows > 0 || $result2->num_rows > 0){
        setcookie("signError","true",time()+(300),"/wtlab108","127.0.0.1");
				header("Location:https://127.0.0.1/wtlab108/index.html");
    }else{
		    $sql = "INSERT INTO `account`(`account`, `password`, `email`,`phone`) VALUES ('$account','$password','$email','$phone')";
		    mysqli_query($connection, $sql);
        $sql = "INSERT INTO `card`(`account`, `owner`,`name`,`cardType`,`phone`, `email`)"
               ."VALUES ('$account','$account','$name','0','$phone','$email')";
        echo $sql;
		    mysqli_query($connection, $sql);

				setcookie("signError","false",time()+(300),"/wtlab108","127.0.0.1");
        setcookie("seed","$account",time()+(300),"/wtlab108","127.0.0.1");
		    header("Location:http://127.0.0.1:3000/seed/"."$account");
    }

	  mysqli_free_result($result);
	  mysqli_close($connection);

?>
