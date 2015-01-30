<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$NIP = $_GET['nip'];
$q="select * from MASTFIP08 where B_02='".$NIP."' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
?>
<script type="text/javascript">
    $(function() { 
        $('#tgnm_061, #tgnm_062').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function save_data_ortu() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=ortu',
            data: $('#rorangtua').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.status === true) {
                    message_edit_success();
                }
            }
        });
    }
</script>
<br/>
<form name="rorangtua" id="rorangtua" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=ortu&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader">
            <td width="3%"> 
              <div><b>U</b></div>
            </td>
            <td colspan="3"><b> DATA ORANG TUA KANDUNG</b></td>
          </tr>
          <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nama Ayah</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" tabindex=1 name="NM_041" class="form-control-static" size="40" value="<?= ortu($NIP,'AYAH','NM_04'); ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tempat/Tgl Lahir</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" tabindex=2 name="NM_051" size="40" class="form-control-static" value="<? echo ortu($NIP,'AYAH','NM_05'); ?>" style="width: 30%">
              <span class="form-control-label">/</span> 
              <input type="text" tabindex=3 name="TGNM_061" id="tgnm_061" class="form-control-static" value="<? echo datefmysql(ortu($NIP,'AYAH','NM_06')); ?>" style="width: 10%">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 03</td>
            
      <td width="20%">Alamat</td>
            <td> 
              <div>:</div>
            </td>
            <td width="77%"> 
              <textarea name="NM_071" tabindex=6 rows="5" cols="41.5" class="form-control-static"><? echo ortu($NIP,'AYAH','NM_07'); ?></textarea>
            </td>
          </tr>
          <tr class="sectiontableheader">
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nama Ibu</td>
            <td>:</td>
            <td width="77%">
              <input type="text" tabindex=7 name="NM_042" class="form-control-static" size="40" value="<? echo ortu($NIP,'IBU','NM_04'); ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tempat/Tgl Lahir</td>
            <td>:</td>
            <td width="77%">
                <input type="text" tabindex=8 name="NM_052" size="40" class="form-control-static" value="<? echo ortu($NIP,'IBU','NM_05'); ?>" style="width: 30%" />
                <span class="form-control-label">/</span>
                <input type="text" tabindex=9 name="TGNM_062" id="tgnm_062" class="form-control-static" value="<? echo datefmysql(ortu($NIP,'IBU','NM_06')); ?>" style="width: 10%" />
            </td>
          </tr>
          <tr> 
            <td width="3%"> 03</td>
            
      <td width="20%">Alamat</td>
            <td> 
              <div>:</div>
            </td>
            <td width="77%">
              <textarea name="NM_072" tabindex=12 rows="5" cols="41.5" class="form-control-static"><? echo ortu($NIP,'IBU','NM_07'); ?></textarea>
            </td>
          </tr>
          <tr bgcolor=""> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="77%">
                <button class="btn btn-primary" onclick="save_data_ortu(); return false;"><i class="fa fa-save"></i> Simpan Data Ortu</button>
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow1; ?>"> 
            <td colspan="4">&nbsp; </td>
          </tr>
      </table>
</form>