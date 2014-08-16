<?


if ($what=='delete')
	mysql_query("delete from MASTJAB1 where JF_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());

if ($updjab)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgjf07=$THJF_07[$i]."-".$BLJF_07[$i]."-".$TGJF_07[$i];
		$xtgjf06=$THJF_06[$i]."-".$BLJF_06[$i]."-".$TGJF_06[$i];
		//$a[$i]=$xtgjf07;
		$I_JB=ereg_replace('\'','\"',$JF_03[$i]);
		//$j=mysql_num_rows(mysql_query("select * from MASTJAB1 where JF_01='$NIP' and JF_07='$xtgjf07' LIMIT 1"));
		if ($upd[$i]=='1')
		{
			
			$q  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JF_02='$JF_02ORG[$i]',JF_01='$NIP',JF_03='$I_JB',JF_04='$JF_04[$i]', ";
			$q .="JF_05='$JF_05[$i]',JF_06='$xtgjf06', JF_07='$xtgjf07'";
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JF_02='$JF_02ORG[$i]',JF_03='$I_JB',JF_04='$JF_04[$i]', ";
			$q .="JF_05='$JF_05[$i]',JF_06='$xtgjf06', JF_07='$xtgjf07' where JF_01='$NIP' and ";
			$q .="ID='$IDORG[$i]'";// and ";
/*			$q .="JF_03='$JF_03ORG[$i]' and ";
			$q .="JF_04='$JF_04ORG[$i]' and ";
			$q .="JF_05='$JF_05ORG[$i]' and ";
			$q .="JF_06='$JF_06ORG[$i]' and ";
			$q .="JF_07='$JF_07ORG[$i]' ";*/
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;			
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT JABATAN",$NIP);
	/*sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgjf07=$THJF_07[$i]."-".$BLJF_07[$i]."-".$TGJF_07[$i];
		$q="update MASTJAB1 set JF_02='$i' where JF_01='$NIP' and JF_07='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}*/
	
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<table border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse" bordercolor="#111111">
<form name="pktform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rjb&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
  <tr> 
    <td align="center" bgcolor="DDDDDD"><strong>I</strong></td>
    <td colspan="6" bgcolor="DDDDDD">&nbsp;<strong>RIWAYAT JABATAN</strong></td>
  </tr>
  <tr> 
    <td align="center" bgcolor="DDDDDD"><strong>No</strong></td>
    <td align="center" bgcolor="DDDDDD"><strong>Nama Jabatan</strong></td>
    <td align="center" bgcolor="DDDDDD"><strong>Esel</strong></td>
    <td align="center" bgcolor="DDDDDD"><strong>No. SK JAB</strong></td>
    <td align="center" bgcolor="DDDDDD"><strong>TMT SK</strong></td>
    <td align="center" bgcolor="DDDDDD"><strong>TMT JAB</strong></td>
    <td align="center" bgcolor="DDDDDD">&nbsp; </td>
  </tr>
  <?
  $no=0;
  $r=mysql_query("select ID,JF_01,JF_02,JF_03,JF_04,JF_05,JF_06,JF_07 from MASTJAB1 where JF_01='$NIP' order by JF_07");
  while ($row=mysql_fetch_array($r))
  {
  	$no++;
  	$JF_03[$no]=$row[JF_03];
  	
  	$JF_05[$no]=$row[JF_05];
  	
  	
  	?>
  <tr valign="top" bgcolor="<?=$warnarow?>"> 
    <input type="hidden" name="upd[<?=$no?>]" value="0">
    <input type="hidden" name="IDORG[<?=$no?>]" value="<?=$row[ID]?>">
    <input type="hidden" name="JF_03ORG[<?=$no?>]" value="<?=$row[JF_03]?>">
    <input type="hidden" name="JF_04ORG[<?=$no?>]" value="<?=$row[JF_04]?>">
    <input type="hidden" name="JF_05ORG[<?=$no?>]" value="<?=$row[JF_05]?>">
    <input type="hidden" name="JF_06ORG[<?=$no?>]" value="<?=$row[JF_06]?>">
    <input type="hidden" name="JF_07ORG[<?=$no?>]" value="<?=$row[JF_07]?>">
    <td align="right">
    <p align="left">
    <input type="text" name="JF_02ORG[<?=$no?>]" size="1" value="<?=$row[JF_02]?>" class="inputkecil"></td>
    <td >
    <? $I_JB=ereg_replace('"','\'',$row[JF_03]); ?>
    <input type="text" name="JF_03[<?=$no?>]" size="30" value="<?=$I_JB?>" class="inputkecil"> 
    </td>
    <td >
    <select name="JF_04[<?=$no?>]" >
    <option value="99" <? if ($row[JF_04]=='99') echo "selected"?>>-</option>
    <option value="12" <? if ($row[JF_04]=='12' || strtoupper($row[JF_04])=='1B') echo "selected"?>>I.a</option>
    <option value="21" <? if ($row[JF_04]=='21' || strtoupper($row[JF_04])=='2A') echo "selected"?>>II.a</option>
    <option value="22" <? if ($row[JF_04]=='22' || strtoupper($row[JF_04])=='2B') echo "selected"?>>II.b</option>
    <option value="31" <? if ($row[JF_04]=='31' || strtoupper($row[JF_04])=='3A') echo "selected"?>>III.a</option>
    <option value="32" <? if ($row[JF_04]=='32' || strtoupper($row[JF_04])=='3B') echo "selected"?>>III.b</option>
    <option value="41" <? if ($row[JF_04]=='41' || strtoupper($row[JF_04])=='4A') echo "selected"?>>IV.a</option>
    <option value="42" <? if ($row[JF_04]=='42' || strtoupper($row[JF_04])=='4B') echo "selected"?>>IV.b</option>
    <option value="51" <? if ($row[JF_04]=='51' || strtoupper($row[JF_04])=='5A') echo "selected"?>>V.a</option>
    <option value="52" <? if ($row[JF_04]=='52' || strtoupper($row[JF_04])=='5B') echo "selected"?>>V.b</option>
    </select>
    
    
    
    </td>
    <td > 
    <input type="text" name="JF_05[<?=$no?>]" size="10" value="<?=$row[JF_05]?>"> 
    </td>
    <td > 
      <input type="text" name="TGJF_06[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JF_06],8,2)?>" class="tanggal"><input type="text" name="BLJF_06[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JF_06],5,2)?>" class="tanggal"><input type="text" name="THJF_06[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[JF_06],0,4)?>" class="tahun">&nbsp;
    </td>
    <td > 
      <input type="text" name="TGJF_07[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JF_07],8,2)?>" class="tanggal"><input type="text" name="BLJF_07[<?=$no?>]" size="1" maxlength="2" value="<?=substr($row[JF_07],5,2)?>" class="tanggal"><input type="text" name="THJF_07[<?=$no?>]" size="2" maxlength="4" value="<?=substr($row[JF_07],0,4)?>" class="tahun">
    </td>
    <td align="center" valign="middle">
    <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rjb&NIP=<?=$NIP?>&what=delete&ID=<?=$row[ID]?>">DEL</a>
    </td>
  </tr>
  <?
	}
	
	if ($jmltambah>0 )
	{
		for ($i=1;$i<=$jmltambah;$i++)
		
		{
			$no++;
			
  ?>
  <tr valign="top"> 
    <input type="hidden" name="upd[<?=$no?>]" value="1">
    <td >
    <input type="text" name="JF_02ORG[<?=$no?>]" size="1" value="<?=$no?>" class="inputkecil"></td>
    <td > 
    <input type="text" name="JF_03[<?=$no?>]" size="30"  class="inputkecil"> 
    </td>
    <td > 
    <select name="JF_04[<?=$no?>]" >
    <option value="99">-</option>
    <option value="12">I.b</option>
    <option value="21">II.a</option>
    <option value="22">II.b</option>
    <option value="31">III.a</option>
    <option value="32">III.b</option>
    <option value="41">IV.a</option>
    <option value="42">IV.b</option>
    <option value="51">V.a</option>
    <option value="52">V.b</option>
    </select>
    
    </td>
    <td > <input type="text" name="JF_05[<?=$no?>]" size="10" > 
    </td>
    <td > 
      <input type="text" name="TGJF_06[<?=$no?>]" size="1" maxlength="2" class="tanggal"><input type="text" name="BLJF_06[<?=$no?>]" size="1" maxlength="2" class="tanggal"><input type="text" name="THJF_06[<?=$no?>]" size="2" maxlength="4" class="tahun">&nbsp; 
    </td>
    <td > 
      <input type="text" name="TGJF_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"><input type="text" name="BLJF_07[<?=$no?>]" size="1" maxlength="2" class="tanggal"><input type="text" name="THJF_07[<?=$no?>]" size="2" maxlength="4" class="tahun"> 
    </td>
    <td>&nbsp;</td>
  </tr>
  <?
  		}
	}
	?>
  <tr> 
    
    <td colspan="7" bgcolor="DDDDDD"><strong>Jumlah Jabatan yang akan ditambahkan :</strong> 
      <select name="jmltambah" 
      onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rjb&NIP=<?=$NIP?>&jmltambah='+this.value+''">
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
      <input class="tombol2" type="submit" name="updjab" value="Simpan"> 
      <input type="hidden" name="no" value="<?=$no?>"> <input class="tombol2" name="bataljab" type="button" id="bataljab" 
      onClick="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rjb&NIP=<?=$NIP?>&jmltambah='" value="Batalkan Penambahan"> 
    </td>
  </tr>
</form>
</table>