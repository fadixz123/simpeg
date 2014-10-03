<?

function print_nama($B_03A,$B_03,$B_03B)
{
	if ($B_03A!='') $dpn=$B_03A.". ";else $dpn="";
        if ($B_03B!='') $nama= $dpn.$B_03.", ".$B_03B; else $nama= $dpn.$B_03; 
	return $nama;
}

function print_nip($nip)
{
	$hasil=substr($nip,0,3)." ".substr($nip,3,3)." ".substr($nip,6,3);
	return $hasil;
}

function print_nip_baru($nip)
{
	$hasil=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
	return $hasil;
}

function format_tanggal($tanggal)
{
	$tanggal1=substr($tanggal,8,2)."-".substr($tanggal,5,2)."-".substr($tanggal,0,4);
	return $tanggal1;
}

function format_tanggal_1($tanggal)
{
	$aBulan= array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

	$tanggal1=substr($tanggal,8,2)." ".$aBulan[intval(substr($tanggal,5,2))]." ".substr($tanggal,0,4);
	return $tanggal1;
}
function dbquery($db,$query)
{
mysql_select_db($db);
$r=mysql_query($query) or die ('this '.$query.' error');
return $r;
}
$warnarow="#DDDDDD";
$warnarow2="#6699FF";
$warnarow3="#DDDDDD";

function gaji($gol1,$thmasker1)
{
	$gaji="select GJ_BR from TABGAJI where PKT='$gol1' and MSK='$thmasker1'";
	$rgaji=mysql_db_query("kabpkl",$gaji);
	$ogaji=mysql_fetch_array($rgaji);
	$gaji=$ogaji["GJ_BR"];
	return $gaji;
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
	
	$res=dbquery("bkd",$q);
	$o=mysql_fetch_array($res);
	$hasil=$o["PF_04"];
	return $hasil;
}

function eselon($eselon)
{
	switch ($eselon)
	{
		case '11': $thisesel="I.a";break;
		case '12': $thisesel="I.b";break;
		case '21': $thisesel="II.a";break;
		case '22': $thisesel="II.b";break;
		case '31': $thisesel="III.a";break;
		case '32': $thisesel="III.b";break;
		case '41': $thisesel="IV.a";break;
		case '42': $thisesel="IV.b";break;
		case '51': $thisesel="V.a";break;
		case '99': $thisesel="-";break;
	}
	
	return $thisesel;
}

function eselon2($eselon)
{
	switch ($eselon)
	{
		case '1A': $thisesel="1A";break;
		case '1B': $thisesel="1B";break;
		case '2A': $thisesel="2A";break;
		case '2B': $thisesel="2B";break;
		case '3A': $thisesel="3A";break;
		case '3B': $thisesel="3B";break;
		case '4A': $thisesel="4A";break;
		case '4B': $thisesel="4B";break;
		case '99': $thisesel="-";break;
	}
	
	return $thisesel;
}
function ortu($NIP,$pos,$field)
{
	$q="select * from MSTORTU1 where NM_01='$NIP' and NM_03='$pos'";
	$res=mysql_db_query("bkd",$q);
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

function cetakJudul($B_03A,$B_03,$B_03B,$hal,$with)
{
	?>
    <tr>
      <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
          
          <TD width="70%" ><B>BIODATA</B> <B><?=print_nama($B_03A,$B_03,$B_03B);?></B></TD>
          <TD width="30%" ALIGN="RIGHT">Halaman <?=$hal?></TD>
          </TR> 
          <?
          if ($with=='1') {
          	?>
          <tr>
          <td colspan="2">&nbsp;</td>
          </tr>
          
          	<?
          }
          ?>
      </table>
      </td>
    </tr>
    	<?
}

function getJmlBarisTabel($TABEL,$COUNT,$FIELD)
{
	$q="select count($COUNT) as JML from $TABEL $FIELD";
	$r=mysql_query($q) or die (mysql_error());
	$row=mysql_fetch_array($r);
	$jrec=$row[JML];
	return $jrec;
}

//$NIP='500034404';
/*

*/
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
	$q="select NAMA from $db2.KECAMATAN where substring(KD,1,2)='".substr($prop,0,2)."' and substring(KD,3,2)='$kabkota' and substring(KD,5,4) = '$kecamatan' LIMIT 1";
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

function TKTDIDIK1($db,$kode)
{
	$q="select NAMA from $db.TKTDIDIK where KD='$kode' LIMIT 1";
	$r=mysql_query($q);
	$o=mysql_fetch_array($r);
	return $o[NAMA];
}

function tktDidik($tk) {
	switch($tk) {
		case "10" : $didik="SD";break;
		case "20" : $didik="SLTP";break;
		case "30" : $didik="SLTA";break;
		case "41" : $didik="DIPLOMA I";break;
		case "42" : $didik="DIPLOMA II";break;
		case "43" : $didik="DIPLOMA III";break;
		case "44" : $didik="DIPLOMA IV";break;
		case "50" : $didik="SARMUD NON AKADEMI";break;
		case "60" : $didik="SARMUD AKADEMI";break;
		case "70" : $didik="STRATA 1 (S1)";break;
		case "80" : $didik="STRATA 2 (S2)";break;
		case "90" : $didik="STRATA 3 (S3)";break;
		default : $didik="-";
	}
	return $didik;
}

function namaLokasiKerja($kd) {
	$kolok=$kd;
	$queryjab="select * from TABLOKB08 where KOLOK='$kd'";
	$rjab=mysql_query($queryjab);
	$rowjab=mysql_fetch_array($rjab);
	$esel=$rowjab['ESEL'];

	while ($kolok!='') {
		$isparent=true;
		$q1="select * from TABLOKB08 where KOLOK<'$kolok' and ESEL<'$esel' and substring(KOLOK,1,2)=substring('$kolok',1,2) order by KOLOK desc,ESEL desc limit 1";
		$rl1=mysql_query($q1);
		$rol1=mysql_fetch_array($rl1);
		$parentkolok=rtrim($rol1[KOLOK],'0');
		$parentlen=strlen($parentkolok);
		$testkolok=substr($kd,0,$parentlen);
		if ($parentkolok!=$testkolok) $isparent=false;
		$kolok=$rol1[KOLOK];
		$esel=$rol1[ESEL];
		if (substr($rol1[NALOK],0,7)!="ASISTEN" && $isparent) $namauk.=" ".$rol1[NALOK];
	}
	return $namauk;
}
?>