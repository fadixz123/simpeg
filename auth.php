<?
include("biodata/config.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (strlen($sid)> 0)
{
	if (strlen($username) != 0 && strlen($password) != 0)
	{
		$q="select username,password from USER where username='$username' and password='$password' LIMIT 1";
		$r=mysql_query($q) or die(mysql_error());
		$j=mysql_num_rows($r);
		if ($j > 0) 
		{
			mysql_query("delete from LOGUSER where TANGGAL='0000-00-00'") or die (mysql_error());
			
			$xtgl=date("Y-m-d",mktime(0,0,0,date("m")  ,date("d")-1,date("Y")));
			mysql_query("delete from LOGUSER where TANGGAL <= '$xtgl'") or die (mysql_error());		
			mysql_query("insert into LOGUSER set sub_app='biodata', user='$username', sid='$sid',TANGGAL='".date("Y-m-d")."'") or die (mysql_error());
			header("location:index.htm?sid=<?=$sid?>&sid=$sid&do=biodata&page=awal");
		}
		else header("Location:index.htm");
	}
	else header("Location:index.htm");	
}
else header("Location:index.htm");

mysql_close();
?>