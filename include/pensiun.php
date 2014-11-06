<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<script type="text/javascript">
    $(function() {
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>','pop','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
    function search_data_pensiun(page) {
        $.ajax({
            type: 'GET',
            url: 'include/pensiun-list.php?page='+page,
            data: $('#pensiun').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#result').html(data);
            }
        });
    }
    
    function paging(page, tab, search) {
        search_data_pensiun(page);
    }
</script>
<h4 class="title">NOMINATIF PNS YANG AKAN PENSIUN</h4>
<form name="pensiun" id="pensiun" action="index.htm?sid=<?=$sid?>&do=pensiun" method="post">
<table width="100%">
	<tr>
	<td width="15%">Unit Kerja:</td>
	<td width="677"> 
	
            <select name="uk" id="uk" class="form-control-static" style="width: 300px;">
            <option value="all">Semua...</option>
            <?
            $lsuk=listUnitKerja();
            foreach($lsuk as $key=>$value) {
			?>
			<option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=$value[1]?></option>
			<? } ?>
            </select></td>
	</tr>
	<tr>
	<td width="107">Pilih waktu: </td>
	<td width="677"> 
	<select name="pensiun" id="pensiun" class="form-control-static" style="width: 300px;">
	<option value="5" <?if ($pensiun=='5') echo "selected"?>>LIMA TAHUN LAGI</option>
	<option value="4" <?if ($pensiun=='4') echo "selected"?>>EMPAT TAHUN LAGI</option>
	<option value="3" <?if ($pensiun=='3') echo "selected"?>>TIGA TAHUN LAGI</option>
	<option value="2" <?if ($pensiun=='2') echo "selected"?>>DUA TAHUN LAGI</option>
	<option value="1" <?if ($pensiun=='1') echo "selected"?>>SATU TAHUN LAGI</option>
	<option value="0" <?if ($pensiun=='0') echo "selected"?>>TAHUN INI</option>
	<option value="-1" <?if ($pensiun=='-1') echo "selected"?>>SATU TAHUN LALU</option>
	<option value="-2" <?if ($pensiun=='-2') echo "selected"?>>DUA TAHUN LALU</option>
	<option value="-3" <?if ($pensiun=='-3') echo "selected"?>>TIGA TAHUN LALU</option>
	<option value="-4" <?if ($pensiun=='-4') echo "selected"?>>EMPAT TAHUN LALU</option>
	<option value="-5" <?if ($pensiun=='-5') echo "selected"?>>LIMA TAHUN LALU</option>

	</select></td>
	</tr>
        <tr valign="top">
          <td width="107" align="left">Jabatan: </td>
          <td width="677" align="left">
            <select name="jabatan" id="jabatan" class="form-control-static" style="width: 300px;">
            <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua...</option>
            <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
            <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
            <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
          </select></td></tr>
	  <tr valign="top">
          <td width="107" align="left">Eselon:</td>
          <td width="677" align="left">
            <select name="eselon" id="eselon" class="form-control-static" style="width: 300px;">
            <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($eselon=='1') echo "selected" ; ?>>I</option>
            <option value="2" <? if ($eselon=='2') echo "selected" ; ?>>II</option>
            <option value="3" <? if ($eselon=='3') echo "selected" ; ?>>III</option>
            <option value="4" <? if ($eselon=='4') echo "selected" ; ?>>IV</option>
		</select>
	</td></tr>
	  <tr valign="top">
          <td width="107" align="left">Jenis Kelamin:</td>
          <td width="677" align="left">
            <select name="kelamin" id="kelamin" class="form-control-static" style="width: 300px;">
            <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
            <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
		</select>
	</td></tr>
<!--	<tr>
	<td>Pilih bulan : 
	<select name="blpensiun" >
	<option value="00">PILIH BULAN</option>
	<option value="01">JANUARI</option>
	<option value="02">FEBRUARI</option>
	<option value="03">MARET</option>
	<option value="04">APRIL</option>
	<option value="05">MEI</option>
	<option value="06">JUNI</option>
	<option value="07">JULI</option>
	<option value="08">AGUSTUS</option>
	<option value="09">SEPTEMBER</option>
	<option value="10">OKTOBER</option>
	<option value="11">NOVEMBER</option>
	<option value="12">DESEMBER</option>
	</select>&nbsp;
	</td>
	</tr>-->
	<tr>
        <td></td>
	<td colspan="2">
            <button type="button" class="btn btn-primary" onclick="search_data_pensiun(1); return false;"><i class="fa fa-search"></i> Tampilkan</button>
            <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
	</td>
	</tr>
</table>
</form>
<div id="result"></div>