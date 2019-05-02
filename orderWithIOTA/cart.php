<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>購物車</title>
    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"  rel ="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Custom styles for this template -->
    <link href="css/order.css" rel="stylesheet">
    <link href="css/viewOrder.css" rel="stylesheet">
      <link href="css/checkBox.css" rel="stylesheet">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="cart.js"></script>
	<script src="../public/showCartAmount.js"></script>

	<style>
	body, h1{
		font-family:'微软雅黑';
	}
	</style>

  </head>
  <body>
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
			<a href="https://wtlab.ddns.net\wtlab108\viewCard\view.html" class="w3-bar-item w3-button" >名片</a>
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
		<div class="w3-right w3-padding-16" id="navRight"></div>
		<div class="w3-center w3-padding-16"><img src="../imgs/LOGO4.png" style="width:40px; margin-top:-12px;">&nbsp My Shop</div>
	  </div>
	</div>


    <br>
    <!--購物車表格跟標題-->
    <div class="container" id="CartTable">
    </br></br>
      <?php
         $storeID=$_GET['storeID']; //單價
         echo "<h1  id='storeID' hidden='hidden'>$storeID</h1>"
      ?>

      <h1>購物車</h1>
      <table class='table table-hover' id='data_table'>
        <thead>
          <tr style="background-color:#fff;">
            <th id='th1'>商品</th>
            <th id='th2'>單價</th>
            <th id='th3'>數量</th>
            <th id='th4'>總價</th>
            <th id='th4'>備註</th>
            <th id='th5'>DELETE</th>
         </tr>
       </thead>
       <tbody id='cartTbody'>
       </tbody>
     </table>


     <div>

       <hr style="border: 3px solid black;border-radius: 5px;">
       <div>
          <h1>選擇付款方式</h1>
       </div>
       <div class="row">
         <div id='checkBox'class="col-md-3">
           <div class="inputGroup C">
            <input class="C" name="radio" type="radio"  id="iotaPay" value="iotaPay">
            <label  for="iotaPay" id="labelIotaPay">IOTA付款</label>
          </div>
          <div class="inputGroup B">
            <input class="C" name="radio" type="radio"  id="cash" value="cash" >
            <label  for="cash">現金付款</label>
          </div>
		   <div class="inputGroup A">
            <input class="C" name="radio" type="radio"  id="paypal" value="paypal" >
            <label  for="paypal">Paypal付款</label>
          </div>
        </div>
       </div>
     </div>
	  <h1 id='price'>&nbsp&nbsp&nbsp</h1>

     <br>
     <div id='button'>
	 <button class="btn btn-primary" onclick="sendOrder()">結帳</button>
	 &nbsp;&nbsp;
	 <button class="btn btn-primary" onclick="window.location=&quot;../testChing/browserProducts/browserProduct.html?id=1&quot;">繼續購物</button>
     </div>
    </div>
    <!--表格本體-->






  </body>
</html>
