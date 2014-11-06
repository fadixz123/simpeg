<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$qcu="select distinct A_02 from MASTFIP08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
if ($tahun=='') $tahun=date("Y");
?>
<script type="text/javascript">
    $(function() {
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nomberkala.php?'+$('#nomberkala').serialize(),'myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
    function search_data_nomberkala(page) {
        $.ajax({
            type: 'GET',
            url: 'include/nomberkala-list.php?page='+page,
            data: $('#nomberkala').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#result').html(data);
            }
        });
    }
    
    function paging(page, tab, search) {
        search_data_nomberkala(page);
    }
</script>

<h4 class="title">NOMINATIF KENAIKAN GAJI BERKALA</h4>
    <form name="nominatif1" id="nomberkala" action="?sid=<?=$sid?>&do=berkala" method="post">
      <table width="100%">
        <tr> 
          <td width="15%" align="left">Bulan:</td>
          <td width="610" align="left"><select name="bln" id="bln" class="form-control-static">
			<option value="1" <?= $bln=='1' ? "selected" : ""?>>Januari</option>
			<option value="2" <?= $bln=='2' ? "selected" : ""?>>Pebruari</option>
			<option value="3" <?= $bln=='3' ? "selected" : ""?>>Maret</option>
			<option value="4" <?= $bln=='4' ? "selected" : ""?>>April</option>
			<option value="5" <?= $bln=='5' ? "selected" : ""?>>Mei</option>
			<option value="6" <?= $bln=='6' ? "selected" : ""?>>Juni</option>
			<option value="7" <?= $bln=='7' ? "selected" : ""?>>Juli</option>
			<option value="8" <?= $bln=='8' ? "selected" : ""?>>Agustus</option>
			<option value="9" <?= $bln=='9' ? "selected" : ""?>>September</option>
			<option value="10" <?= $bln=='10' ? "selected" : ""?>>Oktober</option>
			<option value="11" <?= $bln=='11' ? "selected" : ""?>>Nopember</option>
			<option value="12" <?= $bln=='12' ? "selected" : ""?>>Desember</option>
			</select> <input type="text" name="tahun" value="<?=$tahun?>" class="form-control-static"></td>
        </tr>
        <tr>
          <td>Sub Unit Kerja</td>
          <td>
              <select name="uk" id="uk" style="width: 300px;" class="form-control-static">
            <option value="all">Semua</option>
        <?
        $rupt=listUnitKerja();
        foreach ($rupt as $key=>$value) {
        ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=$value[1]?></option>
        <? } ?>
            </select>
          </td>
        </tr>
        <tr >
        <td height="10" valign="top">&nbsp;</td>
        <td height="10" valign="top">
            <button type="button" class="btn btn-primary" onclick="search_data_nomberkala(1); return false;"><i class="fa fa-search"></i> Tampilkan</button>
            <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        </td>
      </tr>
      </table>
</form>
<div id="result"></div>