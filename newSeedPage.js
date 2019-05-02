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

//http://www.eion.com.tw/Blogger/?Pid=1130
/*
	1. homepage get failToLogin //  return int
	2. homepage get token //
	3. homepage get AuthOver (true or false)
*/
//進入登入頁面時做的動作，如果網頁有cookie則檢查登入狀態


function index(){
    var acc = getCookie("seed");
    if(document.cookie.length>0 && getCookie("seed") != null ){
      $.ajax({
        url:"https://wtlab.ddns.net/wtlab108/seed/"+acc+".txt",  //呼叫的位址
        type:"GET",      //請求方式
        data:{},//傳送到server的資料
        dataType:'text', //預期server回傳的形式
        success: function(reData){     //成功的時候跑的函式
          console.log(reData);
          $("#seed").html(reData);

          $("#save").attr("href","https://wtlab.ddns.net/wtlab108/php/saveSeed.php?acc="+acc+"&seed="+reData);
          $("#DLButton").attr("href","https://wtlab.ddns.net/wtlab108/seed/"+acc+".txt");
        },
        error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
          console.log( errorThrown);
        }
      });
      var now = new Date();
      now.setTime(now.getTime()-1000*600);
      document.cookie = "seed=null;expires="+now.toGMTString()+";path=/wtlab108;domain=wtlab.ddns.net";

    }else{
         alert("你不該來這裡的");
         window.location = "index.html";
    }

}
