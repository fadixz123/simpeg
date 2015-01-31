<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);


$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' LIMIT 1";
//echo $q;
$rows=mysql_fetch_array(mysql_query($q));
if ($rows[A_01] !='') $buker=$rows[A_01];
if ($rows[A_03] !='' && $rows[A_04] !='' && $rows[A_02] !='' ) {
        $lker=$rows[A_01].$rows[A_02].$rows[A_03];
        $loker=$rows[A_01].$rows[A_02].$rows[A_03].$rows[A_04].$rows[A_05];
}

?>
<script type="text/javascript">
    $(function() {
        $('#tgllahir').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function save_data_pegawai() {
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=pegawai',
            data: $('#form-pegawai').serialize(),
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
            }
        });
    }
    
    function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp=false;	
        try{
                xmlhttp=new XMLHttpRequest();
        }
        catch(e)	{		
                try{			
                        xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch(e){
                        try{
                        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                        }
                        catch(e1){
                                xmlhttp=false;
                        }
                }
        }

        return xmlhttp;
    }

    function getContent(thediv,strURL) {         
        var req = getXMLHTTP(); // fuction to get xmlhttp object
        if (req) {
                req.onreadystatechange = function()	{
                        if (req.readyState == 4) { //data is retrieved from server
                                if (req.status == 200) { // which reprents ok status                    
                                        document.getElementById(thediv).innerHTML=req.responseText;
                                } else { 
                                        alert("There was a problem while using XMLHTTP:\n");
                                }
                        }            
                }        
                req.open("GET", strURL, true); //open url using get method
                req.send(null);
        }
    }

    function getSubUK(uk) {
        document.getElementById('subukdiv').innerHTML="<img src='biodata/images/ajax-loader.gif'>";
        getContent('subukdiv','biodata/subuk.php?uk='+uk);
        getContent('subsubukdiv','biodata/subuk.php?uk=');
    }

    function getSubSubUK(uk) {
        document.getElementById('subsubukdiv').innerHTML="<img src='biodata/images/ajax-loader.gif'>";
        getContent('subsubukdiv','biodata/subsubuk.php?uk='+uk);
    }
    
</script>
<br/>
<form name="lokasi" id="form-pegawai" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=lokid&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="sid" id="sid" value="<?= $_GET['sid'] ?>" />
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader"> 
            <td class="sectiontableheader">LOKASI KERJA</td>
            <td>:</td>
            <td align="left" height="22">&nbsp;</td>
          </tr>
          <tr>
            <td width="23%">Unit Kerja</td>
            <?php
            $quker="select kd,nm from TABLOK08 order by kd";
            $ruker=mysql_query($quker) or die(mysql_error());
            ?>
	    <td>:</td>
            <td width="77%">
              <select name="buker" class="pilihan2 form-control" onChange="getSubUK(this.value)">
                <option value="">-</option>
                <?php while($ouker=mysql_fetch_array($ruker)) { ?>
				<option value="<?= substr($ouker[kd],0,2) ?>" <?= (substr($ouker[kd],0,2)==$buker) ? "selected" : ""?>><?= $ouker["nm"]; ?></option>
                <?php } ?>
              </select> </td>
          </tr>
          <tr>
            <td>Sub Unit Kerja</td>
            <?php
            $qlker="select substring(KOLOK,1,6) as KODELOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='$buker' and KOLOK like '%0000' order by KOLOK";
            $rlker=mysql_query($qlker);
            ?>
			<td>:</td>
            <td>
			<div id="subukdiv">
              <select name="lker" class="form-control" onChange="getSubSubUK(this.value)">
                <option value="">-</option>
                <? while($olker=mysql_fetch_array($rlker)) { ?>
                <option value="<?=$olker[KODELOK]?>" <?=$olker[KODELOK]==$lker ? "selected" : ""?>><?= $olker[NALOK]?></option>
                <? } ?>
              </select>
			</div>
            </td>
          </tr>
          <tr>
            <td>Sub-sub Unit Kerja</td>
            <?php
            $qloker="select KOLOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='$buker' order by KOLOK";
            $rloker=mysql_query($qloker);
            ?>
			<td>:</td>
            <td>
			<div id="subsubukdiv">
              <select name="loker" id="loker" class="form-control">
                <option value="">-</option>
                <?php while($oloker=mysql_fetch_array($rloker)) { ?>
                <option value="<?=$oloker[KOLOK]?>" <?=$oloker[KOLOK]==$loker ? "selected" : ""?>><?= $oloker[NALOK]?></option>
                <?php } ?>
              </select>
			</div>
			</td>
          </tr>
<!--          <tr>
            <td>&nbsp; </td>
			<td width="34">:</td>
            <td>
              <input name="updlokid" type="submit" class="tombol2" tabindex='1' value="SIMPAN LOKASI">
            </td>
          </tr>-->
      </table>
<?php // ----------------------- identitas ------------------------------------ ?>
<?php
$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
?>      
    <input type="hidden" name="nip" value="<?= $_GET['nip'] ?>" />
	<table width="100%" class="table table-condensed table-bordered table-hover no-margin">
          <tr class="sectiontableheader"> 
            <td width="3%"> 
              <b>A</b>
            </td>
            <td colspan="3" height="22" class="sectiontableheader"><b>IDENTITAS PEGAWAI</b></td>
          </tr>
          <tr valign="top" height="25"> 
            <td width="3%">01</td>
            <td width="20%">NIP Pegawai</td>
			<td>:</td>
            <td width="77%"><b><?=$NIP?> / <?=format_nip_baru($row[B_02B])?></b></td>
          </tr>
          <tr valign="top" height="20"> 
            <td width="3%"> 02</td>
            <td width="20%">NIP Baru</td>
			<td>:</td>
            <td width="77%"><input type="text" name="B_02B" class="form-control-static" value="<?=$row[B_02B]?>" maxlength="18"></td>
		  </tr>
          <tr valign="top"> 
            <td width="3%"> 03</td>
            <td width="20%">Nama Pegawai</td>
            <td>:</td>
            <td width="77%"> 
                <input type="text" name="B_03A" class="form-control-static" value="<?=$row[B_03A]?>" size="4" style="width: 100px;" /> 
              <input type="text" name="B_03" class="form-control-static" value="<?=stripslashes($row[B_03])?>" size="30" style="width: 300px;" /> 
              <input type="text" name="B_03B" class="form-control-static" value="<?=$row[B_03B]?>" size="6" style="width: 100px;" />
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 04</td>
            <td width="20%">Tempat Lahir</td>
            <td>:</td>
            <td width="77%"><input type="text" class="form-control-static" name="B_04" size="30" value="<?=$row[B_04]?>"></td>
          </tr>
          <tr valign="top">
            <td width="3%"> 05</td>
            <td width="20%">Tanggal Lahir</td>
            <td>:</td>
            <td width="77%"><input name="TGLAHIR" id="tgllahir" class="form-control-static" value="<?=datefmysql($row['B_05'])?>" size="30">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 06</td>
            <td width="20%">Jenis Kelamin</td>
            <td>:</td>
            <? $B_06=$row["B_06"]; ?>
            <td width="77%"> 
              <select name="B_06" class="form-control-static">
                <option value="">-</option>
                <option value="1" <? if ($B_06=='1') echo "selected"; ?>>LAKI-LAKI</option>
                <option value="2" <? if ($B_06=='2') echo "selected"; ?>>PEREMPUAN</option>
              </select>
            </td>
         <tr> 
            <td width="3%"> 07</td>
            <td width="20%">Golongan Darah</td>
            <td>:</td>
            <td width="77%"> 
              <select name="gd" class="form-control-static">
                <option value="">-</option>
                <option value="A" <? if ($row["gd"]=='A') echo "selected"; ?>>A</option>
                <option value="AB" <? if ($row["gd"]=='AB') echo "selected"; ?>>AB</option>
                <option value="B" <? if ($row["gd"]=='B') echo "selected"; ?>>B</option>
				<option value="O" <? if ($row["gd"]=='O') echo "selected"; ?>>O</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 08</td>
            <td width="20%">A g a m a</td>
            <td>:</td>
            <td width="77%"> 
              <? $B_07=$row["B_07"]; ?>
              <select name="B_07" class="form-control-static">
                <option value="">-</option>
                <option value="1" <? if ($B_07=='1') echo "selected"; ?>>ISLAM</option>
                <option value="2" <? if ($B_07=='2') echo "selected"; ?>>KRISTEN</option>
                <option value="3" <? if ($B_07=='3') echo "selected"; ?>>KATHOLIK</option>
                <option value="4" <? if ($B_07=='4') echo "selected"; ?>>HINDU</option>
                <option value="5" <? if ($B_07=='5') echo "selected"; ?>>BUDHA</option>
                <option value="5" <? if ($B_07=='6') echo "selected"; ?>>KONGHUCU</option>
                <option value="5" <? if ($B_07=='7') echo "selected"; ?>>LAINNYA</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 09</td>
            <td width="20%">Status Pegawai</td>
            <td>:</td>
            <td width="77%"> 
              <?php $B_09=$row["B_09"]; ?>
              <select name="B_09" class="form-control-static">
                <option value="">-</option>
                <option value="1" <?php if ($B_09=='1') echo "selected";?>>CPNS</option>
                <option value="2" <?php if ($B_09=='2') echo "selected";?>>PNS</option>
              </select>
            </td>
          </tr>
          <tr valign="top" height="20"> 
            <td width="3%"> 10</td>
            <td width="20%">Jenis Kepegawaian</td>
            <td>:</td>
            <td width="77%"><b>PNS Daerah Otonom</b></td>
          </tr>
          <tr> 
            <td width="3%"> 11</td>
            <td width="20%">Status Perkawinan</td>
            <td>:</td>
            <td width="77%"> 
              <select name="J_01" class="form-control-static">
                <option value="">-</option>
                <option value="1" <?php if ($row["J_01"]=='1') echo "selected"; ?>>KAWIN</option>
                <option value="2" <?php if ($row["J_01"]=='2') echo "selected"; ?>>BELUM KAWIN</option>
                <option value="3" <?php if ($row["J_01"]=='3') echo "selected"; ?>>JANDA/DUDA</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 12</td>
            <td width="20%">Kedudukan Pegawai</td>
            <td>:</td>
            <td width="77%"> 
              <?php $B_11=$row["B_11"]; ?>
              <select name="B_11" class="form-control-static">
                <option value="">-</option>
                <option value="1" <?php if ($B_11=='1') echo "selected"; ?>>PEGAWAI AKTIF</OPTION>
                <option value="2" <?php if ($B_11=='2') echo "selected"; ?>>PEJABAT NEGARA</OPTION>
                <option value="3" <?php if ($B_11=='3') echo "selected"; ?>>CUTI DILUAR TANGGUNGAN NEGARA</OPTION>
                <option value="4" <?php if ($B_11=='4') echo "selected"; ?>>PENERIMA UANG TUNGGU</OPTION>
                <option value="5" <?php if ($B_11=='5') echo "selected"; ?>>BEBAS TUGAS</OPTION>
                <option value="6" <?php if ($B_11=='6') echo "selected"; ?>>TUGAS BELAJAR</OPTION>
                <option value="7" <?php if ($B_11=='7') echo "selected"; ?>>SKORSING</OPTION>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 13</td>
            <td width="20%">Alamat Rumah</td>
            <td>:</td>
            <td width="77%"><textarea class="form-control-static" name="B_12" rows="3" cols="40"><?php echo $row["B_12"]; ?></textarea></td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 14</td>
            <td width="20%">No. Telepon</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="B_NOTELP" class="form-control-static" value="<?php echo $row[B_NOTELP]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 15</td>
            <td width="20%">Nomor Karpeg</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="B_08" class="form-control-static" value="<?php echo $row[B_08];?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 16</td>
            <td width="20%">Nomor Kartu ASKES</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="L_1A" class="form-control-static" value="<?php echo $row[L_1A]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 17</td>
            <td width="20%">No. Kartu Taspen</td>
            <td>:</td>
            <td width="77%"> 
                <input type="text" class="form-control-static" name="L_02" value="<?php echo $row[L_02]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 18</td>
            <td width="20%">Nomor Karis / Karsu</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="L_04" class="form-control-static" value="<?php echo $row[L_04]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 19</td>
            <td width="20%">N P W P</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="L_03" class="form-control-static" value="<?php echo $row[L_03]; ?>">
            </td>
          </tr>
		  <tr valign="top"> 
            <td width="3%"> 20</td>
            <td width="20%">N I K</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="nik" class="form-control-static" size=20 maxlength=21 value="<?php echo $row[nik]; ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" />
            </td>
          </tr>
          <tr valign="top"> 
            <td width="3%"> 21</td>
            <td width="20%">No. Arsip</td>
            <td>:</td>
            <td width="77%"> 
              <input type="text" name="B_NOARSIP" class="form-control-static" value="<?php echo $row[B_NOARSIP]; ?>">
            </td>
          </tr>
      </table>
    </form>
    <table width="100%">
        <tr> 
            <td width="3%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="77%"><button class="btn btn-primary" onclick="save_data_pegawai();"><i class="fa fa-save"></i> Simpan Identitas</button></td>
        </tr>
    </table>