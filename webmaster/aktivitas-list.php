<?php
session_start();
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no" style="width: 60%">
    <thead>
	<tr>
            <th width="5%">No</th>
            <th width="40%" class="left">Username</th>
            <th width="20%">Jml PNS yg Diedit</th>
            <th width="20%">Jml Aktivitas Edit</th>
            <th width="10%"></th>
	</tr>
    </thead>
    <tbody>
	<?
        $limit = 10;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        $tgldari    = date2mysql($_GET['tg_tgldari']);
        $tglsampai  = date2mysql($_GET['tg_tglsampai']);
        $q="select u.username, u.id, count(distinct nipedit) as jml,count(*) as jmlt from history h join user u on (h.id_user = u.id) where ";
        $q.="h.tanggal BETWEEN '$tgldari' and '$tglsampai' group by h.id_user";
        //echo $q;
        $r=mysql_query($q);
	$i=0;
	while ($ro=mysql_fetch_array($r)) {
		$i++;
	?>
	<tr>
		<td align="center"><?=$i?></td>
		<td><?=$ro[username]?></td>
		<td align="center"><?=$ro[jml]?></td>
		<td align="center"><?=$ro[jmlt]?></td>
		<td align="center"><button type="button" onclick="load_detail_history('<?= $ro['id'] ?>','<?= $tgldari ?>','<?= $tglsampai ?>');" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>
	</tr>
	<? } ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>