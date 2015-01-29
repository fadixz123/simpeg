<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$uk = $_GET['uk'];
$bln = $_GET['bln'];
$tahun = $_GET['tahun'];
$thskr=$_GET['tahun']-56;
$thskr1=$_GET['tahun']-60;
$tglok=$thskr."-".date("m");//."-".date("d");
$tglok1=$thskr1."-".date("m");//."-".date("d");

$query="select * from MASTFIP08 where ";
if ($uk!='all') {
	if (strlen($uk)==2) $query.="A_01='".$uk."' ";
	else $query.="A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
}
else $query.="A_01!='99' ";

if ($subuk!='' && $subuk!='all') {
	$query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
}

$query.="and year(G_01) = year(date_sub('".$tahun.date("-m-d")."',interval 2 year)) and month(G_01) = '$bln' ";
$query.="order by F_03 DESC,F_TMT ASC,I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
//echo $query;

?>
<div class="content-width">
<table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
        <tr>
          <th width="5%">No</th>
          <th width="10%">NIP</th>
          <th width="10%">NIP BARU</th>
          <th width="20%" class="left">NAMA</th>
          <th width="30%" class="left">JABATAN</th>
          <th width="5%">Esl</th>
          <th width="7%">GOL/RNG</th>
          <th width="10%">GAJI LAMA</th>
          <th width="10%">GAJI BARU</th>
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
$result=mysql_query($query.'  limit '.$offset.', '.$limit) or die (mysql_error());
$total_data = mysql_num_rows(mysql_query($query));
while ($row=mysql_fetch_array($result)) {
	$no++;
	$thmker=substr($row[G_02],0,2);
	$thmker2=$thmker+2;
?>
        <tr>
          <td align="center"><?=$no+$offset; ?></td>
          <td class="nowrap"><?=$row[B_02]?></td>
          <td class="nowrap"><?=format_nip_baru($row[B_02B])?></td>
          <td class="nowrap"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B]) ?></td>
          <td class="nowrap"><small><?= ucwords(strtolower(getNaJab($row[B_02])))?></small></td>
          <td class="nowrap" align="center"><?= $row[I_06]=='99' ? "-" : eselon($row[I_06])?></td>
          <td align="center" class="nowrap"><?=pktH($row[F_03])?></td>
          <td align="center"><?=number_format(gaji($row[F_03],$thmker))?></td>
          <td align="center"><?=number_format(gaji($row[F_03],$thmker2))?></td>
        </tr>
<? } ?>
    </tbody>
</table>
</div><br/>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>