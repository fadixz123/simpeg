<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTTGAS1 where TG_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());
	
if ($simpanrln)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgtg07=$THTG_07[$i]."-".$BLTG_07[$i]."-".$TGTG_07[$i];
		$xtgtg08=$THTG_08[$i]."-".$BLTG_08[$i]."-".$TGTG_08[$i];
		$xtgtg09=$THTG_09[$i]."-".$BLTG_09[$i]."-".$TGTG_09[$i];
		$TG03=strtoupper($TG_03[$i]);
		$TG04=strtoupper($TG_04[$i]);
		$TG05=strtoupper($TG_05[$i]);
		$a[$i]=$xtgtg09;
		if ($upd[$i]=='1')
		{
			$q  ="insert into MSTTGAS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="TG_01='$NIP',TG_02='$i',TG_03='$TG03',TG_04='$TG04',TG_05='$TG05', ";
			$q .="TG_06='$TG_06[$i]',TG_07='$xtgtg07',TG_08='$xtgtg08',TG_09='$xtgtg09'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTTGAS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="TG_01='$NIP',TG_02='$i',TG_03='$TG03',TG_04='$TG04',TG_05='$TG05', ";
			$q .="TG_06='$TG_06[$i]',TG_07='$xtgtg07',TG_08='$xtgtg08',TG_09='$xtgtg09' ";
			$q .="where TG_01='$NIP' and ID='$IDORG[$i]'";
/*			$q .="TG_02='$TG_02ORG[$i]' and ";
			$q .="TG_03='$TG_03ORG[$i]' and ";
			$q .="TG_04='$TG_04ORG[$i]' and ";
			$q .="TG_05='$TG_05ORG[$i]' and ";
			$q .="TG_06='$TG_06ORG[$i]' and ";
			$q .="TG_07='$TG_07ORG[$i]' and ";
			$q .="TG_08='$TG_08ORG[$i]' and ";
			$q .="TG_09='$TG_09ORG[$i]' ";*/
			
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TUGAS KE LN",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgtg09=$THTG_09[$i]."-".$BLTG_09[$i]."-".$TGTG_09[$i];
		$q="update MSTTGAS1 set TG_02='$i' where TG_01='$NIP' and TG_09='$a[$z]'";
		
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
    
    function add_new_row_rtluarnegeri(val) {
        for (i = 1; i <= val; i++) {
            var str = '<tr class="tr_rows '+((i%2===0)?'odd':'even')+'">'+
                '<td align="center">'+(i)+' <input type="hidden" name="ID[]" /></td>'+
                '<td><input type="text" name="TG_03[]" size="40" /></td>'+
                '<td><input type="text" name="TG_04[]" size="30" /></td>'+
                '<td><input type="text" name="TG_05[]" size="30" /></td>'+
                '<td><input type="text" size="20" name="TG_06[]" /></td>'+
                '<td><input type="text" name="TGTG_07[]" class="tanggal"></td>'+
                '<td><input type="text" name="TGTG_08[]" class="tanggal"></td>'+
                '<td><input type="text" name="TGTG_09[]" class="tanggal"></td>'+
                '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
            '</tr>';
            $('#rtluarnegeri tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    function save_data_rtluarnegeri() {
        
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
            url: 'biodata/save-data.php?save=rtluarnegeri',
            data: $('#rtluarnegeri_form').serialize(),
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
<form name="rlnform" id="rtluarnegeri_form" method="post">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rtluarnegeri">
<!--  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="3%" align="center"><b>L</b></td>
    <td colspan="4"><b>RIWAYAT PENUGASAN KE LUAR NEGERI</b></td>
  </tr>-->
    <thead>
    <tr>
        <th>No</th>
        <th>NEGARA TUJUAN</th>
        <th>JENIS PENUGASAN</th>
        <th>PEJABAT YANG MENETAPKAN</th>
        <th>NOMOR SK</th>
        <th>TANGGAL SK</th>
        <th>TANGGAL MULAI</th>
        <th>TANGGAL SELESAI</th>
        <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
<?php
$r=mysql_query("select ID,TG_01,TG_02,TG_03,TG_04,TG_05,TG_06,TG_07,TG_08,TG_09 from MSTTGAS1 where TG_01='$NIP' order by TG_02") or die (mysql_error());
$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>  
    <tr class="tr_rows">
        <td align="center"><?= $no ?> <input type="hidden" name="ID[]" value="<?= $row['ID'] ?>" /></td>
        <td><input type="text" name="TG_03[]" size="40" value="<?=$row['TG_03']?>" /></td>
        <td><input type="text" name="TG_04[]" size="30" value="<?=$row['TG_04']?>" /></td>
        <td><input type="text" name="TG_05[]" size="30" value="<?=$row['TG_05']?>" /></td>
        <td><input type="text" size="20" name="TG_06[]" value="<?=$row['TG_06']?>" /></td>
        <td><input type="text" name="TGTG_07[]" value="<?=datefmysql($row['TG_07'])?>" class="tanggal"></td>
        <td><input type="text" name="TGTG_08[]" value="<?=datefmysql($row['TG_08'])?>" class="tanggal"></td>
        <td><input type="text" name="TGTG_09[]" value="<?=datefmysql($row['TG_09'])?>" class="tanggal"></td>
        <td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
    </tr>
<?
} ?>
</tbody>
<tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="5">Jumlah Riwayat yang Akan Ditambahkan :&nbsp;
        <select name="jmltambah" id="tambah" onchange="add_new_row_rtluarnegeri(this.value);" style="width: 100px;">
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
        <button type="button" class="btn btn-primary" onclick="save_data_rtluarnegeri(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td colspan="5"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan Tanggal Selesai Tugas&nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>