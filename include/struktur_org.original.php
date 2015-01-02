<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Struktur Organisasi</title>
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
<?php
include('config.inc');

$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if ($uk=='02') {
	$esel1='21';
	$esel15='22';
	$esel2='31';
}else if ($uk=='01') {
	$esel1='00';
	$esel2='22';
} else if ($uk=='40') {
	$esel1='22';
	$esel15='31';
	$esel2='32';
} else if ($uk=='41') {
	$esel1='31';
	$esel2='32';
} elseif ($upt!='00' || $uk>='80') {
    $iskantor=true;
    $esel1='41';
    $esel2='42';
} elseif ($uk>='50' && $uk<='56') {
	$iskantor=true;
	$esel1='31';
	$esel2='41';
} elseif ($uk>='60' && $uk<='78') {
    $iskantor=true;
	$esel1='31';
	$esel2='32';
	$esel21='41';
} else {
	$esel1='22';
	$esel2='31';
	$esel21='32';
}

include("fungsi.inc");


if ($isbiro) {
	$q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".rtrim($uk,'0')."%' and ESEL='$esel1'";
} else {
	$q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".$uk."%' and ESEL='$esel1' and A_02='$upt'";
}
$r=mysql_query($q);
$row=mysql_fetch_array($r);
$KOJABA[0] = $row[KOLOK];
$NAJABA[0] = $row[NAJAB];

if ($isbiro) {
	$q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".rtrim($uk,'0')."%' and ESEL='$esel2' ";//and A_02='00' ";
} else {
	$q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".$uk."%' and (ESEL='$esel2' or ESEL='$esel21') and A_02='$upt' ";
}
$q.="order by KOLOK";
$r=mysql_query($q);
$i=0;
while ($row=mysql_fetch_array($r)) {
	$i++;
	$KOJABB[$i] = $row[KOLOK];
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
    if ($isbiro) {
            $q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".rtrim($KOJABB[$i],'0')."%' and ESEL<>'99' ";//and A_02='00' ";
    } else {
            $q="select KOLOK,NAJAB from TABLOKB08 where KOLOK like '".substr($KOJABB[$i],0,5)."%' and KOLOK>='$KOJABB[$i]' and A_02='$upt' and ESEL<>'99'";
    }
    if ($issetda) $q.=" and ESEL<='22' ";
    if ($KOJABB[$i+1]!='') $q.=" and KOLOK<'".$KOJABB[$i+1]."'";
    $q.="and ESEL>='$esel2' order by KOLOK";
    $r=mysql_query($q);
    $y=0;
    $jmlX[$i]=mysql_num_rows($r);
    while($row=mysql_fetch_array($r)) {
            $y++;
            $KOJABX[$i][$y] = $row[KOLOK];
            $NAJABX[$i][$y] = $row[NAJAB];
    }
}

// sort
//rsort($jmlX);
//reset($jmlX);

?>
<tr>
<?
$kolspan=0;
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==$posisiBos1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top">
		<?
		$q="select B_02,B_02B,B_03A,B_03B,B_03,F_03,I_05 from MASTFIP08 where ";
		if ($isbiro) $q.="A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' and A_04='".substr($uk,6,2)."' and ";
		else $q.="A_01 = '$uk' and ";
		$q.="I_05='".$KOJABA[0]."' LIMIT 1";
		$r=mysql_query($q);
		$row=mysql_fetch_array($r);
		?>
			<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
			<tr>
				<td width="165" align="center"><img src="../showfoto.php?nip=<?=$row[B_02]?>" width="100" height="130"></td>
			</tr>
			<tr bgColor="#93C3FC" height="50">
				<td width="165" align="center"><b><?=jabatan($KOJABA[0])?></b></td>
			</tr>
			<tr height="30">
				<td width="165" align="center">
				<b><a href="../?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></a></b><br>
				<?=namapkt($row[F_03])?> (<?=pktH($row[F_03])?>)<br>
				NIP. <?=$row[B_02]?> /<br><?=format_nip_baru($row[B_02B])?>
				</td>
			</tr>
			</table>
		</td>
		<?
	} else if ($i < $posisiBos1) {
		if ($kolspan == 0) {
			$kalinya = $posisiBos1 - 1;
			$lebarnya = 190 * $kalinya;
			$colspannya = 3 * $kalinya;
			if ($upt=='00') $lokasinya=lokasiKerjaB($uk);
			else $lokasinya=subLokasiKerjaB($uk,$upt);
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
					<font style="font-size:15px;"><b><?=$lokasinya?></b>
					</td>
				</tr>
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:15px;"><b><?=$KAB?></b>
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
	} else if ($i==$jmlKolom && $kolspan==0) {
		if ($upt=='00') $lokasinya=lokasiKerjaB($uk);
		else $lokasinya=subLokasiKerjaB($uk,$upt);
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top">
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
					<font style="font-size:15px;"><b><?=$lokasinya?></b>
					</td>
				</tr>
				<tr>
					<td width="5">&nbsp;</td>
					<td>
					<font style="font-size:15px;"><b><?=$KAB?></b>
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
<?if ($KOJABA[1]!='') {?>
<tr>
<?
$kolspan=0;
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==$posisiBos1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top">
		<?
		$q="select B_02,B_02B,B_03A,B_03B,B_03,F_03,I_05 from MASTFIP08 where ";
                if ($isbiro) $q.="A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' and A_04='".substr($uk,6,2)."' and ";
                else $q.="A_01 = '$uk' and ";
		$q.="I_05='".$KOJABA[1]."' LIMIT 1";
		$r=mysql_query($q);
		$row=mysql_fetch_array($r);
		?>
			<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
			<tr>
				<td width="165" align="center"><img src="../showfoto.php?nip=<?=$row[B_02]?>" width="100" height="130"></td>
			</tr>
			<tr bgColor="#93C3FC" height="50">
				<td width="165" align="center"><b><?=jabatan($KOJABA[1])?></b></td>
			</tr>
			<tr height="30">
				<td width="165" align="center">
				<b><a href="../?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></a></b><br>
				<?=namapkt($row[F_03])?> (<?=pktH($row[F_03])?>)<br>
				NIP. <?=$row[B_02]?> /<br><?=format_nip_baru($row[B_02B])?>
				</td>
			</tr>
			</table>
		</td>
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
<?}?>
<tr>
<?
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==$posisiBos1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top"><img src="gambar/tengahparo.gif" width="165" height="40" border="0"></td>
		<?
	} else  if (($i > $posisiBos1) and ($i < $jmlKolom)) {
		?>
		<td width="5"><img src="gambar/paro5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/paro20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/paro165piksel.gif" width="165" height="40" border="0"></td>
		<?
	} else if ($i == $jmlKolom) {
		?>
		<td width="5"><img src="gambar/paro5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/paro20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/tengahparokanan.gif" width="165" height="40" border="0"></td>
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
//----------------------------- cabang wadir(di bawah kepala)-------------------------------------

if ($esel15!='') {
?>
<tr>
<?
	$query="select KOLOK,NAJAB from TABLOKB08 where substring(KOLOK,1,2)='$uk' and ESEL='$esel15' order by KOLOK";
	$r=mysql_query($query);
	$i=0;
	while ($row=mysql_fetch_array($r)) {
		$i++;
		$KOLOKW[$i] = $row[KOLOK];
		$NAJABW[$i] = $row[NAJAB];
		$query1="select KOLOK,NAJAB from TABLOKB08 where substring(KOLOK,1,5)=substring('$row[KOLOK]',1,5) and ESEL='$esel2' order by KOLOK";
		$r1=mysql_query($query1);
		$j=0;
		while ($row1=mysql_fetch_array($r1)) {
			$j++;
			$KOLOKAB[$i][$j] = $row1[KOLOK];
			$NAJABAB[$i][$j] = $row1[NAJAB];
		}
		$jmlKolom1[$i] = sizeOf($KOLOKAB[$i]);
		$posisiBos2[$i] = ceil($jmlKolom1[$i]/2) + $totKolom;
		$totKolom += $jmlKolom1[$i];
	}

	$bos2Akhir=count($posisiBos2);
	for ($i=1;$i<=$jmlKolom;$i++) {
		if ($i==$posisiBos2[1]) {
			?>
			<td width="5">&nbsp;</td>
			<td width="20">&nbsp;</td>
			<td width="165" valign="top"><img src="gambar/tengahkiri.gif" width="165" height="40" border="0"></td>
			<?
		} else if ($i==$posisiBos2[$bos2Akhir]) {
			?>
			<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
			<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
			<td width="165" valign="top"><img src="gambar/tengahkanan.gif" width="165" height="40" border="0"></td>
			<?
		} else if (in_array($i,$posisiBos2)) {
			?>
			<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
			<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
			<td width="165" valign="top"><img src="gambar/pertigaan.gif" width="165" height="40" border="0"></td>
			<?
		} else if ($i > $posisiBos2[1] && $i < $posisiBos2[$bos2Akhir] && !in_array($i,$posisiBos2)) {
			?>
			<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
			<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
			<td width="165" valign="top"><img src="gambar/spasi20piksel.gif" width="165" height="40" border="0"></td>
			<?
		} else if ($i==$jmlKolom){
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
	$j=0;
	for ($i=1;$i<=$jmlKolom;$i++) {
		if (in_array($i,$posisiBos2)) {
			$j++;
			$gambar='';
			
			?>
			<td width="5">&nbsp;</td>
			<td width="20"><?=$gambar?></td>
			<td width="165" valign="top">
			<?
			$foto='';
			if ($KOLOKW[$j] != '') {
			$q="select B_02,B_02B,B_03A,B_03B,B_03,F_03,I_05 from MASTFIP08 where A_01 = '$uk' and I_05='".$KOLOKW[$j]."' LIMIT 1";
			$r=mysql_query($q);
			$row=mysql_fetch_array($r);
			$kodJab = $KOLOKW[$j];
			?>
				<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
				<tr>
					<td width="165" align="center"><img src="../showfoto.php?nip=<?=$row[B_02]?>" width="100" height="130"></td>
				</tr>
				<tr bgColor="#93C3FC" height="50">
					<td width="165" align="center"><b><?=jabatan($kodJab)?></b></td>
				</tr>
				<tr height="30">
				<td width="165" align="center">
				<b><a href="../?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></a></b><br>
				<?=namapkt($row[F_03])?> (<?=pktH($row[F_03])?>)<br>
				NIP. <?=$row[B_02]?> /<br><?=format_nip_baru($row[B_02B])?>
				</td>
			</tr>
				</table>
			<?
			}
			?>
			</td>
			<?
		} else if ($i==$jmlKolom){
			?>
			<td width="5">&nbsp;</td>
			<td width="20">&nbsp;</td>
			<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="220" border="0"></td>
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
		if ($i < $jmlKolom - 1 && in_array($i,$posisiBos2)) {
			?>
			<td width="5">&nbsp;</td>
			<td width="20">&nbsp;</td>
			<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
			<?
		} else if ($i==$jmlKolom){
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
<?
}

if ($esel15!='') {
?>
<tr>
<?
foreach ($jmlKolom1 as $key=>$value) {
	for ($i=1;$i<=$value;$i++) {
	if ($i==1) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top"><img src="gambar/tengahkiri.gif" width="165" height="40" border="0"></td>
		<?
	} else if ($i==$value) {
		?>
		<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/tengahkanan.gif" width="165" height="40" border="0"></td>
		<?
	} else {
		?>
		<td width="5"><img src="gambar/spasi5piksel.gif" width="5" height="40" border="0"></td>
		<td width="20"><img src="gambar/spasi20piksel.gif" width="20" height="40" border="0"></td>
		<td width="165" valign="top"><img src="gambar/pertigaan.gif" width="165" height="40" border="0"></td>
		<?
	}
		?>
		<?
	}
}
?>
	<td width="5">&nbsp;</td>
	<td width="20">&nbsp;</td>
	<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
</tr>
<?
}
//----------------------------- cabang (di bawah wadir)-------------------------------------
else {
?>
<tr>
<?
for ($i=1;$i<=$jmlKolom;$i++) {
	if ($i==1 && $jmlKolom==2) {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
		<?
	} else if ($i==1) {
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
	} else {
		?>
		<td width="5">&nbsp;</td>
		<td width="20">&nbsp;</td>
		<td width="165" valign="top"><img src="gambar/atastengahan.gif" width="165" height="40" border="0"></td>
		<?
	}
}
?>
</tr>
<?
}

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
		if ($i < $jmlKolom) {
			$gambar='';
			
			if ($KOJABX[$i][$y] != '') {
				if ($KOJABX[$i][$y+1] == '' && !$iskantor) $gambar= "<img src=\"gambar/sampingbawah.gif\" border=\"0\" width=\"20\" height=\"250\">";
				else if ($y==1) $gambar='';
				else $gambar= "<img src=\"gambar/sampingtengah.gif\" border=\"0\" width=\"20\" height=\"250\">";
			}
			
			?>
			<td width="5">&nbsp;</td>
			<td width="20"><?=$gambar?></td>
			<td width="165" valign="top">
			<?
			$foto='';
			if ($KOJABX[$i][$y] != '') {
			$q="select B_02,B_02B,B_03A,B_03B,B_03,F_03,I_05 from MASTFIP08 where ";
        	        if ($isbiro) $q.="A_01='".substr($KOJABX[$i][$y],0,2)."' and A_02='".substr($KOJABX[$i][$y],2,2)."' and A_03='".substr($KOJABX[$i][$y],4,2)."' and A_04='".substr($KOJABX[$i][$y],6,2)."' and ";
	                else $q.="A_01 = '$uk' and ";
			$q.="I_05='".$KOJABX[$i][$y]."' LIMIT 1";
			$r=mysql_query($q);
			$row=mysql_fetch_array($r);
			$kodJab = $KOJABX[$i][$y];
			?>
				<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="165">
				<tr>
					<td width="165" align="center"><img src="../showfoto.php?nip=<?=$row[B_02]?>" width="100" height="130"></td>
				</tr>
				<tr bgColor="#93C3FC" height="50">
					<td width="165" align="center"><b><?=jabatan($kodJab)?></b></td>
				</tr>
				<tr height="50">
					<td width="165" align="center">
					<b><a href="../?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></a></b><br>
					<?=namapkt($row[F_03])?> (<?=pktH($row[F_03])?>)<br>
					NIP. <?=$row[B_02]?> /<br><?=format_nip_baru($row[B_02B])?>
					</td>
				</tr>
				</table>
			<?
			}
			?>
			</td>
			<?
		} else {
			if ($y==1) {
				?>
				<td width="5">&nbsp;</td>
				<td width="20">&nbsp;</td>
				<td width="165" valign="top" align="center">
					<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="63%">
					      <tr>
					        <td width="100%" height="42" colspan="3" bgcolor="#FFFFCC" align="center">
					        <b>KELOMPOK JABATAN FUNGSIONAL</b></td>
					      </tr>
					      <tr>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="34%" height="30">&nbsp;</td>
					      </tr>
					      <tr>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="34%" height="30">&nbsp;</td>
					      </tr>
					      <tr>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="33%" height="30">&nbsp;</td>
					        <td width="34%" height="30">&nbsp;</td>
					      </tr>
				    	</table>
				</td>
				<?
			} else {
				?>
				<td width="5">&nbsp;</td>
				<td width="20">&nbsp;</td>
				<td width="165" valign="top">&nbsp;</td>
				<?
			}
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