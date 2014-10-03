<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$hasupt=false;

$qcu="select distinct A_02 from TABLOKB08 where A_01='$uk' and A_02<>'99'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
?>
<script type="text/javascript">
    $(function() {
        $('#tampilkan').click(function() {
            var uk  = $('#uk').val();
            var upt = $('#upt').val();
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/struktur_org.original.php?sid=<?=$sid?>&uk='+uk+'&upt='+upt+'','pop','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
        });
    });
</script>
<h4 class="title">STRUKTUR ORGANISASI PNS</h4>
<form name="form1" action="?sid=<?=$sid?>&do=struktur" method="post">
<table width="100%">
  
  <tr>
  <td width="15%">Unit Kerja:</td>
  <td>
        <select name="uk" id="uk" class="form-control" onchange="form1.submit()">
        <option>Pilih Unit Kerja ...</option>
        <?
        $lsuk=listUnitKerja();
        foreach($lsuk as $key=>$value) { ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?= ucwords(strtolower($value[1]))?></option>
        <? } ?>
        </select>
  </td>
  </tr>
<? if ($hasupt) { ?>
<tr>
  <td>Induk/UPT:</td>
          <td>
            <select name="upt" id="upt" class="form-control">
            <option value="00" <? if ($subuk=='00') echo "selected "?>>INDUK</option>
        <?
        $qupt="select * from TABLOKB08 where A_01='$uk' and A_02<>'00' and ESEL like '41' order by A_02";
        $rupt=mysql_query($qupt) or die(mysql_error());
        while ($roupt=mysql_fetch_array($rupt)) {
			?>
			<option value="<?=$roupt[A_02]?>" <?= $roupt[A_02]==$subuk ? "selected" : ""?>><?=$roupt[NALOK]?></option>
			<? } ?>
            </select>
          </td>
        </tr>
<? } else { ?>
		<input type="hidden" name="upt" value="00">
<? } ?>
  <tr>
  <td width="76">&nbsp;</td>
  <td width="339">
      <button type="button" class="btn btn-primary" id="tampilkan"><i class="fa fa-save"></i> Tampilkan</button>
  </td>
  </tr>
  <tr>
  <td width="436" colspan="3">&nbsp;</td>
  </tr>
  </table>
</form>
