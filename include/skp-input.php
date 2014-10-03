<?php
session_start();
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        load_data_skp_input(1);
        $('#awal, #akhir').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
        $('#input-skp').click(function() {
            $('#datamodal_input_skp').modal('show');
        });
        $('#nama, #nama2').select2({
            ajax: {
                url: 'include/autocomplete.php?search=pegawai',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        uk: 'all',
                        suk: '',
                        skpd: '<?= $_SESSION['skpd'] ?>'
                    };
                },
                results: function (data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available

                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.data, more: more};
                }
            },
            formatResult: function(data){
                var markup = data.list;
                return markup;
            }, 
            formatSelection: function(data){
                return data.list;
            }
        });
        
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
        });
    });
    
    function confirm_save() {
        
        if ($('#nama').val() === '') {
            dc_validation('#nama','Nama pegawai tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#nama');
        if ($('#kegiatan').val() === '') {
            dc_validation('#kegiatan','Kegiatan tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#kegiatan');
        if ($('#jumlah').val() === '') {
            dc_validation('#jumlah','Jumlah tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#jumlah');
        bootbox.dialog({
          message: "Data yang dimasukkan tidak dapat di ubah, Anda yakin akan menyimpan data ini?",
          title: "Konfirmasi Simpan Data",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            hapus: {
              label: '<i class="fa fa-trash-o"></i>  Simpan',
              className: "btn-primary",
              callback: function() {
                save_skp_input();
              }
            }
          }
        }); 
    }
    
    function reload_data_input() {
        reset_form_input();
        load_data_skp_input(1);
    }
    
    function reset_form_input() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function load_data_skp_input(page) {
        $.ajax({
            type: 'GET',
            url: 'include/skp-input-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
            data: $('#form-search').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#datamodal_add').modal('hide');
                $('#result-input').html(data);
            }
        });
    }
    
    function save_skp_input() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=skp',
            data: $('#skp').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.status === true) {
                    load_data_skp_input(1);
                    message_add_success();
                    reset_form_input();
                }

            }
        });
    }
</script>
<br/>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="input-skp" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-plus-circle"></i> Tambah Data</button>
        <button class="btn" data-target=".bs-modal-lg" id="searching"><i class="fa fa-search"></i> Cari Data</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data_input();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 

<div id="result-input" class="result">
    <table width="100%" class="table table-bordered table-stripped table-hover">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%" class="left">Waktu</th>
            <th width="35%" class="left">Nama Kegiatan</th>
            <th width="45%" class="left">Nama Pegawai</th>
            <th width="15%" class="left">Jumlah</th>
            <th width="10%">&nbsp;</th>
        </tr>
        </thead>
    </table>
</div>

<div id="datamodal_input_skp" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Input SKP Setting</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
		<form method="POST" id="skp" action="?sid=<?=$sid?>&do=edituser">
                <input type="hidden" name="id" id="id" />
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" class="select2-input" id="nama" value=""></td>
                        </tr>
                        <tr>
                            <td>Nama Kegiatan</td>
                            <td>:</td>
                            <td>
                                <select name="kegiatan" id="kegiatan" class="form-control">
                                    <option value="">Pilih ...</option>
                                    <?php 
                                    $sql = mysql_query("select * from kegiatan_skp order by nama");
                                    while ($data = mysql_fetch_array($sql)) { ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Jumlah</td>
                            <td>:</td>
                            <td><input type="text" name="jumlah" class="form-control" id="jumlah" value=""></td>
                        </tr>
                    </table>
		</form>
                        </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="confirm_save(); "><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
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
            <form id="form-search" role="form" class="form-horizontal">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <table width="100%">
                            <tr>
                                <td width="20%">Tanggal</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="awal" class="form-control-static" id="awal" value="">
                                    <input type="text" name="akhir" class="form-control-static" id="akhir" value="">
                                </td>
                            </tr>
                            <tr>
                                <td width="20%">Nama</td>
                                <td>:</td>
                                <td><input type="text" name="nama" class="select2-input" id="nama2" value=""></td>
                            </tr>
                            <tr>
                                <td>Nama Kegiatan</td>
                                <td>:</td>
                                <td>
                                    <select name="kegiatan" id="kegiatan2" class="form-control" style="width: 300px;">
                                        <option value="">Pilih ...</option>
                                        <?php 
                                        $sql = mysql_query("select * from kegiatan_skp order by nama");
                                        while ($data = mysql_fetch_array($sql)) { ?>
                                        <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                        <?php } ?>
                                    </select>
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
            <button type="button" class="btn btn-primary" onclick="load_data_skp_input(1);"><i class="fa fa-save"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>