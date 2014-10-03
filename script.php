<?
include ("include/config.inc");
include ("include/fungsi.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
/*$q="select LT_01,LT_02,LT_07,LT_08 from MSTTEKN1 where LT_07='0000-00-00' and LT_08='0000-00-00' order by LT_01,LT_02";
//echo $q;
$r=mysql_db_query("bkd",$q);echo mysql_num_rows($r)."<br>";
$i=0;
while ($row=mysql_fetch_array($r)) {
//	echo $row[LT_01]." ". $row[LT_02]."<br>";
	$q2="select LT_01,LT_02,LT_07,LT_08 from MSTTEKN1 where LT_01='$row[LT_01]' and LT_02='$row[LT_02]' and LT_07>LT_08";
	$r2=mysql_db_query("test",$q2) or die(mysql_error());$j=mysql_num_rows($r2);
	while ($row2=mysql_fetch_array($r2)) {
//		echo $row2[LT_07]." ". $row2[LT_08]."<br>";
		$q3="update MSTTEKN1 set LT_07='$row2[LT_08]',LT_08='$row2[LT_07]' where LT_01='$row2[LT_01]' and LT_02=$row2[LT_02]";
		echo $q3."<br>";
		$r3=mysql_db_query("bkd",$q3) or die(mysql_error());
		$j=mysql_affected_rows();
		$i=$i+$j;
	}
}
echo $i;*/
?>
