$(document).ready(function(){
	$.ajax({
		url:"https://127.0.0.1/wtlab108/public/getCartAmount.php",
		type:"POST",
		dataType:'json',
		success: function(amount){
			//$("#cart").html("購物車 ("+amount+")");
			$("#cart").html('<span class="glyphicon glyphicon-shopping-cart" style="display:inline;"></span> &nbsp 購物車 ('+amount+')&nbsp <i class="fa fa-caret-down"></i>');
		},
		error: function(jqXHR, textStatus, errorThrown){    //失敗的時候跑的函式
		  console.log( errorThrown);
		}
	});
});
