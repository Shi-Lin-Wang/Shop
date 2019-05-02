<?php
	  include "verifyToken.php";
    include "DB_information.php";
    $DBname = 'wtlab108';

    $name = $_REQUEST["myname"];
    $position =$_REQUEST['position'];
    $company = $_REQUEST['company'];
    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $address = $_REQUEST['address'];
    $companyTel = $_REQUEST['companyTel'];
    $fax = $_REQUEST['fax'];

    $connection = mysqli_connect($DBhost, $DBuser, $DBpass);//or die('Error with MySQL connection');
    mysqli_query($connection,"SET NAMES utf8");
    mysqli_select_db($connection,$DBname);
    header('Content-Type: application/json;charset=utf-8');

    $token = $_COOKIE["token"];
    echo $token;
    //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
  	if(verifyToken($token)){
  		$data = getToken($token);
  	}else{
  	}
  	$acc = $data->UserName;  //將data內的username取出放入acc

    $sql_insert = "INSERT INTO `card`(`account`, `owner`,`name`,`cardType`,`phone`,`address`,`company`, `email`,`position`,`companyTel`,`fax`)"
	               ."VALUES ('$acc','$acc','$name','1','$phone','$address','$company','$email','$position','$companyTel','$fax')";
    mysqli_query($connection,$sql_insert);

		header("Location:https://127.0.0.1/wtlab108/viewCard/view.html");
    //$result = mysqli_query($connection,$sql_insert);// or die('MySQL insert error');
    /*$sql_query = "select * from card";

    $result = mysqli_query($connection,$sql_query) ;//or die('MySQL query error');
    while($row = mysql_fetch_array($result){
        echo $row['name']."<br>";
        echo $row['position']."<br>";
        echo $row['company']."<br>";
        echo $row['email']."<br><br>";
        echo $row['phone']."<br>";
        echo $row['address']."<br>";
        echo $row['companyTel']."<br>";
        echo $row['fax']."<br>";
    }*/

    //mysqli_free_result($result);
    mysqli_close($connection);

?>
