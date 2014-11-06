<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!isset($ultah) || $ultah=='') $ultah=0;
?>
<script type="text/javascript">
    function search_data_ultah(page) {
        $.ajax({
            type: 'GET',
            url: 'include/ultah-list.php?page='+page,
            data: $('#ultah').serialize(),
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
        search_data_ultah(page);
    }
</script>
<h4 class="title">NOMINATIF PNS YANG BERULANG TAHUN</h4>
<form name="ultah1" id="ultah" action="index.htm?sid=<?=$sid?>&do=ulangtahun" method="post">
<table width="100%">
	<tr>
	<td width="15%">PNS yang berulang tahun:</td>
	<td width="85%"> 
            <select name="ultah" id="ultah" class="form-control-static" style="width: 300px;">
                <option value="">Pilih</option>
                <option value="-5" <?= $ultah=='-5' ? "selected" : ""?>>5 Hari Lalu</option>
                <option value="-4" <?= $ultah=='-4' ? "selected" : ""?>>4 Hari Lalu</option>
                <option value="-3" <?= $ultah=='-3' ? "selected" : ""?>>3 Hari Lalu</option>
                <option value="-2" <?= $ultah=='-2' ? "selected" : ""?>>2 Hari Lalu</option>
                <option value="-1" <?= $ultah=='-1' ? "selected" : ""?>>Kemarin</option>
                <option value="0" <?= $ultah==='0' ? "selected" : ""?>>Hari Ini</option>
                <option value="1" <?= $ultah=='1' ? "selected" : ""?>>Besok</option>
                <option value="2" <?= $ultah=='2' ? "selected" : ""?>>2 Hari Lagi</option>
                <option value="3" <?= $ultah=='3' ? "selected" : ""?>>3 Hari Lagi</option>
                <option value="4" <?= $ultah=='4' ? "selected" : ""?>>4 Hari Lagi</option>
                <option value="5" <?= $ultah=='5' ? "selected" : ""?>>5 Hari Lagi</option>
                <option value="bl" <?= $ultah==='bl' ? "selected" : ""?>>Bulan Ini</option>
                <option value="bld" <?= $ultah==='bld' ? "selected" : ""?>>Bulan Depan</option>
            </select>
        </td>
	</tr>
	<tr>
	<td>Unit Kerja:</td>
	<td>
            <select name="uk" id="uk" class="form-control-static" style="width: 300px;">
            <option value="all">Semua</option>
            <?
            $lsuk=listUnitKerja();
            foreach($lsuk as $key=>$value) {
			?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
			<? } ?>
            </select></td>
	</tr>
        <tr>
        <td></td>
	<td colspan="2">
            <button type="button" class="btn btn-primary" onclick="search_data_ultah(1); return false;"><i class="fa fa-search"></i> Tampilkan</button>
	</td>
	</tr>
</table>
</form>
<div id="result"></div>