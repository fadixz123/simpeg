<?php
session_start();
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no" style="width: 100%">
    <thead>
	<tr>
            <th width="5%">No</th>
            <th width="10%" class="left">Username</th>
            <th width="40%" class="left">Nama Pegawai</th>
            <th width="15%">Jml PNS yg Diedit</th>
            <th width="15%">Jml Aktivitas Edit</th>
            <th width="5%"></th>
	</tr>
    </thead>
    <tbody>
	<?
        $limit = 15;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        $tgldari    = date2mysql($_GET['tg_tgldari']);
        $tglsampai  = date2mysql($_GET['tg_tglsampai']);
        $q="select u.username, CONCAT_WS(' ', m.B_03A, m.B_03, m.B_03B) as nama, u.id, count(distinct nipedit) as jml,count(*) as jmlt from history h join user u on (h.id_user = u.id) join mastfip08 m on (u.B_02 = m.B_02) where ";
        $q.="h.tanggal BETWEEN '$tgldari' and '$tglsampai' group by h.id_user limit $offset, $limit";
        
        $count = mysql_fetch_array(mysql_query("select count(*) as jumlah from (select h.*
            from history h join user u on (h.id_user = u.id) 
            join mastfip08 m on (u.B_02 = m.B_02) 
            where h.tanggal BETWEEN '$tgldari' and '$tglsampai' group by h.id_user) as jumlah"));
        //echo $q;
        $r=mysql_query($q);
	$i=0;
	while ($ro=mysql_fetch_array($r)) {
		$i++;
	?>
	<tr valign="top" class="<?= ($i%2===0)?'even':'odd' ?>">
		<td align="center"><?=$i+$offset?></td>
		<td><?=$ro[username]?></td>
                <td><?=$ro['nama']?></td>
		<td align="center"><?=$ro[jml]?></td>
		<td align="center"><?=$ro[jmlt]?></td>
		<td align="right"><button type="button" onclick="load_detail_history('<?= $ro['id'] ?>','<?= $tgldari ?>','<?= $tglsampai ?>');" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>
	</tr>
	<? } ?>
    </tbody>
</table>
<?= page_summary($count['jumlah'], $page, $limit) ?>
<?= paging_ajax($count['jumlah'], $limit, $page, '1', $_GET['search']) ?>