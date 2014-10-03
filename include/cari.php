<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if ($cari) {
	
	if (strlen($B_03) > 0 && isset($uk)) {
		$q="select A_01,A_02,A_03,A_04,B_02,B_03A,B_03,B_03B,I_05,I_06,F_03 from MASTFIP08 where B_03 LIKE '%$B_03%' ";
		if ($uk != 'all') {
			$q.="and A_01='$uk' ";
		}
		$q.="order by I_06 ASC, F_03 DESC";
		$r=mysql_query($q) or die (mysql_error());
		if (mysql_num_rows($r) >= 1) $status=2; else $status=4;
	}
	
	if (isset($nip) && (strlen($nip)==9 || strlen($nip)==18)) {
		$q="select A_01,A_02,A_03,A_04,B_02,B_03A,B_03,B_03B,I_05,I_06,F_03 from MASTFIP08 where B_02='$nip' or B_02B='$nip' LIMIT 1";
		$r=mysql_query($q) or die (mysql_error());
		if (mysql_num_rows($r) == 1) {
			$status=1;
			$ro=mysql_fetch_array($r);
			$nip=$ro[B_02];
		} else $status=4;
	}
}

?>
<script>
	function checkForm() {
            if (document.getElementsByName("nip")[0].value.length > 18) {
                    alert('NIP tidak boleh lebih dari 18 karakter');
                    return false;
            }
	}
        
        function reload_data() {
            reset_form();
            search_data_pns(1);
        }
        
        function reset_form() {
            $('input[type=text], input[type=hidden], select, textarea').val('');
            $('a .select2-chosen').html('&nbsp;');
        }
        
        $(function() {
            search_data_pns(1);
            $('#searching').click(function() {
                $('#datamodal_search').modal('show');
                //reset_form();
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
            $('#suk').select2({
                ajax: {
                    url: 'include/autocomplete.php?search=suk',
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) { // page is the one-based page number tracked by Select2
                        return {
                            q: term, //search term
                            page: page, // page number
                            uk: $('#uk').val()
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
            /*$('#uk').change(function() {
                $.ajax({
                    url: 'include/autocomplete.php?search=suk',
                    data: 'q='+$('#uk').val(),
                    dataType: 'json',
                    success: function(data) {
                        $('#suk').html('<option value="">Semua sub unit kerja ...</option>');
                        $.each(data, function(i, v) {
                            $('#suk').append('<option value="'+v.KOLOK+'">'+v.NALOK+'</option>');
                        });
                    }
                });
            });*/
        });
        
        function search_data_pns(page) {
            $.ajax({
                type: 'GET',
                url: 'include/cari-list.php?page='+page,
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
        
        function load_detail(url) {
            $('#detail-pegawai').empty();
            $('#datamodal_search_detail').modal('show');
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    hide_ajax_indicator();
                    $('#detail-pegawai').html(data);
                }
            });
            return false;
        }
        
        function paging(page, tab, search) {
            search_data_pns(page);
        }
</script>
<h4 class="title">PENCARIAN PNS</h4>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
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
                    <table width="100%" id="autohide">
                        <tr>
                            <td width="20%">Unit Kerja:</td>
                            <td>
                                <select name="uk" class="form-control" id="uk">
                                      <option value="all">Semua unit kerja...</option>
                                      <?
                                      $lsuk=listUnitKerja();
                                      foreach($lsuk as $key=>$value) {
                                      ?>
                                      <option value="<?=$value[0]?>"><?= ucfirst(strtolower($value[1]))?></option>
                                      <? } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Unit Kerja:</td>
                            <td>
                                <!--<select name="suk" class="form-control" id="suk"></select>-->
                                <input type="text" name="suk" class="select2-input" id="suk">
                            </td>
                      </tr>
                      <tr>
                      <td width="15%">NIP / Nama:</td>
                      <td>
                        <input type="text" name="nip" class="select2-input" id="nip">

                      </tr>
                    </table>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_pns(1);"><i class="fa fa-save"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
<div id="datamodal_search_detail" class="modal fade">
    <div class="modal-dialog" style="width: 700px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Detail Data Pegawai</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <div id="detail-pegawai"></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Close</button>
        </div>
    </div>
    </div>
</div>
<div id="result">
    <table class="table table-bordered table-stripped table-hover" id="table_data_no">
        <thead>
            <tr>
              <th width="5%">No</th>
              <th width="10%" class="left">NIP Lama</th>
              <th width="10%" class="left">NIP Baru</th>
              <th width="25%" class="left">Nama</th>
              <th width="49%" class="left">Unit Kerja Jabatan</th>
              <th width="1%"></th>
            </tr>
        </thead>
    </table>
</div>
<?
mysql_close();
?>
