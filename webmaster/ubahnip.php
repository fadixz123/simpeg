<script type="text/javascript">
    $(function() {
        $('#nip1').select2({
            ajax: {
                url: 'include/autocomplete.php?search=pegawai',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        uk: '',
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
                $('#nip1').val(data.id);
                return data.list;
            }
        });
    });
    
    function save_perubahan() {
        var stop = false;
        if ($('#nip1') === '') {
            dc_validation('#nip1','NIP Lama tidak boleh kosong !');
            stop = true;
        }
        if ($('#nip2') === '') {
            dc_validation('#nip2','NIP Baru tidak boleh kosong !');
            stop = true;
        }
        if (stop) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=ubahnip',
            data: $('#ubahnip_form').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.status === false) {
                    message_edit_failed();
                } else {
                    message_edit_success();
                    $('#s2id_nip1, #nip2').val('');
                    $('a .select2-chosen').html('&nbsp;');
                }
            },
            error: function() {
                hide_ajax_indicator();
            }
        });
    }
</script>
<h4 class="title">UBAH NIP</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Ubah NIP</a></li>
</ul>
<form id="ubahnip_form">
<table width="100%">

  <tr> 
    <td width="15%">NIP Lama:</td>
    <td width="85%">
	<input type="text" name="nip1" id="nip1" value="<?=$NIP?>" size="18" maxlength="18" class="select2-input"></td>
  </tr>
  <tr> 
    <td width="15%">NIP Baru:</td>
    <td width="85%"><input name="nip2" id="nip2" type="text" id="nip2" size="18" maxlength="18" class="form-control" style="width: 300px;"></td>
  </tr>
  <tr> 
    <td width="15%"></td>
    <td width="85%"><button class="btn btn-primary" onclick="save_perubahan(); return false;"><i class="fa fa-save"></i> Simpan Perubahan</button></td>
  </tr>
</table>
</form>
<table width="100%">

</table>