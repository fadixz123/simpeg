<?php
session_start();
?>
<script type="text/javascript">
    function load_data_usersystem(page) {
        $.ajax({
            type: 'GET',
            url: 'webmaster/usergroup-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
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
    
    function save_data_user() {
        if ($('#nip').val() === '') {
            dc_validation('#nip','Nama Group tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#nip');
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=groupusersystem',
            data: $('#usersystem').serialize(),
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
                if (data.status === true) {
                    load_data_usersystem(p);
                    message_add_success();
                }
            }
        });
    }
    
    function save_hak_akses() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=hakakses',
            data: $('#hakaksesuser').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.status === true) {
                    message_edit_success();
                }
            }
        });
    }
    
    function reload_data() {
        reset_form();
        load_data_usersystem(1);
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function paging(page) {
        load_data_usersystem(page);
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
    
    function edit_user(detail) {
        var data = detail.split('#');
        $('#datamodal_add').modal('show');
        //$detail = $data['id'].'#'.$data['B_02B'].'#'.$data['username'].'#'.$data['level'];
        $('#id').val(data[0]);
        $('#nip').val(data[1]);
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
        load_data_usersystem(1);
        $('#tambah').click(function() {
            $('#datamodal_add').modal('show');
            reset_form();
        });
        $('#checkall').click(function() {
            var status = $('#checkall').is(':checked');
            if (status === true) {
                $('input[type=checkbox]').attr('checked','checked');
            } else {
                $('input[type=checkbox]').removeAttr('checked');
            }
        });
    });
</script>
<h4 class="title">ADMINISTRASI GROUP USER</h4>

<div id="datamodal_add" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Tambah Group User System</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
		<form method="POST" id="usersystem" action="?sid=<?=$sid?>&do=edituser">
                <input type="hidden" name="id" id="id" />
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" size="20" class="form-control" id="nip" value="<?=$ro[nama]?>"></td>
                        </tr>
                    </table>
		</form>
                        </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="save_data_user(); "><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
    </div>
</div>

<div id="datamodal_hakakses" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Manage Hak Akses</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <form method="POST" id="hakaksesuser" action="?sid=<?=$sid?>&do=edituser">
                            <input type="hidden" name="id" id="idhakakses" />
                            <table width="100%" class="table table-bordered table-stripped table-hover" id="load-hak-akses">
                                <thead>
                                    <tr>
                                        <th align="center" width="5%">No.</th>
                                        <th width="20%" class="left">Modul</th>
                                        <th width="65%" class="left">Nama Menu</th>
                                        <th align="center" width="10%"><input type="checkbox" id="checkall" /></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="save_hak_akses(); "><i class="fa fa-save"></i> Simpan</button>
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
            <th width="75%" class="left">Nama</th>
            <th width="10%">&nbsp;</th>
        </tr>
        </thead>
    </table>
</div>
</body>

</html>