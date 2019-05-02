<?php
    header('content-type: image/png');

    $input_text=$_POST['input_text'];
    $range=$_POST['range'];
    $url="https://chart.googleapis.com/chart?chs=".$range."&cht=qr&chl=".$input_text."&choe=UTF-8&chld=M|2";
    $input = "$url"; //路徑位置
    $output = "C:\\".iconv("UTF-8","big5",$input_text).'.jpg'; //儲存檔案名稱
    file_put_contents($output, file_get_contents($input));

    echo('已下載到C:\，檔名為'.$input_text.'.jpg');
?>
