<?
if ($gantifoto)
{
        $data = file_get_contents($_FILES['userfile']['tmp_name']);
        $data = mysql_real_escape_string($data);
        $type = $_FILES['userfile']['type'];

        $qc="select * from MASTFOTO where NIP='$NIP'";
        $rc=mysql_query($qc) or die(mysql_error());
        if (mysql_num_rows($rc) > 0) {
                $qsg="update MASTFOTO set DATA='$data',MIMETYPE='$type' where NIP='$NIP'";
        } else {
                $qsg="insert into MASTFOTO set DATA='$data',MIMETYPE='$type',NIP='$NIP'";
        }
        $rsg=mysql_query($qsg) or die(mysql_error());
		if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE FOTO",$NIP);
		// edited by heru at july 09th 2012 
}

$q="select A_01,A_02,A_03,A_04,B_NOARSIP,B_02,B_02B,B_03A,B_03,B_03B,B_04,B_05,B_06,B_07,B_12,I_05,I_JB,F_03,H_1A,H_1B,H_4A from MASTFIP08 where B_02='$NIP' LIMIT 1";
$r=mysql_query($q) or die(mysql_error());
$row=mysql_fetch_array($r);
?>
<table cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse" bordercolor="#111111">
<tr>
<td height="20" width="201"><font color="RED" size="4">NOMOR ARSIP</td></font>
<td height="20" width="3"><font color="RED" size="4">:</td></font>
<td height="20" width="463"><font color="RED" size="5"><?=$row[B_NOARSIP]?></td></font>
</tr>
<tr>
<td height="20" width="201">Nama</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=namaPNS($row[B_03A],stripslashes($row[B_03]),$row[B_03B])?></td>
<td rowspan="8" align="center" width="236"><div class="mosimage"><img src="showfoto.php?nip=<?=$row[B_02]?>" width="68" HEIGHT="88" BORDER="1"></div><br>
<?if (!$subdo) {?>
<a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=awal&subdo=ganti&NIP=<?=$NIP?>">Ganti Foto</a><br>
<!--<a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=awal&subdo=gantidisc&NIP=<?=$NIP?>">Ganti File DiSC74</a>-->
<?} else if ($subdo=='ganti') {?>
<form name="statusawal" method="post" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=awal&NIP=<?=$NIP?>" ENCTYPE="multipart/form-data" >
<input name="userfile" type="file" class="tombol" size="20"><br>
<input name="gantifoto" type="submit" class="tombol" value="GANTI FOTO">
</form>
<?} else if ($subdo=='gantidisc') { ?>
<form name="statusawal" method="post" action="main.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=awal&NIP=<?=$NIP?>" ENCTYPE="multipart/form-data" >
<input name="userfile" type="file" class="tombol" size="20"><br>
<input name="gantidisc" type="submit" class="tombol" value="GANTI DiSC74">
</form>
<?}?></td>
</tr>
<tr>
<td height="20" width="201">NIP</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=$NIP?> / <?=format_nip_baru($row[B_02B])?></td>
</tr>
<tr>
<td height="20" width="201">Unit Kerja</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=lokasiKerjaB($row[A_01])?></td>
</tr>
<tr>
<td height="20" width="201">Sub Unit Kerja</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04])?></td>
</tr>
<tr>
<td height="20" width="201">Jabatan</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><? if (jabatan($row[I_05])=='-') echo $row[I_JB]; else echo jabatan($row[I_05])?></td>
</tr>
<tr>
<td height="20" width="201">Pangkat/Golongan</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=namaPKT($row[F_03])." (".pktH($row[F_03]).")"?></td>
</tr>
<tr>
<td height="20" width="201">Pendidikan Umum</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=tktDidik($row[H_1A])." (".jurusan($row[H_1A],$row[H_1B]).")"?></td>
</tr>
<tr>
<td height="20" width="201">Pendidikan Struktural</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=dikStru($row[H_4A])?></td>
</tr>
<tr>
<td height="20" width="201">Agama</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=agama1($row[B_07])?></td>
<td height="20" width="236">&nbsp;</td>
</tr>
<tr>
<td height="20" width="201">Tempat/Tgl Lahir</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=$row[B_04].", ".tanggalnya($row[B_05],0)?></td>
<td height="20" width="27%">&nbsp;</td>
</tr>
<tr>
<td height="20" width="201">Jenis Kelamin</td>
<td height="20" width="3">:</td>
<td height="20" width="463"><?=jenisKelamin($row[B_06])?></td>
<td height="20" width="236">&nbsp;</td>
</tr>
<tr>
<td height="20" width="201">Alamat Rumah</td>
<td height="20" width="3">:</td>
<td height="20" width="699" colspan="2"><?=$row[B_12]?></td>
</tr>
<tr>
<td height="20" width="201">&nbsp;</td>
<td height="20" width="3"></td>
<td height="20" width="463"><input type="button" name="cetak" value="CETAK DATA" class="tombol" onclick="javascript:window.open('CETAKFIP/index.php?sid=<?=$sid?>&NIP=<?=$NIP?>','18399','SCROLLBARS=YES,MENUBAR=YES')"><? if (file_exists("/home/eps/htdocs/biodata/disc/".$row[B_02])) {?><input type="button" name="disc" value="DiSC74" class="tombol" onclick="javascript:window.open('disc/<?=$row[B_02]?>/<?=$row[B_02]?>_CLIENT-001_.HTM?sid=<?=$sid?>&NIP=<?=$NIP?>','18399','SCROLLBARS=YES,MENUBAR=YES')"><?}?></td>
<td height="20" width="236">&nbsp;</td>
</tr>
</table>