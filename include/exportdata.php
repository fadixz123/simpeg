<?
include("config.inc");
include("fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);

$atabel=array(1=>"MASTJAB1","MASTKEL1","MASTPKT1","MSTBHSA1","MSTFUNG1","MSTJASA1","MSTKURS1","MSTORTU1","MSTPEND1","MSTPTAR1","MSTSEMI1","MSTSTRU1","MSTTEKN1","MSTTGAS1");
$afield=array(1=>"JF_01",   "KF_01",   "PF_01",   "BS_01",   "LT_01",   "JS_01",   "LT_01",   "NM_01",   "DK_01",   "LT_01",   "LT_01",   "LT_01",   "LT_01",   "TG_01");

$jmltabel=count($atabel);

$q="select * from MASTFIP08 where A_01='$uk'";
$r=mysql_query($q) or die (mysql_error());
$jrows=mysql_num_fields($r);
$akhir=$jrows-1;
while ($o=mysql_fetch_array($r)) {
	$buf1="";
	$buf1 .= "replace into MASTFIP08 set ";
	for ($i=0;$i<$jrows;$i++) {
		$buf1 .= mysql_field_name($r,$i)."=\"".mysql_escape_string($o[$i])."\"";
		if ($i!=$akhir) $buf1.=",";
	}
	$buff .= $buf1.";\n";
	
	$buf1="";
	
	for ($k=1;$k<=$jmltabel;$k++) {
		$buf1 .= "delete from $atabel[$k] where $afield[$k]='$o[B_02]';\n";
	}
	$buff .= $buf1;
	
	$buf1="";
	
	for ($l=1;$l<=$jmltabel;$l++) {
		$qh = "select * from $atabel[$l] where $afield[$l]='$o[B_02]'";
		$rh=mysql_query($qh) or die(mysql_error());
		$jrowsh=mysql_num_fields($rh);
		$akhirh=$jrowsh-1;
		while ($oh=mysql_fetch_array($rh)) {
			$buf1 = "insert into $atabel[$l] set ";
			for ($j=1;$j<$jrowsh;$j++) {
				$buf1 .= mysql_field_name($rh,$j)."=\"".mysql_escape_string($oh[$j])."\"";
				if ($j!=$akhirh) $buf1.=",";
			}
			$buff .= $buf1.";\n";
		}
	}	
}
//	echo nl2br($buff);

$nauk="EPS_";
$nauk.=lokasiKerja($uk);
$arnama=explode(" ",$nauk);
$nafile=implode("_",$arnama);
$nafile=str_replace("/","_",$nafile);
$nafile=str_replace("&","DAN",$nafile);
$nafile=str_replace("\"","",$nafile);
$nafile=str_replace("'","",$nafile);
$nafile=str_replace(".","",$nafile);
$filename=$nafile."_";
$filename .=date('YmdHis').".sql";
$fd = fopen ($filename, "w");
$contents = fwrite ($fd, $buff);
fclose ($fd);
header("Pragma: public");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Length: ". filesize($filename));
readfile($filename);
unlink($filename);
		
mysql_close();
?>
