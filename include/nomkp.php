<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$pangkat=array('11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');

$qcu="select distinct A_02 from MASTFIP08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
if ($th=='') $th=date("Y");
?>
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript" src="../Scripts/jquery.min.js" ></script>
<script type="text/javascript">
    
    $(function() {
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nomkp.php?'+$('#kpreg').serialize(),'myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
    
    function search_data_kpreg(page) {
        $.ajax({
            type: 'GET',
            url: 'include/nomkp-list.php?page='+page,
            data: $('#kpreg').serialize(),
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
        search_data_kpreg(page);
    }
</script>
<h4 class="title">NOMINATIF KENAIKAN PANGKAT REGULER</h4>
<form name="nominatif1" id="kpreg" action="?sid=<?=$sid?>&do=kpreg" method="post">
      <table width="100%">
        <tr>
          <td colspan="2" align="right"></td>
        </tr>
        
        <tr> 
          <td width="15%" align="left">Bulan:</td>
          <td width="610" align="left"><select name="bln" id="bln" class="form-control-static">
			<option value="4" <?= $bln=='4' ? "selected" : ""?>>April</option>
			<option value="10" <?= $bln=='10' ? "selected" : ""?>>Oktober</option>
			</select> <input type="text" name="th" class="form-control-static" value="<?=$th?>"></td>
        </tr>
        <tr>
          <td>Unit Kerja:</td>
          <td>
              <select style="width: 300px;" name="uk" id="uk" class="form-control">
            <option value="all">Semua</option>
        <?php
        $rupt=listUnitKerja();
        foreach ($rupt as $key=>$value) {
        ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
        <? } ?>
            </select>
          </td>
        </tr>
        <tr >
        <td height="10" valign="top">&nbsp;</td>
        <td height="10" valign="top"><strong>
                <button type="button" class="btn btn-primary" onclick="search_data_kpreg(1); return false;" id="searching"><i class="fa fa-search"></i> Tampilkan</button>
          <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        </strong></td>
      </tr>
        </table>
		</form>
<div id="result"></div>