<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
//$unitkerja=$uk;
$aBulan= array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>:: e-PersonalSystem ::</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT LANGUAGE="JavaScript" src="eps.js"></SCRIPT>
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript" src="../Scripts/jquery.min.js" ></script>
<SCRIPT>
    function cetak() {
        //setTimeout(function(){ window.close();},300);
        $('button').hide();
        window.print();
        $('button').show();
    }
</SCRIPT>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 
MARGINHEIGHT=0>
<?php
$tahun = $_GET['tahun'];
$bln = $_GET['bln'];
$unitkerja = $_GET['uk'];
$qcu="select distinct A_02 from MASTFIP08 where A_01='$unitkerja'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;

if ($unitkerja !='') {
	//$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m")."-".date("d");
	if ($gol1=='') $gol1='11';
	if ($gol2=='') $gol2='45';
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B');
		
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B');
	$aNama=array(1=>'IA','IB','IIA','IIB','IIIA','IIIB','IVA','IVB');
	$aGol=array(1=>'11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');
	$aNama=array(1=>'I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e');
		
		//----------- processing nominatif here ------
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m");//."-".date("d");

	$query="select * from MASTFIP08 where ";
	if ($unitkerja!='all') {
		if (strlen($unitkerja)==2) $query.="A_01='".$unitkerja."' ";
		else $query.="A_01='".substr($unitkerja,0,2)."' and A_02='".substr($unitkerja,2,2)."' and A_03='".substr($unitkerja,4,2)."' ";
	}
	else $query.="A_01!='99' ";

	if ($subuk!='' && $subuk!='all') {
		if ($hasupt) $query.="and A_02='$subuk' ";
		else $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
	}
	
	$query.="and year(G_01) = year(date_sub(now(),interval 2 year)) and month(G_01) = '$bln' ";
	$query.="order by F_03 DESC,F_TMT ASC, I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
        
	$no=0;
	$r=mysql_query($query) or die (mysql_error());
?>
		
<table border="0" cellspacing="0" width="100%" style="border-collapse: collapse">
<tr><td align="center">
	<h3>NOMINATIF KENAIKAN GAJI BERKALA BULAN <?=strtoupper($aBulan[$bln])?> <?=$tahun?><br>
	UNIT KERJA : 
<?if ($unitkerja!='all') {
	if (strlen($unitkerja)==2) echo lokasiKerjaB($unitkerja);
	else echo sublokasiKerjaB($unitkerja);}
else {echo "SEMUA UNIT KERJA";}?><br><?= $subuk!='' && $subuk!='all' ? ( $hasupt ? sublokasiKerjaB($unitkerja,$subuk,'00','00','00') : sublokasiKerjaB($subuk)) : ""?></h3></td></tr>
<tr><td>
<table border="1" cellspacing="0" width="100%" style="border-collapse: collapse" bordercolor="#808080">

          <tr><td colspan="9" align="center"><b>HASIL : 
<?=mysql_num_rows($r)?> Record</b></td></tr>
<tr>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>NO</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>NIP</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>NIP BARU</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>NAMA</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>JABATAN</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>ESEL</b></td>
		    <td align="center" bgcolor="#DDDDDD"><font face="Tahoma" size="1"><b>G/R</b></td>
            <td bgcolor="#DDDDDD" align="center"><b><font face="Tahoma" size="1">GAJI LAMA</b></td>
            <td bgcolor="#DDDDDD" align="center"><b><font face="Tahoma" size="1">GAJI BARU</b></td>
		  </tr>

		<?
		$z=0;
		while ($row=mysql_fetch_array($r)) {
		  	$no++;
			$z++;
			$thmker=substr($row[G_02],0,2);
			$thmker2=$thmker+2;
		?>
		  <tr class="isinya">
		    <td valign="top" class="isinya" align="right"><?=$no?></td>
		    <td valign="top" class="isinya" align="center"><?=$row[B_02]?></td>
		    <td valign="top" class="isinya" align="center"><?=format_nip_baru($row[B_02B])?></td>
		    <td valign="top" class="isinya"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
            <td valign="top"><?= getNaJab($row[B_02])?></td>
		    <td valign="top" class="isinya" align="center"><?=eselon($row[I_06])?></td>
		    <td valign="top" class="isinya" align="center"><?=pktH($row[F_03])?></td>
            <td valign="top" align="center"><?=number_format(gaji($row[F_03],$thmker))?></td>
            <td valign="top" align="center"><?=number_format(gaji($row[F_03],$thmker2))?></td>
		  </tr>
		<? } ?>
	</table>
	</td></tr>
</table>
<? } ?>
        <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>
</html>