<?php
if ($simpan)
{
	for ($i=1;$i<=$totanak;$i++)
	{
		
		if ($upd[$i]=='1')
		{
		$q="insert into MASTKEL1 (KF_01,KF_02,KF_03,KF_04,KF_05,KF_07,KF_08,KF_09,KF_10) ";
		$q=$q."values ('$NIP','2','$KF_03[$i]','".addslashes(strtoupper($KF_04[$i]))."','".$THKF_05[$i]."-".$BLKF_05[$i]."-".$TGKF_05[$i]."','$KF_07[$i]','$KF_08[$i]','".addslashes(strtoupper($KF_09[$i]))."', '$KF_10[$i]' )";
		}
		else
		$q="update MASTKEL1 set KF_02=2,KF_03=$KF_03[$i], KF_04='".addslashes(strtoupper($KF_04[$i]))."', KF_05='".$THKF_05[$i]."-".$BLKF_05[$i]."-".$TGKF_05[$i]."', KF_07='$KF_07[$i]', KF_08='$KF_08[$i]', KF_09='".addslashes(strtoupper($KF_09[$i]))."', KF_10='$KF_10[$i]' where KF_01='$NIP' and KF_02='2' and ID='$ID[$i]' ";
		
			
		mysql_query($q) or die (mysql_error());
		if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE DATA ANAK ".addslashes(strtoupper($KF_04[$i])),$NIP);		
	}
}

if ($action=='delete')
{
	mysql_query("delete from MASTKEL1 where KF_01='$NIP' and ID='$ID' LIMIT 1");
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
<form name="formanak" method="post" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=anak&NIP=<?=$NIP?>">
  <tr bgcolor="<?=$warnarow2?>"> 
    <td width="5%" align="center"><strong>W</strong></td>
    <td colspan="4"><strong>DATA ANAK</strong></td>
  </tr>
  <tr bgcolor="<?=$warnarow?>"> 
    <td align="center"><strong>NO</strong></td>
    <td width="55%" align="center"><strong>NAMA ANAK<br>
      TMP/TGL LAHIR</strong></td>
    <td width="10%" align="center"><strong>JK</strong></td>
    <td width="20%" align="center"><strong>TUNJ<br>
      STATUS </strong></td>
    <td width="10%" align="center">&nbsp;</td>
  </tr>

<?
$i=0;
$qa="select ID,KF_01,KF_02,KF_03,KF_04,KF_05,KF_06,KF_07,KF_08,KF_09,KF_10 from MASTKEL1 where KF_01='$NIP' and KF_02='2' order by KF_03";
$ra=mysql_query($qa) or die(mysql_error());
while ($oa=mysql_fetch_array($ra))
{
	$i++;
	?>
  <tr bgcolor="<?=$warnarow?>"> 
  <input type="hidden" name="upd[<?=$i?>]" value="0">
  <input type="hidden" name="ID[<?=$i?>]" value="<?=$oa[ID]?>">
    <td valign="top"><input type="text" name="KF_03[<?=$i?>]" size="2" value="<?=$oa[KF_03]?>"></td>
    <td valign="top">
    <input type="text" name="KF_04[<?=$i?>]" size="50" value="<?=$oa[KF_04]?>"><br>
    <input type="text" name="KF_09[<?=$i?>]" size="10" value="<?=$oa[KF_09]?>">/
    <input type="text" name="TGKF_05[<?=$i?>]" size="1" maxlength="2" value="<?=substr($oa[KF_05],8,2); ?>">
    - 
    <input type="text" name="BLKF_05[<?=$i?>]" size="1" maxlength="2" value="<?=substr($oa[KF_05],5,2); ?>">
              - 
    <input type="text" name="THKF_05[<?=$i?>]" size="2" maxlength="4" value="<?=substr($oa[KF_05],0,4); ?>">
    </td>
    <td valign="top">
    <select name="KF_10[<?=$i?>]" >
      <option value="">-</option>
      <option value="L" <? if ($oa[KF_10]=='L' || $oa[KF_10]=="LAKI-LAKI") echo "selected"?>>L</option>
      <option value="P" <? if ($oa[KF_10]=='P' || $oa[KF_10]=="PEREMPUAN") echo "selected"?>>P</option>
    
      </select>
    </td>
    <td valign="top">
    <select name="KF_07[<?=$i?>]" >
      <option value="">-</option>
      <option value="D" <? if ($oa[KF_07]=='D') echo "selected"?>>DAPAT</option>
      <option value="T" <? if ($oa[KF_07]=='T') echo "selected"?>>TIDAK</option>
      </select><br>
      <select name="KF_08[<?=$i?>]" >
        <option value="-" <? if ($oa["KF_08"]=='') echo "selected"; ?>>-</option>
        <option value="K" <? if ($oa["KF_08"]=='K') echo "selected"; ?>>KANDUNG</option>
        <option value="T" <? if ($oa["KF_08"]=='T') echo "selected"; ?>>TIRI</option>
        <option value="A" <? if ($oa["KF_08"]=='A') echo "selected"; ?>>ANGKAT</option>
      </select>
    </td>
    <td valign="top"><a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=anak&NIP=<?=$NIP?>&action=delete&ID=<?=$oa[ID]?>">DEL</a></td>
  </tr>
	<?
}
?>


<?
if ($janak > 0)
{
	for ($x=1;$x<=$janak;$x++)
	{
		$i++;
		
		?>
  <tr bgcolor="<?=$warnarow?>"> 
  <input type="hidden" name="upd[<?=$i?>]" value="1">
    <td valign="top"><input type="text" name="KF_03[<?=$i?>]" size="2" value="<?=$i?>"></td>
    <td valign="top">
    <input type="text" name="KF_04[<?=$i?>]" size="50"><br>
    <input type="text" name="KF_09[<?=$i?>]" size="10">/
    <input type="text" name="TGKF_05[<?=$i?>]" size="1" maxlength="2"">
    - 
    <input type="text" name="BLKF_05[<?=$i?>]" size="1" maxlength="2">
              - 
    <input type="text" name="THKF_05[<?=$i?>]" size="2" maxlength="4">
    </td>
    <td valign="top">
    <select name="KF_10[<?=$i?>]" >
      <option value="">-</option>
      <option value="L">L</option>
      <option value="P">P</option>
    
      </select>
    </td>
    <td valign="top">
    <select name="KF_07[<?=$i?>]" >
      <option value="">-</option>
      <option value="D">DAPAT</option>
      <option value="T">TIDAK</option>
      </select><br>
      <select name="KF_08[<?=$i?>]" >
        <option value="-">-</option>
        <option value="K">KANDUNG</option>
        <option value="T">TIRI</option>
        <option value="A">ANGKAT</option>
      </select>
    </td>
    <td valign="top">&nbsp;</td>
  </tr>
  		<?
  	}
}
?>

<!------------------------------ tambahan anak --------------------------->
  <tr bgcolor="<?=$warnarow2?>"> 
    <td colspan="5" height="25"><b>Jumlah Anak yang akan ditambah : </b>
      �
      <select name="janak" id="janak" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=anak&NIP=<?=$NIP?>&action=tambah&janak='+this.value+''">
      <option value="">-</option>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      </select>
      ��� 
      <input class="tombol2" name="simpan" type="submit" id="simpan" value="SIMPAN">
      <input class="tombol2" name="batal" type="submit" id="batal" value="BATALKAN PENAMBAHAN">
      <input type="hidden" name="totanak" value="<?=$i?>">
      </td>
  </tr>
</form>
</table>
