<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
<tr>
    <th width="5%">No</th>
    <th width="13%">NIP</th>
    <th width="20%" class="left">NAMA PNS</th>
    <th width="45%" class="left">JABATAN</th>
    <th width="5%" class="left">G/R</th>
    <th width="10%">TGL LAHIR</th>
</tr>
</thead>
    <tbody>
        <?php
        $ultah = $_GET['ultah'];
        $uk    = $_GET['uk'];
        $limit = 10;
        $page  = $_GET['page'];
        if ($_GET['page'] === '') {
            $page = 1;
            $offset = 0;
        } else {
            $offset = ($page-1)*$limit;
        }
        if ($ultah=='bl') {
                $q="select * from MASTFIP08 where month(B_05)='".date("m")."' ";
        } else if ($ultah=='bld') {
                $q="select * from MASTFIP08 where month(date_sub(B_05,interval 1 month))='".date("m")."' ";
        } else {
                $q="select * from MASTFIP08 where substring(date_sub(B_05,interval ".$ultah." day),6,10)='".date("m-d")."' ";
        }
        if ($uk!='all') {
                if (strlen($uk)==2) $q.="and A_01='".$uk."' ";
                else $q.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
        }
        //echo $q;
        $r=mysql_query($q.'  limit '.$offset.', '.$limit) or die(mysql_error());
        $total_data = mysql_num_rows(mysql_query($q));
        $no=0;
        while ($row=mysql_fetch_array($r))
        {
                        $no++;
                ?>
                <tr class="<?= ($no%2===0)?'odd':'even' ?>">
                <td align="center"><? echo $no; ?>&nbsp;</td>
                <td class="nowrap"><?=$row['B_02B']=='' ? $row[B_02] : format_nip_baru($row[B_02B])?></td>
                <td class="nowrap"><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?>&nbsp;</td>
                <td class="nowrap"><small><? echo ucwords(strtolower(getNaJab($row[B_02]))); ?></small></td>
                <td class="nowrap"><? echo pktH($row['F_03']); ?>&nbsp;</td>
                <td class="nowrap" align="center"><? echo tanggalnya($row['B_05'],0); ?>&nbsp;</TD>
                </tr>
                <?
        }
        ?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>