<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];

$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));
$sql = mysql_query("select * from tb_jenis_hukuman order by nama");
$rows = array();
while ($data = mysql_fetch_array($sql)) {
    $rows[] = $data;
}
?>
<script type="text/javascript">
    $(function() {
        $('.tanggal').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function removeMe(el) {
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var jumlah = $('.tr_rows').length;
        var col = 0;
        for (i = 1; i <= jumlah; i++) {
            $('.tr_rows:eq('+col+')').children('td:eq(0)').html(i);
            col++;
        }
    }
    
    function add_new_row_rpekerjaan(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows">'+
                '<td align="center">'+(i+jml)+'</td>'+
                '<td><input type="text" name="perusahaan[]" id="perusahaan'+i+'" /></td>'+
                '<td><input type="text" name="jabatan[]" id="jabatan'+i+'" /></td>'+
                '<td><input type="text" name="tgl_bekerja[]" id="tgl_bekerja'+i+'" class="tanggal" /></td>'+
                '<td><input type="text" name="tgl_berhenti[]" id="tgl_berhenti'+i+'" class="tanggal" /></td>'+
                '<td><input type="text" name="alasan_berhenti[]" id="alasan_berhenti'+i+'"></td>'+
                '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
              '</tr>';
            $('#rpekerjaan tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rpekerjaan() {
        var jml = $('.tr_rows').length;
        var stop = false;
        if (jml === 0) {
            dc_validation('#tambah','Pilih jumlah jabatan !');
            stop = true;
        }
        for (i = 1; i <= jml; i++) {
            
        }
        if (stop) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=rpekerjaan',
            data: $('#rpekerjaan_form').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.act === 'edit') {
                    message_edit_success();
                } else {
                    message_add_success();
                }
            },
            error: function() {
                hide_ajax_indicator();
            }
        });
    }
    
</script>
<form id="rpekerjaan_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rpekerjaan">
    <thead>
        <tr>
            <th width="3%">No</th>
            <th width="20%">PERUSAHAAN</th>
            <th width="20%">JABATAN</th>
            <th width="7%">TGL BEKERJA</th>
            <th width="7%">TGL BERHENTI</th>
            <th width="20%">ALASAN BERHENTI</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tbody>
<?php
$r=mysql_query("select * from tb_riwayat_pekerjaan where nip='$NIP' order by id") or die (mysql_error());

$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>   
  <tr class="tr_rows">
    <td align="center"><?=$no?></b></td>
    <td><input type="text" name="perusahaan[]" id="perusahaan<?= $no ?>" value="<?= $row['perusahaan'] ?>" /></td>
    <td><input type="text" name="jabatan[]" id="jabatan<?= $no ?>" value="<?= $row['jabatan'] ?>" /></td>
    <td><input type="text" name="tgl_bekerja[]" id="tgl_bekerja<?= $no ?>" class="tanggal" value="<?= datefmysql($row['mulai_bekerja']) ?>" /></td>
    <td><input type="text" name="tgl_berhenti[]" id="tgl_berhenti<?= $no ?>" class="tanggal" value="<?= datefmysql($row['berhenti_bekerja']) ?>" /></td>
    <td><input type="text" name="alasan_berhenti[]" id="alasan_berhenti<?= $no ?>" value="<?= $row['alasan_berhenti'] ?>"></td>
    <td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
  
<?
}
?>   
  </tbody>
  <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="11"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
        <select name="jmltambah" onchange="add_new_row_rpekerjaan(this.value);" style="width: 100px;">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        <button type="button" class="btn btn-primary" onclick="save_data_rpekerjaan(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  <tr>
    <td colspan="11"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TANGGAL SELSAI &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>