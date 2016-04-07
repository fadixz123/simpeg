<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<script type="text/javascript">
    $(function() {
        search_data_pensiun(1);
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
            //reset_form();
        });
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            location.href='include/cetak_pensiun.php?'+$('#pensiun').serialize();
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
    function search_data_pensiun(page) {
        $('#datamodal_search').modal('hide');
        $.ajax({
            type: 'GET',
            url: 'include/pensiun-list.php?page='+page,
            data: $('#pensiun').serialize(),
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
        search_data_pensiun(page);
    }
</script>
<h4 class="title">NOMINATIF PNS YANG AKAN PENSIUN</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Pensiun</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
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
                        <form name="pensiun" id="pensiun" action="index.htm?sid=<?=$sid?>&do=pensiun" method="post" role="form" class="form-horizontal">
                        <table width="100%">
                                <tr>
                                <td width="25%">Unit Kerja:</td>
                                <td> 

                                    <select name="uk" id="uk" class="form-control-static" style="width: 300px;">
                                    <option value="all">Semua...</option>
                                    <?
                                    $lsuk=listUnitKerja();
                                    foreach($lsuk as $key=>$value) {
                                                ?>
                                    <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
                                                <? } ?>
                                    </select></td>
                                </tr>
                                <tr>
                                <td width="107">Pilih waktu: </td>
                                <td> 
                                <select name="pensiun" id="pensiun" class="form-control-static" style="width: 300px;">
                                <option value="5" <?if ($pensiun=='5') echo "selected"?>>Lima Tahun Lagi</option>
                                <option value="4" <?if ($pensiun=='4') echo "selected"?>>Empat Tahun Lagi</option>
                                <option value="3" <?if ($pensiun=='3') echo "selected"?>>Tiga Tahun Lagi</option>
                                <option value="2" <?if ($pensiun=='2') echo "selected"?>>Dua Tahun Lagi</option>
                                <option value="1" <?if ($pensiun=='1') echo "selected"?>>Satu Tahun Lagi</option>
                                <option value="0" <?if ($pensiun=='0') echo "selected"?>>Tahun Ini</option>
                                <option value="-1" <?if ($pensiun=='-1') echo "selected"?>>Satu Tahun Lalu</option>
                                <option value="-2" <?if ($pensiun=='-2') echo "selected"?>>Dua Tahun Lalu</option>
                                <option value="-3" <?if ($pensiun=='-3') echo "selected"?>>Tiga Tahun Lalu</option>
                                <option value="-4" <?if ($pensiun=='-4') echo "selected"?>>Empat Tahun Lalu</option>
                                <option value="-5" <?if ($pensiun=='-5') echo "selected"?>>Lima Tahun Lalu</option>

                                </select></td>
                                </tr>
                                <tr valign="top">
                                  <td width="107" align="left">Jabatan: </td>
                                  <td align="left">
                                    <select name="jabatan" id="jabatan" class="form-control-static" style="width: 300px;">
                                    <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua...</option>
                                    <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
                                    <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
                                    <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
                                  </select></td></tr>
                                  <tr valign="top">
                                  <td width="107" align="left">Eselon:</td>
                                  <td align="left">
                                    <select name="eselon" id="eselon" class="form-control-static" style="width: 300px;">
                                    <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua...</option>
                                    <option value="1" <? if ($eselon=='1') echo "selected" ; ?>>I</option>
                                    <option value="2" <? if ($eselon=='2') echo "selected" ; ?>>II</option>
                                    <option value="3" <? if ($eselon=='3') echo "selected" ; ?>>III</option>
                                    <option value="4" <? if ($eselon=='4') echo "selected" ; ?>>IV</option>
                                        </select>
                                </td></tr>
                                  <tr valign="top">
                                  <td width="107" align="left">Jenis Kelamin:</td>
                                  <td align="left">
                                    <select name="kelamin" id="kelamin" class="form-control-static" style="width: 300px;">
                                    <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua...</option>
                                    <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
                                    <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
                                        </select>
                                </td></tr>
                        <!--	<tr>
                                <td>Pilih bulan : 
                                <select name="blpensiun" >
                                <option value="00">PILIH BULAN</option>
                                <option value="01">JANUARI</option>
                                <option value="02">FEBRUARI</option>
                                <option value="03">MARET</option>
                                <option value="04">APRIL</option>
                                <option value="05">MEI</option>
                                <option value="06">JUNI</option>
                                <option value="07">JULI</option>
                                <option value="08">AGUSTUS</option>
                                <option value="09">SEPTEMBER</option>
                                <option value="10">OKTOBER</option>
                                <option value="11">NOVEMBER</option>
                                <option value="12">DESEMBER</option>
                                </select>&nbsp;
                                </td>
                                </tr>-->
                        </table>
                        </form>
                        </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_pensiun(1);"><i class="fa fa-save"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
</div>
<div id="result"></div>