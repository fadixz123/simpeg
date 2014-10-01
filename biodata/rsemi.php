<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTSEMI1 where LT_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());


if ($simpansemi)
{
	$u=0;
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtglt07=$THLT_07[$i]."-".$BLLT_07[$i]."-".$TGLT_07[$i];
		$xtglt08=$THLT_08[$i]."-".$BLLT_08[$i]."-".$TGLT_08[$i];
		$xtglt11=$THLT_11[$i]."-".$BLLT_11[$i]."-".$TGLT_11[$i];
		$LT03=strtoupper($LT_03[$i]);
		$LT04=strtoupper($LT_04[$i]);
		$LT05=strtoupper($LT_05[$i]);
		$a[$i]=$xtglt08;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTSEMI1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTSEMI1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11' ";
			$q .="where LT_01='$NIP' and ID='$IDORG[$i]'";
/*			$q .="LT_02='$LT_02ORG[$i]' and ";
			$q .="LT_03='$LT_03ORG[$i]' and ";
			$q .="LT_04='$LT_04ORG[$i]' and ";
			$q .="LT_05='$LT_05ORG[$i]' and ";
			$q .="LT_06='$LT_06ORG[$i]' and ";
			$q .="LT_07='$LT_07ORG[$i]' and ";
			$q .="LT_08='$LT_08ORG[$i]' and ";
			$q .="LT_09='$LT_09ORG[$i]' and ";
			$q .="LT_10='$LT_10ORG[$i]' and ";
			$q .="LT_11='$LT_11ORG[$i]' ";*/
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT SEMI/LOKA/SIMP",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$q="update MSTSEMI1 set LT_02='$i' where LT_01='$NIP' and LT_08='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}

$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="rsemiform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rsm&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="37" align="center"><b>S</b></td>
    <td width="538" colspan="4"><b>RIWAYAT SEMINAR/LOKAKARYA/SIMPOSIUM</b></td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="37" align="center" rowspan="2"><b>No</b></td>
    <td align="center"><b>SEMINAR/LOKAKARYA/SIMPOSIUM</b></td>
    <td align="center"><b>TANGGAL</b></td>
    <td align="center"><b>SERTIFIKAT</b></td>
    <td width="40" align="center" rowspan="2">&nbsp;</td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td align="center"><b>NAMA<br>
    TEMPAT<br>
    PENYELENGGARA<br>
    ANGKATAN</b></td>
    <td align="center"><b>MULAI<br>
    SELESAI<br>
    JML JAM</b></td>
    <td align="center"><b>NOMOR<br>
    TANGGAL</b></td>
  </tr>
<?
$r=mysql_query("select ID,LT_01,LT_02,LT_03,LT_04,LT_05,LT_06,LT_07,LT_08,LT_09,LT_10,LT_11 from MSTSEMI1 where LT_01='$NIP' order by LT_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>   
  <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="IDORG[<?=$no?>]" value="<?=$row[ID]?>">
    <input type="hidden" name="LT_02ORG[<?=$no?>]" value="<?=$row[LT_02]?>">
    <input type="hidden" name="LT_03ORG[<?=$no?>]" value="<?=$row[LT_03]?>">
    <input type="hidden" name="LT_04ORG[<?=$no?>]" value="<?=$row[LT_04]?>">
    <input type="hidden" name="LT_05ORG[<?=$no?>]" value="<?=$row[LT_05]?>">
    <input type="hidden" name="LT_06ORG[<?=$no?>]" value="<?=$row[LT_06]?>">
    <input type="hidden" name="LT_07ORG[<?=$no?>]" value="<?=$row[LT_07]?>">
    <input type="hidden" name="LT_08ORG[<?=$no?>]" value="<?=$row[LT_08]?>">
    <input type="hidden" name="LT_09ORG[<?=$no?>]" value="<?=$row[LT_09]?>">
    <input type="hidden" name="LT_10ORG[<?=$no?>]" value="<?=$row[LT_10]?>">
    <input type="hidden" name="LT_11ORG[<?=$no?>]" value="<?=$row[LT_11]?>">
    <td width="37" align="right" valign="top"><b><?=$no?></b></td>
    <td valign="top">
    <input type="text" size="30" name="LT_03[<?=$no?>]" value="<?=$row[LT_03]?>"><br>
    <input type="text" size="30" name="LT_04[<?=$no?>]" value="<?=$row[LT_04]?>"><br>
    <input type="text" size="30" name="LT_05[<?=$no?>]" value="<?=$row[LT_05]?>"><br>
    <input type="text" size="5"  name="LT_06[<?=$no?>]" value="<?=$row[LT_06]?>"></td>
    <td valign="top">
    	<input type="text" name="TGLT_07[<?=$no?>]" size="1" maxlength="2"  value="<?=substr($row[LT_07],8,2)?>" class="tanggal"> 
        <input type="text" name="BLLT_07[<?=$no?>]" size="1" maxlength="2"  value="<?=substr($row[LT_07],5,2)?>" class="tanggal"> 
        <input type="text" name="THLT_07[<?=$no?>]" size="2" maxlength="4"  value="<?=substr($row[LT_07],0,4)?>" class="tahun"><br>
    	<input type="text" name="TGLT_08[<?=$no?>]" size="1" maxlength="2"  value="<?=substr($row[LT_08],8,2)?>" class="tanggal"> 
        <input type="text" name="BLLT_08[<?=$no?>]" size="1" maxlength="2"  value="<?=substr($row[LT_08],5,2)?>" class="tanggal"> 
        <input type="text" name="THLT_08[<?=$no?>]" size="2" maxlength="4"  value="<?=substr($row[LT_08],0,4)?>" class="tahun"><br>
        <input type="text" name="LT_09[<?=$no?>]" size="2" maxlength="4"  value="<?=$row[LT_09]?>" class="tahun">
    </td>
    <td valign="top">
    	<input type="text" size="25" name="LT_10[<?=$no?>]" value="<?=$row[LT_10]?>"><br>
    	<input type="text" name="TGLT_11[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[LT_11],8,2)?>" class="tanggal"> 
        <input type="text" name="BLLT_11[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[LT_11],5,2)?>" class="tanggal"> 
        <input type="text" name="THLT_11[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[LT_11],0,4)?>" class="tahun">
    </td>
    <td width="40" align="center" valign="top"><b><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rsm&NIP=<?=$NIP?>&what=delete&ID=<?=$row[ID]?>">DEL</a></b></td>
  </tr>
  
<?
}
if ($jmltambah>0 )
{
	for ($i=1;$i<=$jmltambah;$i++)
	{
		$no++;
?>  
  <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="1">
    <td width="37" align="right" valign="top"><b><?=$no?></b></td>
    <td valign="top">
    <input type="text" size="30" name="LT_03[<?=$no?>]"><br>
    <input type="text" size="30" name="LT_04[<?=$no?>]"><br>
    <input type="text" size="30" name="LT_05[<?=$no?>]"><br>
    <input type="text" size="5"  name="LT_06[<?=$no?>]">
    </td>
    <td valign="top">
    	<input type="text" name="TGLT_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLLT_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THLT_07[<?=$no?>]" size="2" maxlength="4" class="tahun"><br>
    	<input type="text" name="TGLT_08[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLLT_08[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THLT_08[<?=$no?>]" size="2" maxlength="4" class="tahun"><br>
        <input type="text" name="LT_09[<?=$no?>]" size="2" maxlength="4" class="tahun">
    </td>
    <td valign="top">
    	<input type="text" size="25" name="LT_10[<?=$no?>]"><br>
    	<input type="text" name="TGLT_11[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLLT_11[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THLT_11[<?=$no?>]" size="2" maxlength="4" class="tahun">
    </td>
    <td width="40" align="center" valign="top">&nbsp;</td>
  </tr>
<?
	}
}
?>   
  
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
    <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rsm&NIP=<?=$NIP?>&jmltambah='+this.value+''">
        <option value="">-</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
      </select>
    &nbsp;<input class="tombol2" name="simpansemi" type="submit" value="Simpan">
    &nbsp;<button class="tombol2" name="batal"
    onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rsm&NIP=<?=$NIP?>&jmltambah='">Batalkan Penambahan</button></td>
  </tr>
  <input type="hidden" name="no" value="<?=$no?>">
</form>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TANGGAL SELSAI &nbsp;
    </td>
  </tr>
</table>