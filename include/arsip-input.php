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
        $('#kategori').select2({
            ajax: {
                url: 'include/autocomplete.php?search=arsip_kategori',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        uk: $('#uk').val(),
                        suk: $('#suk').val()
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
        
    });
    
    $('#formadd').on('submit', function(e){
        e.preventDefault();
//            if($('#keterangan').val() === ''){
//                dc_validation('#keterangan','Keterangan tidak boleh kosong !');
//                return false;
//            }
        if ($('#gambar').val() === '') {
            dc_validation('#gambar','Gambar tidak boleh kosong !');
        }
        $(this).ajaxSubmit({
            target: '#output',
            dataType: 'json',
            success: function(msg) {
                if (msg.act === 'add') {
                    message_add_success();
                } else {
                    message_edit_success();
                }
            }
        });
    });
    
    function add_new_rows() {
        var id_kategori = $('#kategori').val();
        var kat_name    = $('#s2id_kategori a .select2-chosen').html();
        var file        = $('input[type=file]').val();
        var keterangan  = $('#keterangan').val();
        var num         = $('.rows').length+1;
        
        var str = '<tr class="rows '+((num%2===0)?'even':'odd')+'">'+
                    '<td align="center">'+num+'</td>'+
                    '<td>'+kat_name+' <input name="id_kategori[]" type="hidden" value="'+id_kategori+'" /></td>'+
                    '<td>'+keterangan+' <input type="hidden" name="keterangan[]" value="'+keterangan+'" /></td>'+
                    '<td><input name="[]" type="file" value="'+file+'" /></td>'+
                    '<td></td>'+
                '</tr>';
        $('#load-arsip tbody').append(str);
    }
    
    function save_arsip_digital() {
        $('#formadd').submit();
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
                                '<td align="center"></td>'+
                                '<td>'+v.nama+'</td>'+
                                '<td>'+v.keterangan+'</td>'+
                                '<td></td>'+
                            '</tr>';
                    $('#load-arsip tbody').append(str);
                });
            }
        });
    }
</script>
<br/>
<form id="formadd" method="POST" action="biodata/save-data.php?save=arsip_digital" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" />
<table width="100%">
    <tr>
        <td width="20%">Kategori Arsip:</td><td><input type="text" name="kategori" id="kategori" class="select2-input" /></td>
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
            <button class="btn btn-primary" onclick="save_arsip_digital();"><i class="fa fa-plus-circle"></i> Simpan</button>
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
                <th width="30%" class="left">File(s)</th>
                <th width="5%" class='nowrap'></th>
            </tr>
        </thead>
        <tbody>

        </tbody>    
    </table>