<?
include("include/fungsi.inc");
?>
<form method="POST" action="?sid=<?=$sid?>&do=history">
	<table border="0" width="100%" style="border-collapse: collapse">
		<tr>
			<td colspan="4">Aktivitas Perubahan Data</td>
		</tr>
		<tr>
			<td width="12%">Dari Tanggal</td>
			<td width="20%"> 
              <input type="text" name="tg_tgldari" size="1" maxlength="2" value="<?=$tg_tgldari?>">
              - 
              <input type="text" name="bl_tgldari" size="1" maxlength="2" value="<?=$bl_tgldari?>">
              - 
              <input type="text" name="th_tgldari" size="2" maxlength="4" value="<?=$th_tgldari?>">
            </td>
			<td width="10%">s/d</td>
			<td width="62%"> 
              <input type="text" name="tg_tglsampai" size="1" maxlength="2" value="<?=$tg_tglsampai?>">
              - 
              <input type="text" name="bl_tglsampai" size="1" maxlength="2" value="<?=$bl_tglsampai?>">
              - 
              <input type="text" name="th_tglsampai" size="2" maxlength="4" value="<?=$th_tglsampai?>"></td>
		</tr>
	</table>
	<p><input type="submit" value="Cari" name="cari"></p>
</form>

<?
if ($_POST['cari']) {
	$tgldari=$_POST['th_tgldari'].'-'.$_POST['bl_tgldari'].'-'.$_POST['tg_tgldari'];
	$tglsampai=$_POST['th_tglsampai'].'-'.$_POST['bl_tglsampai'].'-'.$_POST['tg_tglsampai'];
	$q="select username,count(distinct nipedit) as jml,count(*) as jmlt from HISTORY,USER where user=username ";
	$q.="and tanggal BETWEEN '$tgldari' and '$tglsampai' group by user";
	$r=mysql_query($q);
?>
<table border="1" width="66%" style="border-collapse: collapse" bordercolor="#000000">
	<tr>
		<th width="21">No</th>
		<th width="156">Username</th>
		<th width="50">Jml PNS yg Diedit</th>
		<th width="50">Jml Aktivitas Edit</th>
		<th width="50">Detil</th>
	</tr>
	<?
	$i=0;
	while ($ro=mysql_fetch_array($r)) {
		$i++;
	?>
	<tr>
		<td width="21" align="right"><?=$i?></td>
		<td width="156"><?=$ro[username]?></td>
		<td width="50"><?=$ro[jml]?></td>
		<td width="50"><?=$ro[jmlt]?></td>
		<td width="50"><a href="?sid=<?=$sid?>&do=detilhistory&det=1&tgdr=<?=$tgldari?>&tgsmp=<?=$tglsampai?>&username=<?=$ro[username]?>">Detil</a></td>
	</tr>
	<? } ?>
</table>
<? } ?>