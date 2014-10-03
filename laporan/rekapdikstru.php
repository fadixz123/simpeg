<?
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>

<head>
<title>Jumlah PNS yang Telah Mengikuti Diklat Struktural</title>
</head>
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$dikstru=array("1","2","3","4","5","6","7","8","9");
$r=listUnitKerjaNoBiro();
?>
<body>

<h4 align="center">JUMLAH PEGAWAI NEGERI SIPIL YANG TELAH MENGIKUTI DILKAT 
STRUKTURAL<br>
KEADAAN PER : <?=tanggalnya(date("Y-m-d"),0);?><br>
PEMERINTAH <?=$KAB?></h4>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1">
  <tr>
    <th width="24"><font size="2" face="Verdana">NO</font></th>
    <th width="235"><font size="2" face="Verdana">UNIT KERJA</font></th>
    <th width="81"><font size="2" face="Verdana">DIKLATPIM Tk. IV</font></th>
    <th width="81"><font size="2" face="Verdana">DIKLATPIM Tk. III</font></th>
    <th width="81"><font size="2" face="Verdana">DIKLATPIM Tk. II</font></th>
    <th width="81"><font size="2" face="Verdana">DIKLATPIM Tk. I</font></th>
    <th width="81"><font size="2" face="Verdana">SEPADA/<br>
    ADUM</font></th>
    <th width="82"><font size="2" face="Verdana">SEPALA/<br>
    ADUMLA</font></th>
    <th width="82"><font size="2" face="Verdana">SEPADYA/<br>
    SPAMA</font></th>
    <th width="82"><font size="2" face="Verdana">SESPA/<br>
    SEPAMEN</font></th>
    <th width="83"><font size="2" face="Verdana">LEMHANAS</font></th>
  </tr>
  <tr>
    <th width="24"><font size="2">1</font></th>
    <th width="235"><font size="2">2</font></th>
    <th width="81"><font size="2">3</font></th>
    <th width="81"><font size="2">4</font></th>
    <th width="81"><font size="2">5</font></th>
    <th width="81"><font size="2">6</font></th>
    <th width="81"><font size="2">7</font></th>
    <th width="82"><font size="2">8</font></th>
    <th width="82"><font size="2">9</font></th>
    <th width="82"><font size="2">10</font></th>
    <th width="83"><font size="2">11</font></th>
  </tr>
<?
$ii=0;
foreach ($r as $key=>$row) {
	$ii++;
	for ($i=0;$i<count($dikstru);$i++) {
		$query="select count(*) as jml from MASTFIP08 where H_4A='$dikstru[$i]' and A_01='".substr($row[0],0,2)."' and A_01<>'99' and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
		$r1=mysql_query($query);
		$row1[$i]=mysql_fetch_array($r1);
	}
?>
  <tr>
    <td width="24" align="right"><font size="1" face="Verdana"><?=$ii?></font>&nbsp;</td>
    <td width="235"><font size="1" face="Verdana"><?=$row[nm]?></font>&nbsp;</td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row1[8][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row1[7][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row1[6][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row1[5][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row1[4][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row1[3][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row1[2][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row1[1][jml]?></font></td>
    <td width="83" align="right"><font size="1" face="Verdana"><?=$row1[0][jml]?></font></td>
  </tr>
<?}
for ($i=0;$i<count($dikstru);$i++) {
	$query1="select count(*) as jml from MASTFIP08 where H_4A='$dikstru[$i]' and A_01<>'99' and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
	$r2=mysql_query($query1);
	$row2[$i]=mysql_fetch_array($r2);
}
?>
  <tr>
    <td width="24">&nbsp;</td>
    <td width="235">
    <p align="center"><font size="1" face="Verdana">JUMLAH</font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row2[8][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row2[7][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row2[6][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row2[5][jml]?></font></td>
    <td width="81" align="right"><font size="1" face="Verdana"><?=$row2[4][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row2[3][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row2[2][jml]?></font></td>
    <td width="82" align="right"><font size="1" face="Verdana"><?=$row2[1][jml]?></font></td>
    <td width="83" align="right"><font size="1" face="Verdana"><?=$row2[0][jml]?></font></td>
  </tr>
</table>

</body>

</html>
