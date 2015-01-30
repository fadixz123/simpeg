<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$NIP = $_GET['nip'];
?>
<script type="text/javascript">
    $(function() {
        $('#tgkf_05, #tgkf_06').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
        $('#nomorinduk').select2({
            ajax: {
                url: 'include/autocomplete.php?search=pegawai_pasangan',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        pasangan: $('#ini').val()
                    };
                },
                results: function (data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available

                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.data, more: more};
                }
            },
            formatResult: function(data){
                var markup = data.list;
                return markup;
            }, 
            formatSelection: function(data){
                return data.list;
            }
        });
    });
    
    function save_data_keluarga() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=keluarga',
            data: $('#rsuamiistri').serialize(),
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
<?php
    $q="select B_06 from MASTFIP08 where B_02='$NIP'";
    $r=mysql_query($q);
    $o=mysql_fetch_array($r);
    $jk=$o['B_06'];
    
    if ($jk=='1') { $ini="DATA ISTRI"; } elseif ($jk=='2') { $ini='DATA SUAMI'; } else { $ini="DATA ISTRI/SUAMI"; }
    if ($ini === 'DATA ISTRI') {
        $q="select m.*, f.B_03 from MASTKEL1 m left join mastfip08 f on (f.B_02B=m.`NIP_COUPLE`) where m.KF_01='$NIP' and m.KF_02='1' AND m.KF_03='1'";
    } else {
        $q="select m.*, f.B_03 from MASTKEL1 m left join mastfip08 f on (f.B_02B=m.`NIP_COUPLE`) where m.KF_01='$NIP' and m.KF_02='1' AND m.KF_03='1'";
    }
    //echo $q;
    $r=mysql_query($q);
    $o=mysql_fetch_array($r);
?>
<form name="rsuamiistri" id="rsuamiistri" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=smistri&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader">
            <input type="hidden" name="ini" id="ini" value="<? echo $ini; ?>">
            <td width="3%"> 
              <div align="center"><b>V </b></div>
            </td>
            <td colspan="3"><b><? echo $ini; ?>
              </b></td>
          </tr>
          <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nama </td>
            <td>:</td>
            <td width="77%"> 
                <input type="text" name="KF_04" class="select2-input" id="nomorinduk" value="<?= $o['NIP_COUPLE'] ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tempat/Tgl Lahir</td>
            <td>:</td>
            <td width="77%"> 
                <input type="text" name="KF_09" size="40" class="form-control-static" value="<? echo $o["KF_09"]; ?>" style="width: 30%;">
              <span class="form-control-label">/ </span>
              <input type="text" name="TGKF_05" id="tgkf_05" class="form-control-static" value="<? echo datefmysql($o["KF_05"]); ?>" style="width: 10%;" />
            </td>
          </tr>
		  <tr> 
            <td width="3%"> 03</td>
            <td width="20%">Nomer Akta Nikah </td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="an" size="40" class="form-control-static" value="<? echo $o["an"]; ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"> 04</td>
            
      <td width="20%">Tanggal Menikah </td>
            <td> 
              <div align="center">:</div>
            </td>
            <td width="77%"> 
            	<input type="text" name="TGKF_06" id="tgkf_06" class="form-control-static" value="<? echo datefmysql($o["KF_06"]); ?>">
            
              
            </td>
          </tr>
          <tr> 
            <td width="3%"> 05</td>
            
      <td width="20%">Tunjangan </td>
            <td> 
              <div align="center">:</div>
            </td>
            <td width="77%"> 
              <select name="KF_07" class="form-control-static">
        <option value="D" <? if ($o["KF_07"]=='D') echo "selected"; ?>>DAPAT</option>
        <option value="T" <? if ($o["KF_07"]=='T') echo "selected"; ?>>TIDAK</option>
      </select>
            </td>
          </tr>
          <tr bgcolor=""> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="9">&nbsp;</td>
            <td width="77%">
                <button class="btn btn-primary" onclick="save_data_keluarga(); return false;"><i class="fa fa-save"></i> Simpan Data Istri</button>
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow1; ?>" valign="top"> 
            <td colspan="4">&nbsp; </td>
          </tr>        
    </table>
</form>
<script type="text/javascript">
    $('#s2id_nomorinduk a .select2-chosen').html('<?= $o['NIP_COUPLE'].' '.(($o['B_03'] !== '')?'|':'').' '.$o['B_03'] ?>');
</script>
