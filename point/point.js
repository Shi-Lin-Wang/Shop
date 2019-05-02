//取得cookie的方法  固定在上面
function getCookie(name) {
    var arg = escape(name) + "=";
    var nameLen = arg.length;
    var cookieLen = document.cookie.length;
    //console.log(cookieLen);
    var i = 0;
    while (i < cookieLen) {
        var j = i + nameLen;
        if (document.cookie.substring(i, j) == arg) return getCookieValueByIndex(j);
        i = document.cookie.indexOf(" ", i) + 1;
        if (i == 0) break;
    }
    return null;
}

function getCookieValueByIndex(startIndex) {
    var endIndex = document.cookie.indexOf(";", startIndex);
    if (endIndex == -1) endIndex = document.cookie.length;
    return unescape(document.cookie.substring(startIndex, endIndex));
}

//登出的方法  可以做參考，原理就只是把token的cookie刪除並回到首頁而已
function logout(){
    var now = new Date();
    now.setTime(now.getTime()-1000*600);
    document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=wtlab.ddns.net";
    //document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=140.127.74.168";
    window.location = "../index.html";
}


//navbar get account
$(document).ready(function(){
  $token = getCookie("token");
  console.log($token);
  $.ajax({
    url:"../php/navSigninCheck.php",  //呼叫的位址
    type:"GET",      //請求方式
    data:{"token": $token},//傳送到server的資料
    dataType:'json', //預期server回傳的形式
    success: function(reData){     //成功的時候跑的函式
      console.log("Account Show Data");
      console.log(reData);
      var account = reData[0][0];
      $("#user").html("<span class='glyphicon glyphicon-user'></span> &nbsp "+account+"&nbsp <i class='fa fa-caret-down'></i>");
	  $("#navRight").html("Hi !  "+account);
	  $("#navPoint").attr("href", "http://wtlab.ddns.net:3000/SQL/" +account);
    },
    error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
      console.log( errorThrown);
    }
  });


  $.ajax({
    url:"point.php",
    type:"GET",
    dataType:'json',
    success: function(reData){  //一開始進入檢視的名片顯示為自己的
      console.log(reData);
      var totalPoint=0;
      var pointTable="";
      pointTable+="<table class='table table-hover'>"+
                  "<thead><tr style='background-color:#fff;'>"+
                  "<th scope='col'>訂單標號</th>"+
                  "<th scope='col'>客戶名稱</th>"+
                  "<th scope='col'>商店名稱</th>"+
                  "<th scope='col'>點數</th></tr></thead><br><tbody>";
      for(var i=0; i<reData.length; i++) {
        pointTable+="<tr>";
        pointTable+="<th scope='col'>"+reData[i].orderID+"</th>";
        pointTable+="<th scope='col'>"+reData[i].customerID+"</th>";

        var store="";
        switch (reData[i].storeID) {
          case "0":
            store="Super WTLab's Shop";
            break;
          case "1":
            store="我們家 & Starbox 冷飲站";
            break;
          case "storeA":
            store="以前的 照道理不該出現了";
            break;
            case "Store1":
              store="以前的 照道理不該出現了";
              break;
        }
        pointTable+="<th scope='col'>"+store+"</th>";
        pointTable+="<th scope='col'>"+reData[i].point+"</th>";
        totalPoint+=parseInt(reData[i][3]);
        pointTable+="</tr>";
      }
      pointTable+="</tbody></table>";
      $("#pointTable").html(pointTable);

      $("#pointTitle").html("<h2>總點數為："+ totalPoint+"點</h2>");
    },
    error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
      console.log( errorThrown);
    }
  });

});

// Accordion
function myAccFunc(demoAcc) {
	var demoAccID = (demoAcc.value);

	if($("#demoAcc"+demoAccID).attr('class').indexOf("w3-show") == -1){
		$("#demoAcc"+demoAccID).addClass("w3-show");
	} else {
		$("#demoAcc"+demoAccID).removeClass("w3-show");
	}
}
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
}
