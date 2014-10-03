<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
    <tr>
      <th width="5%">No</th>
      <th width="10%" class="left">NIP Lama</th>
      <th width="10%" class="left">NIP Baru</th>
      <th width="25%" class="left">Nama</th>
      <th width="49%" class="left">Unit Kerja Jabatan</th>
      <th width="1%"></th>
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
        $q="select *, CONCAT(`A_01`,`A_02`, `A_03`, `A_04`, `A_05`) as kode_sub_lokasi from MASTFIP08 where B_03 LIKE '%$B_03%' 
                ";
        //echo $q;
        if ($_GET['uk'] != 'all') {
            $q .="and A_01='".substr($uk,0,2)."' ";
        }
        if ($_GET['nip'] !== '') {
            $q.=" and B_02 = '".$_GET['nip']."'";
        }
        if ($_GET['suk'] !== '') {
            $q.=" having kode_sub_lokasi like ('%".$_GET['suk']."%')";
        }
        if ($_SESSION['skpd'] !== '12' and $_SESSION['nama_group'] !== 'Administrator') {
            $q.=" and A_01 = '".$_SESSION['skpd']."'";
        }
        
        $q .="order by I_06 ASC, F_03 DESC";
        //echo $q.'  limit '.$offset.', '.$limit;
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        while($row=mysql_fetch_array($r)) {
                $no++;
                ?>
              <tr class="<?= ($no%2===0)?'even':'odd' ?>">
                <td align="center"><?=$no+$offset?></td>
                <td><?=$row[B_02]?></td>
                <td class="nowrap"><?=format_nip_baru($row[B_02B])?></td>
                <td><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
                <td>
                <small><?=subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04],$row[A_05])?>
                <?=lokasiKerjaB($row[A_01])?></small><br>
                <small><i><?=getNaJab($row[B_02])?></i></small></td>
                <td><button type="button" onclick="load_detail('include/cari-detail.php?sid=<?=$_GET['sid']?>&B_03=<?= $row['B_03'] ?>&uk=<?= $_GET['uk'] ?>&do=cari&nip=<?=$row[B_02]?>&cari=NIP');" class="btn btn-default btn-xs"><i class="fa fa-eye"></i> Detail</button></td>
              </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>
