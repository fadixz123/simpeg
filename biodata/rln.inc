<?
if ($what=='delete')
	mysql_query("delete from MSTTGAS1 where TG_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());
	
if ($simpanrln)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgtg07=$THTG_07[$i]."-".$BLTG_07[$i]."-".$TGTG_07[$i];
		$xtgtg08=$THTG_08[$i]."-".$BLTG_08[$i]."-".$TGTG_08[$i];
		$xtgtg09=$THTG_09[$i]."-".$BLTG_09[$i]."-".$TGTG_09[$i];
		$TG03=strtoupper($TG_03[$i]);
		$TG04=strtoupper($TG_04[$i]);
		$TG05=strtoupper($TG_05[$i]);
		$a[$i]=$xtgtg09;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTTGAS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="TG_01='$NIP',TG_02='$i',TG_03='$TG03',TG_04='$TG04',TG_05='$TG05', ";
			$q .="TG_06='$TG_06[$i]',TG_07='$xtgtg07',TG_08='$xtgtg08',TG_09='$xtgtg09'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTTGAS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="TG_01='$NIP',TG_02='$i',TG_03='$TG03',TG_04='$TG04',TG_05='$TG05', ";
			$q .="TG_06='$TG_06[$i]',TG_07='$xtgtg07',TG_08='$xtgtg08',TG_09='$xtgtg09' ";
			$q .="where TG_01='$NIP' and ID='$IDORG[$i]'";
/*			$q .="TG_02='$TG_02ORG[$i]' and ";
			$q .="TG_03='$TG_03ORG[$i]' and ";
			$q .="TG_04='$TG_04ORG[$i]' and ";
			$q .="TG_05='$TG_05ORG[$i]' and ";
			$q .="TG_06='$TG_06ORG[$i]' and ";
			$q .="TG_07='$TG_07ORG[$i]' and ";
			$q .="TG_08='$TG_08ORG[$i]' and ";
			$q .="TG_09='$TG_09ORG[$i]' ";*/
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TUGAS KE LN",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgtg09=$THTG_09[$i]."-".$BLTG_09[$i]."-".$TGTG_09[$i];
		$q="update MSTTGAS1 set TG_02='$i' where TG_01='$NIP' and TG_09='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="rlnform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtg&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="3%" align="center"><b>L</b></td>
    <td colspan="4"><b>RIWAYAT PENUGASAN KE LUAR NEGERI</b></td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="3%" align="center" rowspan="2"><b>No</b></td>
    <td align="center" rowspan="2"><b>NEGARA TUJUAN<br>
    JENIS PENUGASAN<br>
    PEJABAT YANG MENETAPKAN</b></td>
    <td align="center"><b>SK</b></td>
    <td align="center"><b>TANGGAL</b></td>
    <td align="center" rowspan="2">&nbsp;</td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td align="center"><b>NOMOR<br>
    TANGGAL</b></td>
    <td align="center"><b>MULAI<br>
    SELESAI</b></td>
    
  </tr>
<?
$r=mysql_query("select ID,TG_01,TG_02,TG_03,TG_04,TG_05,TG_06,TG_07,TG_08,TG_09 from MSTTGAS1 where TG_01='$NIP' order by TG_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>  
    <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="IDORG[<?=$no?>]" value="<?=$row[ID]?>">
    <input type="hidden" name="TG_02ORG[<?=$no?>]" value="<?=$row[TG_02]?>">
    <input type="hidden" name="TG_03ORG[<?=$no?>]" value="<?=$row[TG_03]?>">
    <input type="hidden" name="TG_04ORG[<?=$no?>]" value="<?=$row[TG_04]?>">
    <input type="hidden" name="TG_05ORG[<?=$no?>]" value="<?=$row[TG_05]?>">
    <input type="hidden" name="TG_06ORG[<?=$no?>]" value="<?=$row[TG_06]?>">
    <input type="hidden" name="TG_07ORG[<?=$no?>]" value="<?=$row[TG_07]?>">
    <input type="hidden" name="TG_08ORG[<?=$no?>]" value="<?=$row[TG_08]?>">
    <input type="hidden" name="TG_09ORG[<?=$no?>]" value="<?=$row[TG_09]?>">
    <td width="3%" align="right" valign="top"><b><?=$no?></b></td>
    <td valign="top">
    <input type="text" name="TG_03[<?=$no?>]" size="40" value="<?=$row[TG_03]?>" ><br>
    <input type="text" name="TG_04[<?=$no?>]" size="30" value="<?=$row[TG_04]?>"><br>
    <input type="text" name="TG_05[<?=$no?>]" size="30" value="<?=$row[TG_05]?>">
    </td>
    <td valign="top">
    	<input type="text" size="20" name="TG_06[<?=$no?>]" value="<?=$row[TG_06]?>"><br>
    	<input type="text" name="TGTG_07[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_07],8,2)?>" class="tanggal"> 
        <input type="text" name="BLTG_07[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_07],5,2)?>" class="tanggal"> 
        <input type="text" name="THTG_07[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[TG_07],0,4)?>" class="tahun">
    </td>
    <td valign="top">
    	<input type="text" name="TGTG_08[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_08],8,2)?>" class="tanggal"> 
        <input type="text" name="BLTG_08[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_08],5,2)?>" class="tanggal"> 
        <input type="text" name="THTG_08[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[TG_08],0,4)?>" class="tahun"><br>
    	<input type="text" name="TGTG_09[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_09],8,2)?>" class="tanggal"> 
        <input type="text" name="BLTG_09[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[TG_09],5,2)?>" class="tanggal"> 
        <input type="text" name="THTG_09[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[TG_09],0,4)?>" class="tahun"> 
    </td>
    <td align="center" valign="top"><b><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtg&NIP=<?=$NIP?>&what=delete&ID=<?=$row[ID]?>">DEL</a></b></td>
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
    <td width="3%" align="right" valign="top"><b><?=$no?></b></td>
    <td valign="top">
    <input type="text" name="TG_03[<?=$no?>]" size="40"><br>
    <input type="text" name="TG_04[<?=$no?>]" size="30"><br>
    <input type="text" name="TG_05[<?=$no?>]" size="30">
    </td>
    <td valign="top">
    	<input type="text" size="20" name="TG_06[<?=$no?>]"><br>
    	<input type="text" name="TGTG_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLTG_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THTG_07[<?=$no?>]" size="2" maxlength="4" class="tahun">
    </td>
    <td valign="top">
    	<input type="text" name="TGTG_08[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLTG_08[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THTG_08[<?=$no?>]" size="2" maxlength="4" class="tahun"><br>
    	<input type="text" name="TGTG_09[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLTG_09[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THTG_09[<?=$no?>]" size="2" maxlength="4" class="tahun"> 
    </td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
<?
	}
}
?>    
  
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="5"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
    <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtg&NIP=<?=$NIP?>&jmltambah='+this.value+''">
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
    &nbsp;<input class="tombol2" name="simpanrln" type="submit" value="Simpan">
    &nbsp;<button class="tombol2" name="batal"
    onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtg&NIP=<?=$NIP?>&jmltambah='">Batalkan Penambahan</button></td>
  </tr>
  <input type="hidden" name="no" value="<?=$no?>">
</form>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan Tanggal Selesai Tugas&nbsp;
    </td>
  </tr>
</table>