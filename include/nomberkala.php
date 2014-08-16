<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$qcu="select distinct A_02 from MASTFIP08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
if ($tahun=='') $tahun=date("Y");
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
            window.open('include/i_nomberkala.htm?bln=<?=$bln?>&tahun=<?=$tahun?>&unitkerja=<?=$uk?>&subuk=<?=$subuk?>','myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
</script>

<h4 class="title">NOMINATIF KENAIKAN GAJI BERKALA</h4>
    <form name="nominatif1" action="?sid=<?=$sid?>&do=berkala" method="post">
      <table width="100%">
        <tr> 
          <td width="15%" align="left">Bulan:</td>
          <td width="610" align="left"><select name="bln" id="bln" class="form-control-static">
			<option value="1" <?= $bln=='1' ? "selected" : ""?>>Januari</option>
			<option value="2" <?= $bln=='2' ? "selected" : ""?>>Pebruari</option>
			<option value="3" <?= $bln=='3' ? "selected" : ""?>>Maret</option>
			<option value="4" <?= $bln=='4' ? "selected" : ""?>>April</option>
			<option value="5" <?= $bln=='5' ? "selected" : ""?>>Mei</option>
			<option value="6" <?= $bln=='6' ? "selected" : ""?>>Juni</option>
			<option value="7" <?= $bln=='7' ? "selected" : ""?>>Juli</option>
			<option value="8" <?= $bln=='8' ? "selected" : ""?>>Agustus</option>
			<option value="9" <?= $bln=='9' ? "selected" : ""?>>September</option>
			<option value="10" <?= $bln=='10' ? "selected" : ""?>>Oktober</option>
			<option value="11" <?= $bln=='11' ? "selected" : ""?>>Nopember</option>
			<option value="12" <?= $bln=='12' ? "selected" : ""?>>Desember</option>
			</select> <input type="text" name="tahun" value="<?=$tahun?>" class="form-control-static"></td>
        </tr>
        <tr>
          <td>Sub Unit Kerja</td>
          <td>
            <select name="uk" id="uk" class="form-control-static">
            <option value="all">Semua</option>
        <?
        $rupt=listUnitKerja();
        foreach ($rupt as $key=>$value) {
        ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=$value[1]?></option>
        <? } ?>
            </select>
          </td>
        </tr>
        <tr >
        <td height="10" valign="top">&nbsp;</td>
        <td height="10" valign="top">
          <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
          <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
        </td>
      </tr>
      </table>
</form>
<table>
<?
$thskr=$tahun-56;
$thskr1=$tahun-60;
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

$result=mysql_query($query) or die (mysql_error());
$jrec=mysql_num_rows($result);
?>
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
                <td width="60" align="center"><strong>GOL/<br>RNG</strong></td>
                <td width="155" align="center"><b>GAJI LAMA</b></td>
                <td width="142" align="center"><b>GAJI BARU</b></td>
              </tr>
<?
$no=0;
while ($row=mysql_fetch_array($result)) {
	$no++;
	$thmker=substr($row[G_02],0,2);
	$thmker2=$thmker+2;
?>
              <tr>
                <td width="23" valign="top" align="right"><?=$no; ?></td>
                <td width="110" valign="top"><a href="?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=$row[B_02]?></a></td>
                <td width="182" valign="top"><b><?=format_nip_baru($row[B_02B])?></b></td>
                <td width="205" valign="top"><a href="?&sid=<?=$sid; ?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B]) ?></a></td>
                <td width="469" valign="top"><?= getNaJab($row[B_02])?></td>
                <td width="39" valign="top" align="center"><?= $row[I_06]=='99' ? "-" : eselon($row[I_06])?></td>
                <td width="60" valign="top" align="center"><?=pktH($row[F_03])?></td>
                <td width="155" valign="top" align="center"><?=number_format(gaji($row[F_03],$thmker))?></td>
                <td width="142" valign="top" align="center"><?=number_format(gaji($row[F_03],$thmker2))?></td>
              </tr>
<? } ?>
            </table>
<? } ?>
          </td>
        </tr>
</table>