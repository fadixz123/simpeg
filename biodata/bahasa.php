<?
if ($what=='delete')
	mysql_query("delete from MSTBHSA1 where BS_01='$NIP' and BS_02='$BS_02' LIMIT 1") or die (mysql_error());

if ($simpanbahasa)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$BS04=strtoupper($BS_04[$i]);
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTBHSA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="BS_01='$NIP',BS_02='$i',BS_03='$BS_03[$i]',BS_04='$BS04',BS_05='$BS_05[$i]'";
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTBHSA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="BS_02='$i',BS_03='$BS_03[$i]',BS_04='$BS04',BS_05='$BS_05[$i]' ";
			$q .="where BS_01='$NIP' and ";
			$q .="BS_02='$BS_02ORG[$i]' and ";
    			$q .="BS_03='$BS_03ORG[$i]' and ";
    			$q .="BS_04='$BS_04ORG[$i]' and ";
    			$q .="BS_05='$BS_05ORG[$i]' ";
    			mysql_query($q) or die (mysql_error());
    		}
		if (mysql_affected_rows() > 0) $u++;
    	}
	if ($u > 0) lethistory($sid,"UPDATE KEMAMPUAN BAHASA",$NIP);
}
		
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="bahasaform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=bhs&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td align="center"><b>M</b></td>
    <td width="549" colspan="4"><b>PENGUASAAN BAHASA</b></td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="25" align="center"><b>No</b></td>
    <td width="90" align="center"><b>JENIS</b></td>
    <td width="267" align="center"><b>NAMA BAHASA</b></td>
    <td width="150" align="center"><b>KEMAMPUAN</b></td>
    <td width="54" align="center">&nbsp;</td>
  </tr>
<?
$r=mysql_query("select BS_01,BS_02,BS_03,BS_04,BS_05 from MSTBHSA1 where BS_01='$NIP' order by BS_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?> 
  <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="BS_02ORG[<?=$no?>]" value="<?=$row[BS_02]?>">
    <input type="hidden" name="BS_03ORG[<?=$no?>]" value="<?=$row[BS_03]?>">
    <input type="hidden" name="BS_04ORG[<?=$no?>]" value="<?=$row[BS_04]?>">
    <input type="hidden" name="BS_05ORG[<?=$no?>]" value="<?=$row[BS_05]?>">
    <td width="25" align="right" valign="top"><b><?=$no?></b></td>
    <td width="90" valign="top">
    <select size="1" name="BS_03[<?=$no?>]" >
    <option value="-">-</option>
    <option value="ASING" <? if ($row[BS_03]=='ASING') echo "selected"?>>ASING</option>
    <option value="DAERAH"<? if ($row[BS_03]=='DAERAH') echo "selected"?>>DAERAH</option>
    </select>
    </td>
    <td width="267" valign="top"><input type="text" size="32" name="BS_04[<?=$no?>]" value="<?=$row[BS_04]?>"></td>
    <td width="150" valign="top">
    <select size="1" name="BS_05[<?=$no?>]" >
    <option value="-">-</option>
    <option value="AKTIF" <? if ($row[BS_05]=='AKTIF') echo "selected"?>>AKTIF</option>
    <option value="PASIF" <? if ($row[BS_05]=='PASIF') echo "selected"?>>PASIF</option>
    </select>
    </td>
    <td width="54" align="center" valign="top"><b><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=bhs&NIP=<?=$NIP?>&what=delete&BS_02=<?=$row[BS_02]?>">DEL</a></b></td>
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
    <td width="90" valign="top">
    <select size="1" name="BS_03[<?=$no?>]" >
    <option value="-">-</option>
    <option value="ASING">ASING</option>
    <option value="DAERAH">DAERAH</option>
    </select>
    </td>
    <td width="267" valign="top"><input type="text" size="32" name="BS_04[<?=$no?>]"></td>
    <td width="150" valign="top">
    <select size="1" name="BS_05[<?=$no?>]" >
    <option value="-">-</option>
    <option value="AKTIF">AKTIF</option>
    <option value="PASIF">PASIF</option>
    </select>
    </td>
    <td width="54" align="center" valign="top">&nbsp;</td>
  </tr>
<?
	}
}
?>   
  
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Jml Kemampuan Bhs yang Akan Ditambahkan :</b>&nbsp;
    <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=bhs&NIP=<?=$NIP?>&jmltambah='+this.value+''">
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
    <input class="tombol2" name="simpanbahasa" type="submit" value="Simpan">
    <button class="tombol2" name="batal"
    onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=bhs&NIP=<?=$NIP?>&jmltambah='">Batalkan Penambahan</button></td>
  </tr>
  <input type="hidden" name="no" value="<?=$no?>">
</form>
  
</table>