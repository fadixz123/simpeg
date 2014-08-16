<?


$link=mysql_connect("localhost","root","d4t4");
mysql_select_db("kabpkl");

if ($simpan && strlen($TABDIK) > 0 && strlen(ereg_replace(" ","",$KET)) > 0) {
	$q="select KOD from TABDIK".$TABDIK." order by KOD desc";
	$r=mysql_query($q) or die (mysql_error());
	$row=mysql_fetch_array($r);
	$KODA=intval($row[KOD]);
	$KODA++;
	$KETA=strtoupper($KET);
	$q="insert into TABDIK".$TABDIK." set KOD='$KODA', KET='$KETA', TKP='$TABDIK'";
	mysql_query($q) or die (mysql_error());
}
 
?>

<html>
<head>
<title>- Tambah Data Pendidikan -</title>
<LINK REL="STYLESHEET" TYPE="TEXT/CSS" href="/include/newEPS.css">

<link href="../css/template_css.css" rel="stylesheet" type="text/css">
</head>

<BODY>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<form name="addDikForm" method="post" action="?sid=<?=$sid?>&sid2=<?=$sid2?>">
<tr>
  <td colspan="3" class="componentheading"><b>Tambah Data Pendidikan</b></td>
</tr>
<tr>
  <td width="20%">Tingkat Pendidikan</td>
  <td width="1%">:</td>
  <td width="79%">
  <select name="TABDIK"  onChange="window.location='?sid=<?=$sid?>&sid2=<?=$sid2?>&TABDIK='+this.value+''">
  <option value="">PILIH</option>
   <option value="10" <? if ($TABDIK=='10') echo "selected"?>>SD</option>
   <option value="20" <? if ($TABDIK=='20') echo "selected"?>>SLTP</option>
   <option value="30" <? if ($TABDIK=='30') echo "selected"?>>SLTA</option>
   <option value="41" <? if ($TABDIK=='41') echo "selected"?>>DIPLOMA I</option>
   <option value="42" <? if ($TABDIK=='42') echo "selected"?>>DIPLOMA II</option>
   <option value="43" <? if ($TABDIK=='43') echo "selected"?>>DIPLOMA III</option>
   <option value="44" <? if ($TABDIK=='44') echo "selected"?>>DIPLOMA IV</option>
   <option value="50" <? if ($TABDIK=='50') echo "selected"?>>SARMUD NON AKADEMI</option>
   <option value="60" <? if ($TABDIK=='60') echo "selected"?>>SARMUD AKADEMI</option>
   <option value="70" <? if ($TABDIK=='70') echo "selected"?>>STRATA 1 (S1)</option>
   <option value="80" <? if ($TABDIK=='80') echo "selected"?>>STRATA 2 (S2)</option>
   <option value="90" <? if ($TABDIK=='90') echo "selected"?>>STRATA 3 (S3)</option>
   <option value="99" <? if ($TABDIK=='99') echo "selected"?>>PROFESI </option>

  </select>
  
  </td>
</tr>
<tr>
  <td width="20%">Nama Pendidikan</td>
  <td width="1%">:</td>
  <td width="79%">
  <?
	if (isset($TABDIK) && $TABDIK !='') {
	?>
	<input type="text" name="KET" width="100" value="<?=$KET?>">
	<?
	}
  ?>
  </td>
</tr>
<tr>
  <td width="20%">&nbsp;</td>
  <td width="1%">&nbsp;</td>
  <td width="79%"><input type="submit" name="simpan" value="SIMPAN" class="tombol2">
  <input type="button" class="tombol2" name="a" value="TUTUP" onClick="window.close()">
  </td>
</tr>
</form>
</table>
</body>

</html>

<?
mysql_close();
?>
