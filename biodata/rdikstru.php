<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTSTRU1 where LT_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());

$aJab=array(1=>"SEPADA","SEPALA","SEPADYA","ADUM","ADUMLA","SPAMA","SESPA","SPAMEN","SESPANAS","SPATI","LEMHANAS","DIKLATPIM Tk.I","DIKLATPIM Tk.II","DIKLATPIM Tk.III","DIKLATPIM Tk.IV","DIKLATPIM PEMDA");
if ($simpandikstru)
{
	$u=0;	
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtglt07=$THLT_07[$i]."-".$BLLT_07[$i]."-".$TGLT_07[$i];
		$xtglt08=$THLT_08[$i]."-".$BLLT_08[$i]."-".$TGLT_08[$i];
		$xtglt11=$THLT_11[$i]."-".$BLLT_11[$i]."-".$TGLT_11[$i];
		
		$z=$i-1;
		$LT03=$aJab[$LT_03[$i]];
		
		$LT04=strtoupper($LT_04[$i]);
		$LT05=strtoupper($LT_05[$i]);
		$a[$i]=$LT_03[$i];
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTSTRU1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTSTRU1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11' ";
			$q .="where LT_01='$NIP' and ID='$IDORG[$i]'";// and ";
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
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT DIKLAT STRUKTURAL",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$m=intval($a[$z]);;
		
		$q="update MSTSTRU1 set LT_02='$i' where LT_01='$NIP' and LT_03='$aJab[$m]'";
		
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
    
    function add_new_row_rdikstru(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows">'+
            '<td align="center">'+(i+jml)+'</td>'+
            '<td>'+
            '<select name="LT_03[]" >'+
            '<option value="-">-</option>'+
                  '<option value="1">SEPADA</option>'+
                  '<option value="2">SEPALA</option>'+
                  '<option value="3">SEPADYA</option>'+
                  '<option value="4">ADUM</option>'+
                  '<option value="5">ADUMLA</option>'+
                  '<option value="6">SPAMA</option>'+
                  '<option value="7">SESPA</option>'+
                  '<option value="8">SPAMEN</option>'+
                  '<option value="9">SESPANAS</option>'+
                  '<option value="10">SPATI</option>'+
                  '<option value="11">LEMHANAS</option>'+
                  '<option value="12">DIKLATPIM Tk.I</option>'+
                  '<option value="13">DIKLATPIM Tk.II</option>'+
                  '<option value="16">DIKLATPIM PEMDA</option>'+
                  '<option value="14">DIKLATPIM Tk.III</option>'+
                  '<option value="15">DIKLATPIM Tk.IV</option>'+
            '</select></td>'+
            '<td><input type="text" name="LT_04[]"></td>'+
            '<td><input type="text" name="LT_05[]"></td>'+
            '<td><input type="text" name="LT_06[]"></td>'+
            '<td><input type="text" name="TGLT_07[]" class="tanggal"> </td>'+
            '<td><input type="text" name="TGLT_08[]" class="tanggal"></td>'+
            '<td><input type="text" name="LT_09[]" maxlength="4" class="tahun"></td>'+
            '<td><input type="text" name="LT_10[]"></td>'+
            '<td><input type="text" name="TGLT_11[]" class="tanggal"></td>'+
            '<td align="center"><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
          '</tr>';
            $('#rdikstru tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rdikstru() {
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
            url: 'biodata/save-data.php?save=rdikstru',
            data: $('#rdikstru_form').serialize(),
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
<form id="rdikstru_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rdikstru">
    <thead>
    <tr>
        <th>No</th>
        <th>NAMA</th>
        <th>TEMPAT</th>
        <th>PENYELENGGARA</th>
        <th>ANGKATAN</th>
        <th>TGL MULAI</th>
        <th>TGL SELESAI</th>
        <th>JML JAM</th>
        <th>NOMOR STPP</th>
        <th>TGL STPP</th>
        <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
<?php
$r=mysql_query("select ID,LT_01,LT_02,LT_03,LT_04,LT_05,LT_06,LT_07,LT_08,LT_09,LT_10,LT_11 from MSTSTRU1 where LT_01='$NIP' order by LT_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>   
  <tr class="tr_rows">
    <td align="center"><?= $no ?></td>
    <td>
    <select size="1" name="LT_03[]" >
    <option value="-">-</option>
          <option value="1"	<? if ($row["LT_03"]=="SEPADA") echo "selected"; ?>>SEPADA</option>
          <option value="2"	<? if ($row["LT_03"]=="SEPALA") echo "selected"; ?>>SEPALA</option>
          <option value="3"	<? if ($row["LT_03"]=="SEPADYA") echo "selected"; ?>>SEPADYA</option>
          <option value="4"	<? if ($row["LT_03"]=="ADUM") echo "selected"; ?>>ADUM</option>
          <option value="5"	<? if ($row["LT_03"]=="ADUMLA") echo "selected"; ?>>ADUMLA</option>
          <option value="6"	<? if ($row["LT_03"]=="SPAMA") echo "selected"; ?>>SPAMA</option>
          <option value="7"	<? if ($row["LT_03"]=="SESPA") echo "selected"; ?>>SESPA</option>
          <option value="8"	<? if ($row["LT_03"]=="SPAMEN") echo "selected"; ?>>SPAMEN</option>
          <option value="9"	<? if ($row["LT_03"]=="SESPANAS") echo "selected"; ?>>SESPANAS</option>
          <option value="10"	<? if ($row["LT_03"]=="SPATI") echo "selected"; ?>>SPATI</option>
          <option value="11"	<? if ($row["LT_03"]=="LEMHANAS") echo "selected"; ?>>LEMHANAS</option>
          <option value="12"	<? if ($row["LT_03"]=="DIKLATPIM Tk.I") echo "selected"; ?>>DIKLATPIM Tk.I</option>
          <option value="13"	<? if ($row["LT_03"]=="DIKLATPIM Tk.II") echo "selected"; ?>>DIKLATPIM Tk.II</option>
          <option value="16"	<? if ($row["LT_03"]=="DIKLATPIM PEMDA") echo "selected"; ?>>DIKLATPIM PEMDA</option>
          <option value="14"	<? if ($row["LT_03"]=="DIKLATPIM Tk.III") echo "selected"; ?>>DIKLATPIM Tk.III</option>
          <option value="15"	<? if ($row["LT_03"]=="DIKLATPIM Tk.IV") echo "selected"; ?>>DIKLATPIM Tk.IV</option>
    </select></td>
    <td><input type="text" name="LT_04[]" value="<?=$row[LT_04]?>"></td>
    <td><input type="text" name="LT_05[]" value="<?=$row[LT_05]?>"></td>
    <td><input type="text" name="LT_06[]" value="<?=$row[LT_06]?>"></td>
    <td><input type="text" name="TGLT_07[]" value="<?=datefmysql($row[LT_07])?>" class="tanggal"> </td>
    <td><input type="text" name="TGLT_08[]" value="<?=datefmysql($row[LT_08])?>" class="tanggal"></td>
    <td><input type="text" name="LT_09[]" maxlength="4"  value="<?=$row[LT_09]?>" class="tahun"></td>
    <td><input type="text" name="LT_10[]" value="<?=$row[LT_10]?>"></td>
    <td><input type="text" name="TGLT_11[]" value="<?=datefmysql($row[LT_11])?>" class="tanggal"></td>
    <td align="center"><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
  
<?
}
?>   
 </tbody>
 <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="11">Jumlah Riwayat yang Akan Ditambahkan :&nbsp;
        <select name="jmltambah" onchange="add_new_row_rdikstru(this.value);" style="width: 100px;">
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
        <button type="button" class="btn btn-primary" onclick="save_data_rdikstru(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  <tr>
    <td colspan="11">Perhatian : Data Akan Diurutkan otomatis berdasarkan TINGKAT PENDIDIKAN &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>