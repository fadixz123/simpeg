<script type="text/javascript">
    function load_data_skp_setting(page) {
        $.ajax({
            type: 'GET',
            url: 'include/skp-setting-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
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
    
    function save_skp_setting() {
        if ($('#nama').val() === '') {
            dc_validation('#nama','Nama setting tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#nama');
        if ($('#target').val() === '') {
            dc_validation('#target','Target tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#target');
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=skpsetting',
            data: $('#skpsetting').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                var page = $('li.noblock').html();
                if (page === undefined) {
                    p = 1;
                } else {
                    p = page;
                }
                if (data.act === 'add') {
                    load_data_skp_setting(p);
                    message_add_success();
                } else {
                    load_data_skp_setting(p);
                    message_edit_success();
                }
            }
        });
    }
    
    function reload_data() {
        reset_form();
        load_data_skp_setting(1);
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function delete_user(id, p){
        bootbox.dialog({
          message: "Anda yakin akan menghapus data ini?",
          title: "Hapus Data",
          buttons: {
            batal: {
              label: '<i class="fa fa-refresh"></i> Batal',
              className: "btn-default",
              callback: function() {
                
              }
            },
            hapus: {
              label: '<i class="fa fa-trash-o"></i>  Hapus',
              className: "btn-primary",
              callback: function() {
                $.ajax({
                    type : 'DELETE',
                    url: '',
                    cache: false,
                    dataType : 'json',
                    success: function(data) {
                        get_list_pemesanan(p);
                        message_delete_success();
                    },
                    error: function(e){
                         message_delete_failed();
                    }
                });
              }
            }
          }
        });   
    }
    
    function edit_setting_skp(detail) {
        var data = detail.split('#');
        $('#datamodal_add').modal('show');
        //$detail = $data['id'].'#'.$data['B_02B'].'#'.$data['username'].'#'.$data['level'];
        $('#id').val(data[0]);
        $('#nama').val(data[1]);
        $('#jml_bulan').val(data[2]);
        $('#target').val(data[3]);
    }
    
    function edit_akses(id) {
        $('#datamodal_hakakses').modal('show');
        $('#idhakakses').val(id);
        $.ajax({
            url: 'include/autocomplete.php?search=hakakses&id_group='+id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#load-hak-akses tbody').empty();
                var str = '';
              	var modul = '';
              	var no = 1;
                $.each(data,function(i, v) {
                	var cek = '';
                	if (v.id_group_users !== null) {
                            cek = 'checked="checked"';
                	};

                    var highlight = 'odd';
                    if ((i % 2) === 1) {
                        highlight = 'even';
                    };

                    str = '<tr class="'+highlight+'">'+
                            '<td align="center"><b>'+((modul !== v.module)?no:'')+'</b></td>'+
                            '<td><b>'+((modul !== v.module)?v.module:'')+'</b></td>'+
                            '<td>'+v.menu+'</td>'+
                            '<td align="center" class="aksi">'+
                            	'<input type="checkbox" name="data[]" value="'+ v.id +'" '+cek+' class="check" />';
                            '</td>'+
                        '</tr>;'
                    $('#load-hak-akses tbody').append(str);

                    if (modul !== v.module) {
                    	no++;
                    	modul = v.module;
                    };
                });
            }
        });
    }
    
    $(function() {
        load_data_skp_setting(1);
        $('#tambah').click(function() {
            $('#datamodal_add').modal('show');
            reset_form();
        });
    });
</script>
<br/>
<div id="datamodal_add" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Tambah SKP Setting</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
		<form method="POST" id="skpsetting" action="?sid=<?=$sid?>&do=edituser">
                <input type="hidden" name="id" id="id" />
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" class="form-control" id="nama" value=""></td>
                        </tr>
                        <tr>
                            <td>Jumlah Bulan</td>
                            <td>:</td>
                            <td>
                                <select name="jml_bulan" id="jml_bulan" class="form-control-static">
                                    <?php for($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                                <span class="form-control-label">Bulan</span>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%">Target</td>
                            <td>:</td>
                            <td><input type="text" name="target" class="form-control" id="target" value=""></td>
                        </tr>
                    </table>
		</form>
                        </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="save_skp_setting(); "><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
    </div>
</div>

<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="tambah" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-plus-circle"></i> Tambah Data</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 
<div id="result">
    <table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th width="45%" class="left">Nama</th>
            <th width="15%" class="left">Jumlah Bulan</th>
            <th width="15%" class="left">Target</th>
            <th width="10%">&nbsp;</th>
        </tr>
        </thead>
    </table>
</div>
</body>

</html>