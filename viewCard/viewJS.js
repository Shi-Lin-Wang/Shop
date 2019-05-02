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
		url:"php/viewMyCard.php",
		type:"GET",
		dataType:'json',
		success: function(re){  //一開始進入檢視的名片顯示為自己的
			$("#company").text(re[0].company);
			$("#name").text(re[0].name);
			$("#position").text(re[0].position);
			$("#phone").text(re[0].phone);
			$("#companyTel").text(re[0].companyTel);
			$("#email").text(re[0].email);
			$("#fax").text(re[0].fax);
			$("#address").text(re[0].address);

			$("#myCard").val(re[0].name);
		},
		error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
		  console.log( errorThrown);
		}

	  });

	  $.ajax({
		url:"php/viewCheckbox.php",  //呼叫的位址
		type:"GET",      //請求方式
		dataType:'json', //預期server回傳的形式
		success: function(e){

			var checkboxDiv = $('#checkboxDiv');

			for(var i=0;i<e.length;i++){

				var check = $('<a/>')
						.html("<input type='checkbox' class='people' name='people' id='people' value='"+e[i].name+"'>")
						.appendTo(checkboxDiv);

				var btn = $('<a/>')
					.html("<button type='button' class='btn btn-link' value='"+e[i].name+"' id='"+e[i].name+"' onclick='return showInfo(this);'>"+e[i].name+"</button>")
					.appendTo(checkboxDiv);

				var b = $('<a/>')
					.html("</br>")
					.appendTo(checkboxDiv);
			}
		},
		error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
		  console.log( errorThrown);
		}
	});
}

function del(){
	var chkArray = [];
	$(".people:checked").each(function() {
		chkArray.push("'"+$(this).val()+"'");
	});

	var selected;
	selected = chkArray.join(',') ;

	if(selected.length > 0){
		$.ajax({
			url:"php/delCardAjax.php",  //呼叫的位址
			type:"POST",      //請求方式
			data:{"selected": selected},
			dataType:'json', //預期server回傳的形式
			success: function(e){

				var checkboxDiv = $('#checkboxDiv');

				checkboxDiv.empty(); //先清空再重寫html

				for(var i=0;i<e.length;i++){

					var check = $('<a/>')
						.html("<input type='checkbox' class='people' name='people' id='people' value='"+e[i].name+"'>")
						.appendTo(checkboxDiv);

					var btn = $('<a/>')
						.html("<button type='button' class='btn btn-link' value='"+e[i].name+"' id='"+e[i].name+"' onclick='return showInfo(this);'>"+e[i].name+"</button>")
						.appendTo(checkboxDiv);

					var b = $('<a/>')
						.html("</br>")
						.appendTo(checkboxDiv);
				}
			},
			error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
			  console.log(errorThrown);
			}
		});

		$.ajax({
			url:"php/delShowInfoAjax.php",
			type:"GET",
			dataType:'json',
			success: function(afterDelShowAccountCard){  //顯示點擊的名片
				$("#company").text(afterDelShowAccountCard[0].company);
				$("#name").text(afterDelShowAccountCard[0].name);
				$("#position").text(afterDelShowAccountCard[0].position);
				$("#phone").text(afterDelShowAccountCard[0].phone);
				$("#companyTel").text(afterDelShowAccountCard[0].companyTel);
				$("#email").text(afterDelShowAccountCard[0].email);
				$("#fax").text(afterDelShowAccountCard[0].fax);
				$("#address").text(afterDelShowAccountCard[0].address);
			},
			error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
			  console.log( errorThrown);
			}
		});

	}else{
		alert("未勾選");
	}
}

function checkModify(){
	var chkArray = [];
	$(".people:checked").each(function() {
		chkArray.push($(this).val());
	});

	if(chkArray.length > 1){
		alert("請選一個進行修改");
		return false;
	}else if(chkArray.length == 0){
		alert("未勾選");
		return false;
	}
	else{
		return true;
	}
}

function showInfo(link){
	var clickVal = (link.value);

	$.ajax({
		url:"php/viewShowInfoAjax.php",
		type:"GET",
		data:{"clickVal": clickVal},
		dataType:'json',
		success: function(ClickCard){  //顯示點擊的名片
			$("#company").text(ClickCard[0].company);
			$("#name").text(ClickCard[0].name);
			$("#position").text(ClickCard[0].position);
			$("#phone").text(ClickCard[0].phone);
			$("#companyTel").text(ClickCard[0].companyTel);
			$("#email").text(ClickCard[0].email);
			$("#fax").text(ClickCard[0].fax);
			$("#address").text(ClickCard[0].address);
		},
		error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
		  console.log( errorThrown);
		}
	});
}

function logout(){
	var now = new Date();
	now.setTime(now.getTime()-1000*600);
	document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=wtlab.ddns.net";
	//document.cookie = "token=null;expires="+now.toGMTString()+";path=/wtlab108;domain=140.127.74.168";
	window.location = "../index.html";
}

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