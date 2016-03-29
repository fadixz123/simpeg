<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
$q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
$I_06=$row[I_06];
?>
<script type="text/javascript">
    $(function() {
        $('#inolnam').val('<?= $row['I_06'] ?>');
        $('.autohide').show();
        $('.autoshow').hide();
        $('#tgtmtjab, #tgskjab').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function gantijab() {
        //$('.autohide').hide();
        $('.autoshow').show();
        var str = '<select name="pilihjab" id="pilihjab" class="form-control-static autoshow" onchange="get_jabatan_group();" style="width: 300px;">'+
                        '<option value="">Pilih ...</option>'+
                        '<option value="1">STRUKTURAL</option>'+
                        '<option value="2">JFK</option>'+
                        '<option value="3">JFU</option>'+
                '</select>'+
                '<input type="hidden" name="pilihjab" value="0">'+
                '<button type="button" class="btn btn-xs" onclick="batal_submit();"><i class="fa fa-times-circle"></i> Batal</button>';
        $('#load-extend').html(str);
    }
    
    function save_jabatan_terakhir() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=jabatan',
            data: $('#jabatan').serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.status === true) {
                    message_edit_success();
                    search_data_pns(1);
                }
            }
        });
    }
    function batal_submit() {
        $('.autohide').show();
        $('.autoshow').hide();
    }
    
    function get_jabatan_group() {
        //var nilai = $('#pilihjab').val();
        $.ajax({
            type: 'GET',
            url: 'biodata/load-extend.php',
            data: 'pilihjab='+$('#pilihjab').val()+'&nip=<?= $NIP ?>',
            success: function(data) {
                $('#load-extend-child').html(data);
            }
        });
        
        //if ($('#pilihjab').val() === '1') {
            $.ajax({
                type: 'GET',
                url: 'biodata/load-extend.php',
                data: 'geteselon=yes&nip=<?= $NIP ?>',
                dataType: 'json',
                success: function(data) {
                    //alert(data.I_06);
                    $('#inolnam').val(data.I_06);
                }
            });
        //}
    }
    
    function load_jab_fungsional_khusus() {
        $.ajax({
            type: 'GET',
            url: 'biodata/load-extend.php',
            data: 'I_05='+$('#I_05').val()+'&khusus=detail',
            success: function(data) {
                $('#load-extend-child2').html(data);
            }
        });
    }
    
    function validate_jenjang(id) {
        if (id === '04') {
            var str = '<div class="checkbox"><label><input type="checkbox" name="is_kepala_sekolah" value="Ya" /> Kepala Sekolah</label></div>';
            $('#load-extend-child3').html(str);
        } else {
            $('#load-extend-child3').html('&nbsp;');
        }
    }
    
</script>
<br/>
<?php 
if ($row['I_05'] !== '00018') {
  $qjenjang="select * from TABJENJANG where KJENJANG = '".$row['I_07']."'";
} else {
  $qjenjang="select * from TABJENJANG_GURU where KJENJANG = '".$row['I_07']."'";
}
$nama_jenjang = mysql_fetch_array(mysql_query($qjenjang));

?>

<form name="jabatan" id="jabatan" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=jab&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="jabnya" value="<?=$jabnya?>">
    <input type="hidden" name="A_01" value="<?=$row[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$row[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$row[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$row[A_04]?>">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
        <tr class="sectiontableheader"> 
            <td width="3%"><b>F</b></td>
            <td colspan="4" height="22"><b>JABATAN STRUKTURAL / FUNGSIONAL / FUNGSIONAL UMUM (JFU)</b></td>
        </tr>
        <tr>
            <td width="3%"> 01</td>
            <td width="20%">Jabatan Terakhir</td>
            <td>:</td>
            <td width="77%"><b class="autohide"><?=$jabnya=getNaJab($NIP)?> <?= isset($nama_jenjang['JENJANG'])?$nama_jenjang['JENJANG']:NULL ?> <?= ($row['is_kepala_sekolah'] === 'Ya')?'& Kepala Sekolah':'' ?></b> <button type="button" class="btn btn-xs autohide" onclick="gantijab();"><i class="fa fa-pencil"></i> Ganti Jab</button>
            </td>
          </tr>
          <tr class="autoshow">
              <td></td>
              <td></td>
              <td></td>
              <td id="load-extend"></td>
          </tr>
          <tr class="autoshow">
              <td></td>
              <td></td>
              <td></td>
              <td><span id="load-extend-child"></span> <span id="load-extend-child2"></span> </td>
          </tr>
          <tr class="autoshow">
              <td></td>
              <td></td>
              <td></td>
              <td id="load-extend-child3"></td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Eselon</td>
            <td> :</td>
            <td width="77%">
	<?php
		if ($subjab02!="") {
		$ess="select * from TBJAB where KOJAB='$subjab02'";
		$ress=mysql_query($ess);
		$oess=mysql_fetch_array($ress);
		$I_06=$oess[esel];
		}
	?>
              <select name="I_06" id="inolnam" class="form-control-static">
                <option value="99">-</option>
                <option value="11">I.a</option>
                <option value="12">I.b</option>
                <option value="21">II.a</option>
                <option value="22">II.b</option>
                <option value="31">III.a</option>
                <option value="32">III.b</option>
                <option value="41">IV.a</option>
                <option value="42">IV.b</option>
                <option value="51">V.a</option>
                <option value="52">V.b</option>
             </select> 
              	
              </td>
          </tr>
          <?php if ($I_01=='') { $I_01=$row[I_01]; }?>
          <tr> 
            <td width="3%"> 03</td>
            <td width="20%">Ditetapkan oleh</td>
            <td> :</td>
            <td width="77%"> 
            <select name="I_01" class="form-control-static">
                <option value="">-</option>
                <?
                	$pjb="select * from TABPJB";
	              	$res=mysql_query($pjb);
	              	while ($ro=mysql_fetch_array($res))
	              	{
	              		?>
	                	<option value="<?=$ro[KODE]?>" <? if ($ro[KODE]==$I_01) echo "selected"; ?>><?=$ro[NAMA]?></option>
	                	<?
	              	}
	    	?>
              </select> </td>
          </tr>
          <? if ($I_02=='') $I_02=$row[I_02];?>
          <tr> 
            <td width="3%"> 04</td>
            <td width="20%">Nomor SK Jabatan</td>
            <td> :</td>
            <td width="77%">  
            	<input type="text" class="form-control-static" name="I_02" value="<?=$I_02?>" size="50"> 
            </td>
          </tr>
          <tr> 
            <td width="3%"> 05</td>
            <td width="20%">Tanggal SK Jabatan</td>
            <td> :</td>
            <td width="77%"> 
              <input name="TGSKJAB" class="form-control-static" id="tgskjab" value="<?=datefmysql($row['I_03']); ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 06</td>
            <td width="20%">TMT Jabatan</td>
            <td> :</td>
            <td width="77%">
              <input name="TGTMTJAB" class="form-control-static" id="tgtmtjab" value="<?=datefmysql($row['I_04']); ?>">
            </td>
          </tr>
          
          <tr> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="77%">  
                <button class="tombol2 btn btn-primary" onclick="save_jabatan_terakhir(); return false;"><i class='fa fa-save'></i> Simpan Jabatan Terakhir</button>
            </td>
          </tr>
        
      </table>
    </form>
