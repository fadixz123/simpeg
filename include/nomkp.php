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
        search_data_kpreg(1);
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nomkp.php?'+$('#kpreg').serialize(),'myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
        
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
        });
    });
    
    function reload_data() {
        $('#bln, #uk').val('');
        $('#th').val('<?= date("Y") ?>');
        search_data_kpreg(1);
    }
    
    function search_data_kpreg(page) {
        $('#datamodal_search').modal('hide');
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
<h4 class="title">NOMINNATIF KENAIKAN PANGKAT REGULER</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Kenaikan Pangkat</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div>
<div id="datamodal_search" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Parameter Pencarian</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <form name="nominatif1" id="kpreg" action="?sid=<?=$sid?>&do=kpreg" method="post" role="form" class="form-horizontal">
                              <table width="100%">
                                <tr>
                                  <td colspan="2" align="right"></td>
                                </tr>

                                <tr> 
                                  <td width="25%" align="left">Bulan:</td>
                                  <td width="610" align="left"><select name="bln" id="bln" class="form-control-static">
                                                <option value="4" <?= $bln=='4' ? "selected" : ""?>>April</option>
                                                <option value="10" <?= $bln=='10' ? "selected" : ""?>>Oktober</option>
                                      </select> <input type="number" name="th" id="th" class="form-control-static" value="<?=$th?>"></td>
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
                                </table>
                        </form>
                        </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_kpreg(1);"><i class="fa fa-eye"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
<div id="result"></div>
