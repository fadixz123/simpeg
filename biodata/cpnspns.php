<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
?>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(function() {
        $('#tgskcapeg, #tgtmtskcapeg, #tgskpns, #tgtmtpns').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    function save_data_pns() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=pns',
            data: $('#pnsform').serialize(),
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
        return false;
    }
    
    function save_data_cpns() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=cpns',
            data: $('#cpnsform').serialize(),
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
        return false;
    }
</script>
<br/>
<form id="cpnsform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=cpnspns&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$row[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$row[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$row[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$row[A_04]?>">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
<table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader"> 
            <td width="3%"> 
              <div align="center"><b>B</b></div>
            </td>
            <td colspan="3" height="22"><b>PENGANGKATAN SEBAGAI CPNS</b></td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%"> 01</td>
            <td width="20%" bgcolor="<? echo $warnarow; ?>">TGL SK CPNS</td>
            <td>:</td>
            <td width="77%"> 
                <input type="text" name="TGSKCAPEG" id="tgskcapeg" class="form-control-static" value="<?= datefmysql($row["D_03"]) ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%">02</td>
            <td width="20%">Nomor SK</td>
            <td align="center"><b>:</b></td>
            <td width="77%">  
              <input type="text" name="D_02" size="40" class="form-control-static" value="<? echo $row["D_02"]; ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>">
            <td width="3%">03</td>
            <td width="20%">TMT CPNS</td>
            <td align="center"><b>:</b></td>
            <td width="77%">  
              <input type="text" name="TGTMTCAPEG" id="tgtmtskcapeg" class="form-control-static" value="<?= datefmysql($row["D_04"]); ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%"> 04</td>
            <td width="20%">Golongan / Ruang</td>
            <td>:</td>
            <td width="77%">  
              <? $D_05=$row["D_05"]; ?>
              <select name="D_05" class="form-control-static" onchange="mypkt(this,'cpns')" style="width: 20%;">
                <option value="">-</option>
                <option value="11" <? if ($D_05=="11") echo "selected"; ?>>I/a</option>
                <option value="12" <? if ($D_05=="12") echo "selected"; ?>>I/b</option>
                <option value="13" <? if ($D_05=="13") echo "selected"; ?>>I/c</option>
                <option value="14" <? if ($D_05=="14") echo "selected"; ?>>I/d</option>
                <option value="21" <? if ($D_05=="21") echo "selected"; ?>>II/a</option>
                <option value="22" <? if ($D_05=="22") echo "selected"; ?>>II/b</option>
                <option value="23" <? if ($D_05=="23") echo "selected"; ?>>II/c</option>
                <option value="24" <? if ($D_05=="24") echo "selected"; ?>>II/d</option>
                <option value="31" <? if ($D_05=="31") echo "selected"; ?>>III/a</option>
                <option value="32" <? if ($D_05=="32") echo "selected"; ?>>III/b</option>
                <option value="33" <? if ($D_05=="33") echo "selected"; ?>>III/c</option>
                <option value="34" <? if ($D_05=="34") echo "selected"; ?>>III/d</option>
                <option value="41" <? if ($D_05=="41") echo "selected"; ?>>IV/a</option>
                <option value="42" <? if ($D_05=="42") echo "selected"; ?>>IV/b</option>
                <option value="43" <? if ($D_05=="43") echo "selected"; ?>>IV/c</option>
                <option value="44" <? if ($D_05=="44") echo "selected"; ?>>IV/d</option>
                <option value="45" <? if ($D_05=="45") echo "selected"; ?>>IV/e</option>
              </select>
               
              <input type="text" name="pktcpns" class="form-control-static" value="<? echo namapkt($row["D_05"]); ?>" size="28" style="width: 79%;">
            </td>
          </tr>
          <tr> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td> 
                <button class="tombol2 btn btn-primary" onclick="save_data_cpns(); return false;"><i class='fa fa-save'></i> Simpan CPNS</button>
            </td>
          </tr>
      </table>
</form>
      <br>
<?php // ---------------------------------------- PNS ---------------------------------- ?>      
<form id="pnsform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=cpnspns&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="A_01" value="<?=$row[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$row[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$row[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$row[A_04]?>">
    <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader"> 
            <td width="3%"> 
              <div align="center"><b>C</b></div>
            </td>
            <td colspan="3" height="22"><b>PENGANGKATAN 
              SEBAGAI PNS</b></td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%">01</td>
            <td width="149">No SK</td>
            <td><b>:</b></td>
            <td width="77%">  
              <input type="text" name="E_02" size="40" class="form-control-static" value="<? echo $row["E_02"]; ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%"> 02</td>
            <td width="149">TGL SK PNS</td>
            <td>:</td>
            <td width="77%">  
              <input type="text" name="TGSKPNS" id="tgskpns" class="form-control-static" value="<? echo datefmysql($row["E_03"]); ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%"> 03</td>
            <td width="149">Golongan / Ruang</td>
            <td>:</td>
            <td width="77%"> 
              <? $E_05=$row["E_05"]; ?>
              <select name="E_05" class="form-control-static" onchange="mypkt(this,'pns');document.pns.TGTMTPNS.focus()" style="width: 20%;">
                <option value="">-</option>
                <option value="11" <? if ($E_05=="11") echo "selected"; ?>>I/a</option>
                <option value="12" <? if ($E_05=="12") echo "selected"; ?>>I/b</option>
                <option value="13" <? if ($E_05=="13") echo "selected"; ?>>I/c</option>
                <option value="14" <? if ($E_05=="14") echo "selected"; ?>>I/d</option>
                <option value="21" <? if ($E_05=="21") echo "selected"; ?>>II/a</option>
                <option value="22" <? if ($E_05=="22") echo "selected"; ?>>II/b</option>
                <option value="23" <? if ($E_05=="23") echo "selected"; ?>>II/c</option>
                <option value="24" <? if ($E_05=="24") echo "selected"; ?>>II/d</option>
                <option value="31" <? if ($E_05=="31") echo "selected"; ?>>III/a</option>
                <option value="32" <? if ($E_05=="32") echo "selected"; ?>>III/b</option>
                <option value="33" <? if ($E_05=="33") echo "selected"; ?>>III/c</option>
                <option value="34" <? if ($E_05=="34") echo "selected"; ?>>III/d</option>
                <option value="41" <? if ($E_05=="41") echo "selected"; ?>>IV/a</option>
                <option value="42" <? if ($E_05=="42") echo "selected"; ?>>IV/b</option>
                <option value="43" <? if ($E_05=="43") echo "selected"; ?>>IV/c</option>
                <option value="44" <? if ($E_05=="44") echo "selected"; ?>>IV/d</option>
                <option value="45" <? if ($E_05=="45") echo "selected"; ?>>IV/e</option>
              </select>
               
              <input type="text" name="pktpns" class="form-control-static" value="<? echo namapkt($row["E_05"]); ?>" size="28" style="width: 79%;">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%">04</td>
            <td width="20%">TMT PNS</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="TGTMTPNS" id="tgtmtpns" class="form-control-static" value="<? echo datefmysql($row["E_04"]); ?>">
            </td>
          </tr>
          <tr bgcolor="<? echo $warnarow; ?>"> 
            <td width="3%"> 05</td>
            <td width="149">Sumpah / Janji</td>
            <td>:</td>
            <td width="77%"> 
              <? $E_06=$row["E_06"]; ?>
              <select name="E_06" id="E_06" class="form-control-static">
                <option value="">-</option>
                <option value="1" <? if ($E_06=="1") echo "selected"; ?>>SUDAH</option>
                <option value="2" <? if ($E_06=="2") echo "selected"; ?>>BELUM</option>
              </select>
            </td>
          </tr>
          <tr> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="77%"> 
              <button class="tombol2 btn btn-primary" onclick="save_data_pns(); return false;"><i class='fa fa-save'></i> Simpan PNS</button>
            </td>
          </tr>
      </table>
</form>