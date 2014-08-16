<table width="40%" border="0" cellspacing="1" cellpadding="1">
<form name="ubahnip" method="post" action="?sid=<?=$sid?>&do=ubahnip">
  <tr bgcolor="#FFCC00"> 
    <td width="24%" bgcolor="#F0F0F0">&nbsp;<strong>NIP LAMA</strong></td>
    <td width="5%" align="center" bgcolor="#F0F0F0"><strong>:</strong></td>
    <td width="68%" bgcolor="#F0F0F0">
	<input type="text" name="nip1" value="<?=$NIP?>" size="18" maxlength="18"></td>
  </tr>
  <tr bgcolor="#FFCC00"> 
    <td width="24%" bgcolor="#F0F0F0">&nbsp;<strong>NIP BARU</strong></td>
    <td width="5%" align="center" bgcolor="#F0F0F0"><strong>:</strong></td>
    <td width="68%" bgcolor="#F0F0F0"><input name="nip2" type="text" class="input2" id="nip2" size="18" maxlength="18"></td>
  </tr>
  <tr bgcolor="#FFCC00"> 
    <td width="24%" bgcolor="#F0F0F0"></td>
    <td width="5%" align="center" bgcolor="#F0F0F0"></td>
    <td width="68%" bgcolor="#F0F0F0"><input type="submit" name="gantinip" value="GANTI NIP" class="button1"></td>
  </tr>
 
<tr bgcolor=""> 
    <td width="40%" colspan="3">

<?
$notok=0;

if ($gantinip)
{
	$q="select count(B_02) as JML from MASTFIP08 where B_02='$nip1' LIMIT 1";
	$r=mysql_query($q);
	$row=mysql_fetch_array($r);
	if ($row[JML]==0) 
	{
		echo "NIP LAMA tidak ada !!" ;
		$notok=1;
		
	}
	
	$q="select count(B_02) as JML from MASTFIP08 where B_02='$nip2' LIMIT 1";
	$r=mysql_query($q);
	$row=mysql_fetch_array($r);
	if ($row[JML]==1) 
	{
		echo "NIP BARU sudah ada !!" ;
		$notok=1;
		
	}
	if ($notok==0)
	{
		$atabel=array(1=>"MASTFIP1","MASTFIP08","MASTJAB1","MASTKEL1","MASTPKT1","MSTBHSA1","MSTFUNG1","MSTJASA1","MSTKURS1","MSTORTU1","MSTPEND1","MSTPTAR1","MSTSEMI1","MSTSTRU1","MSTTEKN1","MSTTGAS1","MASTJFU");
		$afield=array(1=>"B_02",    "B_02",     "JF_01",   "KF_01",   "PF_01",   "BS_01",   "LT_01",   "JS_01",   "LT_01",   "NM_01",   "DK_01",   "LT_01",   "LT_01",   "LT_01",   "LT_01",   "TG_01",   "NIP");
		 
		 for ($i=1;$i<=count($atabel);$i++)
		 {
			$q="update $atabel[$i] set $afield[$i]='$nip2' where $afield[$i]='$nip1' ";
			
			mysql_query($q) or die (mysql_error());
			if (mysql_affected_rows() > 0) echo $atabel[$i]." UPDATED<br>";
		 }
	}
}
?>	
   
    </td>
    
  </tr>
  </form> 
</table>
<?
mysql_close($link);
?>