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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

      $(document).ready(function(){
      <?php
        //包含解token的部分及資料庫的部分
        include "php/DB_information.php";

        $DBname = "wtlab108";
        $conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
        mysqli_query($conn,"SET NAMES utf8");
        mysqli_select_db($conn,$DBname);
        $orderID = $_GET["orderID"];
        //去資料庫看status
        $sql = "SELECT `status` FROM `storeorder` WHERE `orderNumber`='$orderID'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_NUM);
        $status=$row[0];
        echo "var status=$status;";

        mysqli_query($conn, $sql);
        mysqli_close($conn);
        if($status==1){
          echo "console.log(status);";
          echo "alert('訂單已確認完成');";
          echo "window.location = 'http://127.0.0.1/wtlab108/orderWithIOTA/complete.php?view=0&orderID=$orderID';";
        }
      ?>
     }); //document.ready結束
   </script>
  </head>
  <body>
    <!--表格本體-->
    <div class="container" id="orderTable">
      <br>
        <?php $orderID = $_GET["orderID"];
            echo "<h1>訂單編號：$orderID</h1>"
        ?>
      <table class="table mytable" id="data_table">
        <thead align=left>
          <tr>
            <th id="th1" >產品</th>
            <th id="th2" >單價</th>
            <th id="th3" >數量</th>
            <th id="th4" >總價</th>
          </tr>
        </thead>
        <tbody id='tbody'>
            <?php
              //包含解token的部分及資料庫的部分
              include "php/DB_information.php";

              $DBname = "wtlab108";
            	$conn = mysqli_connect($DBhost, $DBuser, $DBpass) ;//連接資料庫
            	mysqli_query($conn,"SET NAMES utf8");
            	mysqli_select_db($conn,$DBname);

              //建立一個用來放回傳資料的陣列
            	$return_arr = array();

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
                 for($j=1;$j<count($return_arr[$i]);$j++){
                    echo "<td>".$return_arr[$i][$j]."</td>";
                 }
                 $totalprice+=$return_arr[$i][4];
                 echo "</tr>";
              }
              echo "<tr><td></td><td></td><td>合計</td><td>".$totalprice."</td></tr>";
              //回傳json形式

              mysqli_free_result($result);
              mysqli_close($conn);
            ?>
        </tbody>
      </table>
      <hr>
      <div align="center">
        <?php $orderID = $_GET["orderID"];
            echo "<button class='btn btn-primary' onclick='window.location=\"php/orderCheckBackEnd.php?view=0&orderID=$orderID\"' align='center'>確認訂單</button>"
        ?>

      </div>
    </div>
  </body>
</html>
