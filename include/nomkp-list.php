<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$unitkerja=$_GET['uk'];
$aBulan= array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
$pangkat=array('11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');
$qcu="select distinct A_02 from MASTFIP08 where A_01='$unitkerja'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;

if ($unitkerja !='') {
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m")."-".date("d");
	if ($gol1=='') $gol1='11';
	if ($gol2=='') $gol2='45';
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B');
		
		//----------- processing nominatif here ------
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$th=$_GET['th'];
	$th1=$th-4;$th11=$th-5;
	$th2=$th-5;$th21=$th-6;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m");//."-".date("d");

	
?>
<b>NOMINATIF KENAIKAN PANGKAT REGULER PERIODE <?=$namabl?> <?=$th?>
    <div style="text-align: right; float: right;">UNIT KERJA : 
<?php if ($unitkerja!='all') {
	if (strlen($unitkerja)==2) echo lokasiKerjaB($unitkerja);
	else echo sublokasiKerjaB($unitkerja);}
else {echo "SEMUA UNIT KERJA";}?><br><?= $subuk!='' && $subuk!='all' ? ( $hasupt ? sublokasiKerjaB($unitkerja,$subuk,'00','00','00') : sublokasiKerjaB($subuk)) : ""?></div></b>
<table class="table table-bordered table-stripped table-hover" id="table_data_no">
    <thead>
        <tr>
            <th width="3%">NO</th>
            <th width="10%">NIP</th>
            <th width="10%">NIP BARU</th>
            <th width="20%" class="left">NAMA</th>
            <th width="30%" class="left">JABATAN</th>
            <th width="5%">ESEL</th>
            <th width="7%">PKT&nbsp;LAMA</th>
            <th width="7%">PKT&nbsp;BARU</th>
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
        $z=0;
        //$query .="order by I_06 ASC, F_03 DESC";
        //echo $q.'  limit '.$offset.', '.$limit;
        $query="select * from MASTFIP08 where ";
	if ($unitkerja!='all') {
		if (strlen($unitkerja)==2) $query.="A_01='".$unitkerja."' ";
		else $query.="A_01='".substr($unitkerja,0,2)."' and A_02='".substr($unitkerja,2,2)."' and A_03='".substr($unitkerja,4,2)."' ";
	}
	else $query.="A_01!='99' ";

	if ($subuk!='' && $subuk!='all') {
		if ($hasupt) $query.="and A_02='$subuk' ";
		else $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
	}
	
	if ($_GET['bln']=='4') {
		$namabl="APRIL";
		$query.="and ((substring(F_TMT,6,2) in ('11','12') and substring(F_TMT,1,4)='".$th2."') or (substring(F_TMT,6,2) in ('01','02','03','04') and substring(F_TMT,1,4)='".$th1."')) ";
	} else {
		$namabln="OKTOBER";
		$query.="and (substring(F_TMT,6,2) in ('05','06','07','08','09','10') and substring(F_TMT,1,4)='".$th1."') ";
	}

	$query.="and (";
	$query.="(H_1A='10' and F_03<'21') or (H_1A='20' and F_03<'23') or ((H_1A='30' or H_1A='41' or H_1A='42') and F_03<'32') or ";
	$query.="((H_1A='43' or H_1A='50' or H_1A='60') and F_03<'33') or ";
	$query.="(((H_1A='70' and H_1B not in ('2304','2305','2306','2307','2308','2309','2311','2312','2313','2314','2315','3013','3058')) or H_1A='44') and F_03<'34') or ";
	$query.="(((H_1A='70' and H_1B in ('2304','2305','2306','2307','2308','2309','2311','2312','2313','2314','2315','3013','3058')) or H_1A='80') and F_03<'41') or ";
	$query.="(H_1A='90' and F_03<'42')";
	$query.=") ";
	$query.="order by F_03 DESC,F_TMT ASC, I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
	$no=0;
        //echo $query;
	$r=mysql_query($query.'  limit '.$offset.', '.$limit) or die (mysql_error());
        $total_data = mysql_num_rows(mysql_query($query));
        while ($row=mysql_fetch_array($r)) {
                $no++;
                $z++;
                $pkt_l=array_search($row[F_03],$pangkat);
                $pkt_b=$pkt_l+1;
        ?>
          <tr class="<?= ($no%2 === 0)?'odd':'even' ?>">
            <td valign="top" class="isinya nowrap" align="center"><?=$no+$offset?></td>
            <td valign="top" class="isinya nowrap" align="center"><?=$row[B_02]?></td>
            <td valign="top" class="isinya nowrap" align="center"><?=format_nip_baru($row[B_02B])?></td>
            <td valign="top"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
            <td valign="top"><small><?= ucwords(strtolower(getNaJab($row[B_02])))?></small></td>
            <td valign="top" class="isinya nowrap" align="center"><?=eselon($row[I_06])?></td>
            <td valign="top" align="center"><?=pktH($row[F_03])?></td>
            <td valign="top" align="center"><?=pktH($pangkat[$pkt_b])?></td>
          </tr>
        <? } ?>
    </tbody>
</table>
<?= page_summary($total_data, $page, $limit) ?>
<?= paging_ajax($total_data, $limit, $page, '1', $_GET['search']) ?>
<? } ?>