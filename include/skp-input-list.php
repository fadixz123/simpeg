<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%" class="left">Waktu</th>
            <th width="30%" class="left">Nama Kegiatan</th>
            <th width="45%" class="left">Nama Pegawai</th>
            <th width="15%" class="left">Jumlah</th>
            <th width="10%">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $limit = 10;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        $i=0;
        $qu="select r.*, k.nama as kegiatan, CONCAT_WS(' ',`B_03A`,`B_03`,`B_03B`) as pegawai from rekap_skp r 
            join kegiatan_skp k on (r.id_kegiatan_skp = k.id)
            join mastfip08 m on (r.B_02 = m.B_02)
        ";
        if ($_GET['awal'] !== '' and $_GET['akhir'] !== '') {
            $qu.=" and date(r.waktu) between '".  date2mysql($_GET['awal'])."' and '".  date2mysql($_GET['akhir'])."'";
        }
        if ($_GET['nama'] !== '') {
            $qu.=" and r.B_02 = '".$_GET['nama']."'";
        }
        if ($_GET['kegiatan'] !== '') {
            $qu.=" and r.id_kegiatan_skp = '".$_GET['kegiatan']."'";
        }
        $ru=mysql_query($qu.' order by nama asc limit '.$offset.', '.$limit) or die(mysql_error());
        $total_data = mysql_num_rows(mysql_query($qu));
        while ($data=mysql_fetch_array($ru)) {
                $i++;
                $detail = $data['id'].'#'.$data['nama'].'#'.$data['jumlah_bulan'].'#'.$data['target'];
        ?>
        <tr class="<?= ($i%2===0)?'odd':'even' ?>">
                <td width="33" align="center"><?=$i+$offset?></td>
                <td width="102"><?=datetimefmysql($data['waktu'], true)?></td>
                <td width="102"><?=$data['kegiatan']?></td>
                <td width="102"><?=$data['pegawai']?></td>
                <td width="102"><?=$data['jumlah']?></td>
                <td width="67">
                    <button type="button" class="btn btn-default btn-xs" onclick="delete_setting_skp(<?= $data['id'] ?>);"><i class="fa fa-trash-o"></i> Delete</button>
                </td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>