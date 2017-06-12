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
      <th width="3%">No</th>
      <th width="20%" class="left">Nama Sekolah</th>
      <th width="10%" class="left">ROmbel</th>
      <th width="10%" class="left">Jml Siswa</th>
      <th width="20%" class="left">Alamat</th>
      <th width="17%">Email</th>
      <th width="10%">Telp</th>
      <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
        <?php
        $uk    = $_GET['uk'];
        $B_03 = ($_GET['B_03'] !== '')?$_GET['B_03']:'-';
        $limit = 15;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        $no=0;
        $q="select *, substring(KOLOK,1,8) as KODELOK from TABLOKB08 where substring(KOLOK,1,2)='04' order by KOLOK ";
        //echo $q;
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        while($row=mysql_fetch_array($r)) {
            $detail = "<table>
                <tr><td class=nowrap>".ucwords(strtolower(subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04],$row[A_05])))."</td></tr>
                <tr><td class=nowrap>".ucwords(strtolower(lokasiKerjaB($row[A_01])))."</td></tr>
                </table>
                ";
                $no++;
                if ($row['I_05'] === '00018') {
                    $qjenjang="select * from TABJENJANG_GURU where KJENJANG = '".$row['I_07']."'";
                } else {
                    $qjenjang="select * from TABJENJANG where KJENJANG = '".$row['I_07']."'";
                }
                $nama_jenjang = mysql_fetch_array(mysql_query($qjenjang));
                ?>
              <tr valign="top" class="<?= ($no%2===0)?'even':'odd' ?>">
                <td class="nowrap" align="center"><?=$no+$offset?></td>
                <td><?= $row['NALOK'] ?></td>
                <td><input type="text" name="rombel" class="form-control" /></td>
                <td><input type="text" name="jml_siswa" class="form-control" /></td>
                <td><input type="text" name="alamat" class="form-control" /></td>
                <td><input type="text" name="email" class="form-control" /></td>
                <td><input type="text" name="telp" class="form-control" /></td>
                <td class="nowrap" align="right">
                    <button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</button>
                    <button class="btn btn-default btn-xs"><i class="fa fa-save"></i> Save</button>
                    
                </td>
              </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>

