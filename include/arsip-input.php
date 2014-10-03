<?php
session_start();
include('config.inc');
include('fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<script type="text/javascript" src="Scripts/jquery.form.js"></script>
<script type="text/javascript">
    $(function() {
        load_data_arsip();
    });
    function save_arsip_digital() {
        if ($('#kategori').val() === '') {
            dc_validation('#kategori','Kategori harus dipilih!'); return false;
        }
        dc_validation_remove('#kategori');
        if ($('#file').val() === '') {
            dc_validation('#file','File harus dipilih!'); return false;
        }
        dc_validation_remove('#file');
        $('#formadd').ajaxSubmit({
            target: '#output',
            dataType: 'json',
            data: $('#formadd').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(msg) {
                hide_ajax_indicator();
                $('input[type=text],input[type=file], select').val('');
                if (msg.act === 'add') {
                    message_add_success();
                    load_data_arsip();
                } else {
                    message_edit_success();
                    load_data_arsip();
                }
            },
            error: function() {
                hide_ajax_indicator();
                dinamic_alert('File yang di upload harus bertipe PDF!');
            }
        });
        
    }
    
//    function save_arsip_digital() {
//        $('#formadd').submit();
//    }
    function get_name_value() {
        var nama = $('#kategori option:selected').text();
        $('#nama_arsip').val(nama);
    }
    
    function delete_arsip(id, nama_file) {
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
                    url: 'include/delete.php?delete=arsip',
                    data: 'id='+id+'&nama_file='+nama_file,
                    cache: false,
                    dataType : 'json',
                    beforeSend: function() {
                        show_ajax_indicator();
                    },
                    success: function(data) {
                        load_data_arsip();
                        message_delete_success();
                        hide_ajax_indicator();
                    },
                    error: function(e){
                         message_delete_failed();
                         hide_ajax_indicator();
                    }
                });
              }
            }
          }
        });
    }
    
    function load_data_arsip() {
        $.ajax({
            url: 'include/autocomplete.php?search=arsip',
            data: 'nip=<?= $_GET['nip'] ?>',
            dataType: 'json',
            success: function(data) {
                $('#load-arsip tbody').empty();
                $.each(data, function(i, v) {
                    var str = '<tr class="rows '+((i%2===0)?'even':'odd')+'">'+
                                '<td align="center">'+(++i)+'</td>'+
                                '<td>'+v.nama+'</td>'+
                                '<td>'+v.keterangan+'</td>'+
                                '<td><a target="_BLANK" href="arsip/'+v.nama_file+'">'+v.nama_file+'</a></td>'+
                                '<td><button title="Klik untuk hapus file" onclick="delete_arsip('+v.id+', \''+v.nama_file+'\');" type="button" class="btn btn-default btn-xs"><i class="fa fa-minus-circle"></i> </button> </td>'+
                            '</tr>';
                    $('#load-arsip tbody').append(str);
                });
            }
        });
    }
</script>
<br/>
<form id="formadd" method="POST" action="biodata/save-data.php?save=arsip_digital" enctype="multipart/form-data">
    <input type="hidden" name="nip" id="nip" value="<?= $_GET['nip'] ?>" />
    <input type="hidden" name="id" id="id" />
    <input type="hidden" name="nama_arsip" id="nama_arsip" />
<table width="100%">
    <tr>
        <td width="20%">Kategori Arsip:</td><td>
            <select name="kategori" id="kategori" onchange="get_name_value();" class="form-control-static" style="width: 300px;">
                <option value="">Pilih ...</option>
            <?php
            $sql = mysql_query("select * FROM arsip_kategori order by nama");
            while ($data = mysql_fetch_array($sql)) { ?>
                <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
            <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>File:</td><td><input type="file" name="mFile" id="file" class="form-control-static" /></td>
    </tr>
    <tr>
        <td width="20%">Keterangan:</td><td><input type="text" name="keterangan" id="keterangan" class="form-control-static" style="width: 300px;" /></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <button class="btn btn-primary" onclick="save_arsip_digital(); return false;"><i class="fa fa-plus-circle"></i> Simpan</button>
        </td>
    </tr>
</table>
</form>
<br/>

    <table class="table table-bordered table-stripped table-hover" id="load-arsip">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%" class="left">Nama Arsip</th>
                <th width="30%" class="left">Keterangan</th>
                <th width="34%" class="left">File(s)</th>
                <th width="1%" class='nowrap'></th>
            </tr>
        </thead>
        <tbody>

        </tbody>    
    </table>