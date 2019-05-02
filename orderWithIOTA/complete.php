<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>交易完成頁面</title>
    <!-- Bootstrap core CSS -->
    <link rel ="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!--google icon-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/order.css" rel="stylesheet">

    <!--JavaScript-->
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
       function closewin(){
          window.open('', '_self', ''); window.close();
       }
    </script>
  </head>
  <body>
    <div class="container">
      </br>
      <div class="card">
        <?php $view = $_GET["view"];
          if($view=="0"){
             echo "<h5 class='card-header'>確認完畢</h5>";
          }else{
             echo "<h5 class='card-header'>交易完成</h5>";
          }
        ?>
        <div class="card-body">
          <?php $orderID = $_GET["orderID"];
            if($view=="0"){
               echo "<h5 class='card-title'><strong>訂單編號：<font color='red'>$orderID </font>確認完畢</strong></h5>".
                    "<ul>".
                    "<li><p>當顯示這個頁面的時候，代表你已經確認完訂單了</p></li>".
                    "<li><p>接下來請等待客戶取貨</p></li></ul>";
            }else{
              echo "<h5 class='card-title'><strong>訂單編號：<font color='red'>$orderID </font>交易完成</strong></h5>".
                   "<ol>".
                   "<li><p>恭喜你，此筆交易已經完成了</p></li>".
                   "<li><p>點數已發放至客戶帳戶內</p></li></ol>";
            }
          ?>
          <!--button id='exit'  class="btn btn-danger" onclick="closewin()">關閉頁面</button-->
        </div>
      </div>
    </div> <!-- /container -->

  </body>
</html>
