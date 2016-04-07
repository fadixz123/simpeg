<?php
    include("include/fungsi.inc");
?>
<h4 class="title">History Penggunaan Sistem</h4>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        search_data_aktivitas(1);
        $('#awal, #akhir').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
        });
    });
    function search_data_aktivitas(page) {
        $.ajax({
            type: 'GET',
            url: 'webmaster/aktivitas-list.php?page='+page,
            data: $('#form-search').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#datamodal_search').modal('hide');
                $('#result').html(data);
            }
        });
    }
    
    function reload_data() {
        $('#awal, #akhir').val('<?= date("d/m/Y") ?>');
        search_data_aktivitas(1);
    }
    
    function load_detail_history(id_user, awal, akhir) {
        $('#datamodal_detail').modal('show');
        $.ajax({
            url: 'include/autocomplete.php?search=history',
            data: 'id_user='+id_user+'&awal='+awal+'&akhir='+akhir,
            dataType: 'json',
            success: function(data) {
                $('#table_data_detail tbody').empty();
                $.each(data, function(i, v) {
                    var str = '<tr class="'+((i%2===1)?'odd':'even')+'">'+
                            '<td align="center">'+(i+1)+'</td>'+
                            '<td align="center">'+datefmysql(v.tanggal)+' '+v.jam+'</td>'+
                            '<td>'+v.app+'</td>'+
                            '<td>'+v.nipedit+'</td>'+
                            '<td>'+v.subapp+'</td>'+
                            '<td>'+v.what+'</td>'+
                            '</tr>';
                    $('#table_data_detail tbody').append(str);
                });
            }
        });
    }
</script>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">History</a></li>
</ul>
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
            <form id="form-search" role="form" class="form-horizontal">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                    <table>
                            <tr>
                                <td>Dari Tanggal: &nbsp;</td>
                                <td> 
                                    <input type="text" name="tg_tgldari" id="awal" value="<?=date("01/m/Y")?>" class="form-control" style="width: 145px;" />
                                </td>
                                <td align="center">&nbsp; s.d&nbsp; </td>
                                <td> 
                                    <input type="text" name="tg_tglsampai" id="akhir" class="form-control" value="<?=date("d/m/Y")?>" style="width: 145px;" />
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_aktivitas(1);"><i class="fa fa-save"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 
<div id="datamodal_detail" class="modal fade">
    <div class="modal-dialog" style="width: 1024px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Detail History</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <table class="table table-bordered table-stripped table-hover" id="table_data_detail" style="width: 100%">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Waktu</th>
                        <th width="15%" class="left">App</th>
                        <th width="15%">NIP</th>
                        <th width="10%" class="left">Sub App</th>
                        <th width="40%" class="left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
        </div>
    </div>
    </div>
</div>
<div id="result"></div>