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
        var str = '<select name="pilihjab" id="pilihjab" class="form-control-static autoshow" onchange="get_jabatan_group();" style="width: 20%;">'+
                        '<option value="">Pilih ...</option>'+
                        '<option value="1">STRUKTURAL</option>'+
                        '<option value="2">JFK</option>'+
                        '<option value="3">JFU</option>'+
                '</select>'+
                '<input type="hidden" name="pilihjab" value="0">'+
                '<button type="button" class="btn btn-default btn-xs" onclick="batal_submit();"><i class="fa fa-minus-circle"></i> Batal</button>';
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
</script>
<br/>
<form name="jabatan" id="jabatan" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=jab&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="jabnya" value="<?=$jabnya?>">
    <input type="hidden" name="A_01" value="<?=$row[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$row[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$row[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$row[A_04]?>">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
        <tr class="sectiontableheader"> 
            <td width="3%"><b>G</b></td>
            <td colspan="4" height="22"><b>JABATAN STRUKTURAL / FUNGSIONAL / FUNGSIONAL UMUM (JFU)</b></td>
        </tr>
        <tr>
            <td width="3%"> 01</td>
            <td width="20%">Jabatan Terakhir</td>
            <td>:</td>
            <td width="77%"><b class="autohide"><?=$jabnya=getNaJab($NIP)?></b> <a class="autohide" href="#" onclick="gantijab();">Ganti Jab</a>
            </td>
          </tr>
          <tr class="autoshow">
              <td></td>
              <td></td>
              <td>:</td>
              <td id="load-extend"></td>
          </tr>
          <tr class="autoshow">
              <td></td>
              <td></td>
              <td>:</td>
              <td><span id="load-extend-child"></span> <span id="load-extend-child2"></span></td>
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
              <select name="I_06" class="form-control-static">
                <option value="99" <? if ($I_06=='99') echo "selected"; ?>>-</option>
                <option value="11" <? if ($I_06=='11') echo "selected"; ?>>I.a</option>
                <option value="12" <? if ($I_06=='12') echo "selected"; ?>>I.b</option>
                <option value="21" <? if ($I_06=='21') echo "selected"; ?>>II.a</option>
                <option value="22" <? if ($I_06=='22') echo "selected"; ?>>II.b</option>
                <option value="31" <? if ($I_06=='31') echo "selected"; ?>>III.a</option>
                <option value="32" <? if ($I_06=='32') echo "selected"; ?>>III.b</option>
                <option value="41" <? if ($I_06=='41') echo "selected"; ?>>IV.a</option>
                <option value="42" <? if ($I_06=='42') echo "selected"; ?>>IV.b</option>
                <option value="51" <? if ($I_06=='51') echo "selected"; ?>>V.a</option>
                <option value="52" <? if ($I_06=='52') echo "selected"; ?>>V.b</option>
             </select> 
              	
              </td>
          </tr>
          <? if ($I_01=='') $I_01=$row[I_01];?>
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
