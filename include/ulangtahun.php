<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!isset($ultah) || $ultah=='') $ultah=0;
?>
<h4 class="title">NOMINATIF PNS YANG BERULANG TAHUN</h4>
<table width="100%">
	<td width="287" colspan="2"><form name="ultah1" action="index.htm?sid=<?=$sid?>&do=ulangtahun" method="post">
	<tr>
	<td width="15%">Cari PNS yang berulang tahun:
	</td>
	<td width="77%"> 
	<select name="ultah" id="ultah" class="form-control-static" onchange="ultah1.submit();">
	<option value="">Pilih</option>
	<option value="-5" <?= $ultah=='-5' ? "selected" : ""?>>5 Hari Lalu</option>
	<option value="-4" <?= $ultah=='-4' ? "selected" : ""?>>4 Hari Lalu</option>
	<option value="-3" <?= $ultah=='-3' ? "selected" : ""?>>3 Hari Lalu</option>
	<option value="-2" <?= $ultah=='-2' ? "selected" : ""?>>2 Hari Lalu</option>
	<option value="-1" <?= $ultah=='-1' ? "selected" : ""?>>Kemarin</option>
	<option value="0" <?= $ultah==='0' ? "selected" : ""?>>Hari Ini</option>
	<option value="1" <?= $ultah=='1' ? "selected" : ""?>>Besok</option>
	<option value="2" <?= $ultah=='2' ? "selected" : ""?>>2 Hari Lagi</option>
	<option value="3" <?= $ultah=='3' ? "selected" : ""?>>3 Hari Lagi</option>
	<option value="4" <?= $ultah=='4' ? "selected" : ""?>>4 Hari Lagi</option>
	<option value="5" <?= $ultah=='5' ? "selected" : ""?>>5 Hari Lagi</option>
	<option value="bl" <?= $ultah==='bl' ? "selected" : ""?>>Bulan Ini</option>
	<option value="bld" <?= $ultah==='bld' ? "selected" : ""?>>Bulan Depan</option>
	</select></td>
	</tr>
	<tr>
	<td width="23%">Unit Kerja:</td>
	<td width="77%">
            <select name="uk" id="uk" class="form-control-static" onchange="ultah1.submit();">
            <option value="all">Semua</option>
            <?
            $lsuk=listUnitKerja();
            foreach($lsuk as $key=>$value) {
			?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
			<? } ?>
            </select></td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	<td colspan="2">
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse: collapse">
		<tr bgcolor="#CCCCCC">
		<th width="4" ><div align="center">No</div></th>
		<th><div align="center">NIP</div></th>
		<th><div align="center">NAMA PNS</div></th>
		<th><div align="center">JABATAN</div></th>
		<th><div align="center">G/R</div></th>
		<th><div align="center">TGL LAHIR</div></th>
		</tr>
		<?
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
		$r=mysql_query($q) or die(mysql_error());
		$no=0;
		while ($row=mysql_fetch_array($r))
		{
				$no++;
			?>
			<tr>
			<td width="4"><? echo $no; ?>&nbsp;</td>
			<td><a href="index.htm?sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row['B_02']?>"><?=$row['B_02B']=='' ? $row[B_02] : format_nip_baru($row[B_02B])?></a>&nbsp;</td>
			<td><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?>&nbsp;</td>
			<td><? echo getNaJab($row[B_02]); ?>&nbsp;</td>
			<td><? echo pktH($row['F_03']); ?>&nbsp;</td>
			<td><? echo tanggalnya($row['B_05'],0); ?>&nbsp;</TD>
			</tr>
			<?
		}
		?>
	  </table>
</table>
