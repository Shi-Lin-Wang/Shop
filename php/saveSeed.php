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

	  $acc = $_GET["acc"];
    $seed = $_GET["seed"];
    echo $acc."\n";
    echo $seed;
    $sql = "UPDATE `account` SET `seed`= '$seed' WHERE `account`='$acc'";
    mysqli_query($connection, $sql);
    header("Location:https://127.0.0.1/wtlab108/index.html");
	  mysqli_close($connection);

?>
