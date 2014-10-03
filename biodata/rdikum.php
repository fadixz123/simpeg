<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTPEND1 where DK_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());

if ($simpandikum)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		
		$xtgdk09=$THDK_09[$i]."-".$BLDK_09[$i]."-".$TGDK_09[$i];
		$DK04=addslashes(strtoupper($DK_04[$i]));
		$DK05=addslashes(strtoupper($DK_05[$i]));
		$DK06=addslashes(strtoupper($DK_06[$i]));
		$DK07=addslashes(strtoupper($DK_07[$i]));
		$a[$i]=$xtgdk09;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTPEND1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="DK_01='$NIP',DK_02='$i',DK_03='$DK_03[$i]',DK_04='$DK04',DK_05='$DK05', ";
			$q .="DK_06='$DK06',DK_07='$DK07',DK_08='$DK_08[$i]',DK_09='$xtgdk09'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTPEND1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="DK_02='$i',DK_03='$DK_03[$i]',DK_04='$DK04',DK_05='$DK05', ";
			$q .="DK_06='$DK06',DK_07='$DK07',DK_08='$DK_08[$i]',DK_09='$xtgdk09' ";
			$q .="where ID='$IDORG[$i]' and DK_01='$NIP'";/* and ";
			$q .="DK_02='$DK_02ORG[$i]' and ";
			$q .="DK_03='$DK_03ORG[$i]' and ";
			$q .="DK_04='".addslashes($DK_04ORG[$i])."' and ";
			$q .="DK_05='".addslashes($DK_05ORG[$i])."' and ";
			$q .="DK_06='".addslashes($DK_06ORG[$i])."' and ";
			$q .="DK_07='".addslashes($DK_07ORG[$i])."' and ";
			$q .="DK_08='$DK_08ORG[$i]' and ";
			$q .="DK_09='$DK_09ORG[$i]' ";*/
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT PENDIDIKAN UMUM",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		
		$q="update MSTPEND1 set DK_02='$i' where DK_01='$NIP' and DK_09='$a[$z]'";
		
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
    
    function add_new_row_rdikum(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows">'+
                '<td align="center">'+(i+jml)+'</td>'+
                '<td>'+
                    '<select name="DK_03[]">'+
                        '<option value="-">-</option>'+
                        '<option value="SD">SD</option>'+
                        '<option value="SLTP">SLTP</option>'+
                        '<option value="SLTA">SLTA</option>'+
                        '<option value="D-I">D-I</option>'+
                        '<option value="D-II">D-II</option>'+
                        '<option value="D-III">D-III</option>'+
                        '<option value="D-IV">D-IV</option>'+
                        '<option value="SARMUD">SARMUD</option>'+
                        '<option value="SARMUD NON AK">SARMUD NON AK</option>'+
                        '<option value="S1">STRATA-1</option>'+
                        '<option value="S2">STRATA-2</option>'+
                        '<option value="S3">STRATA-3</option>'+
                        '<option value="P">PROFESI</option>'+
                    '</select>'+
                '</td>'+
                '<td><input type="text" name="DK_04[]"></td>'+
                '<td><input type="text" name="DK_05[]"></td>'+
                '<td><input type="text" name="DK_06[]"></td>'+
                '<td><input type="text" name="DK_07[]"></td>'+
                '<td><input type="text" name="DK_08[]"></td>'+
                '<td><input type="text" name="TGDK_09[]" class="tanggal"></td>'+
                '<td align="center"><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
              '</tr>';
            $('#rdikum tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rdikum() {
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
            url: 'biodata/save-data.php?save=rdikum',
            data: $('#rdikum_form').serialize(),
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
<form id="rdikum_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rdikum">
    <thead>
    <tr>
      <th width="5%">No</th>
      <th width="10%">TINGKAT</th>
      <th width="20%">JURUSAN</th>
      <th width="20%">NAMA SEKOLAH</th>
      <th width="10%">TEMPAT</th>
      <th width="15%">NAMA KEPSEK/REKTOR</th>
      <th width="10%">NO. STTB</th>
      <th width="7%">TGL STTB</th>
      <th width="2%">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
<?
$r=mysql_query("select ID,DK_01,DK_02,DK_03,DK_04,DK_05,DK_06,DK_07,DK_08,DK_09 from MSTPEND1 where DK_01='$NIP' order by DK_09") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?> 
  <tr class="tr_rows">
    <td align="center"><?= $no ?></td>
    <td>
        <select name="DK_03[]">
            <option value="-">-</option>
            <option value="SD"			<? if ($row[DK_03]=="SD"		) echo "selected";?>>SD</option>
            <option value="SLTP"		<? if ($row[DK_03]=="SLTP"	        ) echo "selected";?>>SLTP</option>
            <option value="SLTA"		<? if ($row[DK_03]=="SLTA"	        ) echo "selected";?>>SLTA</option>
            <option value="D-I"			<? if ($row[DK_03]=="D-I"		) echo "selected";?>>D-I</option>
            <option value="D-II"		<? if ($row[DK_03]=="D-II"	        ) echo "selected";?>>D-II</option>
            <option value="D-III"		<? if ($row[DK_03]=="D-III"	        ) echo "selected";?>>D-III</option>
            <option value="D-IV"		<? if ($row[DK_03]=="D-IV"	        ) echo "selected";?>>D-IV</option>
            <option value="SARMUD"		<? if ($row[DK_03]=="SARMUD"		) echo "selected";?>>SARMUD</option>
            <option value="SARMUD NON AK"	<? if ($row[DK_03]=="SARMUD NON AK"  	) echo "selected";?>>SARMUD NON AK</option>
            <option value="S1"			<? if ($row[DK_03]=="S1"		) echo "selected";?>>STRATA-1</option>
            <option value="S2"			<? if ($row[DK_03]=="S2"		) echo "selected";?>>STRATA-2</option>
            <option value="S3"			<? if ($row[DK_03]=="S3"		) echo "selected";?>>STRATA-3</option>
            <option value="P"			<? if ($row[DK_03]=="P"		) echo "selected";?>>PROFESI</option>
        </select>
    </td>
    <td><input type="text" name="DK_04[]" value="<?=$row[DK_04]?>"></td>
    <td><input type="text" name="DK_05[]" value="<?=$row[DK_05]?>"></td>
    <td><input type="text" name="DK_06[]" value="<?=$row[DK_06]?>"></td>
    <td><input type="text" name="DK_07[]" value="<?=$row[DK_07]?>"></td>
    <td><input type="text" name="DK_08[]" value="<?=$row[DK_08]?>"></td>
    <td><input type="text" name="TGDK_09[]" value="<?=datefmysql($row[DK_09])?>" class="tanggal"></td>
    <td align="center"><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
<?
}
?>   
  </tbody>
  <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="9"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
        <select name="jmltambah" onchange="add_new_row_rdikum(this.value);" style="width: 100px;">
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
        <button type="button" class="btn btn-primary" onclick="save_data_rdikum(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  
  <tr>
    <td width="586" colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TINGKAT & Tanggal STTB &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>