<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<script type="text/javascript">
    $(function() {
        $('.mypopover').popover({html: true, trigger:'hover'}); 
    });
</script>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
    <tr>
      <th width="3%">No</th>
      <th width="12%" class="left">NIP Lama</th>
      <th width="12%" class="left">NIP Baru</th>
      <th width="25%" class="left">Nama</th>
      <th width="35%" class="left">Jabatan</th>
      <th width="15%"></th>
    </tr>
    </thead>
    <tbody>
        <?php
        $uk    = $_GET['uk'];
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
        if ($_GET['uk'] !== 'all') {
            $q .="and A_01='".substr($uk,0,2)."' ";
        }
        if ($_GET['nip'] !== '') {
            $q.=" and B_02 = '".$_GET['nip']."'";
        }
        if ($_GET['suk'] !== '') {
            $q.=" having kode_sub_lokasi like ('%".$_GET['suk']."%')";
        }
        if ($_SESSION['skpd'] !== '20' and $_SESSION['nama_group'] !== 'Administrator') {
            //$q.=" and A_01 = '".$_SESSION['skpd']."' and A_02 = '".$_SESSION['subskpd']."'";
        }
        
        $q .=" order by I_06 ASC, F_03 DESC";
        //echo $q.'  limit '.$offset.', '.$limit;
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        while($row=mysql_fetch_array($r)) {
            if ($row['I_05'] === '00018') {
                $qjenjang="select * from TABJENJANG_GURU where KJENJANG = '".$row['I_07']."'";
            } else {
                $qjenjang="select * from TABJENJANG where KJENJANG = '".$row['I_07']."'";
            }
            $nama_jenjang = mysql_fetch_array(mysql_query($qjenjang));
            $detail = "<table>
                <tr><td class=nowrap>".  ucwords(strtolower(subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04],$row[A_05])))."</td></tr>
                <tr><td class=nowrap>".ucwords(strtolower(lokasiKerjaB($row[A_01])))."</td></tr>
                </table>
                ";
                $no++;
                ?>
              <tr valign="top" class="<?= ($no%2===0)?'even':'odd' ?>">
                <td class="nowrap" align="center"><?=$no+$offset?></td>
                <td class="nowrap"><?=$row[B_02]?></td>
                <td class="nowrap"><?=format_nip_baru($row[B_02B])?></td>
                <td><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
                <td><?=ucwords(strtolower(getNaJab($row[B_02]).' '.$nama_jenjang['JENJANG']))?></td>
                <td class="nowrap" align="right">
                    <button type="button" class="btn btn-default btn-xs mypopover" data-container="body" data-toggle="popover" data-placement="top" data-title="Detail Unit Kerja" data-content="<?= $detail ?>"><i class="fa fa-eye"></i> Unit Kerja</button>
                </td>
              </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>

