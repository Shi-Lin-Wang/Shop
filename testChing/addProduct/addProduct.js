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


window.addEventListener( "load", start, false );

function start(){
  $token = getCookie("token");
  console.log($token);
  $.ajax({
    url:"../../php/navSigninCheck.php",  //呼叫的位址
    type:"GET",      //請求方式
    data:{"token": $token},//傳送到server的資料
    dataType:'json', //預期server回傳的形式
    success: function(reData){     //成功的時候跑的函式
      console.log("Account Show Data");
      console.log(reData);
      var account = reData[0][0];
      $("#user").html(account);

    },
    error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
      console.log( errorThrown);
    }
  });

}

function setOption(input, id){
		for(value in input){
			$(id).append($("<option value='" + input[value].categoryID + "'>" + input[value].categoryName + "</option>"));
		}
	}

	$(document).ready(function () {

		var data = (function () {
			$.ajax({
				async: false,
				global: false,
				url: "../categoryTree/makeJson.php",
				dataType: "json",
				success: function (product) {
					data = new CategoryTree(product);
				}
			});
			return data;
		})();

		setOption(data.layer1, "#sel1");

		$("#sel1").click(function(){
			$('#sel2').empty();
			$('#sel3').empty();
			for(value in data.layer1){
				if( $('#sel1').val() == data.layer1[value].categoryID ){
					setOption(data.layer1[value].children, "#sel2");
				}
			}
		});

		$("#sel2").click(function(){
			$('#sel3').empty();
			for(value in data.categoryMap){
				if($('#sel2').val() == data.categoryMap[value].categoryID){
					setOption(data.categoryMap[value].children, "#sel3");
				}
			}
		});

	 });

	  //------------------------------------- 上傳圖片預覽
		$(function (){

			function format_float(num, pos)
			{
				var size = Math.pow(10, pos);
				return Math.round(num * size) / size;
			}

			function preview(input) {
				if (input.files && input.files[0]) { // 若有選取檔案

					// 建立一個物件，使用 Web APIs 的檔案讀取器(FileReader 物件) 來讀取使用者選取電腦中的檔案
					var reader = new FileReader();

					// 事先定義好，當讀取成功後會觸發的事情
					reader.onload = function (e) {

						console.log(e);

						// 這裡看到的 e.target.result 物件，是使用者的檔案被 FileReader 轉換成 base64 的字串格式，
						// 在這裡我們選取圖檔，所以轉換出來的，會是如 『data:image/jpeg;base64,.....』這樣的字串樣式。
						// 我們用它當作圖片路徑就對了。
						$('.preview').attr('src', e.target.result);
						//$("input[name='imagestring']").val(e.target.result);
						$('.imagestring').val(e.target.result);

						// 檔案大小，把 Bytes 轉換為 KB
						var KB = format_float(e.total / 1024, 2);
						$('.size').text("檔案大小：" + KB + " KB");
					}

					// 因為上面定義好讀取成功的事情，所以這裡可以放心讀取檔案
					reader.readAsDataURL(input.files[0]);
				}
			}

			$("body").on("change", ".upl", function (){
				preview(this);
			})

		})
		//-------------------------------------------------
		/*
		function checkFormA(){
			var res="";
			var lines = $('#productDescription').val().split('\n');
			for(var i = 0;i < lines.length;i++){
				res += lines[i]+"<br>"
			}
			$("#productDescription").val(res);
			alert("A");
			return true;
		}
		*/
function logout(){
	var now = new Date();
	now.setTime(now.getTime()-1000*600);
	document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=127.0.0.1";
	//document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=140.127.74.168";
	window.location = "../../index.html";
}
function checkForm(){
	alert($('#sel3').val());
	if(!$('#sel3').val()){
		alert("請分類設定");
		$("#categorySet").css("color", "red").css("font-weight","bold");
		return false;
	}

	var res="";
	var lines = $('#productDescription').val().split('\n');
	for(var i = 0;i < lines.length;i++){
		res += lines[i]+"<br>"
	}
	$("#productDescription").val(res);

	return true;
}
