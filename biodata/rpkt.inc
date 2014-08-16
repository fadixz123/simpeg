<?
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04,F_03 from MASTFIP08 where B_02='$NIP' LIMIT 1"));
$myF_03=$x[F_03];

if ($what=='delete')
{
	$q="delete from MASTPKT1 where PF_02='$PF_02' and ID='$ID' LIMIT 1";
	mysql_query($q) or die (mysql_error());
}

if ($updpk)
{
	for ($i=3;$i<=$no;$i++)
	{
		$a1[$i][0]=$PF_03[$i];
		$a1[$i][1]=$i;
		$a2[$i][0]=$PF_03[$i];
		$a2[$i][1]=$i;
	}
	sort($a2);
	$u=0;
	for ($i=0;$i<count($a2);$i++)
	{
		$xno=$a2[$i][1];
		$xpk=$a2[$i][0];
		$xtsk="$THSK[$xno]-$BLSK[$xno]-$TGSK[$xno]";
		$xmsk="$THTMT[$xno]-$BLTMT[$xno]-$TGTMT[$xno]";
		$q="select * from MASTPKT1 where PF_01='$NIP' and PF_03='$xpk' and PF_05='$PF_05ORG[$xno]' and PF_06='$PF_06ORG[$xno]' LIMIT 1";
		if (mysql_num_rows(mysql_query($q))==0)
		{
			$q  ="insert into MASTPKT1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="PF_01='$NIP',PF_02='$xno',PF_03='$xpk',PF_04='$PF_04[$xno]',PF_05='$xtsk',PF_06='$xmsk'";
			mysql_query($q) or die (mysql_error());
		}
		else
		{
			$q  ="update MASTPKT1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="PF_02='$xno', PF_04='$PF_04[$xno]',PF_05='$xtsk',PF_06='$xmsk' where PF_01='$NIP' and  PF_03='$xpk' and ";
			$q .="PF_05='$PF_05ORG[$xno]' and PF_06='$PF_06ORG[$xno]'";
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
		// update MASTFIP08 untuk pkt terakhir;
		mysql_query("update MASTFIP08 set F_02='$xtsk', F_TMT='$xmsk' where B_02='$NIP' and F_03='$xpk'");		
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT PANGKAT",$NIP);
		
}
?>
<table border="0" cellspacing="1" class="garis" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2">
  <form name="pktform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rpk&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <tr> 
      <td height="20" align="center" bgcolor="<?=$warnarow2?>"><b>H</b></td>
      <td height="20" colspan="5" bgcolor="<?=$warnarow2?>"><b>RIWAYAT KEPANGKATAN</b></td>
    </tr>
    <tr> 
      <td width="18" height="20" align="center" bgcolor="DDDDDD"><b>No</b></td>
      <td width="62" height="20" align="center" bgcolor="DDDDDD"><b>PKT/GOL</b></td>
      <td width="139" height="20" align="center" bgcolor="DDDDDD"><b>NO SK</b></td>
      <td width="150" height="20" align="center" bgcolor="DDDDDD"><b>TGL SK</b></td>
      <td width="150" height="20" align="center" bgcolor="DDDDDD"><b>TMT PKT</b></td>
      <td width="50" height="20" align="center" bgcolor="DDDDDD">&nbsp; </td>
    </tr>
    <?
            $query="select * from MASTPKT1 where PF_01='$NIP' order by PF_03,PF_06,PF_02";
            $result=mysql_query($query) or die (mysql_error());
            $no=0;
            while ($row=mysql_fetch_array($result))
            {
            	$no++;
            	$PF_02[$no]=$row["PF_02"];
            	$PF_03[$no]=$row["PF_03"];
            	$query1="delete from MASTPKT1 where PF_01='$NIP' and PF_02='$PF_02[$no]' LIMIT 1";
		$delquery=base64_encode($query1);
            	
            ?>
    <tr valign="top" bgcolor="<? echo $warnarow; ?>"> 
      <td width="18" height="20" align="right"> <b><?=$no; ?></b> </td>
      <td width="62" height="20"> 
      <input type="hidden" name="PF_02[<?=$no; ?>]" value="<?=$row["PF_02"]; ?>"> 
      <input type="hidden" name="upd[<?=$no; ?>]" value="0"> 
      <input type="hidden" name="PF_02ORG[<?=$no; ?>]" value="<?=$row["PF_02"];?>"> 
      <input type="hidden" name="PF_03ORG[<?=$no; ?>]" value="<?=$row["PF_03"];?>"> 
      <input type="hidden" name="PF_05ORG[<?=$no?>]" value="<?=$row[PF_05]?>">
      <input type="hidden" name="PF_06ORG[<?=$no?>]" value="<?=$row[PF_06]?>">
      <?
      if ($no>2)
      {
      	?>
        <select name="PF_03[<? echo $no; ?>]" >
          <option value="">-</option>
          <option value="11" <? if ($row["PF_03"]=="11") echo "selected"; ?>>I/a</option>
          <option value="12" <? if ($row["PF_03"]=="12") echo "selected"; ?>>I/b</option>
          <option value="13" <? if ($row["PF_03"]=="13") echo "selected"; ?>>I/c</option>
          <option value="14" <? if ($row["PF_03"]=="14") echo "selected"; ?>>I/d</option>
          <option value="21" <? if ($row["PF_03"]=="21") echo "selected"; ?>>II/a</option>
          <option value="22" <? if ($row["PF_03"]=="22") echo "selected"; ?>>II/b</option>
          <option value="23" <? if ($row["PF_03"]=="23") echo "selected"; ?>>II/c</option>
          <option value="24" <? if ($row["PF_03"]=="24") echo "selected"; ?>>II/d</option>
          <option value="31" <? if ($row["PF_03"]=="31") echo "selected"; ?>>III/a</option>
          <option value="32" <? if ($row["PF_03"]=="32") echo "selected"; ?>>III/b</option>
          <option value="33" <? if ($row["PF_03"]=="33") echo "selected"; ?>>III/c</option>
          <option value="34" <? if ($row["PF_03"]=="34") echo "selected"; ?>>III/d</option>
          <option value="41" <? if ($row["PF_03"]=="41") echo "selected"; ?>>IV/a</option>
          <option value="42" <? if ($row["PF_03"]=="42") echo "selected"; ?>>IV/b</option>
          <option value="43" <? if ($row["PF_03"]=="43") echo "selected"; ?>>IV/c</option>
          <option value="44" <? if ($row["PF_03"]=="44") echo "selected"; ?>>IV/d</option>
          <option value="45" <? if ($row["PF_03"]=="45") echo "selected"; ?>>IV/e</option>
        </select> 
      <?
      	}
	else
	{
		echo "<b>&nbsp;&nbsp;".pktH($row[PF_03])."</b>";
	}
	?>      
      </td>
      <td height="20" width="139"> 
      <?
      if ($no>2)
      {
      	?>
      <input type="text" name="PF_04[<?=$no; ?>]" size="30" value="<?=$row["PF_04"]; ?>"> 
	<?
	} 
	else echo "<b>".$row[PF_04]."</b>";
   	?>
      </td>
      <td height="20" width="150"> 
      <?
      if ($no>2)
      {
      	?>
      <input type="text" name="TGSK[<?=$no; ?>]" class="tanggal" size="1" maxlength="2" value="<?=substr($row["PF_05"],8,2); ?>">-
      <input type="text" name="BLSK[<?=$no; ?>]" class="tanggal"  size="1" maxlength="2" value="<?=substr($row["PF_05"],5,2); ?>">-
      <input type="text" name="THSK[<?=$no; ?>]"  class="tahun" size="2" maxlength="4" value="<?=substr($row["PF_05"],0,4); ?>"> 
      <?
      	}
      	else echo "<b>&nbsp;".format_tanggal($row[PF_05])."</b>";
      ?>
      	
      
      </td>
      <td height="20" width="150"> 
      <?
      if ($no>2)
      {
      	?>
      <input type="text" name="TGTMT[<?=$no; ?>]" class="tanggal"  size="1" maxlength="2" value="<?=substr($row["PF_06"],8,2); ?>">-
        <input type="text" name="BLTMT[<?=$no; ?>]" class="tanggal"  size="1" maxlength="2" value="<?=substr($row["PF_06"],5,2); ?>">-
        <input type="text" name="THTMT[<?=$no; ?>]" class="tahun"  size="2" maxlength="4" value="<?=substr($row["PF_06"],0,4); ?>"> 
      <?
      	}
      	else echo "<b>&nbsp;".format_tanggal($row[PF_06])."</b>";
      ?>
      
      </td>
      <td height="20" width="50" valign="top">
      	<? 
      	if ($row[PF_03]==$myF_03) echo "*";
      	else if ($no>2) { ?> <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rpk&NIP=<?=$NIP?>&PF_02=<?=$row[PF_02]?>&ID=<?=$row[ID]?>&what=delete">DEL</a>
        <? } ?>
      </td>
    </tr>
    <?
            }
            if ($TAMBAH > 0)
            { 
            	
            	for ($i=1;$i<=$TAMBAH;$i++)
            	{ 
            		$no++;
            ?>
    <tr valign="top" bgcolor="<?=$warnarow; ?>"> 
      <td width="18" height="20" align="right"> <b><?=$no; ?></b> </td>
      <input type="hidden" name="upd[<?=$no; ?>]" value="1">
      <input type="hidden" name="PF_02[<?=$no?>]" value="<?=$no?>">
      <td width="62" height="20"> 
      <select name="PF_03[<? echo $no; ?>]" >
          <option value="">-</option>
          <option value="11" <? if ($PF_03[$no]=="11") echo "selected"; ?>>I/a</option>
          <option value="12" <? if ($PF_03[$no]=="12") echo "selected"; ?>>I/b</option>
          <option value="13" <? if ($PF_03[$no]=="13") echo "selected"; ?>>I/c</option>
          <option value="14" <? if ($PF_03[$no]=="14") echo "selected"; ?>>I/d</option>
          <option value="21" <? if ($PF_03[$no]=="21") echo "selected"; ?>>II/a</option>
          <option value="22" <? if ($PF_03[$no]=="22") echo "selected"; ?>>II/b</option>
          <option value="23" <? if ($PF_03[$no]=="23") echo "selected"; ?>>II/c</option>
          <option value="24" <? if ($PF_03[$no]=="24") echo "selected"; ?>>II/d</option>
          <option value="31" <? if ($PF_03[$no]=="31") echo "selected"; ?>>III/a</option>
          <option value="32" <? if ($PF_03[$no]=="32") echo "selected"; ?>>III/b</option>
          <option value="33" <? if ($PF_03[$no]=="33") echo "selected"; ?>>III/c</option>
          <option value="34" <? if ($PF_03[$no]=="34") echo "selected"; ?>>III/d</option>
          <option value="41" <? if ($PF_03[$no]=="41") echo "selected"; ?>>IV/a</option>
          <option value="42" <? if ($PF_03[$no]=="42") echo "selected"; ?>>IV/b</option>
          <option value="43" <? if ($PF_03[$no]=="43") echo "selected"; ?>>IV/c</option>
          <option value="44" <? if ($PF_03[$no]=="44") echo "selected"; ?>>IV/d</option>
          <option value="45" <? if ($PF_03[$no]=="45") echo "selected"; ?>>IV/e</option>
        </select> </td>
      <td height="20" width="139"> <input type="text" name="PF_04[<? echo $no; ?>]" size="30"> 
      </td>
      <td height="20" width="150"> <input type="text" name="TGSK[<? echo $no; ?>]" size="1" maxlength="2" class="tanggal">
        - 
        <input type="text" name="BLSK[<? echo $no; ?>]" size="1" maxlength="2" class="tanggal">
        - 
        <input type="text" name="THSK[<? echo $no; ?>]" size="2" maxlength="4" class="tahun"> 
      </td>
      <td height="20" width="150"> <input type="text" name="TGTMT[<? echo $no; ?>]" size="1" maxlength="2" class="tanggal">
        - 
        <input type="text" name="BLTMT[<? echo $no; ?>]" size="1" maxlength="2" class="tanggal">
        - 
        <input type="text" name="THTMT[<? echo $no; ?>]" size="2" maxlength="4" class="tahun"> 
      </td>
      <td height="20" width="50"> </td>
    </tr>
    <?
            	}
            }
            ?>
    <tr valign="top" bgcolor="#DDDDDD"> 
      <td height="20" colspan="6"> <strong>Jumlah Pangkat yang akan ditambahkan 
        :</strong> <select name="TAMBAH" 
        onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rpk&NIP=<?=$NIP?>&TAMBAH='+this.value+''">
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
        </select>   <input type="hidden" name="no" value="<? echo $no; ?>"> 
        <input class="tombol2" type="submit" name="updpk" value="SIMPAN"> 
        <input class="tombol2" name="batalpkt" type="button" id="batalpkt" onclick="javascript:window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rpk&NIP=<?=$NIP?>&TAMBAH=0'" value="Batalkan Penambahan"> 
      </td>
    </tr>
    <tr valign="top" bgcolor="#CCCCCC"> 
      <td height="20" colspan="2">
      <b>Perhatian : </b> 
      </td>
      <td colspan="4">
      	No 1 dan 2 <i>otomatis</i> terisi dari pangkat CPNS dan PNS pertama kali
      </td>
    </tr>
    <tr valign="top" bgcolor="#CCCCCC"> 
      <td height="20" colspan="2">&nbsp;
      
      </td>
      <td colspan="4">
      	Nomor akan diurutkan sesuai pangkat
      </td>
    </tr>
    <tr valign="top" bgcolor="#CCCCCC"> 
      <td height="20" colspan="2">&nbsp;
      
      </td>
      <td colspan="4">
      	Pangkat Terakhir diupdate dari Menu Pangkat & Gaji (bertanda *)
      </td>
    </tr>
  </form>
</table>
