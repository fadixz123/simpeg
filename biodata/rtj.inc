<?
if ($what=='delete')
	mysql_query("delete from MSTJASA1 where JS_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());
if ($simpanrtj)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgjs05=$THJS_05[$i]."-".$BLJS_05[$i]."-".$TGJS_05[$i];
		$JS03=strtoupper($JS_03[$i]);
		$JS07=strtoupper($JS_07[$i]);
		$a[$i]=$xtgjs05;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JS_01='$NIP',JS_02='$i',JS_03='$JS03',JS_04='$JS_04[$i]',JS_05='$xtgjs05', ";
			$q .="JS_06='$JS_06[$i]',JS_07='$JS07'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JS_02='$i',JS_03='$JS03',JS_04='$JS_04[$i]',JS_05='$xtgjs05', ";
			$q .="JS_06='$JS_06[$i]',JS_07='$JS07' where JS_01='$NIP' and ";
			$q .="JS_02='$JS_02ORG[$i]' and ";
			$q .="JS_03='$JS_03ORG[$i]' and ";
			$q .="JS_04='$JS_04ORG[$i]' and ";
			$q .="JS_05='$JS_05ORG[$i]' and ";
			$q .="JS_06='$JS_06ORG[$i]' and ";
			$q .="JS_07='$JS_07ORG[$i]' ";
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TANDA JASA",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgjs05=$THJS_05[$i]."-".$BLJS_05[$i]."-".$TGJS_05[$i];
		$q="update MSTJASA1 set JS_02='$i' where JS_01='$NIP' and JS_05='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="rtjform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtj&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="25" align="center"><b>K</b></td>
    <td width="549" colspan="4"><b>RIWAYAT TANDA JASA/PENGHARGAAN/KEHORMATAN</b></td>
  </tr>
  <tr bgcolor="<? echo $warnarow3; ?>">
    <td width="25" align="center"><b>No</b></td>
    <td width="254" align="center"><b>NAMA PENGHARGAAN<br>
    NO SK</b></td>
    <td align="center"><b>TANGGAL<br>
    TAHUN</b></td>
    <td align="center"><b>ASAL<br>
    PEROLEHAN</b></td>
    <td align="center">&nbsp;</td>
  </tr>
<?
$r=mysql_query("select * from MSTJASA1 where JS_01='$NIP' order by JS_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>
  <tr bgcolor="<? echo $warnarow; ?>">
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="JS_02ORG[<?=$no?>]" value="<?=$row[JS_02]?>">
    <input type="hidden" name="JS_03ORG[<?=$no?>]" value="<?=$row[JS_03]?>">
    <input type="hidden" name="JS_04ORG[<?=$no?>]" value="<?=$row[JS_04]?>">
    <input type="hidden" name="JS_05ORG[<?=$no?>]" value="<?=$row[JS_05]?>">
    <input type="hidden" name="JS_06ORG[<?=$no?>]" value="<?=$row[JS_06]?>">
    <input type="hidden" name="JS_07ORG[<?=$no?>]" value="<?=$row[JS_07]?>">
    <td width="25" align="right" valign="top"><b><?=$no?></b></td>
    <td width="254">
    <input type="text" name="JS_03[<?=$no?>]" value="<?=$row[JS_03]?>" size="40"><br>
    <input type="text" name="JS_04[<?=$no?>]" value="<?=$row[JS_04]?>" size="30">
    </td>
    <td>
    	<input type="text" name="TGJS_05[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JS_05],8,2)?>" class="tanggal"> 
        <input type="text" name="BLJS_05[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JS_05],5,2)?>" class="tanggal"> 
        <input type="text" name="THJS_05[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[JS_05],0,4)?>" class="tahun"><br>
        <input type="text" name="JS_06[<?=$no?>]" size="2" maxlength="4"  value="<?=$row[JS_06]?>" class="tahun"> 
    </td>
    <td valign="top">
    <input type="text" name="JS_07[<?=$no?>]" value="<?=$row[JS_07]?>" size="20"></td>
    <td align="center" valign="top"><b><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtj&NIP=<?=$NIP?>&what=delete&ID=<?=$row[ID]?>">DEL</a></b></td>
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
    <td width="254">
    <input type="text" name="JS_03[<?=$no?>]" size="40"><br>
    <input type="text" name="JS_04[<?=$no?>]" size="30">
    </td>
    <td>
    	<input type="text" name="TGJS_05[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="BLJS_05[<?=$no?>]" size="1" maxlength="2" class="tanggal"> 
        <input type="text" name="THJS_05[<?=$no?>]" size="2" maxlength="4" class="tahun"><br>
        <input type="text" name="JS_06[<?=$no?>]" size="2" maxlength="4" class="tahun"> 
    </td>
    <td valign="top"><input type="text" name="JS_07[<?=$no?>]" size="20"></td>
    <td align="center" valign="top">&nbsp;</td>
  </tr>
<?
	}
}
?>  
  
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
    <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtj&NIP=<?=$NIP?>&jmltambah='+this.value+''">
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
    &nbsp;<input class="tombol2" name="simpanrtj" type="submit" value="Simpan">
    &nbsp;<button class="tombol2" name="batal"
    onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rtj&NIP=<?=$NIP?>&jmltambah='">Batalkan Penambahan</button></td>
  </tr>
  <input type="hidden" name="no" value="<?=$no?>">
</form>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan Tanggal &nbsp;
    </td>
  </tr>
</table>