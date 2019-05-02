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

	//------------------------------------------------------圖片上傳

	// 取得圖片的副檔名 ( 如 jpg, gif... )
	$file_ext = strrchr($_FILES['file']['name'],'.');  //上傳檔案的副檔名

	switch(strtolower($file_ext)){
		case '.bmp': $src = imagecreatefromwbmp($_FILES['file']['tmp_name']); break;
		case '.gif': $src = imagecreatefromgif($_FILES['file']['tmp_name']); break;
		case '.jpg': $src = imagecreatefromjpeg($_FILES['file']['tmp_name']); break;
		case '.png': $src = imagecreatefrompng($_FILES['file']['tmp_name']); break;
		default : echo "Unsupported picture type!";
	}

	// 取得圖片的寬
	$src_w = imagesx($src);

	// 取得圖片的長
	$src_h = imagesy($src);

	// 依長與寬兩者最短的邊來算出要抓的正方形邊長
	if( $src_w > $src_h){
		$new_w = $src_h;
		$new_h = $src_h;
	}else{
		$new_w = $src_w;
		$new_h = $src_w;
	}

	// 以長方形的中心來取得正方形的左上方原點
	$srt_w = ( $src_w - $new_w ) / 2;
	$srt_h = ( $src_h - $new_h ) / 2;

	// 定義一個圖形 ( 針對正方形圖形 )
	$newpc = imagecreatetruecolor($new_w,$new_h);

	// 抓取正方形的截圖
	imagecopy($newpc, $src, 0, 0, $srt_w, $srt_h, $new_w, $new_h );

	// 建立縮圖
	$finpic = imagecreatetruecolor(213,213);

	// 開始縮圖
	imagecopyresampled($finpic, $newpc, 0, 0, 0, 0, 213, 213, $new_w, $new_h);

	switch(strtolower($file_ext)){

	 // 儲存縮圖到指定的目錄存放 , 檔名自訂
		/*
		case '.bmp': imagewbmp($finpic,dirname(__FILE__)."/uploadImg/".$_FILES['file']['name']); break;
		case '.gif': imagegif($finpic,dirname(__FILE__)."/uploadImg/".$_FILES['file']['name']); break;
		case '.jpg': imagejpeg($finpic,dirname(__FILE__)."/uploadImg/".$_FILES['file']['name']); break;
		case '.png': imagepng($finpic,dirname(__FILE__)."/uploadImg/".$_FILES['file']['name']); break;
		*/
		/*
		case '.bmp': imagewbmp($finpic,"C:/AppServ/www/test/uploadImg/".$_FILES['file']['name']); break;
		case '.gif': imagegif($finpic,"C:/AppServ/www/test/uploadImg/".$_FILES['file']['name']); break;
		case '.jpg': imagejpeg($finpic,"C:/AppServ/www/test/uploadImg/".$_FILES['file']['name']); break;
		case '.png': imagepng($finpic,"C:/AppServ/www/test/uploadImg/".$_FILES['file']['name']); break;
		*/
		//用140.127.74.192上傳改這個
		case '.bmp': imagewbmp($finpic,dirname(dirname(__FILE__))."/uploadImg/".$_FILES['file']['name']); break;
		case '.gif': imagegif($finpic,dirname(dirname(__FILE__))."/uploadImg/".$_FILES['file']['name']); break;
		case '.jpg': imagejpeg($finpic,dirname(dirname(__FILE__))."/uploadImg/".$_FILES['file']['name']); break;
		case '.png': imagepng($finpic,dirname(dirname(__FILE__))."/uploadImg/".$_FILES['file']['name']); break;
		//C:\xampp\htdocs\wtlab108\testChing/uploadImg/436491.jpg

	}

	$tmpname="路徑/檔名".$file_ext;

	//https://homying.blogspot.com/2016/09/phpgd.html

	//------------------------------------------------------

	//insert SQL
	$sql_insert = "INSERT INTO `product`( `productID`, `productTypeCode`, `productName`, `productPrice`, `productDescription`, `productImage` )
				  SELECT MAX( `productID` ) + 1,'".$_POST['state']."', '".$_POST['productName']."','".$_POST['productPrice']."',
				  '".$_POST['productDescription']."','".$_FILES['file']['name']."' FROM `product`;";

	for ($i = 1; $i <= 3; $i++) { //總共三層的下拉式選單
		$categoryID = $_POST['sel'.$i]; //切割":"
		$sql_insert .= "INSERT INTO `category_product`(`productID`, `categoryID`) SELECT MAX( `productID` ),".$categoryID."  FROM `product`;";
	}

	//echo var_dump($_POST);
	//echo __FILE__;
	//echo "\n".dirname(__FILE__)."\here";

	if (mysqli_multi_query($conn,$sql_insert))
	{
	  do
		{
		// Store first result set
		if ($result=mysqli_store_result($conn)) {
		  // Fetch one and one row
		  while ($row=mysqli_fetch_row($result))
			{
			printf("%s\n",$row[0]);
			}
		  // Free result set
		  mysqli_free_result($result);
		  }
		}
	  while (mysqli_next_result($conn));
	}

	mysqli_close($conn);

	header("Location:https://127.0.0.1/wtlab108/testChing/addProduct/addProduct.html");

?>
