<?
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
<SCRIPT LANGUAGE="JavaScript" src="eps.js"></SCRIPT>

<LINK REL="STYLESHEET" TYPE="TEXT/CSS" href="/include/newEPS.css">

</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 
MARGINHEIGHT=0>
            <?
		if ($unitkerja !='')
		{
		$tahun=date("Y");
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

if ($radio1=='') $radio1=1;
if ($unitkerja!='all') {
switch($radio1) {
case 1:
$query="select * from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 >= '" . $gol1. "' ";
break;
case 2:
$query="select * from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 <= '" . $gol1. "' ";
break;
case 3:
$query="select * from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";
break;
}
} else {
switch($radio1) {
case 1:
$query="select * from MASTFIP1 where A_01!='99' and F_03 >= '" . $gol1. "' ";
break;
case 2:
$query="select * from MASTFIP1 where A_01!='99' and F_03 <= '" . $gol1. "' ";
break;
case 3:
$query="select * from MASTFIP1 where A_01!='99' and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";
break;
}
}
if (!$ignore) {
        $query.="and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (substring(B_05,1,7) >= '$tglok1' and I_5A=2)) ";
}
if ($jabatan!='all') {
        $query.="and I_5A='$jabatan' ";
}
if ($eselon!='all' && $eselon!='str') {
        $query.="and I_06='$eselon' ";
}
if ($eselon=='str') {
        $query.="and I_06<>'99' and I_06 is not null ";
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
if ($uks) {
switch ($unitkerja) {
case '02000000':include "nom_pns02_rule.inc";break;
case '21000000':include "nom_pns21_rule.inc";break;
case '22000000':include "nom_pns22_rule.inc";break;
case '23000000':include "nom_pns23_rule.inc";break;
case '24000000':include "nom_pns24_rule.inc";break;
case '25000000':include "nom_pns25_rule.inc";break;
case '26000000':include "nom_pns26_rule.inc";break;
case '27000000':include "nom_pns27_rule.inc";break;
case '28000000':include "nom_pns28_rule.inc";break;
case '29000000':include "nom_pns29_rule.inc";break;
case '30000000':include "nom_pns30_rule.inc";break;
case '31000000':include "nom_pns31_rule.inc";break;
case '32000000':include "nom_pns32_rule.inc";break;
case '34000000':include "nom_pns34_rule.inc";break;
case '35000000':include "nom_pns35_rule.inc";break;
case '36000000':include "nom_pns36_rule.inc";break;
case '37000000':include "nom_pns37_rule.inc";break;
case '38000000':include "nom_pns38_rule.inc";break;
case '39000000':include "nom_pns39_rule.inc";break;
}
}
$query.="order by F_03 DESC,F_02 ASC, F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
		  $no=0;
		  $r=mysql_query($query) or die (mysql_error());
		?>
		
		<table border="1" cellspacing="0" width="100%" style="border-collapse: collapse" bordercolor="#808080">
<tr><td colspan="8" align="center"><h3>UNIT KERJA : 
<?if ($unitkerja!='all') {echo lokasiKerja(substr($unitkerja,0,2));} else {echo "SEMUA UNIT KERJA";}?></h3></td></tr>
<tr><td colspan="8">
<?
if ($eselon!='all' && $eselon!='str') echo "Eselon : ".eselon($eselon)."<br>";
if ($kelamin!='all') echo "Jenis kelamin : ".jenisKelamin($kelamin)."<br>";
if ($agama!='all') echo "Agama : ".agama1($agama)."<br>";
?>
</td></tr>

          <tr><td colspan="8" align="center"><b>HASIL : 
<?=mysql_num_rows($r)?> Record</b></td></tr>
<tr>
		    <td width="3%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>NO</b></td>
		    <td width="20%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>NAMA<br>NIP<br>PANGKAT</b></td>
		    <td width="25%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>JABATAN</b></td>
		    <td width="30%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>ALAMAT</b></td>
		    <td width="20%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>INSTANSI</b></td>
<?/*if ($unitkerja=='all') {?>
		    <td width="6%" align="center" bgcolor="#DDDDDD"><font 
face="Tahoma" size="2"><b>UNIT KERJA</b></td><?}*/?>
		  </tr>

		  <?
$z=0;
		  while ($row=mysql_fetch_array($r))
		  {
		  	$no++;
			$z++;
			
		  	?>
		  <tr class="isinya">
		    <td valign="top" class="isinya" width="3%" 
align="right"><?=$no?></td>
		    <td valign="top" class="isinya" 
width="20%"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?><br><?=$row[B_02]?><br><?=pktH($row[F_03])?></td>
		    <td valign="top" class="isinya" 
width="25%"><?=$row[I_JB]?></td>
		    <td valign="top" class="isinya" 
width="30%"><?=$row[B_12]?></td>
		    <td valign="top" class="isinya" 
width="20%"><?=lokasiKerja($row[A_01])?></td>
<?/*if ($unitkerja=='all') {?>
		    <td valign="top" class="isinya" 
width="45%"><?=lokasiKerja($row[A_01])?></td><?}*/?>
		  </tr>
		  	<?
/*if ($z==65) {
$z=0;
?>
</table>
<p STYLE="page-break-after: always" align="center">&nbsp;</p>
<table border="1" cellspacing="0" width="100%" style="border-collapse: 
collapse" bordercolor="#808080">
<?
}*/
}		  ?>
		</table>
		<?
		}
		?>

        
</body>
</html>
