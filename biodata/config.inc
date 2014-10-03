<?
$db = 'kabpkl';
$db2= 'pupns';
$server = 'localhost';
$user = 'root';
$user2 = 'bkd2';
$pass = '';
$warnarow="#DDDDDD";
$warnarow2="#CCDD88";
$warnarow3="#CCCCCC";
$direktori_foto="../foto/";

//----------- fugsi fungsi ------------//
function print_nama($B_03A,$B_03,$B_03B)
{
	if ($B_03A!='') $dpn=$B_03A.". ";else $dpn="";
        if ($B_03B!='') $nama= $dpn.$B_03.", ".$B_03B; else $nama= $dpn.$B_03; 
	return $nama;
}
function gaji($gol1,$thmasker1)
{
	$gaji="select GJ_BR from TABGAJI where PKT='$gol1' and MSK='$thmasker1'";
	$rgaji=dbquery2($gaji);
	$ogaji=mysql_fetch_array($rgaji);
	$gaji=$ogaji["GJ_BR"];
	return $gaji;
}
function format_tanggal($tanggal)
{
	$tanggal1=substr($tanggal,8,2)."-".substr($tanggal,5,2)."-".substr($tanggal,0,4);
	return $tanggal1;
}

function namapkt($pangkat)
{
switch(intval($pangkat)) {
  case 11: $pkt_nya="JURU MUDA";break;
  case 12: $pkt_nya="JURU MUDA TK I";break;
  case 13: $pkt_nya="JURU";break;
  case 14: $pkt_nya="JURU TK I";break;
  case 21: $pkt_nya="PENGATUR MUDA";break;
  case 22: $pkt_nya="PENGATUR MUDA TK I";break;
  case 23: $pkt_nya="PENGATUR";break;
  case 24: $pkt_nya="PENGATUR TK I";break;
  case 31: $pkt_nya="PENATA MUDA";break;
  case 32: $pkt_nya="PENATA MUDA TK I";break;
  case 33: $pkt_nya="PENATA";break;
  case 34: $pkt_nya="PENATA TK I";break;
  case 41: $pkt_nya="PEMBINA";break;
  case 42: $pkt_nya="PEMBINA TK I";break;
  case 43: $pkt_nya="PEMBINA UTAMA MUDA";break;
  case 44: $pkt_nya="PEMBINA UTAMA MADYA";break;
  case 45: $pkt_nya="PEMBINA UTAMA";break;
  default : $pkt_nya="";
}	
return $pkt_nya;
}

function pktH($pkt)
{
	switch($pkt)
	{
		case "11" : $hasil='I/a';break;
		case "12" : $hasil='I/b';break;
		case "13" : $hasil='I/c';break;
		case "14" : $hasil='I/d';break;
		case "21" : $hasil='II/a';break;
		case "22" : $hasil='II/b';break;
		case "23" : $hasil='II/c';break;
		case "24" : $hasil='II/d';break;
		case "31" : $hasil='III/a';break;
		case "32" : $hasil='III/b';break;
		case "33" : $hasil='III/c';break;
		case "34" : $hasil='III/d';break;
		case "41" : $hasil='IV/a';break;
		case "42" : $hasil='IV/b';break;
		case "43" : $hasil='IV/c';break;
		case "44" : $hasil='IV/d';break;
		case "45" : $hasil='IV/e';break;
	}
	return $hasil;
}
function nosk($NIP)
{
	$q="select * from MASTPKT1 where PF_01='$NIP' order by PF_03 desc, PF_06 desc";
	
	$res=dbquery2($q);
	$o=mysql_fetch_array($res);
	$hasil=$o["PF_04"];
	return $hasil;
}

function eselon($eselon)
{
	switch ($eselon)
	{
		case '11': $thisesel="1A";break;
		case '12': $thisesel="1B";break;
		case '21': $thisesel="2A";break;
		case '22': $thisesel="2B";break;
		case '31': $thisesel="3A";break;
		case '32': $thisesel="3B";break;
		case '41': $thisesel="4A";break;
		case '42': $thisesel="4B";break;
		case '99': $thisesel="99";break;
	}
	
	return $thisesel;
}

function ortu($NIP,$pos,$field)
{
	$q="select * from MSTORTU1 where NM_01='$NIP' and NM_03='$pos'";
	$res=dbquery2($q);
	$o=mysql_fetch_array($res);
	$hasil=$o[$field];
	return $hasil;
}

function namajab($kojab,$kode)
{
	if ($kode=='02')
	$q="select najab as hasil1 from TBJAB where kojab='$kojab'";
	else
	$q="select FUNGSI as hasil1 from TABFUNG where KODE='$kojab'";
	
	$rr=dbquery2($q);
	$oo=mysql_fetch_array($rr);
	$hasil=$oo['hasil1'];
	
	return $hasil;
} 	

function dbquery2($query1)
{

$r=mysql_query($query1) or die ('this '.$query1.' error');
return $r;
}
function mydbq($q1)
{

	//mysql_select_db($db) or die(mysql_error());
	$r=mysql_unbuffered_query($q1) or die ('this '.$q1.' error');
	return $r;
}
function dbquery($db,$query)
{
mysql_select_db($db);
$r=mysql_query($query) or die ('this '.$query.' error');
return $r;
}

function PROPINSI($db2,$prop)
{
	$q="select NAMA from PROPKAB where KD='".$prop."00"."' order by NAMA";
	
        $r=mysql_db_query($db2,$q) or die (mysql_error());
        $o=mysql_fetch_array($r);
        return $o[NAMA];
}

function KABKOTA($db2,$prop,$kabkota)
{
	$q="select NAMA from PROPKAB where KD='".$prop.$kabkota."' order by NAMA";
        $r=mysql_db_query($db2,$q) or die (mysql_error());
        $o=mysql_fetch_array($r);
        return $o[NAMA];
}

function INSTANSI($db2,$instansi)
{
	$q1="select NAMA from INSTANSI where KD='$instansi' LIMIT 1";
    	$r1=mysql_db_query($db2,$q1) or die (mysql_error());
    	$o=mysql_fetch_array($r1);
    	return $o[NAMA];
}

function KECAMATAN($db2,$prop,$kabkota,$kecamatan)
{
	$q="select NAMA from $db2.KECAMATAN where substring(KD,1,2)='".substr($prop,0,2)."' and substring(KD,3,2)='$kabkota' and substring(KD,5,4) ='$kecamatan' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NAMA];
}

	
function UKER($db,$kode)
{
	$q="select NM from $db.TABLOK where substring(KD,1,2)='$kode' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NM];
}

function JENISKEPEG($db,$kode)
{
	$q="select NAMA from $db.JENISKEPEG where KD='$kode' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NAMA];
}

function KEDUKPNS($db,$kode)
{
	$q="select NAMA from $db.KEDUKPNS where KD='$kode' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NAMA];
}

function TKTDIDIK($db,$kode)
{
	$q="select NAMA from $db.TKTDIDIK where KD='$kode' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NAMA];
}
?>