<?
	$tgldari=$_GET['tgdr'];
	$tglsampai=$_GET['tgsmp'];
	$q="select * from HISTORY where user='$username' ";
	$q.="and tanggal BETWEEN '$tgldari' and '$tglsampai' order by tanggal,jam";
	$r=mysql_query($q);
?>
Detail history untuk pengguna '<?=$username?>'
<table border="1" width="66%" style="border-collapse: collapse" bordercolor="#000000">
	<tr>
		<th width="21">No</th>
		<th width="50">Tanggal</th>
		<th width="50">Jam</th>
		<th width="50">NIP</th>
		<th width="250">Detil</th>
	</tr>
	<?
	$i=0;
	while ($ro=mysql_fetch_array($r)) {
		$i++;
	?>
	<tr>
		<td width="21" align="right"><?=$i?></td>
		<td width="50"><?=$ro[tanggal]?></td>
		<td width="50"><?=$ro[jam]?></td>
		<td width="50"><?=$ro[nipedit]?></td>
		<td width="250"><?=$ro[what]?></td>
	</tr>
	<? } ?>
</table>
