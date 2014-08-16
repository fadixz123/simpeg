<?
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<?
//if ($what =='nominatif')

	
	?>
<table width="96%" cellpadding="0" cellspacing="0">
	<tr>
	<td><b>Peta Jabatan</b></td>
	</tr>
	<form name="peta" action="../peta/" target="_blank" method="post">
	<tr><td>
	Pilih Unitkerja :
	<select name="uk" >
	<?
	$q="select * from TABLOK where kd<>'01000000' order by kd";
	$r=mysql_query($q);
	$q2="select * from TABLOKB where KOLOK like '02%' and ESEL='22' order by KOLOK";
	$r2=mysql_query($q2);
	$row=mysql_fetch_array($r);
	{?>
		<option value="<?=$row[kd]?>" <? if ($row['kd']==$uk) echo "selected "?>><?=$row['nm']?></option>
	<?}
	while ($row2=mysql_fetch_array($r2))
	{?>
		<option value="<?=$row2[KOLOK]?>" <? if ($row2['KOLOK']==$uk) echo "selected "?>><?=$row2['NALOK']?></option>
	<?}
	while ($row=mysql_fetch_array($r))
	{?>
		<option value="<?=$row[kd]?>" <? if ($row['kd']==$uk) echo "selected "?>><?=$row['nm']?></option>
	<?}
	?>
	</select>
	</td>
	</tr>
	<tr>
	<td><br>
	<input type="submit" name="submit" value="PETA RIIL">
	<input type="button" name="petaIdeal" value="PETA IDEAL" onClick="window.open('peta/petaideal.php?uk='+document.peta.uk.value+'')">
	</td>
	</tr>
</table>
