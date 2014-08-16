<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$pangkat=array('11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');

$qcu="select distinct A_02 from MASTFIP08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
if ($th=='') $th=date("Y");
?>
<script type="text/javascript">
    $(function() {
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nomkp.htm?bln=<?=$bln?>&th=<?=$th?>&unitkerja=<?=$uk?>&subuk=<?=$subuk?>','myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
</script>
<h4 class="title">NOMINATIF KENAIKAN PANGKAT REGULER</h4>
<form name="nominatif1" action="?sid=<?=$sid?>&do=kpreg" method="post">
      <table width="100%">
        <tr>
          <td colspan="2" align="right"></td>
        </tr>
        
        <tr> 
          <td width="15%" align="left">Bulan:</td>
          <td width="610" align="left"><select name="bln" id="bln" class="form-control-static">
			<option value="4" <?= $bln=='4' ? "selected" : ""?>>April</option>
			<option value="10" <?= $bln=='10' ? "selected" : ""?>>Oktober</option>
			</select> <input type="text" name="th" class="form-control-static" value="<?=$th?>"></td>
        </tr>
        <tr>
          <td>Unit Kerja:</td>
          <td>
            <select name="uk" id="uk" class="form-control">
            <option value="all">Semua</option>
        <?
        $rupt=listUnitKerja();
        foreach ($rupt as $key=>$value) {
        ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
        <? } ?>
            </select>
          </td>
        </tr>
        <tr >
        <td height="10" valign="top">&nbsp;</td>
        <td height="10" valign="top"><strong>
          <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
          <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        </strong></td>
      </tr>
        </table>
		</form>
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-60;
$th1=$th-4;$th11=$th-5;
$th2=$th-5;$th21=$th-6;
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

if ($bln=='4') {
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
$query.="order by F_03 DESC,F_TMT ASC,I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
//echo $query;
$result=mysql_query($query) or die (mysql_error());
$jrec=mysql_num_rows($result);
?>
        <table>
      <tr>
          <td height="10" colspan="2" valign="top">
          Hasil : <?=$jrec?> Record
        </td>
        </tr>
        <tr>
          <td colspan="2" valign="top"> 
		  <? if ($cari) { ?>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000" class="moduletable" style="border-collapse: collapse">
              <tr bgcolor="#CCCCCC">
                <td width="23" align="center"><strong>No</strong></td>
                <td width="110" align="center"><strong>NIP</strong></td>
                <td width="182" align="center"><b>NIP BARU</b></td>
                <td width="205" align="center"><strong>NAMA</strong></td>
                <td width="469" align="center"><strong>JABATAN</strong></td>
                <td width="39" align="center"><strong>Esl</strong></td>
                <td width="155" align="center"><b>PKT LAMA</b></td>
                <td width="142" align="center"><b>PKT BARU</b></td>
              </tr>
<?
$no=0;
while ($row=mysql_fetch_array($result)) {
	$no++;
	$pkt_l=array_search($row[F_03],$pangkat);
	$pkt_b=$pkt_l+1;
?>
              <tr>
                <td width="23" valign="top" align="right"><?=$no; ?></td>
                <td width="110" valign="top"><a href="?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=$row[B_02]?></a></td>
                <td width="182" valign="top"><b><?=format_nip_baru($row[B_02B])?></b></td>
                <td width="205" valign="top"><a href="?&sid=<?=$sid; ?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B]) ?></a></td>
                <td width="469" valign="top"><?= getNaJab($row[B_02])?></td>
                <td width="39" valign="top" align="center"><?= $row[I_06]=='99' ? "-" : eselon($row[I_06])?></td>
                <td width="155" valign="top" align="center"><?=pktH($row[F_03])?></td>
                <td width="142" valign="top" align="center"><?=pktH($pangkat[$pkt_b])?></td>
              </tr>
<? } ?>
            </table>
<? } ?>
          </td>
        </tr>
</table>