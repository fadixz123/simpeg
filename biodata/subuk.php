<?
include("../include/config.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$uk=$_GET[uk];

$qloker="select substring(KOLOK,1,6) as KODELOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='$uk' and KOLOK like '%0000' order by KOLOK";
//echo "select substring(KOLOK,1,6) as KODELOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='$uk' and KOLOK like '%0000' order by KOLOK";
$rloker=mysql_query($qloker);
?>
<select name="lker" class="form-control" onChange="getSubSubUK(this.value)">
	<option value="">-</option>
	<? while($oloker=mysql_fetch_array($rloker)) { ?>
	<option value="<?=$oloker[KODELOK]?>"><?=$oloker["NALOK"]; ?></option>
	<? } ?>
</select>