<?
include("config.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (strlen($sid)> 0)
{
	mysql_query("delete from LOGUSER where sid='$sid' LIMIT 1") or die (mysql_error());
	header("Location:index.html");
	
}
else header("Location:index.html");

mysql_close();
?>