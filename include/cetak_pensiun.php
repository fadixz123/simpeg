<?
include('config.inc');
include('fungsi.inc');
?>
<html>
<head>
<title>
Nominatif PNS yang Akan Pensiun
</title>
<LINK REL="STYLESHEET" TYPE="TEXT/CSS" href="newEPS.css">
</head>
<body>
<?
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if ($uk != '')
	{
		?>
<div align="center">
<h3>NOMINATIF PNS YANG AKAN PENSIUN <?if ($pensiun=='0') {echo "TAHUN INI";} else {echo $pensiun." TAHUN LAGI";}?></h3>
</div>
		<table width="100%" border="1" style="border-collapse: collapse" bordercolor="#000000">
		<tr bgcolor="CCCCCC">
		<td width="4" >No</td>
		<td><a href="cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>&sort=B_02">NIP</a></td>
		<td>NIP BARU</td>
		<td><a href="cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>&sort=B_03">NAMA PNS</a></td>
		<td>JABATAN</td>
		<td><a href="cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>&sort=F_03">G/R</a></td>
		<td>TGL LAHIR</td>
		<td>UNIT KERJA</td>
		<td><a href="cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>&sort=B_05">TMT PENSIUN</a></td>
		</tr>
		<?
		$thini=intval(date("Y"));
		$next=$thini+intval($pensiun);
      	        $thskr=$next-56;
	        $thskra=$thskr-1;
                $thskr1=$next-60;
                $thskr1a=$thskr1-1;
//$batas=
		$q="select * from MASTFIP08 where A_01<>'99' ";
		if ($uk!='all') {
			$q.="and A_01='".substr($uk,0,2)."' ";
		}
if ($jabatan!='all') {
        if ($jabatan=='1') {
                $q.="and (I_5A='$jabatan' and I_06<>99) ";
        }
        $q.="and I_5A='$jabatan' ";
}
if ($eselon!=''&&$eselon!='all' && $eselon!='str') {
        $q.="and I_06='$eselon' ";
}
if ($eselon=='str') {
        $q.="and I_06<>'99' and I_06 is not null ";
}
$q.="and        (
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskra' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='0' or I_5A='1' or I_5A='' or I_5A is null)
                                )
                        or
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr1' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskr1a' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='2' or I_5A='4')
                                )
			) ";
switch ($sort) {
	case "B_02":$q.="order by B_02";break;
	case "B_03":$q.="order by B_03";break;
	case "B_05":$q.="order by year(B_05),month(B_05),F_03 desc";break;
	default:$q.="order by F_03 desc";break;
}
		//echo $q;
		$r=mysql_query($q);
		$no=0;
		while ($row=mysql_fetch_array($r)) {
				$bllahir=substr($row['B_05'],5,2);
				$thlahir=substr($row[B_05],0,4);
				$bltmt=$bllahir+1;
				$thtmt=date('Y')+$pensiun;
				if ($bltmt>12) {
					$bltmt=1;
				}
				$no++;
			?>
			<tr>
			<td width="4"><? echo $no; ?></td>
			<td><? echo $row['B_02']; ?></td>
			<td><? echo $row['B_02B']; ?></td>
			<td><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?></td>
			<td><? echo getNaJab($row['B_02']); ?></td>
			<td><? echo pktH($row['F_03']); ?></td>
			<td><? echo tanggalnya($row['B_05'],0); ?></TD>
			<td><? echo lokasiKerjaB($row['A_01']); ?></td>
			<td><? echo "1-".$bltmt."-".$thtmt; ?></td>
			</tr>
			<?
		}
		?>

		</table>
		<?
	}
?>
</table>
</body>
</html>