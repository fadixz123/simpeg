<?
include("../include/config.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$uk=$_GET[uk];

$qloker="select KOLOK,NALOK from TABLOKB08 where KOLOK like '".$uk."%' order by KOLOK";
$rloker=mysql_query($qloker);
?>
<select name="loker" class="form-control">
	<option value="">-</option>
	<? while($oloker=mysql_fetch_array($rloker)) { ?>
	<option value="<?=$oloker[KOLOK]?>"><?=$oloker[NALOK]; ?></option>
	<? } ?>
</select>