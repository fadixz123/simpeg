<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$sid = $_GET['sid'];
?>
<script type="text/javascript">
    $(function() {
        $('.mypopover').popover({html: true, trigger:'hover'}); 
    });
</script>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
    <tr>
      <th width="5%">No</th>
      <th width="12%" class="left">NIP Lama</th>
      <th width="12%" class="left">NIP Baru</th>
      <th width="25%" class="left">Nama</th>
      <th width="35%" class="left">Jabatan</th>
      <th width="10%" class="left">Unit Kerja</th>
      <th width="5%"></th>
    </tr>
    </thead>
    <tbody>
        <?php
        $uk    = $_GET['uk'];
        $B_03 = ($_GET['B_03'] !== '')?$_GET['B_03']:'-';
        $limit = 10;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        $no=0;
        $q="select *, CONCAT(`A_01`,`A_02`, `A_03`, `A_04`, `A_05`) as kode_sub_lokasi from MASTFIP08 where B_02 is not NULL  and A_01 != '99'
                ";
        //echo $q;
        if ($_GET['uk'] !== 'all') {
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
        
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        while($row=mysql_fetch_array($r)) {
            $detail = "<table>
                <tr><td class=nowrap>".  ucwords(strtolower(subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04],$row[A_05])))."</td></tr>
                <tr><td class=nowrap>".ucwords(strtolower(lokasiKerjaB($row[A_01])))."</td></tr>
                </table>
                ";
                $no++;
                ?>
              <tr class="<?= ($no%2===0)?'even':'odd' ?>">
                <td class="nowrap" align="center"><?=$no+$offset?></td>
                <td class="nowrap"><?=$row[B_02]?></td>
                <td class="nowrap"><?=format_nip_baru($row[B_02B])?></td>
                <td class="nowrap"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
                <td class="nowrap"><small><?=ucwords(strtolower(getNaJab($row[B_02])))?></small></td>
                <td><button type="button" class="btn btn-default btn-xs mypopover" data-container="body" data-toggle="popover" data-placement="top" data-title="Detail Unit Kerja" data-content="<?= $detail ?>">Show</button></td>
                <td class="nowrap">
                    <button type="button" onclick="load_detail('include/main-tabs.php?sid=<?=$sid?>&do=cari&nip=<?=$row['B_02']?>&nama=<?=$row['B_03']?>&cari=NIP','<?= $row['B_02'] ?>');" class="btn btn-default btn-xs"><i class="fa fa-eye"></i></button>
                </td>
              </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>
