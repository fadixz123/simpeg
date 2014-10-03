<?php
session_start();
?>
<script type="text/javascript">
    function load_data_kategori_arsip(page) {
        $.ajax({
            type: 'GET',
            url: 'include/arsip-kategori-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
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
            url: 'biodata/save-data.php?save=kategori_arsip',
            data: $('#kategori_arsip').serialize(),
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
                    if (data.act === 'add') {
                        load_data_kategori_arsip(p);
                        message_add_success();
                    } else {
                        load_data_kategori_arsip(p);
                        message_edit_success();
                    }
                }
            }
        });
    }
   
    function reload_data() {
        reset_form();
        load_data_kategori_arsip(1);
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function paging(page) {
        load_data_kategori_arsip(page);
    }
    
    function delete_arsip_kategori(id, p){
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
                    url: 'include/delete.php?delete=arsip_kategori&id='+id,
                    cache: false,
                    dataType : 'json',
                    success: function(data) {
                        load_data_kategori_arsip(p);
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
    
    function edit_arsip_kategori(detail) {
        var data = detail.split('#');
        $('#datamodal_add').modal('show');
        //$detail = $data['id'].'#'.$data['B_02B'].'#'.$data['username'].'#'.$data['level'];
        $('#id').val(data[0]);
        $('#nip').val(data[1]);
        $('#keterangan').val(data[2]);
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
        load_data_kategori_arsip(1);
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
<h4 class="title">ARSIP KATEGORI</h4>

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
		<form method="POST" id="kategori_arsip" action="?sid=<?=$sid?>&do=edituser">
                <input type="hidden" name="id" id="id" />
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td width="80%"><input type="text" name="nama" size="20" class="form-control" id="nip" value="<?=$ro[nama]?>"></td>
                        </tr>
                        <tr>
                            <td width="20%">Keterangan</td>
                            <td>:</td>
                            <td><textarea name="keterangan" id="keterangan" class="form-control"></textarea></td>
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

<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="tambah" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-plus-circle"></i> Tambah Data</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 
<div id="result">
</div>
</body>

</html>