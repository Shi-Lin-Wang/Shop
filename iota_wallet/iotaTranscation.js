
$(document).ready(function(){
  $.ajax({
    url:"getSeed.php",  //呼叫的位址
    type:"GET",      //請求方式
    data:{},//傳送到server的資料
    dataType:'json', //預期server回傳的形式
    success: function(reData){     //成功的時候跑的函式
      console.log("seed Data");
      console.log(reData);
      $("#seed").val(reData[0][0]);

    },
    error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
      console.log( errorThrown);
    }
  });

});
