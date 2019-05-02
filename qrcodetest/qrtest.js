function qr(){
  var data=$('#text').prop("value");
  $("#qrImg").prop("src","https://chart.googleapis.com/chart?cht=qr&chs=100x100&choe=UTF-8&chld=L|0&chl="+data);
  $("#qrDownload").prop("href","https://chart.googleapis.com/chart?cht=qr&chs=100x100&choe=UTF-8&chld=L|0&chl="+data);

}
