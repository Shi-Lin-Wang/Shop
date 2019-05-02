<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>查看訂單內容</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"  rel ="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/order.css" rel="stylesheet">
    
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<script src="../public/showCartAmount.js"></script>
	<script src="viewOrderDetail.js"></script>
  </head>

  
  <!-- Sidebar (hidden by default) -->
<nav class="w3-sidebar w3-bar-block w3-card w3-top w3-large w3-animate-left" style="display:none;z-index:2;width:20%;min-width:150px" id="mySidebar">


    <i onclick="w3_close()" class="fa fa-remove w3-button w3-display-topright"></i>

    <br><br>
	<div style="text-align:center;"><img src="../imgs/LOGO4.png" style="width:100px; margin-top:-12px;"></div>
	<br>

	<button onclick="return myAccFunc(this);" class="btn btn-link w3-block w3-white w3-left-align" id="user" value="1" style="display:inline;"></button>
	<div name="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium" id="demoAcc1">
		<a href="#" class="w3-bar-item w3-button" onclick="window.location = '../personalInfo.html';">個人資訊</a>
		<a href="#" class="w3-bar-item w3-button" id="navPoint">點數</a>
		<a href="https://127.0.0.1\wtlab108\viewCard\view.html" class="w3-bar-item w3-button" >名片</a>
	</div>

	<button onclick="return myAccFunc(this);" class="btn btn-link w3-block w3-white w3-left-align" id="cart" value="2" style="display:inline;"></button>
	<div name="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium" id="demoAcc2">
		<a href="cart.php?storeID=1" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-shopping-cart" style="display:inline;"></span>&nbsp 我們家 & Starbox 冷飲站</a>
		<a href="cart.php?storeID=0" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-shopping-cart" style="display:inline;"></span>&nbsp Super WTLab's Shop</a>
	</div>

	<a href="viewOrder.html" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-list-alt" style="display:inline;"></span>&nbsp 查看購買紀錄</a>

	<button onclick="return myAccFunc(this);" class="btn btn-link w3-block w3-white w3-left-align" value="3" style="display:inline;"><span class="glyphicon glyphicon-home" style="display:inline;"></span> &nbsp SHOP <i class='fa fa-caret-down'></i></button>
	<div name="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium" id="demoAcc3">
		<a href="../testChing/browserProducts/browserProduct.html?shopID=1" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-home" style="display:inline;"></span>&nbsp 我們家 & Starbox 冷飲站</a>
		<a href="../testChing/browserProducts/browserProduct.html?shopID=0" class="w3-bar-item w3-button"><span class="glyphicon glyphicon-home" style="display:inline;"></span>&nbsp Super WTLab's Shop</a>
	</div>


	<a data-toggle="tab" class="w3-bar-item w3-button" onclick="logout();"><span class="glyphicon glyphicon-log-out"></span> 登出</a>

</nav>

<!-- Top menu -->
<div class="w3-top">
  <div class="w3-black w3-xlarge" style="max-width:1200px;margin:auto">
    <div class="w3-button w3-padding-16 w3-left" onclick="w3_open()">☰</div>
    <div class="w3-right w3-padding-16 user" id="navRight"></div>
    <div class="w3-center w3-padding-16"><img src="../imgs/LOGO4.png" style="width:40px; margin-top:-12px;">&nbsp My Shop</div>
  </div>
</div>

   <body> 
  
   
   
    <!--表格本體-->
    <div class="container" id="orderTable">
      <br><br><br><br>
        <?php $orderID = $_GET["orderID"];
            echo "<h1>訂單編號：$orderID</h1>"
        ?>
      <table class="table table-hover" id="data_table">
        <thead style="background-color:#fff;">
          <tr>
            <th id="th1" width="10%">產品</th>
            <th id="th2" width="10%">單價</th>
            <th id="th3" width="10%">數量</th>
            <th id="th4" width="10%">總價</th>
          </tr>
        </thead>
        <tbody id='tbody'>
            <?php
              //包含解token的部分及資料庫的部分
              include "php/DB_information.php";
              include "php/verifyToken.php";

              $DBname = "wtlab108";
            	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
            	mysqli_query($conn,"SET NAMES utf8");
            	mysqli_select_db($conn,$DBname);

              //建立一個用來放回傳資料的陣列
            	$return_arr = array();

              $token = $_COOKIE["token"];
              //這邊傳入verifyToken的方法verifyToken 和getToken 去尋找token內部的值username 和time
              if(verifyToken($token)){
                $data = getToken($token);
              }else{
              }
              $acc = $data->UserName;  //將data內的username取出放入acc

              //從資料庫獲得資料
              $sql = "SELECT *  FROM `storeorder_Detail` Where `orderNumber`='$orderID'";

              $result = mysqli_query($conn, $sql);

              //這邊將抓到的資料放入陣列
              while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {

                $row_array = $row;
                array_push($return_arr,$row_array);
              }

              $totalprice=0;
              for($i=0;$i<count($return_arr);$i++){
                 echo "<tr>";
                 for($j=1;$j<count($return_arr[$i])-1;$j++){
                    echo "<td>".$return_arr[$i][$j]."</td>";
                 }
                 $totalprice+=$return_arr[$i][4];
                 echo "</tr>";
              }
              echo "<tr><td></td><td></td><td>合計</td><td>".$totalprice."</td></tr></tbody></table>";
              //回傳json形式

              mysqli_free_result($result);
              mysqli_close($conn);
            ?>
        </tbody>
     </table>
  </body>
</html>
