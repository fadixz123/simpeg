<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTJASA1 where JS_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());
if ($simpanrtj)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgjs05=$THJS_05[$i]."-".$BLJS_05[$i]."-".$TGJS_05[$i];
		$JS03=strtoupper($JS_03[$i]);
		$JS07=strtoupper($JS_07[$i]);
		$a[$i]=$xtgjs05;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JS_01='$NIP',JS_02='$i',JS_03='$JS03',JS_04='$JS_04[$i]',JS_05='$xtgjs05', ";
			$q .="JS_06='$JS_06[$i]',JS_07='$JS07'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JS_02='$i',JS_03='$JS03',JS_04='$JS_04[$i]',JS_05='$xtgjs05', ";
			$q .="JS_06='$JS_06[$i]',JS_07='$JS07' where JS_01='$NIP' and ";
			$q .="JS_02='$JS_02ORG[$i]' and ";
			$q .="JS_03='$JS_03ORG[$i]' and ";
			$q .="JS_04='$JS_04ORG[$i]' and ";
			$q .="JS_05='$JS_05ORG[$i]' and ";
			$q .="JS_06='$JS_06ORG[$i]' and ";
			$q .="JS_07='$JS_07ORG[$i]' ";
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TANDA JASA",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgjs05=$THJS_05[$i]."-".$BLJS_05[$i]."-".$TGJS_05[$i];
		$q="update MSTJASA1 set JS_02='$i' where JS_01='$NIP' and JS_05='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<script type="text/javascript">
    $(function() {
        $('.dpicker').datepicker({
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
    
    function add_new_row_rtanda_jasa(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows '+((i%2===0)?'odd':'even')+'">'+
                '<td align=center>'+(jml+i)+'</td>'+
                '<td><input type="text" name="JS_03[]" size="40"/><input type="hidden" name="ID[]" value="" /></td>'+
                '<td><input type="text" name="JS_04[]" size="30"/></td>'+
                  '<td><input type="text" name="TGJS_05[]" class="dpicker" /></td>'+
                  '<td><input type="text" name="JS_06[]" size="4" /></td>'+
                  '<td><input type="text" name="JS_07[]" size="40"/></td>'+
                  '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
                '</tr>';
            $('#rtanda_jasa tbody').append(str);
            $('.dpicker').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rtandajasa() {
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
            url: 'biodata/save-data.php?save=rtanda_jasa',
            data: $('#rtandajasa_form').serialize(),
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
<form name="rtjform" id="rtandajasa_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rtanda_jasa">

    
<!--  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="25" align="center"><b>K</b></td>
    <td width="549" colspan="4"><b>RIWAYAT TANDA JASA/PENGHARGAAN/KEHORMATAN</b></td>
  </tr>-->
    <thead>
  <tr>
    <th width="5%">No</th>
    <th width="30%">NAMA PENGHARGAAN</th>
    <th width="20%">NO SK</th>
    <th width="10%">TANGGAL</th>
    <th width="10%">TAHUN</th>
    <th width="30%">ASAL PEROLEHAN</th>
    <th width="1%">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php
$r=mysql_query("select * from MSTJASA1 where JS_01='$NIP' order by JS_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>
  <tr class="tr_rows">
    
    <td align="center"><?=$no?></td>
    <td>
        <input type="hidden" name="ID[]" value="<?= $row['ID'] ?>" />
        <input type="text" name="JS_03[]" value="<?=$row[JS_03]?>" size="40"></td>
    <td>
        <input type="text" name="JS_04[]" value="<?=$row[JS_04]?>" size="30">
    </td>
    <td>
        <input type="text" name="TGJS_05[]" value="<?=datefmysql($row[JS_05])?>" class="dpicker"></td>
    <td>
        <input type="text" name="JS_06[]" size="2" maxlength="4"  value="<?=$row[JS_06]?>" class="tahun"> 
    </td>
    <td valign="top">
    <input type="text" name="JS_07[]" value="<?=$row[JS_07]?>" size="20"></td>
    <td align="center" valign="top">
        <button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button>
    </td>
  </tr>
<?
}
?>  
  </tbody>
  <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="7">Jumlah Riwayat yang Akan Ditambahkan :&nbsp;
        <select name="jmltambah" onchange="add_new_row_rtanda_jasa(this.value);" style="width: 100px;">
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
        </select><input type="hidden" name="no" value="<?=$no?>">
        <button type="button" class="btn btn-primary" onclick="save_data_rtandajasa(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>

  <tr>
    <td width="586" colspan="7"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan Tanggal &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>