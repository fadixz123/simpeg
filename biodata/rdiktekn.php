<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTTEKN1 where LT_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());


if ($simpandiktekn)
{
	$u=0;
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtglt07=$THLT_07[$i]."-".$BLLT_07[$i]."-".$TGLT_07[$i];
		$xtglt08=$THLT_08[$i]."-".$BLLT_08[$i]."-".$TGLT_08[$i];
		$xtglt11=$THLT_11[$i]."-".$BLLT_11[$i]."-".$TGLT_11[$i];
		$LT03=strtoupper($LT_03[$i]);
		$LT04=strtoupper($LT_04[$i]);
		$LT05=strtoupper($LT_05[$i]);
		$a[$i]=$xtglt08;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTTEKN1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTTEKN1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11' ";
			$q .="where LT_01='$NIP' and ID='$IDORG[$i]'";
/*			$q .="LT_02='$LT_02ORG[$i]' and ";
			$q .="LT_03='$LT_03ORG[$i]' and ";
			$q .="LT_04='$LT_04ORG[$i]' and ";
			$q .="LT_05='$LT_05ORG[$i]' and ";
			$q .="LT_06='$LT_06ORG[$i]' and ";
			$q .="LT_07='$LT_07ORG[$i]' and ";
			$q .="LT_08='$LT_08ORG[$i]' and ";
			$q .="LT_09='$LT_09ORG[$i]' and ";
			$q .="LT_10='$LT_10ORG[$i]' and ";
			$q .="LT_11='$LT_11ORG[$i]' ";*/
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT DIKLAT TEKNIS",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$q="update MSTTEKN1 set LT_02='$i' where LT_01='$NIP' and LT_08='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
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
    
    function add_new_row_rdiktekn(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows">'+
                '<td>'+(i+jml)+'</td>'+
                '<td><input type="text" size="30" name="LT_03[]" /></td>'+
                '<td><input type="text" size="30" name="LT_04[]" /></td>'+
                '<td><input type="text" size="30" name="LT_05[]" /></td>'+
                '<td><input type="text" size="5"  name="LT_06[]" /></td>'+
                '<td><input type="text" name="TGLT_07[]" size="1" maxlength="2" class="tanggal" /></td>'+
                '<td><input type="text" name="TGLT_08[]" size="1" maxlength="2" class="tanggal" /> </td>'+
                '<td><input type="text" name="LT_09[]" size="2" maxlength="4" class="tahun" /></td>'+
                '<td><input type="text" size="25" name="LT_10[]" /></td>'+
                '<td><input type="text" name="TGLT_11[]" size="1" maxlength="2" class="tanggal"></td>'+
                '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
              '</tr>';
            $('#rdiktekn tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rdiktekn() {
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
            url: 'biodata/save-data.php?save=rdiktekn',
            data: $('#rdiktekn_form').serialize(),
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
<form id="rdiktekn_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rdiktekn">
    <thead>
        <tr>
            <th width="3%">No</th>
            <th width="15%">NAMA</th>
            <th width="15%">TEMPAT</th>
            <th width="15%">PENYELENGGARA</th>
            <th width="3%">ANGKATAN</th>
            <th width="7%">MULAI</th>
            <th width="7%">SELESAI</th>
            <th width="5%">JML JAM</th>
            <th width="10%">NOMOR STPP<br>
            <th width="7%">TGL STPP</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tbody>
<?php
$r=mysql_query("select ID,LT_01,LT_02,LT_03,LT_04,LT_05,LT_06,LT_07,LT_08,LT_09,LT_10,LT_11 from MSTTEKN1 where LT_01='$NIP' order by LT_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>   
  <tr class="tr_rows">
    <td align="center"><?=$no?></b></td>
    <td><input type="text" size="30" name="LT_03[]" value="<?=$row[LT_03]?>"></td>
    <td><input type="text" size="30" name="LT_04[]" value="<?=$row[LT_04]?>"></td>
    <td><input type="text" size="30" name="LT_05[]" value="<?=$row[LT_05]?>"></td>
    <td><input type="text" size="5"  name="LT_06[]" value="<?=$row[LT_06]?>"></td>
    <td><input type="text" name="TGLT_07[]" size="1" maxlength="2"  value="<?=datefmysql($row[LT_07])?>" class="tanggal"></td>
    <td><input type="text" name="TGLT_08[]" size="1" maxlength="2"  value="<?=datefmysql($row[LT_08])?>" class="tanggal"> </td>
    <td><input type="text" name="LT_09[]" size="2" maxlength="4"  value="<?=$row[LT_09]?>" class="tahun"></td>
    <td><input type="text" size="25" name="LT_10[]" value="<?=$row[LT_10]?>"></td>
    <td><input type="text" name="TGLT_11[]" size="1" maxlength="2" value="<?=datefmysql($row[LT_11])?>" class="tanggal"></td>
    <td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
  
<?
}
?>   
  </tbody>
  <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="11"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
        <select name="jmltambah" onchange="add_new_row_rdiktekn(this.value);" style="width: 100px;">
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
        <button type="button" class="btn btn-primary" onclick="save_data_rdiktekn(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  <tr>
    <td colspan="11"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TANGGAL SELSAI &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>