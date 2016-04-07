<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!isset($ultah) || $ultah=='') $ultah=0;
?>
<script type="text/javascript">
    $(function() {
        search_data_ultah(1);
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
            //reset_form();
        });
    });
    function reload_data() {
        reset_form();
        search_data_pensiun(1);
    }

    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    function search_data_ultah(page) {
        $('#datamodal_search').modal('hide');
        $.ajax({
            type: 'GET',
            url: 'include/ultah-list.php?page='+page,
            data: $('#ultah').serialize(),
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
        search_data_ultah(page);
    }
</script>
<h4 class="title">NOMINATIF PNS YANG BERULANG TAHUN</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Ulang Tahun</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <!--<button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>-->
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
                        <form name="ultah1" id="ultah" action="index.htm?sid=<?=$sid?>&do=ulangtahun" method="post">
                        <table width="100%">
                                <tr>
                                <td width="27%">PNS ulang tahun:</td>
                                <td width="73%"> 
                                    <select name="ultah" id="ultah" class="form-control-static" style="width: 300px;">
                                        <option value="">Pilih</option>
                                        <option value="-5" <?= $ultah=='-5' ? "selected" : ""?>>5 Hari Lalu</option>
                                        <option value="-4" <?= $ultah=='-4' ? "selected" : ""?>>4 Hari Lalu</option>
                                        <option value="-3" <?= $ultah=='-3' ? "selected" : ""?>>3 Hari Lalu</option>
                                        <option value="-2" <?= $ultah=='-2' ? "selected" : ""?>>2 Hari Lalu</option>
                                        <option value="-1" <?= $ultah=='-1' ? "selected" : ""?>>Kemarin</option>
                                        <option value="0" <?= $ultah==='0' ? "selected" : ""?>>Hari Ini</option>
                                        <option value="1" <?= $ultah=='1' ? "selected" : ""?>>Besok</option>
                                        <option value="2" <?= $ultah=='2' ? "selected" : ""?>>2 Hari Lagi</option>
                                        <option value="3" <?= $ultah=='3' ? "selected" : ""?>>3 Hari Lagi</option>
                                        <option value="4" <?= $ultah=='4' ? "selected" : ""?>>4 Hari Lagi</option>
                                        <option value="5" <?= $ultah=='5' ? "selected" : ""?>>5 Hari Lagi</option>
                                        <option value="bl" <?= $ultah==='bl' ? "selected" : ""?>>Bulan Ini</option>
                                        <option value="bld" selected <?= $ultah==='bld' ? "selected" : ""?>>Bulan Depan</option>
                                    </select>
                                </td>
                                </tr>
                                <tr>
                                <td>Unit Kerja:</td>
                                <td>
                                    <select name="uk" id="uk" class="form-control-static" style="width: 300px;">
                                    <option value="all">Semua</option>
                                    <?
                                    $id_skpd = NULL;
                                  if ($_SESSION['skpd'] !== '12' and $_SESSION['nama_group'] !== 'Administrator') {
                                    $id_skpd = $_SESSION['skpd'];
                                  }
                                    $lsuk=listUnitKerja($id_skpd);
                                    foreach($lsuk as $key=>$value) {
                                                ?>
                                    <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
                                                <? } ?>
                                    </select></td>
                                </tr>
                        </table>
                        </form>
                        </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_ultah(1);"><i class="fa fa-save"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
</div>
<div id="result"></div>