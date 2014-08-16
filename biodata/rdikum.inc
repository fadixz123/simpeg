<?
if ($what=='delete')
	mysql_query("delete from MSTPEND1 where DK_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());

if ($simpandikum)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		
		$xtgdk09=$THDK_09[$i]."-".$BLDK_09[$i]."-".$TGDK_09[$i];
		$DK04=addslashes(strtoupper($DK_04[$i]));
		$DK05=addslashes(strtoupper($DK_05[$i]));
		$DK06=addslashes(strtoupper($DK_06[$i]));
		$DK07=addslashes(strtoupper($DK_07[$i]));
		$a[$i]=$xtgdk09;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTPEND1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="DK_01='$NIP',DK_02='$i',DK_03='$DK_03[$i]',DK_04='$DK04',DK_05='$DK05', ";
			$q .="DK_06='$DK06',DK_07='$DK07',DK_08='$DK_08[$i]',DK_09='$xtgdk09'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTPEND1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="DK_02='$i',DK_03='$DK_03[$i]',DK_04='$DK04',DK_05='$DK05', ";
			$q .="DK_06='$DK06',DK_07='$DK07',DK_08='$DK_08[$i]',DK_09='$xtgdk09' ";
			$q .="where ID='$IDORG[$i]' and DK_01='$NIP'";/* and ";
			$q .="DK_02='$DK_02ORG[$i]' and ";
			$q .="DK_03='$DK_03ORG[$i]' and ";
			$q .="DK_04='".addslashes($DK_04ORG[$i])."' and ";
			$q .="DK_05='".addslashes($DK_05ORG[$i])."' and ";
			$q .="DK_06='".addslashes($DK_06ORG[$i])."' and ";
			$q .="DK_07='".addslashes($DK_07ORG[$i])."' and ";
			$q .="DK_08='$DK_08ORG[$i]' and ";
			$q .="DK_09='$DK_09ORG[$i]' ";*/
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT PENDIDIKAN UMUM",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		
		$q="update MSTPEND1 set DK_02='$i' where DK_01='$NIP' and DK_09='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="rdikumform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rdu&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="25" align="center"><b>N</b></td>
    <td width="549" colspan="4"><b>RIWAYAT PENDIDIKAN UMUM</b></td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="25" align="center" rowspan="2"><b>No</b></td>
    <td width="171" align="center" rowspan="2"><b>TINGKAT<br>
    JURUSAN</b></td>
    <td width="269" align="center" rowspan="2"><b>NAMA SEKOLAH<br>
    TEMPAT<br>
    NAMA KEPSEK/REKTOR</b></td>
    <td width="113" align="center"><b>STTB</b></td>
    <td width="40" align="center" rowspan="2">&nbsp;</td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="113" align="center"><b>NOMOR<br>
    TANGGAL</b></td>
    
  </tr>
  
<?
$r=mysql_query("select ID,DK_01,DK_02,DK_03,DK_04,DK_05,DK_06,DK_07,DK_08,DK_09 from MSTPEND1 where DK_01='$NIP' order by DK_09") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?> 
  <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="IDORG[<?=$no?>]" value="<?=$row[ID]?>">
    <input type="hidden" name="DK_02ORG[<?=$no?>]" value="<?=$row[DK_02]?>">
    <input type="hidden" name="DK_03ORG[<?=$no?>]" value="<?=$row[DK_03]?>">
    <input type="hidden" name="DK_04ORG[<?=$no?>]" value="<?=$row[DK_04]?>">
    <input type="hidden" name="DK_05ORG[<?=$no?>]" value="<?=$row[DK_05]?>">
    <input type="hidden" name="DK_06ORG[<?=$no?>]" value="<?=$row[DK_06]?>">
    <input type="hidden" name="DK_07ORG[<?=$no?>]" value="<?=$row[DK_07]?>">
    <input type="hidden" name="DK_08ORG[<?=$no?>]" value="<?=$row[DK_08]?>">
    <input type="hidden" name="DK_09ORG[<?=$no?>]" value="<?=$row[DK_09]?>">
    <td width="25" align="right" valign="top"><b><?=$no?></b></td>
    <td width="171" valign="top">
    <select size="1" name="DK_03[<?=$no?>]" >
    <option value="-">-</option>
    <option value="SD"			<? if ($row[DK_03]=="SD"		) echo "selected";?>>SD</option>
    <option value="SLTP"		<? if ($row[DK_03]=="SLTP"	        ) echo "selected";?>>SLTP</option>
    <option value="SLTA"		<? if ($row[DK_03]=="SLTA"	        ) echo "selected";?>>SLTA</option>
    <option value="D-I"			<? if ($row[DK_03]=="D-I"		) echo "selected";?>>D-I</option>
    <option value="D-II"		<? if ($row[DK_03]=="D-II"	        ) echo "selected";?>>D-II</option>
    <option value="D-III"		<? if ($row[DK_03]=="D-III"	        ) echo "selected";?>>D-III</option>
    <option value="D-IV"		<? if ($row[DK_03]=="D-IV"	        ) echo "selected";?>>D-IV</option>
    <option value="SARMUD"		<? if ($row[DK_03]=="SARMUD"		) echo "selected";?>>SARMUD</option>
    <option value="SARMUD NON AK"	<? if ($row[DK_03]=="SARMUD NON AK"  	) echo "selected";?>>SARMUD NON AK</option>
    <option value="S1"			<? if ($row[DK_03]=="S1"		) echo "selected";?>>STRATA-1</option>
    <option value="S2"			<? if ($row[DK_03]=="S2"		) echo "selected";?>>STRATA-2</option>
    <option value="S3"			<? if ($row[DK_03]=="S3"		) echo "selected";?>>STRATA-3</option>
	<option value="P"			<? if ($row[DK_03]=="P"		) echo "selected";?>>PROFESI</option>
    </select><br>
    <input type="text" name="DK_04[<?=$no?>]" size="30" value="<?=$row[DK_04]?>">
    </td>
    <td width="269" valign="top">
    	<input type="text" size="29" name="DK_05[<?=$no?>]" value="<?=$row[DK_05]?>"><br>
    	<input type="text" size="29" name="DK_06[<?=$no?>]" value="<?=$row[DK_06]?>"><br>
    	<input type="text" size="29" name="DK_07[<?=$no?>]" value="<?=$row[DK_07]?>">
    </td>
    <td width="113" valign="top">
    	<input type="text" size="15" name="DK_08[<?=$no?>]" value="<?=$row[DK_08]?>"><br>
    	<input type="text" name="TGDK_09[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[DK_09],8,2)?>" class="tanggal"> 
        <input type="text" name="BLDK_09[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[DK_09],5,2)?>" class="tanggal"> 
        <input type="text" name="THDK_09[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[DK_09],0,4)?>" class="tahun"> 
    </td>
    <td width="40" align="center" valign="top"><b><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rdu&NIP=<?=$NIP?>&what=delete&ID=<?=$row[ID]?>">DEL</a></b></td>
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
    
    <td width="25" align="right" valign="top"><b><?=$no?></b></td>
    <td width="171" valign="top">
    <select size="1" name="DK_03[<?=$no?>]" >
    <option value="-">-</option>
    <option value="SD"			>SD</option>
    <option value="SLTP"		>SLTP</option>
    <option value="SLTA"		>SLTA</option>
    <option value="D-I"			>D-I</option>
    <option value="D-II"		>D-II</option>
    <option value="D-III"		>D-III</option>
    <option value="D-IV"		>D-IV</option>
    <option value="SARMUD"		>SARMUD</option>
    <option value="SARMUD NON AK"	>SARMUD NON AK</option>
    <option value="S1"			>STRATA-1</option>
    <option value="S2"			>STRATA-2</option>
    <option value="S3"			>STRATA-3</option>
	<option value="P"			>PROFESI</option>
    </select><br>
    <input type="text" name="DK_04[<?=$no?>]" size="30">
    </td>
    <td width="269" valign="top">
    	<input type="text" size="29" name="DK_05[<?=$no?>]"><br>
    	<input type="text" size="29" name="DK_06[<?=$no?>]"><br>
    	<input type="text" size="29" name="DK_07[<?=$no?>]">
    </td>
    <td width="113" valign="top">
    	<input type="text" size="15" name="DK_08[<?=$no?>]"><br>
    	<input type="text" name="TGDK_09[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLDK_09[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THDK_09[<?=$no?>]" size="2" maxlength="4" class="tahun"> 
    </td>
    <td width="40" align="center" valign="top"></td>
  </tr>
<?
	}
}
?>   
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
    <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rdu&NIP=<?=$NIP?>&jmltambah='+this.value+''">
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
    &nbsp;<input class="tombol2" name="simpandikum" type="submit" value="Simpan">
    &nbsp;<button class="tombol2" name="batal"
    onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rdu&NIP=<?=$NIP?>&jmltambah='">Batalkan Penambahan</button></td>
  </tr>
  <input type="hidden" name="no" value="<?=$no?>">
</form>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TINGKAT & Tanggal STTB &nbsp;
    </td>
  </tr>
</table>