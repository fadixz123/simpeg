<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>:: e-PersonalSystem ::</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript">
    function cetak() {
        setTimeout(function(){ window.close();},300);
        window.print();    
    }
</script>

</HEAD>
<body onload="cetak();">
<?php
$unitkerja  = $_GET['unitkerja'];

$qcu="select distinct A_02 from TABLOKB08 where A_01='$unitkerja'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
//$uk     = $_GET['uk'];
$subuk  = $_GET['subuk'];
$hasupt = $_GET['hasupt'];
$radio1 = $_GET['radio1'];
$gol1   = $_GET['gol1'];
$gol2   = $_GET['gol2'];
$status = $_GET['status'];
$jabatan= $_GET['jabatan'];
$jabfung= $_GET['jabfung'];
$eselon = $_GET['eselon'];
$kelamin= $_GET['kelamin'];
$agama  = $_GET['agama'];
$diklat = $_GET['diklat'];
$dik    = $_GET['dik'];
$jur    = $_GET['jur'];
//$urut   = $_GET['urut'];
if ($unitkerja !='') {
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m")."-".date("d");
	if ($gol1=='') $gol1='11';
	if ($gol2=='') $gol2='45';
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B','5A');
		
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B','5A');
	$aNama=array(1=>'IA','IB','IIA','IIB','IIIA','IIIB','IVA','IVB','VA');
	$aGol=array(1=>'11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');
	$aNama=array(1=>'I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e');
		
		//----------- processing nominatif here ------
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m");//."-".date("d");

	$query="select * from MASTFIP08 where 1 ";
	if ($unitkerja!='all') {
		if (strlen($unitkerja)==2) $query.="and A_01='".$unitkerja."' ";
		else $query.="and A_01='".substr($unitkerja,0,2)."' and A_02='".substr($unitkerja,2,2)."' and A_03='".substr($unitkerja,4,2)."' ";
	} else $query.="and A_01<>'99' ";

	if ($subuk!='' && $subuk!='all') {
		if ($hasupt) $query.="and A_02='$subuk' ";
		else $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
	}
	
	if ($radio1=='') $radio1=1;
	switch($radio1) {
		case 1: $query.="and F_03 >= '" . $gol1. "' ";break;
		case 2: $query.="and F_03 <= '" . $gol1. "' ";break;
		case 3: $query.="and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";break;
	}

	if ($status!='all') {
		$query.="and B_09='$status' ";
	}
	if ($jabatan!='all') {
		if ($jabatan==2) $query.="and (I_5A='2' or I_5A='4') ";
		else $query.="and I_5A='$jabatan' ";
	}
	if ($jabfung!='') {
		$query.="and (I_5A='2' or I_5A='4') and I_05='$jabfung' ";
	}
	if ($eselon!='all' && $eselon!='str') {
        	if (strlen($eselon)==1) $query.="and I_06 like '".$eselon."%' ";else $query.="and I_06='$eselon' ";
	}
	if ($eselon=='str') {
		$query.="and I_06<>'99' and I_06 is not null and I_5A='1' ";
	}
	if ($kelamin!='all') {
		$query.="and B_06='$kelamin' ";
	}
	if ($agama!='all') {
		$query.="and B_07='$agama' ";
	}
	if ($diklat!='all') {
		$query.="and H_4A='$diklat' ";
	}
	if ($dik!='all') {
		$query.="and H_1A='$dik' ";
	}
	if ($jur!='') {
		$query.="and H_1B='$jur' ";
	}
	$query.="order by F_03 DESC,F_TMT ASC, I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
	$no=0;
        //echo $query;
	$r=mysql_query($query) or die (mysql_error());
?>
		
<table>
<tr><td align="center"><h3>UNIT KERJA : 
<?php if ($unitkerja!='all') {
	if (strlen($unitkerja)==2) echo lokasiKerjaB($unitkerja);
	else echo sublokasiKerjaB($unitkerja);}
else {echo "SEMUA UNIT KERJA";}?><br><?= $subuk!='' && $subuk!='all' ? ( $hasupt ? sublokasiKerjaB($unitkerja,$subuk,'00','00','00') : sublokasiKerjaB(substr($subuk,0,2),substr($subuk,2,2),substr($subuk,4,2),substr($subuk,6,2),substr($subuk,8,2))) : ""?></h3></td></tr>
<tr><td>
<?php
if ($eselon!='all' && $eselon!='str') echo "Eselon : ".eselon($eselon)."<br>";
if ($kelamin!='all') echo "Jenis kelamin : ".jenisKelamin($kelamin)."<br>";
if ($agama!='all') echo "Agama : ".agama1($agama)."<br>";
?>
</td></tr>
<tr><td><table width="100%" class="tabel-laporan">
  <tr>
    <th width="10">NO</th>
    <th width="5">NIP LAMA</th>
    <th width="110">NIP BARU</th>
    <th width="150">NAMA</th>
    <?php if ($showalamat=="true") { ?>
    <th width="30%">ALAMAT</th>
    <?php } ?>
	<th>TEMPAT LAHIR</th>
        <th>TGL LAHIR</th>
    <?php if ($showcpns=="true") { ?>
    <th width="7%">TMT CPNS</th>
    <?php } ?>
    <?php if ($showjk=="true") { ?>
    <th width="5%">JENIS KELAMIN</th>
    <?php } ?>
    <th width="100">JABATAN</th>
    <th colspan="3">UNIT KERJA</th>
    <th width="50">ESEL</th>
    <th width="50">G/R</th>
    <th>TMT</th>
    <th width="250">ALAMAT</th>
    <th width="10">PENDIDIKAN</th>
<th width="10">JURUSAN</th>
<th width="10">LULUS</th>
    <?php if ($showpdd=="true") { ?>
    <?php } ?>
  </tr>
  <?php
		$z=0;
		while ($row=mysql_fetch_array($r)) {
		  	$no++;
			$z++;
		?>
  <tr>
    <td valign="top" class="isinya" align="center">
      <?=$no?>
    </td>
    <td valign="top" class="isinya" align="center">
      <?=$row[B_02]?>
    </td>
    <td valign="top" class="isinya">
      <?=$row[B_02B] =='' ? $row[B_02] : format_nip_baru($row[B_02B])?>
    </td>
	
    <td valign="top" class="isinya">
      <?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?>
    </td>
	<td align="center" valign="top" class="isinya" width="7%"><?=$row[B_04]?>
    </td>
    <?php if ($showalamat=="true") { ?>
    <td valign="top" class="isinya" width="30%">
      <?=$row[B_12]?>
    </td>
	
     <?php } ?>
    <td align="center" valign="top" class="isinya" width="7%"><?= datefmysql($row[B_05])?>
    </td>
    <?php if ($showcpns=="true") { ?>
    <td valign="top" class="isinya" width="7%">
      <?=datefmysql($row[D_04])?>
    </td>
    <?php } ?>
    <?php if ($showjk=="true") { ?>
    <td valign="top" class="isinya" width="5%">
      <?= jenisKelamin($row[B_06])?>
    </td>
    <?php } ?>
    <td valign="top" class="isinya">
      <?= getNaJab($row[B_02])?>
    </td>
    <td valign="top" class="isinya">
      <?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03].$row[A_04])?>
    </td>
    <td valign="top" class="isinya">
      <?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03])?>
    </td>
    <td valign="top" class="isinya">
      <?=lokasiKerjaB($row[A_01])?>
    </td>
    <td valign="top" class="isinya" align="center">
      <?=eselon($row[I_06])?>
    </td>
    <td valign="top" class="isinya" align="center">
      <?=pktH($row[F_03])?>
    </td>
    <td valign="top" class="isinya" align="center">
      <?=  datefmysql($row[F_TMT])?>
    </td>
    <td valign="top" class="isinya" width="5%">
      <?=$row[B_12]?>
    </td>
	<td valign="top" class="isinya" width="5%"><?= tktdidik($row[H_1A])?></td>
<td valign="top" class="isinya" width="5%"><?= jurusan($row[H_1A],$row[H_1B])?></td>
<td valign="top" class="isinya" width="5%"><?=($row[H_02])?></td>
    <?php if ($showpdd=="true") { ?>
    <?php } ?>
  </tr>
  <?php } ?>
</table></td>
</tr>
</table>
<?php } ?>

        
</body>
</html>
