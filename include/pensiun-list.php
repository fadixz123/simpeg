<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$pensiun = $_GET['pensiun'];
$jabatan = $_GET['jabatan'];
$eselon  = $_GET['eselon'];
$kelamin = $_GET['kelamin'];
$uk      = $_GET['uk'];
?>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
<tr>
    <th width="4%" >No</th>
    <th width="10%" class="left">NIP</th>
    <th width="10%" class="left">NIP BARU</th>
    <th width="25%" class="left">NAMA PNS</th>
    <th width="20%" class="left">JABATAN</th>
    <th width="10%" class="left">G/R</th>
    <th width="7%" class="left">TGL LAHIR</th>
    <th width="7%" class="left">TMT PENSIUN</td>
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
		$thini=intval(date("Y"));
		$next=$thini+intval($pensiun);
		//$batas=
$tahun=date("Y")+intval($pensiun);
$thskr=$tahun-56;
$thskra=$thskr-1;
$thskr1=$tahun-60;
$thskr1a=$thskr1-1;
$thskr2=$tahun-65;
$thskr2a=$thskr1-1;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$qpf="select distinct(KFUNG) from TABPENSIUNFUNG where USIA_PENS>56";
$rpf=mysql_query($qpf) or die(mysql_error());
while ($ropf=mysql_fetch_row($rpf)) {
	$kfunglb[]=$ropf[0];
}
$qflb=implode(",",$kfunglb);

$qpf60="select * from TABPENSIUNFUNG where USIA_PENS=60";
$rpf60=mysql_query($qpf60) or die(mysql_error());
while ($ropf60=mysql_fetch_array($rpf60)) {
	$kfunglb60[]="(I_05='$ropf60[KFUNG]' and F_03>='$ropf60[PKT_MIN]' and F_03<='$ropf60[PKT_MAX]')";
}
$qflb60=implode(" or ",$kfunglb60);

$qpf65="select * from TABPENSIUNFUNG where USIA_PENS=65";
$rpf65=mysql_query($qpf65) or die(mysql_error());
while ($ropf65=mysql_fetch_array($rpf65)) {
	$kfunglb65[]="(I_05='$ropf65[KFUNG]' and F_03>='$ropf65[PKT_MIN]' and F_03<='$ropf65[PKT_MAX]')";
}
$qflb65=implode(" or ",$kfunglb65);

$q="select * from MASTFIP08 where 1 ";
if (substr($pensiun,0,1)!="-") { $q.="and A_01<>'99' "; }
if ($uk!='all') {
        if (strlen($uk)==2) { $q.="and A_01='".$uk."' "; }
        else { $q.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' "; }
}
if ($jabatan!='all') {
	if ($jabatan=='1') {
		$q.="and (I_5A='$jabatan' and I_06<>99) ";
	}
        $q.="and I_5A='$jabatan' ";
}
if (isset($eselon) && $eselon!='all' && $eselon!='str') {
        $q.="and I_06 like '".$eselon."%' ";
}
if ($eselon=='str') {
        $q.="and I_06<>'99' and I_06 is not null ";
}
if ($kelamin!='all') {
        $q.="and B_06='$kelamin' ";
}
	$q.="and        (
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskra' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='0' or (I_5A='1' and I_06<>'00') or I_5A='' or I_5A is null)
                                )
                        or
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskra' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='2' or I_5A='4' or (I_5A='1'and I_06='00'))
				and
					I_05 not in ($qflb)
                                )
                        or
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr1' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskr1a' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='2' or I_5A='4' or (I_5A='1'and I_06='00'))
				and
					($qflb60)
                                )
                        or
                                (
                                        (
                                                (substring(B_05,1,4) = '$thskr2' and substring(B_05,6,2)<>'12')
                                        or
                                                (substring(B_05,1,4) = '$thskr2a' and substring(B_05,6,2)='12')
                                        )
                                and
                                        (I_5A='2' or I_5A='4' or (I_5A='1'and I_06='00'))
				and
					($qflb65)
                                )
			) ";
		$q.=" order by B_05,F_03 desc";
		//echo "<pre>".$q."</pre>";
		$r=mysql_query($q.'  limit '.$offset.', '.$limit);
                $total_data = mysql_num_rows(mysql_query($q));
		$no=0;
		while ($row=mysql_fetch_array($r))
		{
			$bllahir=substr($row['B_05'],5,2);
			$thlahir=substr($row[B_05],0,4);
			$bltmt=$bllahir+1;
			$thtmt=date('Y')+$pensiun;
			if ($bltmt>12) {
				$bltmt=1;
			}
			$no++;
			?>
			<tr class="<?= ($no%2===0)?'even':'odd' ?>">
			<td align="center" width="4"><? echo $no+$offset; ?></td>
			<td><? echo $row['B_02']; ?></td>
			<td><? echo $row['B_02B']; ?></td>
			<td><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?></td>
			<td><? echo getNaJab($row[B_02]); ?></td>
			<td><? echo pktH($row['F_03']); ?></td>
                        <td><? echo datefmysql($row['B_05']); ?></TD>
			<td><? echo "1-".$bltmt."-".$thtmt; ?></td>
			</tr>
			<?
		}
		?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>