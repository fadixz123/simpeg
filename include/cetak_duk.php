<?php
include('../include/config.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);

function dikstru($didik) {
	switch($didik) {
		case "1": $hasil="LEMHANAS";break;
                case "2": $hasil="SESPA/SEPAMEN";break;
                case "3": $hasil="SEPADYA/SEPAMA";break;
                case "4": $hasil="SEPALA/ADUMLA";break;
                case "5": $hasil="SEPADA/ADUM";break;
                case "6" : $hasil="DIKLATPIM Tk.I";break;
                case "7" : $hasil="DIKLATPIM Tk.II";break;
                case "8" : $hasil="DIKLATPIM Tk.III";break;
                case "9" : $hasil="DIKLATPIM Tk.IV";break;
		default: $hasil="";
        }
        return $hasil;
}

function tktdidik($didik) {
	switch($didik) {
		case "10": $hasil="SD";break;
        	case "20": $hasil="SMTP";break;
        	case "30": $hasil="SMTA";break;
        	case "41": $hasil="DIPLOMA I";break;
        	case "42": $hasil="DIPLOMA II";break;
        	case "43": $hasil="DIPLOMA III";break;
        	case "44": $hasil="DIPLOMA IV";break;
        	case "50": $hasil="SARJANA MUDA NON AKADEMI";break;
        	case "60": $hasil="SARJANA MUDA AKADEMI";break;
        	case "70": $hasil="SARJANA (S1)";break;
        	case "80": $hasil="PASCA SARJANA (S2)";break;
        	case "90": $hasil="DOCTOR (S3)";break;
        	default : $hasil="";
        }
        return $hasil;
}

function print_nama($B_03A,$B_03,$B_03B) {
	if ($B_03A!='') $dpn=$B_03A.". ";else $dpn="";
        if ($B_03B!='') $nama= $dpn.$B_03.", ".$B_03B; else $nama= $dpn.$B_03; 
	return $nama;
}

function tanggalnya($tanggal,$mau) {
	$aBulan= array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

	$angka=intval(substr($tanggal,5,2));
	if ($mau==1)
	$hasil=substr($tanggal,8,2)." ".$aBulan[$angka]." ".substr($tanggal,0,4); else
	$hasil=substr($tanggal,8,2)."-".substr($tanggal,5,2)."-".substr($tanggal,0,4);
	return $hasil;
}

function pktH($kod_pkt) {
	switch(intval($kod_pkt)) {
  	case 11: $pkt_nya="I/a";break;
  	case 12: $pkt_nya="I/b";break;
  	case 13: $pkt_nya="I/c";break;
  	case 14: $pkt_nya="I/d";break;
  	case 21: $pkt_nya="II/a";break;
  	case 22: $pkt_nya="II/b";break;
  	case 23: $pkt_nya="II/c";break;
  	case 24: $pkt_nya="II/d";break;
  	case 31: $pkt_nya="III/a";break;
  	case 32: $pkt_nya="III/b";break;
  	case 33: $pkt_nya="III/c";break;
  	case 34: $pkt_nya="III/d";break;
  	case 41: $pkt_nya="IV/a";break;
  	case 42: $pkt_nya="IV/b";break;
  	case 43: $pkt_nya="IV/c";break;
  	case 44: $pkt_nya="IV/d";break;
  	case 45: $pkt_nya="IV/e";break;
  	}
	return $pkt_nya;
}

function jurusan($didik,$jur) {
	$q1="select * from TABDIK".$didik." where kod='$jur'";
	$r=mysql_query($q1);
	$o1=mysql_fetch_array($r);
	$hasil=$o1["ket"];
	return $hasil;
}

function lokker($A_01) {
	if (strlen($A_01) == 2) $q1="select nm from TABLOK08 where kd='$A_01'";
	else $q1="select NALOK from TABLOKB08 where KOLOK='$A_01'";
	$r=mysql_query($q1);
	$o1=mysql_fetch_row($r);
	$hasil=$o1[0];
	return $hasil;
}	

function nipnya($nip) {
	$mynip=substr($nip,0,3)." ".substr($nip,3,3)." ".substr($nip,6,3);
	return $mynip;
}

function masaKerAsli($B_02) {
        $Q="select F_02,F_04,G_01,G_02,to_days(now()) - to_days(F_02) as selisih1,to_days(now()) - to_days(G_01) as selisih2 from MASTFIP08 where B_02 ='$B_02'";
        $ROW=mysql_fetch_array(mysql_query($Q));
        if ($ROW[F_02]>$ROW[G_01]) {$selisih=$ROW[selisih1];} else {$selisih=$ROW[selisih2];}
        if ($ROW[F_04]>$ROW[G_02]) {$mker=$ROW[F_04];} else {$mker=$ROW[G_02];}
        $tahun=floor($selisih/356);
        if ($tahun<>0) {
                $bulan=floor(($selisih-($tahun*356))/30);
        } else {
                $bulan=floor($selisih/30);
        }
        $thasli=substr($mker,0,2)+$tahun;
        $blasli=substr($mker,2,2)+$bulan;
        if ($blasli>12) {$blasli=$blasli-12;$thasli=$thasli+1;}
        if (strlen($thasli)<2) $thasli="0".$thasli;
        if (strlen($blasli)<2) $blasli="0".$blasli;
	return $thasli.$blasli;
}

function getNaJFU($nip) {
        $q="select b.NAJFU from MASTJFU a,TABJFU b where a.JABBARU=b.KOJFU and a.NIP='$nip'";
        $r=mysql_query($q) or die(mysql_error());
        $ro=mysql_fetch_row($r);
        if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJFK($nip) {
        $q="select I_JB from MASTFIP08 where B_02='$nip'";
        $r=mysql_query($q) or die(mysql_error());
        $ro=mysql_fetch_row($r);
        if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJabStru($nip) {
        $q="select b.NAJAB from MASTFIP08 a left join TABLOKB08 b on (a.I_05=b.KOLOK) where a.B_02='$nip'";
        $r=mysql_query($q) or die(mysql_error());
        $ro=mysql_fetch_row($r);
        if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJab($nip) {
        $q="select I_5A,I_JB from MASTFIP08 where B_02='$nip'";
        $r=mysql_query($q) or die(mysql_error());
        $ro=mysql_fetch_row($r);
        switch ($ro[0]) {
                case '1':
	case '4': $nama=getNaJabStru($nip);break;
                case '2': $nama=getNaJFK($nip);break;
                default: $nama=getNaJFU($nip);break;
        }
        if ($nama=='0') $nama="-";
        return $nama;
}

function format_nip_baru($nip) {
        $nipbaru=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
        return $nipbaru;
}
$tglskr=date("Y");
$pensiun=($tglskr-56)."-".date("m");//."-".date("d");
$pensiun1=($tglskr-61)."-".date("m")."-".date("d");
$A_01   = $_GET['A_01'];
if ($A_01 =='xx') $jjj="JAJARAN PEMERINTAH";
else $jjj.=lokker($A_01);

function kepala($jjj,$gol1,$gol2) {
?>
<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="1200" id="AutoNumber1">
  <tr>
    <td width="100%" align="center" class="judul">DAFTAR URUT KEPANGKATAN</td>
  </tr>
  <tr>
    <td width="100%" align="center" class="judul">PNS DI <?=$jjj." KABUPATEN PEKALONGAN";?></td>
  </tr>
  <tr>
    <td width="100%" align="center" class="judul">GOLONGAN RUANG : <?=$gol1?> SAMPAI DENGAN <?=$gol2?></td>
  </tr>
  <tr>
    <td width="100%" align="center" class="judul">KEADAAN : <?=date("d")."-".date("m")."-".date("Y");?></td>
  </tr>
  <tr>
    <td width="100%" align="center" class="judul">&nbsp;</td>
  </tr>
</table>
<? } ?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">

<title>::CETAK DUK::</title>
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript" src="../Scripts/jquery.min.js" ></script>
<script type="text/javascript">
    function cetak() {
        //setTimeout(function(){ window.close();},300);
        $('button').hide();
        window.print();
        $('button').show();
    }
</script>
<style>
    * { font-size: 10px; }
</style>
</head>
<body>
<?php
$unitkerja  = $_GET['A_01'];
$jabatan    = $_GET['jabatan'];
$eselon     = $_GET['eselon'];
$kelamin    = $_GET['kelamin'];
$agama      = $_GET['agama'];
$gol1       = $_GET['GOL1'];
$gol2       = $_GET['GOL2'];
if ($unitkerja !='')
{
if ($unitkerja == 'xx'){
$Q="select count(*) as Jumlah from MASTFIP08 where A_01 !='99' and A_01 !='' ";
}else{
if (strlen($unitkerja)==2) $Q="select count(*) as Jumlah from MASTFIP08 where A_01 ='$unitkerja' ";
else $Q="select count(*) as Jumlah from MASTFIP08 where A_01 ='".substr($unitkerja,0,2)."' and A_02 ='".substr($unitkerja,2,2)."' and A_03 ='".substr($unitkerja,4,2)."' ";
}
if ($jabatan!='' && $jabatan!='all') {
	if ($jabatan=='2') $query="and (I_5A='2' or I_5A='4') ";
	else $query.="and I_5A='$jabatan' ";
}
if ($eselon!='' && $eselon!='all' && $eselon!='str') {
        $query.="and I_06='$eselon' ";
}
if ($eselon=='str') {
        $query.="and I_06<>'99' and I_06 is not null ";
}
if ($kelamin!='' && $kelamin!='all') {
        $query.="and B_06='$kelamin' ";
}
if ($agama!='' && $agama!='all') {
        $query.="and B_07='$agama' ";
}
$Q.=$query;
$Q.="and F_03 >= '$gol1' and F_03 <= '$gol2' and B_09='2' order by F_03 DESC,F_TMT ASC,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC";

//echo $Q;
$row=mysql_fetch_array(mysql_query($Q));   

$akhir=$row[Jumlah];
if (intval($row[Jumlah]) <=21)
{
	$starthal=1;
	$stophal=1;
}
else
{
	$tothal=intval($row[Jumlah]);
	
	$sisa1 = $tothal - 21;
	if ($sisa1 <= 22)
	{
		$starthal=1;
		$stophal=2;
	}
	else
	{
		
		$sisa2=$sisa1 % 22;
		
		$halini= ($sisa1-$sisa2)/22;
		$starthal=1;
		$stophal=$halini +2;
		
	
	}

} 
$hal=$starthal;
$start=0;
$stop1=21;
$stop2=22;
$no1=0;
$myF04='';
}
$GOL1   = $_GET['GOL1'];
$GOL2   = $_GET['GOL2'];
for ($i=$starthal;$i<=$stophal;$i++) {
	if ($hal=='1') {
		$start=0;
		$stop=$stop1;
		$hal2start=$stop1;
		echo kepala($jjj,pktH($GOL1),pktH($GOL2));
	} else if ($hal=='2') {
		$start=$hal2start;
		$stop=$stop2;
	} else {
	    $start=$start+$stop2;
		$stop=$stop2;
	}
        
?>
 
<table width="100%" class="tabel-laporan" id="AutoNumber2">
  <tr>
    <td width="46" colspan="2" align="center"><b>NO URUT</b></td>
    <td width="206" rowspan="2" align="center"><b>NAMA PEGAWAI<br>
    NOMOR INDUK PEGAWAI</b></td>
    <td width="69" align="center"><b>PANGKAT</b></td>
    <td width="263" align="center"><b>JABATAN</b></td>
    <td width="45" colspan="2" align="center"><b>MKER</b></td>
    <td width="86" align="center"><b>LAT. JABATAN</b></td>
    <td width="22" align="center">&nbsp;</td>
    <td width="205" colspan="2" align="center"><b>PENDIDIKAN</b></td>
    <td width="80" rowspan="2" align="center"><b>TMP LAHIR<br>
    TGL LAHIR</b></td>
    <td width="35" rowspan="2" align="center"><b>CAT<br>MUT<br>KEPEG</b></td>
    <td width="176" rowspan="2" align="center"><b>UNIT KERJA</b></td>
  </tr>
  <tr>
    <td width="24" align="center"><b>PEG</b></td>
    <td width="22" align="center"><b>PKT</b></td>
    <td width="69" align="center"><b>G/R AKHIR<br>
    TMT</b></td>
    <td width="263" align="center"><b>NAMA JABATAN<br>
    TMT</b></td>
    <td width="24" align="center"><b>TH</b></td>
    <td width="21" align="center"><b>BL</b></td>
    <td width="86" align="center"><b>NAMA <br>
    TGL LULUS</b></td>
    <td width="22" align="center"><b>JAM</b></td>
    <td width="179" align="center"><b>NAMA PENDIDIKAN<br>
    TINGKAT PENDIDIKAN</b></td>
    <td width="26" align="center"><b>TH<br>
    LLS</b></td>
  </tr>
  <tr>
    <td width="24" align="center"><b>1</b></td>
    <td width="22" align="center"><b>2</b></td>
    <td width="206" align="center"><b>3/4</b></td>
    <td width="69" align="center"><b>5/6</b></td>
    <td width="263" align="center"><b>7/8</b></td>
    <td width="24" align="center"><b>9</b></td>
    <td width="21" align="center"><b>10</b></td>
    <td width="86" align="center"><b>11/12</b></td>
    <td width="22" align="center"><b>13</b></td>
    <td width="179" align="center"><b>14/15</b></td>
    <td width="26" align="center"><b>16</b></td>
    <td width="80" align="center"><b>17/18</b></td>
    <td width="35" align="center"><b>19</b></td>
    <td width="176" align="center"><b>20</b></td>
  </tr>
<?php

if ($A_01 == 'xx'){
$Q="select *,to_days(now()) - to_days(F_02) as selisih1,to_days(now()) - to_days(G_01) as selisih2 from MASTFIP08 where A_01 !='99' and A_01 !='' ";
} else {
$Q="select *,to_days(now()) - to_days(F_02) as selisih1,to_days(now()) - to_days(G_01) as selisih2 from MASTFIP08 where ";
if (strlen($A_01)==2) $Q.="A_01 ='$A_01' ";
else $Q.="A_01='".substr($A_01,0,2)."' and A_02='".substr($A_01,2,2)."' and A_03='".substr($A_01,4,2)."' ";
}

if ($jabatan!='' && $jabatan!='all') {
	if ($jabatan=='2') $query="and (I_5A='2' or I_5A='4') ";
	else $query.="and I_5A='$jabatan' ";
}

if ($eselon!='' && $eselon!='all' && $eselon!='str') {
        $query.="and I_06='$eselon' ";
}

if ($eselon=='str') {
        $query.="and I_06<>'99' and I_06 is not null ";
}

if ($kelamin!='' && $kelamin!='all') {
        $query.="and B_06='$kelamin' ";
}

if ($agama!='' && $agama!='all') {
        $query.="and B_07='$agama' ";
}

$Q.=$query;
$Q.="and F_03 >= '$GOL1' and F_03 <= '$GOL2' and B_09='2' order by F_03 DESC,F_TMT ASC,I_06 ASC, I_04 asc,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC LIMIT $start,$stop ";
//echo $Q;
$r=mysql_query($Q) or die (mysql_error());


while ($row=mysql_fetch_array($r)) {
	$no1++;
	if ($myF03 != $row[F_03]) $no2=0;
	$myF03=$row[F_03];
	$masaker=masaKerAsli($row[B_02]);
	$no2++;
	?>
  <tr>
    <td width="24" align="right" valign="top"><?=$no1?>&nbsp;</td>
    <td width="22" align="right" valign="top"><?=$no2?>&nbsp;</td>
    <td width="206" valign="top"><?=print_nama($row[B_03A],$row[B_03],$row[B_03B])?><br>NIP. <?=$row[B_02B]=='' ? nipnya($row[B_02]) : format_nip_baru($row[B_02B])?></td>
    <td width="69" align="center" valign="top"><?=pktH($row[F_03])."<br>".tanggalnya($row[F_TMT],0)?></td>
    <td width="263" valign="top"><?=substr(getNaJab($row[B_02]),0,100)."<br>".tanggalnya($row[I_04],0)?></td>
    <td width="24" align="right" valign="top"><?=substr($masaker,0,2)?>&nbsp;</td>
    <td width="21" align="right" valign="top"><?=substr($masaker,2,2)?>&nbsp;</td>
    <td width="86" valign="top"><?=dikstru($row[H_4A])."<br>".tanggalnya($row[H_4B],0)?></td>
    <td width="22" valign="top">&nbsp;</td>
    <td width="179" valign="top"><?=substr(jurusan($row[H_1A],$row[H_1B]),0,24)."<br>".tktdidik($row[H_1A])?></td>
    <td width="26" valign="top"><?=$row[H_02]?>&nbsp;</td>
    <td width="80" valign="top"><?=$row[B_04]?><br>
    <?=tanggalnya($row[B_05],0)?></td>
    <td width="35" valign="top">&nbsp;</td>
    <td width="176" valign="top"><?=lokker($row[A_01]);?>&nbsp;</td>
  </tr>
<?
}
?>
    <?
    //beri pembatas akhir halaman...
    $myno=$no1;
    $myno++;
    ?>
<tr><td colspan="14" valign="top">
<table width="100%">
<tr>
    <td width="10%" style="border: none;" align="left" valign="top">&nbsp;Hal : <?=$hal?></td>
    <td width="80%" style="border: none;" align="center" valign="top">DUK (c)2010 BKD DIKLAT KABUPATEN PEKALONGAN</td>
    <td width="10%" style="border: none;" align="right" valign="top"><? if ($myno < $akhir) echo "No : ".$myno." .... &nbsp;";?></td>
  </tr>
  </table>
</td>
</tr>
  
</table>
</td></tr></table>
<br/><br/>
<?
$hal++;
}
?>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
