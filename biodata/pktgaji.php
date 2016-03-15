<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
?>
<script type="text/javascript">
    function save_data_pangkat_gaji() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=pangkat_gaji',
            data: $('#pktform').serialize(),
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
    
    $(function() {
        $('#tggol, #tgpkt, #tggaji, #tglsurat, #tmt_ijin_penggunaan_gelar, #tglsurat_ijin_belajar, #tmt_ijin_belajar, #tglsurat_penyesuaian_ijasah, #tmt_penyesuaian_ijasah').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
</script>
<br/>
<form name="pktform" id="pktform" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=pkt&NIP=<?=$NIP?>" method="post">
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
        <input type="hidden" name="A_01" value="<?=$row[A_01]?>">
        <input type="hidden" name="A_02" value="<?=$row[A_02]?>">
        <input type="hidden" name="A_03" value="<?=$row[A_03]?>">
        <input type="hidden" name="A_04" value="<?=$row[A_04]?>">
        <input type="hidden" name="nip" value="<?=$_GET['nip']?>">
        
        <tr class="sectiontableheader"> 
            <td width="3%" bgcolor="<? echo $warnarow2; ?>"> <div><b>D</b></div></td>
            <td colspan="3" bgcolor="<? echo $warnarow2; ?>" height="22"><b>PANGKAT / GOLONGAN TERAKHIR</b> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Ditetapkan oleh</td>
            <td>:</td>
            <td width="77%"> <select name="F_01" class="form-control-static">
                <option value="">-</option>
                <?
              $pjb="select * from TABPJB";
              $res=mysql_query($pjb);
              while ($ro=mysql_fetch_array($res))
              {
              ?>
                <option value="<? echo $ro["KODE"]; ?>" <? if ($ro["KODE"]==$row["F_01"]) echo "selected"; ?>> 
                <? echo $ro["NAMA"]; ?> </option>
                <?
              }
              ?>
              </select> </td>
        </tr>
        <tr> 
            <td width="3%">02</td>
            <td width="20%">No SK</td>
            <td>:</td>
            <td width="77%">  <input class="form-control-static" type="text" name="F_SK" size="40" value="<? echo $row[F_SK]; ?>"> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 03</td>
            <td width="20%">TANGGAL SK</td>
            <td> :</td>
            <td width="77%">  
              <input type="text" class="form-control-static" name="TGGOL" id="tggol" value="<? echo datefmysql($row["F_02"]); ?>">
            </td>
        </tr>
        <tr> 
            <td width="3%"> 04</td>
            <td width="20%">Golongan / Ruang</td>
            <td> :</td>
            <td width="77%"> 
              <? $F_03=$row["F_03"]; ?>
              <select name="F_03" class="form-control-static" onchange="mypkt(this,'pkt')" style="width: 20%;">
                <option value="">-</option>
                <option value="11" <? if ($F_03=="11") echo "selected"; ?>>I/a</option>
                <option value="12" <? if ($F_03=="12") echo "selected"; ?>>I/b</option>
                <option value="13" <? if ($F_03=="13") echo "selected"; ?>>I/c</option>
                <option value="14" <? if ($F_03=="14") echo "selected"; ?>>I/d</option>
                <option value="21" <? if ($F_03=="21") echo "selected"; ?>>II/a</option>
                <option value="22" <? if ($F_03=="22") echo "selected"; ?>>II/b</option>
                <option value="23" <? if ($F_03=="23") echo "selected"; ?>>II/c</option>
                <option value="24" <? if ($F_03=="24") echo "selected"; ?>>II/d</option>
                <option value="31" <? if ($F_03=="31") echo "selected"; ?>>III/a</option>
                <option value="32" <? if ($F_03=="32") echo "selected"; ?>>III/b</option>
                <option value="33" <? if ($F_03=="33") echo "selected"; ?>>III/c</option>
                <option value="34" <? if ($F_03=="34") echo "selected"; ?>>III/d</option>
                <option value="41" <? if ($F_03=="41") echo "selected"; ?>>IV/a</option>
                <option value="42" <? if ($F_03=="42") echo "selected"; ?>>IV/b</option>
                <option value="43" <? if ($F_03=="43") echo "selected"; ?>>IV/c</option>
                <option value="44" <? if ($F_03=="44") echo "selected"; ?>>IV/d</option>
                <option value="45" <? if ($F_03=="45") echo "selected"; ?>>IV/e</option>
              </select>  <input type="text" class="form-control-static" name="pktpkt" value="<? echo namapkt($row["F_03"]); ?>" size="28" style="width: 79%;"> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 05</td>
            <td width="20%">TMT PANGKAT</td>
            <td> :</td>
            <td width="77%">  
              <input type="text" class="form-control-static" name="TGPKT" id="tgpkt" value="<?=datefmysql($row[F_TMT]); ?>" >
            </td>
        </tr>
        <tr> 
            <td width="3%"> 06</td>
            <td width="20%">Masa kerja</td>
            <td> :</td>
            <td width="77%"> <input type="text" class="form-control-static" name="F_04A" value="<?=substr($row["F_04"],0,2) ; ?>" size="2" maxlength="2" style="width: 20%;">
                <span class="form-control-label">TAHUN </span>
              <input type="text" name="F_04B" size="2" class="form-control-static" maxlength="2" value="<?=substr($row["F_04"],2,2) ; ?>" style="width: 20%;">
              <span class="form-control-label">BULAN</span> </td>
        </tr>
        <?
      //------------------------------------ GAJI TERAKHIR -----------------------------------
      ?>
        <tr class="sectiontableheader"> 
            <td width="3%" bgcolor="<? echo $warnarow2; ?>"> <div><b>E</b></div></td>
            <td colspan="3" bgcolor="<? echo $warnarow2; ?>" height="22"><b>KENAIKAN 
              GAJI BERKALA TERAKHIR</b></td>
        </tr>
        <tr> 
            <td width="3%"> 01</td>
            <td width="20%">TMT Gaji Berkala</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="TGGAJI" class="form-control-static" id="tggaji" value="<? echo datefmysql($row["G_01"]); ?>">
            </td>
        </tr>
        <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Masa kerja gaji</td>
            <td> :</td>
            <td width="77%">  <input type="text" name="G_02A" class="form-control-static" value="<? echo substr($row["G_02"],0,2) ; ?>" size="2" maxlength="2" style="width: 20%;">
                <span class="form-control-label">TAHUN</span> 
              <input type="text" name="G_02B" size="2" class="form-control-static" maxlength="2" value="<? echo substr($row["G_02"],2,2) ; ?>" style="width: 20%;">
                <span class="form-control-label">BULAN</span></td>
        </tr>
        <tr> 
            <td width="3%"> 03</td>
            <td width="20%">Gaji Pokok</td>
            <td> :</td>
            <td width="77%"> <input type="text" name="G_03" class="form-control-static" onkeyup="FormNum(this);" value="<? echo $row['G_03']; ?>" style="width: 20%;">
              <- gaji tidak perlu diisi </td>
        </tr>
        <tr class="sectiontableheader"> 
            <td width="3%" bgcolor="<? echo $warnarow2; ?>"> <div><b>E</b></div></td>
            <td colspan="3" bgcolor="<? echo $warnarow2; ?>" height="22"><b>IJIN PENGGUNAAN GELAR</b></td>
        </tr>
        <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nomor Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="nomorsurat" class="form-control-static" id="nomorsurat" value="<?= $row['ipg_nomor'] ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tanggal Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tglsurat" class="form-control-static" id="tglsurat" value="<?= datefmysql($row['ipg_tgl_surat']) ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 03</td>
            <td width="20%">TMT</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tmt_ijin_penggunaan_gelar" class="form-control-static" id="tmt_ijin_penggunaan_gelar" value="<?= datefmysql($row['ipg_tmt']) ?>" /> 
            </td>
        </tr>
        <tr class="sectiontableheader"> 
            <td width="3%" bgcolor="<? echo $warnarow2; ?>"> <div><b>E</b></div></td>
            <td colspan="3" bgcolor="<? echo $warnarow2; ?>" height="22"><b>IJIN BELAJAR</b></td>
        </tr>
        <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nomor Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="nomorsurat_ijin_belajar" class="form-control-static" id="nomorsurat_ijin_belajar" value="<?= $row['ib_nomor'] ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tanggal Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tglsurat_ijin_belajar" class="form-control-static" id="tglsurat_ijin_belajar" value="<?= datefmysql($row['ib_tgl_surat']) ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 03</td>
            <td width="20%">TMT</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tmt_ijin_belajar" class="form-control-static" id="tmt_ijin_belajar" value="<?= datefmysql($row['ib_tmt']) ?>" /> 
            </td>
        </tr>
        <tr class="sectiontableheader"> 
            <td width="3%" bgcolor="<? echo $warnarow2; ?>"> <div><b>E</b></div></td>
            <td colspan="3" bgcolor="<? echo $warnarow2; ?>" height="22"><b>PENYESUAIAN IJASAH</b></td>
        </tr>
        <tr> 
            <td width="3%"> 01</td>
            <td width="20%">Nomor Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="nomorsurat_penyesuaian_ijasah" class="form-control-static" id="nomorsurat_penyesuaian_ijasah" value="<?= $row['pi_nomor'] ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 02</td>
            <td width="20%">Tanggal Surat</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tglsurat_penyesuaian_ijasah" class="form-control-static" id="tglsurat_penyesuaian_ijasah" value="<?= datefmysql($row['pi_tgl_surat']) ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%"> 03</td>
            <td width="20%">TMT</td>
            <td> :</td>
            <td width="77%"> 
                <input type="text" name="tmt_penyesuaian_ijasah" class="form-control-static" id="tmt_penyesuaian_ijasah" value="<?= datefmysql($row['pi_tmt']) ?>" /> 
            </td>
        </tr>
        <tr> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="77%">  
                <button class="tombol2 btn btn-primary" onclick="save_data_pangkat_gaji(); return false;"><i class='fa fa-save'></i> Simpan Pangkat & Gaji</button>
            </td>
        </tr>
    </table>
</form>
