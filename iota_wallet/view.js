
$(document).ready(function(){
  $.ajax({
    url:"getSeed.php",  //呼叫的位址
    type:"GET",      //請求方式
    data:{},//傳送到server的資料
    dataType:'json', //預期server回傳的形式
    success: function(seed){     //成功的時候跑的函式
      $.ajax({
        url:"view.php",  //呼叫的位址
        type:"GET",      //請求方式
        data:{"seed":seed[0][0]},//傳送到server的資料
        dataType:'json', //預期server回傳的形式
        success: function(reData){     //成功的時候跑的函式
          console.log("Account Show Data");
          console.log(reData);


          $("#seed").html(reData[0].seed);
    	    $("#balance").html(reData[0].balance);
    	    $("#address").html(reData[0].latestAddress);
        },
        error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
          console.log( errorThrown);
        }
      });

      $.ajax({
        url:"viewTransaction.php",  //呼叫的位址
        type:"GET",      //請求方式
        data:{"seed":seed[0][0]},//傳送到server的資料
        dataType:'json', //預期server回傳的形式
        success: function(reData){     //成功的時候跑的函式
          console.log("消費紀錄");
          console.log(reData);
          var transaction="";
          //transaction+="<tr><td colspan='4' align='center'><h3>消費紀錄</h3></td></tr>";
          for( var i=0;i<reData.length;i++ ){
             transaction+="<tr><td><label>"+i+"</label></td><td><p>"+reData[i].status+"</p></td><td><p>"+reData[i].price+"</p></td><td><p>"+reData[i].message+"</p></td></tr>";
          }
    	    $("#transaction").html(transaction);
        },
        error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
          console.log( errorThrown);
        }
      });

    },
    error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
      console.log( errorThrown);
    }
  });


});
