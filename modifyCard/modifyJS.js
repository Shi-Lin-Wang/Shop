window.addEventListener( "load", start, false );

function start(){

	var url=window.location.toString(); //取得當前網址
	var str=""; //參數中等號左邊的值
	var str_value=""; //參數中等號右邊的值
	if(url.indexOf("?")!=-1){ //如果網址有"?"符號
		var ary=url.split("?")[1];
		str=ary[0].split("=")[0];
		str_value = decodeURI(ary.split("=")[1]);
	}

	$.ajax({
		url:"modifyCard.php",
		type:"POST",
		data:{"name": str_value },
		dataType:'json',
		success: function(people){  //

			$("#user").text(people[0].account);
			$("#company").val(people[0].company);
			$("#name").val(people[0].name);
			$("#position").val(people[0].position);
			$("#phone").val(people[0].phone);
			$("#companyTel").val(people[0].companyTel);
			$("#email").val(people[0].email);
			$("#fax").val(people[0].fax);
			$("#address").val(people[0].address);

			$("#modifyName").val(people[0].name);
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
	window.location = "index.html";
}
