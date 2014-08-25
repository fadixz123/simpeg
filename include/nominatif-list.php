<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-60;
$tglok=$thskr."-".date("m");//."-".date("d");
$tglok1=$thskr1."-".date("m");//."-".date("d");

$query="select * from MASTFIP08 where 1 ";
$uk     = $_GET['uk'];
$subuk  = $_GET['subuk'];
$hasupt = $_GET['hasupt'];
$radio1 = $_GET['radio1'];
$gol1   = $_GET['gol1'];
$gol2   = $_GET['gol2'];
$status = $_GET['status'];
$jabatan= $_GET['jabatan'];
$jabfung= $_GET['jabfung'];
$eselon = $_GET['eselon'];
$kelamin= $_GET['kelamin'];
$agama  = $_GET['agama'];
$diklat = $_GET['diklat'];
$dik    = $_GET['dik'];
$jur    = $_GET['jur'];
$urut   = $_GET['urut'];


if ($uk!='all') {
	if (strlen($uk)==2) $query.="and A_01='".$uk."' ";
	else $query.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
} else $query.="and A_01<>'99' ";

if ($subuk!=='' && $subuk!=='all') {
	if ($hasupt === 'true') $query.="and A_02='$subuk' ";
	else $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
}

if ($radio1=='') $radio1=1;
switch($radio1) {
	case 1: $query.="and F_03 >= '" . $gol1. "' ";break;
	case 2: $query.="and F_03 <= '" . $gol1. "' ";break;
	case 3: $query.="and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";break;
}

if ($status!=='all') {
	$query.="and B_09='$status' ";
}
if ($jabatan!=='all') {
        if ($jabatan==2) { $query.="and (I_5A='2' or I_5A='4') "; }
        else { $query.="and I_5A='$jabatan' "; }
}
if ($jabfung!=='') {
	$query.="and (I_5A='2' or I_5A='4') and I_05='$jabfung' ";
}
if ($eselon!=='all' && $eselon!=='str') {
	if (strlen($eselon)==1) $query.="and I_06 like '".$eselon."%' ";else $query.="and I_06='$eselon' ";
}
if ($eselon=='str') {
	$query.="and I_06<>'99' and I_06 is not null and I_5A='1' ";
}
if ($kelamin!='all') {
	$query.="and B_06='$kelamin' ";
}
if ($agama!='all') {
	$query.="and B_07='$agama' ";
}
if ($diklat!='all') {
        $query.="and H_4A='$diklat' ";
}
if ($dik!='all') {
        $query.="and H_1A='$dik' ";
}
if ($jur!='') {
        $query.="and H_1B='$jur' ";
}
$limit = 10;
$page  = $_GET['page'];
if ($_GET['page'] === '') {
    $page = 1;
    $offset = 0;
} else {
    $offset = ($page-1)*$limit;
}
if ($urut=='str') $query.="order by I_05 ";
else $query.="order by F_03 DESC,F_TMT ASC,I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
//echo $query.'  limit '.$offset.', '.$limit;
$result=mysql_query($query.'  limit '.$offset.', '.$limit) or die (mysql_error());
$total_data=mysql_num_rows(mysql_query($query));
?>
<table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>      
    <tr>
        <th width="4%">No</th>
        <th width="13%" class="left">NIP</th>
        <th width="17%" class="left">NAMA</th>
        <th width="6%">TGL LHR</th>
        <th width="10%" class="left">JABATAN</th>
        <th width="40%" colspan="3">UNIT KERJA</th>
        <th width="5%">Esl</th>
        <th width="5%">GOL/RNG</th>
    </tr>
    </thead>
<?php
$no=0;

while ($row=mysql_fetch_array($result)) {
$no++;	
?>
    <tr class="<?= ($no%2===0)?'even':'odd' ?>">
        <td align="center"><?=$no; ?></td>
        <td><a href="?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?= $row[B_02B]=='' ? $row[B_02] : format_nip_baru($row[B_02B])?></a></td>
        <td><a href="?&sid=<?=$sid; ?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B]) ?></a></td>
        <td><?=datefmysql($row[B_05]); ?></td>
        <td><?= getNaJab($row[B_02])?></td>
        <td><?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03].$row[A_04])?></td>
        <td><?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03])?></td>
        <td><?=lokasiKerjaB($row[A_01])?></td>
        <td align="center"><?= $row[I_06]=='99' ? "-" : eselon($row[I_06])?></td>
        <td align="center"><?=pktH($row[F_03])?></td>
    </tr>
<? } ?>
</table>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>