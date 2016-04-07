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
        search_data_nomberkala(1);
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nomberkala.php?'+$('#nomberkala').serialize(),'myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
        });
    });
    function search_data_nomberkala(page) {
        $('#datamodal_search').modal('hide');
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
    
    function reload_data() {
        reset_form();
        search_data_nomberkala(1);
    }

    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
        $('#tahun').val('<?= date("Y") ?>');
    }
    
    function paging(page, tab, search) {
        search_data_nomberkala(page);
    }
</script>

<h4 class="title">NOMINATIF KENAIKAN GAJI BERKALA</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Kenaikan Gaji Berkala</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div>
<div id="datamodal_search" class="modal fade">
    <div class="modal-dialog" style="width: 500px; height: 100%;">
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
                        <form name="nominatif1" id="nomberkala" action="?sid=<?=$sid?>&do=berkala" method="post" role="form" class="form-horizontal">
                          <table width="100%">
                            <tr> 
                              <td width="25%" align="left">Bulan:</td>
                              <td align="left"><select name="bln" id="bln" class="form-control-static">
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
                                            </select> <input type="text" name="tahun" id="tahun" value="<?=$tahun?>" class="form-control-static"></td>
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
            <button type="button" class="btn btn-primary" onclick="search_data_nomberkala(1);"><i class="fa fa-eye"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
<div id="result"></div>
