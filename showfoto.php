<?php
include("include/config.inc");
include("include/fungsi.inc");

$conn=mysql_connect($server,$user,$pass);
$db=mysql_select_db($db,$conn);

$NIP=$_GET[nip];
if ($NIP=='') {
	$qgb="select DATA,MIMETYPE from MASTFOTO where NIP='blank'";
} else {
	$qgb="select DATA,MIMETYPE from MASTFOTO where NIP='$NIP'";
}
$rgb=mysql_query($qgb) or die(mysql_error());
if (mysql_num_rows($rgb)==0) {
	$qgb="select DATA,MIMETYPE from MASTFOTO where NIP='blank02'";
	$rgb=mysql_query($qgb) or die(mysql_error());
}
$rogb=mysql_fetch_row($rgb);

header('Content-Length: '.strlen($rogb[0]));
header("Content-type: image/".$rogb[1]);
// outputing image
echo $rogb[0];
exit();
?>
