<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
        <tr>
            <th width="3%">No</th>
            <!--<th width="10%" class="left">NIP</th>-->
            <th width="10%" class="left">Username</th>
            <th width="20%" class="left">Nama</th>
            <th width="15%" class="left">Unit kerja</th>
            <th width="15%" class="left">Sub Unit Kerja</th>
            <th width="20%" class="left">Sub Sub Unit Kerja</th>
            <th width="10%" class="left">Level</th>
            <th width="10%" class="left">Password</th>
            <th width="12%">&nbsp;</th>
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
        $i=0;
        if ($_GET['username'] !== '') {
            $q.=" and u.username like ('%".$_GET['username']."%')";
        }
        if ($_GET['nama'] !== '') {
            $q.=" and m.B_03 like ('%".$_GET['nama']."%')";
        }
        if ($_GET['group_user'] !== '') {
            $q.=" and u.id_group_user = '".$_GET['group_user']."'";
        }
        $qu="select u.*, CONCAT_WS(' ',m.`B_03A`,`B_03`,`B_03B`) as nama_pegawai, g.nama as level,
            m.A_01, m.A_02, m.A_03, m.A_04, m.A_05
            from USER u 
            left join mastfip08 m on (u.B_02 = m.`B_02`)
            left join group_users g on (u.id_group_user = g.id)
            where u.id is not NULL $q
            ";
        $ru=mysql_query($qu.' order by username asc limit '.$offset.', '.$limit) or die(mysql_error());
        $total_data = mysql_num_rows(mysql_query($qu));
        while ($data=mysql_fetch_array($ru)) {
                $i++;
                $detail = $data['id'].'#'.$data['B_02'].'#'.$data['username'].'#'.$data['id_group_user'].'#'.$data['nama_pegawai'];
                $sublok = mysql_fetch_array(mysql_query("select substring(KOLOK,1,6) as KODELOK,NALOK from TABLOKB08 where KOLOK like '".$data['A_01'].$data['A_02'].$data['A_03']."%' and KOLOK like '%0000'"));
            $subsublok = mysql_fetch_array(mysql_query("select substring(KOLOK,1,6) as KODELOK,NALOK from TABLOKB08 where KOLOK like '".$data['A_01'].$data['A_02'].$data['A_03'].$data['A_04'].$data['A_05']."'"));
        ?>
        <tr class="<?= ($i%2===0)?'odd':'even' ?>">
                <td width="33" align="center"><?=$i+$offset?></td>
                <!--<td width="102"><?=$data['B_02']?></td>-->
                <td width="102"><?=$data['username']?></td>
                <td width="186"><?=$data['nama_pegawai']?></td>
                <td width="186"><?=  lokasiKerjaB($data['A_01'])?></td>
                <td width="186"><?= $sublok['NALOK']?></td>
                <td width="186"><?= $subsublok['NALOK'] ?></td>
                <td><?=$data['level']?></td>
                <td width="67">********</td>
                <td width="67" align="right" style="white-space: nowrap;">
                    <button type="button" onclick="edit_user('<?= $detail ?>')" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button> 
                    <button type="button" class="btn btn-default btn-xs" onclick="delete_user('<?= $data['id'] ?>','<?= $page ?>');"><i class="fa fa-trash-o"></i></button>
                </td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>