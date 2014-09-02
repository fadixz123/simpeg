<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$sid = $_GET['sid'];
?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
    <tr>
      <th width="5%">No</th>
      <th width="10%" class="left">Waktu</th>
      <th width="40%" class="left">Nama Jabatan</th>
      <th width="10%" class="left">Periode Mulai</th>
      <th width="10%" class="left">Periode Selesai</th>
      <th width="10%" class="left">Status</th>
      <th width="6%" class='nowrap'></th>
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
        $no=0;
        $q="select * from baperjakat order by waktu desc";
        //echo $q.'  limit '.$offset.', '.$limit;
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        while($row=mysql_fetch_array($r)) {
                $no++;
                ?>
              <tr class="<?= ($no%2===0)?'even':'odd' ?>">
                <td align="center"><?=$no+$offset?></td>
                <td><?= datetimefmysql($row['waktu'])?></td>
                <td><?= $row['jabatan']?></td>
                <td><?= datefmysql($row['periode_mulai']) ?></td>
                <td><?= datefmysql($row['periode_selesai']) ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <button type="button" onclick="" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> Input</button> 
                </td>
              </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>
