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
            <th width="75%" class="left">Nama</th>
            <th width="20%">&nbsp;</th>
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
        $qu="select * from group_users";
        $ru=mysql_query($qu.' order by nama asc limit '.$offset.', '.$limit) or die(mysql_error());
        $total_data = mysql_num_rows(mysql_query($qu));
        while ($data=mysql_fetch_array($ru)) {
                $i++;
                $detail = $data['id'].'#'.$data['nama'];
        ?>
        <tr class="<?= ($i%2===0)?'odd':'even' ?>">
                <td width="33" align="center"><?=$i+$offset?></td>
                <td width="102"><?=$data['nama']?></td>
                <td width="67">
                    <button type="button" onclick="edit_akses('<?= $data['id'] ?>')" class="btn btn-default btn-xs"><i class="fa fa-cogs"></i> Hak Akses</button> 
                    <button type="button" onclick="edit_user('<?= $detail ?>')" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Edit</button> 
                    <button type="button" class="btn btn-default btn-xs" onclick="delete_user(<?= $data['id'] ?>);"><i class="fa fa-trash-o"></i> Delete</button>
                </td>
        </tr>
        <? } ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>