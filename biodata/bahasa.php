<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTBHSA1 where BS_01='$NIP' and BS_02='$BS_02' LIMIT 1") or die (mysql_error());

if ($simpanbahasa)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$BS04=strtoupper($BS_04[$i]);
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTBHSA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="BS_01='$NIP',BS_02='$i',BS_03='$BS_03[$i]',BS_04='$BS04',BS_05='$BS_05[$i]'";
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTBHSA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="BS_02='$i',BS_03='$BS_03[$i]',BS_04='$BS04',BS_05='$BS_05[$i]' ";
			$q .="where BS_01='$NIP' and ";
			$q .="BS_02='$BS_02ORG[$i]' and ";
    			$q .="BS_03='$BS_03ORG[$i]' and ";
    			$q .="BS_04='$BS_04ORG[$i]' and ";
    			$q .="BS_05='$BS_05ORG[$i]' ";
    			mysql_query($q) or die (mysql_error());
    		}
		if (mysql_affected_rows() > 0) $u++;
    	}
	if ($u > 0) lethistory($sid,"UPDATE KEMAMPUAN BAHASA",$NIP);
}
		
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

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
    
    function add_new_row_rbahasa(val) {
        for (i = 1; i <= val; i++) {
            var str = '<tr class="tr_rows '+((i%2===0)?'odd':'even')+'">'+
                '<td width="25" align="center">'+(i)+'</td>'+
                '<td width="90" valign="top">'+
                    '<select size="1" name="BS_03[]" >'+
                        '<option value="-">-</option>'+
                        '<option value="ASING">ASING</option>'+
                        '<option value="DAERAH">DAERAH</option>'+
                    '</select>'+
                '</td>'+
                '<td><input type="text" size="32" name="BS_04[]"></td>'+
                '<td>'+
                    '<select size="1" name="BS_05[]" >'+
                        '<option value="-">-</option>'+
                        '<option value="AKTIF">AKTIF</option>'+
                        '<option value="PASIF">PASIF</option>'+
                    '</select>'+
                '</td>'+
                '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
              '</tr>';
            $('#rbahasa tbody').append(str);
        }
    }
    function save_data_rbahasa() {
        
        var jml = $('.tr_rows').length;
        var stop = false;
        if (jml === 0) {
            dc_validation('#tambah','Belum ada data yang di tambahkan !');
            stop = true;
        }
        if (stop) {
            return false;
        }
        
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=rbahasa',
            data: $('#rbahasa_form').serialize(),
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
<form name="bahasaform" id="rbahasa_form">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rbahasa">
    <thead>
    <tr>
        <th width="3%">No</th>
        <th width="10%">JENIS</th>
        <th width="40%">NAMA BAHASA</th>
        <th width="10%">KEMAMPUAN</th>
        <th width="2%">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
<?php
$r=mysql_query("select BS_01,BS_02,BS_03,BS_04,BS_05 from MSTBHSA1 where BS_01='$NIP' order by BS_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r)) {
  	$no++;
  	?> 
  <tr class="tr_rows">
    <td align="center"><?= $no ?></td>
    <td>
        <select size="1" name="BS_03[]" >
            <option value="-">-</option>
            <option value="ASING" <? if ($row[BS_03]=='ASING') echo "selected"?>>ASING</option>
            <option value="DAERAH"<? if ($row[BS_03]=='DAERAH') echo "selected"?>>DAERAH</option>
        </select>
    </td>
    <td><input type="text" size="32" name="BS_04[]" value="<?=$row[BS_04]?>"></td>
    <td>
        <select size="1" name="BS_05[]" >
            <option value="-">-</option>
            <option value="AKTIF" <? if ($row[BS_05]=='AKTIF') echo "selected"?>>AKTIF</option>
            <option value="PASIF" <? if ($row[BS_05]=='PASIF') echo "selected"?>>PASIF</option>
        </select>
    </td>
    <td align="center"><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
<?php
}
?>   
  </tbody>
  <tfoot>
  <tr>
    <td width="586" colspan="5"><b>Jml Kemampuan Bhs yang Akan Ditambahkan :</b>&nbsp;
        <select name="jmltambah" id="tambah" onchange="add_new_row_rbahasa(this.value);" style="width: 100px;" >
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
        <button type="button" class="btn btn-primary" onclick="save_data_rbahasa(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  </tfoot>
</table>
</form>