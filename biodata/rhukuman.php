<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MSTPTAR1 where LT_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());


if ($simpantatar && $no > 0)
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
			$q  ="insert into MSTPTAR1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";
			
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MSTPTAR1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
			$q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
			$q .="LT_10='$LT_10[$i]', LT_11='$xtglt11' ";
			$q .="where ID='$IDORG[$i]' and LT_01='$NIP'";// and ";
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
	//echo $q."<br>";
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT PENATARAN",$NIP);
	sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$q="update MSTPTAR1 set LT_02='$i' where LT_01='$NIP' and LT_08='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}
}

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
    
    function add_new_row_rkursus(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows">'+
                '<td align="center">'+(i+jml)+'</td>'+
                '<td><select name="jns_hukuman[]" id="jns_hukuman'+i+'"><option value="">Pilih ...</option><?php foreach ($rows as $value) { ?><option value="<?= $value['id'] ?>"><?= $value['nama'] ?></option> <?php } ?></select></td>'+
                '<td><select name="bobot[]" id="bobot'+i+'"><option value="">Pilih ...</option><option value="Ringan">Ringan</option><option value="Sedang">Sedang</option><option value="Berat">Berat</option></select></td>'+
                '<td><input type="text" name="tgl_sk[]" id="tgl_sk'+i+'" class="tanggal" /></td>'+
                '<td><input type="text" name="tmt_sk[]" id="tmt_sk'+i+'" class="tanggal" /></td>'+
                '<td><input type="text" name="masa_berlaku[]" id="masa_berlaku'+i+'"></td>'+
                '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
              '</tr>';
            $('#rkursus tbody').append(str);
            $('.tanggal').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rkursus() {
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
            url: 'biodata/save-data.php?save=rhukuman',
            data: $('#rkursus_form').serialize(),
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
<form id="rkursus_form" method="post">
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rkursus">
    <thead>
        <tr>
            <th width="3%">No</th>
            <th width="15%">JENIS HUKUMAN</th>
            <th width="10%">BOBOT</th>
            <th width="7%">TGL SK</th>
            <th width="7%">TMT SK</th>
            <th width="10%">MS BERLAKU</th>
            <th width="2%"></th>
        </tr>
    </thead>
    <tbody>
<?php
$r=mysql_query("select * from tb_riwayat_hukuman where nip='$NIP' order by id") or die (mysql_error());

$no=0;
while ($row=mysql_fetch_array($r))
{
  	$no++;
  	?>   
  <tr class="tr_rows">
    <td align="center"><?=$no?></b></td>
    <td><select name="jns_hukuman[]" id="jns_hukuman<?= $no ?>"><option value="">Pilih ...</option><?php foreach ($rows as $value) { ?><option value="<?= $value['id'] ?>" <?= ($row['id_jenis_hukuman'] === $value['id'])?'selected':'' ?>><?= $value['nama'] ?></option> <?php } ?></select></td>
    <td><select name="bobot[]" id="bobot<?= $no ?>">
            <option value="">Pilih ...</option>
            <option value="Ringan" <?= ($row['bobot'] === 'Ringan')?'selected':'' ?>>Ringan</option>
            <option value="Sedang" <?= ($row['bobot'] === 'Sedang')?'selected':'' ?>>Sedang</option>
            <option value="Berat" <?= ($row['bobot'] === 'Berat')?'selected':'' ?>>Berat</option>
        </select></td>
        <td><input type="text" name="tgl_sk[]" value="<?= datefmysql($row['tanggal_sk']) ?>" id="tgl_sk<?= $no ?>" class="tanggal" /></td>
        <td><input type="text" name="tmt_sk[]" value="<?= datefmysql($row['tmt_sk']) ?>" id="tmt_sk<?= $no ?>" class="tanggal" /></td>
        <td><input type="text" name="masa_berlaku[]" value="<?= $row['masa_berlaku'] ?>" id="masa_berlaku<?= $no ?>"></td>
    <td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>
  </tr>
  
<?
}
?>   
  </tbody>
  <tfoot>
  <tr bgcolor="<? echo $warnarow2; ?>">
    <td width="586" colspan="11"><b>Jumlah Riwayat yang Akan Ditambahkan :</b>&nbsp;
        <select name="jmltambah" onchange="add_new_row_rkursus(this.value);" style="width: 100px;">
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
        <button type="button" class="btn btn-primary" onclick="save_data_rkursus(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  <tr>
    <td colspan="11"><b>Perhatian : </b>Data Akan Diurutkan otomatis berdasarkan TANGGAL SELSAI &nbsp;
    </td>
  </tr>
  </tfoot>
</table>
</form>