<?
include('config.inc');

$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

include('session.inc');

if (!isset($uk)) {
	header("Location:index.html?do=peta");
	exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Peta Jabatan</title>
<style>
<!--
td	     { font-family: Tahoma; font-size: 10px; color: #000000; }
a:active     { font-family: Tahoma; font-size: 9px }
a:link       { font-family: Tahoma; font-size: 9px }
a:visited    { font-family: Tahoma; font-size: 9px }
a            { font-family: Tahoma; font-size: 9px ;text-decoration : none; color:#000000;}
A:hover       {font-family: Tahoma; font-size: 9px; text-decoration: underline; color: #FFFFFF
-->
</style>
</head>
</body>
<?
//$uker='25';

if ($uk=='02000000') {
        $esel1='12';
        $esel2='21';
} elseif (($uk >= '02001100') && ($uk <='02004300')) {
        $esel1='22';
        $esel2='31';
	$isbiro=true;
} elseif (substr($uk,0,1)==4) {
	$esel1='31';
	$esel2='41';
} else {
	$esel1='21';
	$esel2='31';
}
$uker=substr($uk,0,2);

include("fungsi.inc");

if ($isbiro) {
	$q="select count(*) as jml  from MASTFIP1 where A_01=substring('$uk',1,2) and A_03=substring('$uk',5,2)";
} else {
	$q="select count(*) as jml  from MASTFIP1 where substring(A_01,1,2)='$uker'";
}
$r=mysql_query($q);
$row=mysql_fetch_array($r);
$jmlpns=$row[jml];

if ($isbiro) {
	$q="select KOJAB,NAJAB from TBJAB where KOJAB=concat(substring('$uk',1,2),substring('$uk',5,4)) and ESEL='$esel1'";
} else {
	$q="select KOJAB,NAJAB from TBJAB where substring(KOJAB,1,2)='$uker' and ESEL='$esel1'";
}

$r=mysql_query($q);
$row=mysql_fetch_array($r);
$KOJABA[1] = $row[KOJAB];
$NAJABA[1] = $row[NAJAB];

if ($isbiro) {
	$q="select KOJAB,NAJAB from TBJAB where KOJAB=substring('$uk',1,6) and ESEL='$esel2'";
} else {
	$q="select KOJAB,NAJAB from TBJAB where substring(KOJAB,1,2)='$uker' and ESEL='$esel2'";
}
$r=mysql_query($q);
$i=0;
while ($row=mysql_fetch_array($r)) {
	$i++;
	$KOJABB[$i] = $row[KOJAB];
	$NAJABB[$i] = $row[NAJAB];
}

$jmlKolom = sizeOf($KOJABB)+1;
$posisiBos1 = ceil($jmlKolom/2);

// start draw table

?>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="<?=$jmlKolom * 190?>">



<?
//---------------- sub kedua

for ($i=1;$i<$jmlKolom;$i++) {
	if ($uk=='02000000') {
		$q="select KOJAB,NAJAB from TBJAB where substring(KOJAB,1,3)='".substr($KOJABB[$i],0,3)."' and ESEL <='22' order by KOLOK";
	} elseif ($isbiro) {
		$q="select KOJAB,NAJAB from TBJAB where substring(KOJAB,1,5)=substring('$KOJABB[$i]',1,5) and ESEL >'22' order by KOLOK";
	} else {
		//$q="select KOLOK,NALOK from TABLOKB where substring(KOLOK,1,6)='".substr($KOJABB[$i],0,6)."' and ESEL !='99'";
		$q="select KOJAB,NAJAB from TBJAB where substring(KOJAB,1,2)='$uker' and ESEL<>'99' and KOJAB>='$KOJABB[$i]' order by KOJAB";
		if ($KOJABB[$i+1]!='') $q.=" and KOJAB<'".$KOJABB[$i+1]."'";
	}
	$r=mysql_query($q);
	$y=0;
	$jmlX[$i]=mysql_num_rows($r);
	while($row=mysql_fetch_array($r)) {
		$y++;
		$KOJABX[$i][$y] = $row[KOLOK];
		$NAJABX[$i][$y] = $row[NALOK];
		
	}
}

// sort
rsort($jmlX);
reset($jmlX);

?>
<tr>
<?
$kolspan=0;
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==$posisiBos1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="bottom">
                <?
                $q="select B_02,B_03A,B_03B,B_03,F_03,I_05 from MASTFIP1 where A_01 = '$uker' and I_05='".$KOJABA[0]."' LIMIT 1";
                $r=mysql_query($q);
                $row=mysql_fetch_array($r);
                if (file_exists("../foto/".$row[B_02].".png"))
                        $foto="<img src=\"../foto/".$row[B_02].".png\" width=\"100\" height=\"130\">" ;
                else if (mysql_num_rows($r) == 0)
                        $foto="<img src=\"gambar/blank.png\" width=\"100\" height=\"130\">" ;
                else
                        $foto="<img src=\"gambar/blank02.png\" width=\"100\" height=\"130\">" ;

                ?>
			<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
			<tr bgColor="#93C3FC" height="50">
				<td width="165" align="center"><?=$foto?></td>
			</tr>
			</table>
		</td>
		<?
	} else if ($i < $posisiBos1) {
		if ($kolspan == 0) {
			$kalinya = $posisiBos1 - 1;
			$lebarnya = 190 * $kalinya;
			$colspannya = 3 * $kalinya; 
			?>
			<td colspan="<?=$colspannya?>" width="<?=$lebarnya?>" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">	
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:12px;"><b>STRUKTUR ORGANISASI</b>
					</td>
				</tr>
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:15px;"><b><?=lokasiKerja($uker)?></b>
					</td>
				</tr>
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:12px;">&nbsp;
					</td>
				</tr>
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:8px;"><b>Data per-Tanggal <?=date("d.m.Y")?></b>
					</td>
				</tr>
				</table>
			</td>
			<?
			$kolspan=1;
		}
	} else {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top">&nbsp;</td>
		<?
	}
}
?>
</tr>
<tr>
<?
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==1) { ?>
                <td width="5">&nbsp;</td>
                <td width="20">&nbsp;</td>
	        <td width="165" valign="top"><img src="gambar/tengahparo.gif" width="165" height="40" border="0"></td>
	<?
	} elseif ($i==$posisiBos1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top" background="gambar/atastengahan.gif"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
		<?
	} else {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top">&nbsp;</td>
		<?
	}
}
?>
</tr>
<tr>
<?
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top"><img src="gambar/tengahkiri.gif" width="165" height="40" border="0"></td>
		<?
	} else if ($i==$jmlKolom - 1) {
		?>
		<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/tengahkanan.gif" width="165" height="40" border="0"></td>
		<?
	} else if ($i < $jmlKolom - 1) {
		?>
		<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/pertigaan.gif" width="165" height="40" border="0"></td>
		<?
	}
}
?>
</tr>
<?
for ($y=1;$y<=$jmlX[0];$y++) {
	if ($y==2) {
		?>
		<tr>
		<?
		for ($i=1;$i<=$jmlKolom;$i++) {
			if ($i < $jmlKolom ) {
				?>
				<td width="5">&nbsp;</td>
				<td width="20">&nbsp;</td>
				<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
				<?
			
			} else {
				?>
				<td width="5">&nbsp;</td>
				<td width="20">&nbsp;</td>
				<td width="165" valign="top">&nbsp;</td>
				<?
			}
		}
		?>
		</tr>
		<tr>
		<?
		for ($i=1;$i<=$jmlKolom;$i++) {
			if ($i < $jmlKolom ) {
				?>
				<td width="5">&nbsp;</td>
				<td width="20"><img src="gambar/pojokkiriatas.gif" width="20" height="40" border="0"></td>
				<td width="165" valign="top"><img src="gambar/separobiasa.gif" width="165" height="40" border="0"></td>
				<?
			
			} else {
				?>
				<td width="5">&nbsp;</td>
				<td width="20">&nbsp;</td>
				<td width="165" valign="top">&nbsp;</td>
				<?
			}
		}
		?>
		</tr>
		<?
				
	}
	
	for ($i=1;$i<=$jmlKolom;$i++) {
	$jmlBaris[$i]=count($KOJABX[$i]);
		if ($i < $jmlKolom) {
			$gambar='';
			$bgpic='';
			if ($KOJABX[$i][$y] != '') {
				if ($y==1) {
				$gambar='';
				$bgpic="";	
				} else if ($KOJABX[$i][$y+1] == '') {
				$gambar= "<img src=\"gambar/sampingbawah.gif\" border=\"0\" width=\"20\" height=\"250\">";
				$bgpic="";
				} else {
				$gambar= "<img src=\"gambar/sampingtengah.gif\" border=\"0\" width=\"20\" height=\"250\">";
				$bgpic=" background=\"gambar/sampingtengahbg.gif\"";
				}
			}
			
			?>
			<td width="5">&nbsp;</td>
			<td width="20" <?=$bgpic?>><?=$gambar?></td>
			<td width="165" valign="<? if ($jmlBaris[$i]==1) {echo "top";} else {echo "center";}?>">
			<?
			if ($KOJABX[$i][$y] != '') {
			$qjmljfu="select count(*) as jml from MASTJFU where subuk='".$KOJABX[$i][$y]."'";
			$rowjmljfu=mysql_fetch_array(mysql_db_query("jfu",$qjmljfu));
			$jmljfu=$rowjmljfu[jml];
			$qjfu="select namajfu,count(*) as jml from MASTJFU b where subuk='".$KOJABX[$i][$y]."' group by namajfu order by namajfu";
			$rjfu=mysql_db_query("jfu",$qjfu);
			?>
				<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
				<tr bgColor="#93C3FC" height="50">
					<td width="165" align="center"><b><b><?=$NAJABX[$i][$y]?></b><br>
					<? if ($y!=1||$jmlBaris[$i]==1) {?>JFU : <?=$jmljfu?><?}?>
					</td>
				</tr>
			<? if ($y!=1||$jmlBaris[$i]==1) {?>
				<tr>
					<td width="165" align="left"><table border="0" width="100%"><span style="font-size: 6pt">

			<?
				while ($rowjfu=mysql_fetch_array($rjfu)) {
			?>
					<tr><td><span style="font-size: 6pt"><?=namaJFU($rowjfu[namajfu])?></span></td><td valign="top"><span style="font-size: 6pt"><?=$rowjfu[jml]?></span></td></tr>
			<?}?>
					</span></table></td>
				</tr>
			<?}?>
				</table>
			<?
			}
			?>
			</td>
			<?
		}
		else {/*
			?>
			<td width="5">&nbsp;</td>
			<td width="20">&nbsp;</td>
			<td width="165" valign="top">&nbsp;</td>
			<?*/
		}
		
	}
	?>
	</tr>
	
	<?
}



mysql_close();
?>
</table>

</body>

</html>
