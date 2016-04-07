<h4 class="title">SELEKSI JABATAN</h4>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        load_data_pemilihan(1);
        $('#adddata').click(function() {
            $('#datamodal_add').modal('show');
            reset_form();
        });
        
        $('#awal, #akhir').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
        
        $('#nip').select2({
            ajax: {
                url: 'include/autocomplete.php?search=pegawai',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        uk: 'all',
                        suk: ''
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
                $('#nip').val(data.id);
                return data.list;
            }
        });
    });
    
    function reload_data() {
        reset_form();
        load_data_pemilihan(1);
    }

    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function load_data_pemilihan(page) {
        $.ajax({
            type: 'GET',
            url: 'include/baperjakat-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
            data: $('#form-search').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#datamodal_add').modal('hide');
                $('#result').html(data);
            }
        });
    }
    
    function save_baperjakat() {
        if ($('#jabatan').val() === '') {
            dinamic_alert('Jabatan tidak boleh kosong !'); return false;
        }
        dc_validation_remove('#jabatan');
        if ($('#awal').val() === '' || $('#akhir').val() === '') {
            dinamic_alert('Awal tidak boleh kosong!'); return false;
        }
        var jml =  $('input:checked').length;
        if (parseFloat(jml) === 0) {
            dinamic_alert('Pegawai belum ada yang dipilih !'); return false;
        }
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=baperjakat',
            dataType: 'json',
            data: $('#form-save').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                if (data.status === true) {
                    $('#s2id_nip a .select2-chosen').html('&nbsp;');
                    $('#nip').val('');
                    if (data.act === 'add') {
                        message_add_success();
                        load_data_pemilihan(1);
                    } else {
                        message_edit_success();
                    }
                } else {
                    message_add_failed();
                }
                hide_ajax_indicator();
            }, error: function() {
                hide_ajax_indicator();
            }
        });
    }
    
    function add_new_row() {
        var nip = $('#nip').val();
        if (nip === '') {
            dinamic_alert('Nama pegawai belum dipilih !'); return false;
        }
        $.ajax({
            type: 'GET',
            url: 'include/kandidat.php?sid=<?= $_GET['sid'] ?>&nip='+nip,
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                $('#filter').append(data);
                $('#s2id_nip a .select2-chosen').html('&nbsp;');
                $('#nip').val('');
                hide_ajax_indicator();
            }
        });
        return false;
    }
    
    function detail_seleksi(id) {
        $.ajax({
            url: 'include/baperjakat-detail.php?id='+id,
            success: function(data) {
                $('#datamodal_detail').modal('show');
                $('#detail-seleksi').html(data);
            }
        });
    }
    
    function paging(page, tab, search) {
        load_data_pemilihan(page);
    }
</script>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Baperjakat</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="adddata" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-plus-circle"></i> Tambah</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div>
<div id="datamodal_add" class="modal fade">
    <div class="modal-dialog" style="width: 1024px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Tambah BAPERJAKAT</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <form id="form-save" role="form" class="form-horizontal">
                <input type="hidden" name="id_baperjakat" id="id_baperjakat" />
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <table width="100%" id="autohide">
                        <tr>
                            <td width="15%">Nama Jabatan:</td>
                            <td><input type="text" name="jabatan" class="form-control-static" id="jabatan" style="width: 300px;" /></td>
                        </tr>
                        <tr>
                            <td>Masa Jabatan:</td>
                            <td>
                                <input type="text" name="awal" class="form-control-static" id="awal" style="width: 134px;" /> <span class="form-control-label">s . d </span>
                                <input type="text" name="akhir" class="form-control-static" id="akhir" style="width: 135px;" />
                            </td>
                        </tr>
                        <tr>
                            <td width="15%">NIP / Nama:</td>
                            <td><input type="text" name="nip" class="select2-input" id="nip"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="button" class="btn btn-primary" onclick="add_new_row();"><i class="fa fa-plus-circle"></i> Tambahkan </button>
                            </td>
                        </tr>
                        </table>
                        <br/>
                        <div id="filter"></div>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="save_baperjakat();"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
    </div>
</div>

<div id="datamodal_detail" class="modal fade">
    <div class="modal-dialog" style="width: 1024px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Detail Seleksi BAPERJAKAT</h4>
                </div>
            </div>
        </div>
        <div class="modal-body" id="detail-seleksi">
            
        </div>
    </div>
    </div>
</div>
<div id="result"></div>