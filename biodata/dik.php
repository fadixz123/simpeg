<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
if ($H_1A=='') { $H_1A=$row['H_1A']; }
?>
<script type="text/javascript">
    
    $(function() {
        get_jurusan('<?= $row['H_1B'] ?>');
        $('#tglijasah, #tgdikstru').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    function save_data_pendidikan() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=pendidikan',
            data: $('#dikumumakhir').serialize(),
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
    
    function save_data_pendidikan_struk_akhir() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=dikstruakhir',
            data: $('#dikstruakhir').serialize(),
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
    
    function get_jurusan(id_jurusan) {
        $.ajax({
            type: 'GET',
            url: 'biodata/load-extend.php?extend=jurusan_pendidikan',
            data: 'H_IA='+$('#pend').val()+'&id_jurusan='+id_jurusan,
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#jurusan').html(data);
            }
        });
    }
</script>
<br/>
<form name="dikumumakhir" id="dikumumakhir" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=dik&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
        <tr class="sectiontableheader"> 
            <td>G</td>
            <td colspan="3"><b>PENDIDIKAN UMUM TERAKHIR</b></td>
        </tr>
          <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Tingkat</td>
            <td>:</td>
            <td width="77%">
            <select name="H_1A" class="form-control-static" id="pend" onChange="get_jurusan();">
                <option value="">-</option>
                <option value="10" <?php if ($H_1A=='10') echo "selected"; ?>>SD</option>
                <option value="20" <?php if ($H_1A=='20') echo "selected"; ?>>SLTP</option>
                <option value="30" <?php if ($H_1A=='30') echo "selected"; ?>>SLTA</option>
                <option value="41" <?php if ($H_1A=='41') echo "selected"; ?>>DIPLOMA I</option>
                <option value="42" <?php if ($H_1A=='42') echo "selected"; ?>>DIPLOMA II</option>
                <option value="43" <?php if ($H_1A=='43') echo "selected"; ?>>DIPLOMA III</option>
                <option value="44" <?php if ($H_1A=='44') echo "selected"; ?>>DIPLOMA IV</option>
                <option value="50" <?php if ($H_1A=='50') echo "selected"; ?>>SARMUD NON AKADEMI</option>
                <option value="60" <?php if ($H_1A=='60') echo "selected"; ?>>SARMUD AKADEMI</option>
                <option value="70" <?php if ($H_1A=='70') echo "selected"; ?>>STRATA 1 (S1)</option>
	          <option value="80" <?php if ($H_1A=='80') echo "selected"; ?>>STRATA 2 (S2)</option>
                <option value="90" <?php if ($H_1A=='90') echo "selected"; ?>>STRATA 3 (S3)</option>
                <option value="99" <?php if ($H_1A=='99') echo "selected"; ?>>PROFESI </option>
              </select> </td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Jurusan</td>
            <td> :</td>
            <td width="77%" id="jurusan"></td>
          </tr>
          <tr> 
            <td width="3%"> 03</td>
            <td width="20%">Nama Sekolah</td>
            <td>:</td>
            <td width="77%"> 
            <input name="H_SEKOLAH" class="form-control-static" type="text" size="40" maxlength="40" value="<?=$row[H_SEKOLAH]; ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="3%"> 04</td>
            <td width="20%">Tempat</td>
            <td>:</td>
            <td width="77%"> 
            <input name="H_TEMPAT" type="text" class="form-control-static" size="40" maxlength="40" value="<?=$row[H_TEMPAT]; ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="3%"> 05</td>
            <td width="20%">Kasek/Rektor/Dir</td>
            <td>:</td>
            <td width="77%"> 
            <input name="H_KASEK" type="text" class="form-control-static" size="50" maxlength="100" value="<?=$row[H_KASEK]; ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="3%"> 06</td>
            <td width="20%">No. Ijazah</td>
            <td>:</td>
            <td width="77%"> 
            <input name="H_IJAZAH" type="text" class="form-control-static" size="40" maxlength="40" value="<?=$row[H_IJAZAH]; ?>"> 
            </td>
          </tr>
          <tr> 
            <td width="3%"> 07</td>
            <td width="20%">Tanggal Ijazah</td>
            <td>:</td>
            <td width="77%"> 
            <input name="tg_H_TGL_IJAZAH" id="tglijasah" class="form-control-static" type="text" value="<?=datefmysql($row[H_TGL_IJAZAH]) ?>">
            </td>
          </tr>
          <tr> 
            <td width="3%"></td>
            <td width="20%">&nbsp;</td>
            <td></td>
            <td width="77%"> 
            <button class="btn btn-primary" onclick="save_data_pendidikan(); return false;"><i class="fa fa-save"></i> Simpan Pend. Umum Akhir</button>
            <button class="btn btn-primary" onclick="save_tambah_pendidikan(); return false;"><i class="fa fa-save"></i> Tambah Pendidikan</button>
          </tr>
    </table>
</form>

<form name="dikstruakhir" id="dikstruakhir" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=dik&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader"> 
            <td width="3%">H</td>
            <td colspan="3" width="767" height="22"><b> 
              DIKLAT STRUKTURAL TERAKHIR</b></td>
          </tr>
          <?
          $TGDIKSTRU=datefmysql($row[H_4B]);
          ?>
          <tr bgcolor="<? echo $warnarow1; ?>" valign="top"> </tr>
          <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Tingkat</td>
            <td>:</td>
            <td width="77%"> 
            <select name="H_4A" class="form-control-static">
                <option value="">-</option>
                <option value="1" <? if ($row['H_4A']=='1') echo "selected"; ?>>LEMHANAS</option>
                <option value="2" <? if ($row['H_4A']=='2') echo "selected"; ?>>SESPA/SEPAMEN</option>
                <option value="3" <? if ($row['H_4A']=='3') echo "selected"; ?>>SEPADYA/SEPAMA</option>
                <option value="4" <? if ($row['H_4A']=='4') echo "selected"; ?>>SEPALA/ADUMLA</option>
                <option value="5" <? if ($row['H_4A']=='5') echo "selected"; ?>>SEPADA/ADUM</option>
                <option value="6" <? if ($row['H_4A']=='6') echo "selected"; ?>>DIKLATPIM Tk.I</option>
                <option value="7" <? if ($row['H_4A']=='7') echo "selected"; ?>>DIKLATPIM Tk.II</option>
                <option value="10" <? if ($row['H_4A']=='10') echo "selected"; ?>>DIKLATPIM PEMDA</option>
                <option value="8" <? if ($row['H_4A']=='8') echo "selected"; ?>>DIKLATPIM Tk.III</option>
                <option value="9" <? if ($row['H_4A']=='9') echo "selected"; ?>>DIKLATPIM Tk.IV</option>
              </select> </td>
          </tr>
          <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tanggal Selesai</td>
            <td>:</td>
            <td width="77%"><input name="TGDIKSTRU" id="tgdikstru" class="form-control-static" value="<?= $TGDIKSTRU; ?>"></td>
          </tr>
          <tr> 
            <td width="3%"></td>
            <td width="20%">&nbsp;</td>
            <td> <div align="center"><b></b></div></td>
            <td width="77%"> 
            <button class="btn btn-primary" onclick="save_data_pendidikan_struk_akhir(); return false;"><i class="fa fa-save"></i> Simpan Pend. Stru. Akhir</button>
          </tr>
      </table> 
    </form>
