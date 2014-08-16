<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
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
            window.open('include/cetak_pensiun.php?pensiun=<?=$pensiun?>&jabatan=<?=$jabatan?>&eselon=<?=$eselon?>&uk=<?=$uk?>','pop','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
    });
</script>
<h4 class="title">NOMINATIF PNS YANG AKAN PENSIUN</h4>
<form name="pensiun" action="index.htm?sid=<?=$sid?>&do=pensiun" method="post">
<table width="100%">
	<tr>
	<td width="15%">Unit Kerja:</td>
	<td width="677"> 
	
            <select name="uk" id="uk" class="form-control-static">
            <option value="all">Semua...</option>
            <?
            $lsuk=listUnitKerja();
            foreach($lsuk as $key=>$value) {
			?>
			<option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=$value[1]?></option>
			<? } ?>
            </select></td>
	</tr>
	<tr>
	<td width="107">Pilih waktu: </td>
	<td width="677"> 
	<select name="pensiun" id="pensiun" class="form-control-static">
	<option value="5" <?if ($pensiun=='5') echo "selected"?>>LIMA TAHUN LAGI</option>
	<option value="4" <?if ($pensiun=='4') echo "selected"?>>EMPAT TAHUN LAGI</option>
	<option value="3" <?if ($pensiun=='3') echo "selected"?>>TIGA TAHUN LAGI</option>
	<option value="2" <?if ($pensiun=='2') echo "selected"?>>DUA TAHUN LAGI</option>
	<option value="1" <?if ($pensiun=='1') echo "selected"?>>SATU TAHUN LAGI</option>
	<option value="0" <?if ($pensiun=='0') echo "selected"?>>TAHUN INI</option>
	<option value="-1" <?if ($pensiun=='-1') echo "selected"?>>SATU TAHUN LALU</option>
	<option value="-2" <?if ($pensiun=='-2') echo "selected"?>>DUA TAHUN LALU</option>
	<option value="-3" <?if ($pensiun=='-3') echo "selected"?>>TIGA TAHUN LALU</option>
	<option value="-4" <?if ($pensiun=='-4') echo "selected"?>>EMPAT TAHUN LALU</option>
	<option value="-5" <?if ($pensiun=='-5') echo "selected"?>>LIMA TAHUN LALU</option>

	</select></td>
	</tr>
        <tr valign="top">
          <td width="107" align="left">Jabatan: </td>
          <td width="677" align="left">
            <select name="jabatan" id="jabatan" class="form-control-static">
            <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua...</option>
            <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
            <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
            <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
          </select></td></tr>
	  <tr valign="top">
          <td width="107" align="left">Eselon:</td>
          <td width="677" align="left">
            <select name="eselon" id="eselon" class="form-control-static">
            <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($eselon=='1') echo "selected" ; ?>>I</option>
            <option value="2" <? if ($eselon=='2') echo "selected" ; ?>>II</option>
            <option value="3" <? if ($eselon=='3') echo "selected" ; ?>>III</option>
            <option value="4" <? if ($eselon=='4') echo "selected" ; ?>>IV</option>
		</select>
	</td></tr>
	  <tr valign="top">
          <td width="107" align="left">Jenis Kelamin:</td>
          <td width="677" align="left">
            <select name="kelamin" id="kelamin" class="form-control-static">
            <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
            <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
		</select>
	</td></tr>
<!--	<tr>
	<td>Pilih bulan : 
	<select name="blpensiun" >
	<option value="00">PILIH BULAN</option>
	<option value="01">JANUARI</option>
	<option value="02">FEBRUARI</option>
	<option value="03">MARET</option>
	<option value="04">APRIL</option>
	<option value="05">MEI</option>
	<option value="06">JUNI</option>
	<option value="07">JULI</option>
	<option value="08">AGUSTUS</option>
	<option value="09">SEPTEMBER</option>
	<option value="10">OKTOBER</option>
	<option value="11">NOVEMBER</option>
	<option value="12">DESEMBER</option>
	</select>&nbsp;
	</td>
	</tr>-->
	<tr>
        <td></td>
	<td colspan="2">
            <button type="button" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
            <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
	</td>
	</tr>
</table>
<table>
	<tr>
	<td colspan="2">
	<?
	if ($btSubmitPensiun)
	{
		?>
		<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse: collapse">
		<tr bgcolor="#CCCCCC">
		<td width="4" ><div align="center">No</div></td>
		<td><div align="center">NIP</div></td>
		<td align="center">NIP BARU</td>
		<td><div align="center">NAMA PNS</div></td>
		<td><div align="center">JABATAN</div></td>
		<td><div align="center">G/R</div></td>
		<td><div align="center">TGL LAHIR</div></td>
		<td><div align="center">TMT PENSIUN</div></td>
		</tr>
		<?
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
if (substr($pensiun,0,1)!="-") $q.="and A_01<>'99' ";
if ($uk!='all') {
	if (strlen($uk)==2) $q.="and A_01='".$uk."' ";
	else $q.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
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
		//echo $q;
		$r=mysql_query($q);
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
			<tr>
			<td width="4"><? echo $no; ?>&nbsp;</td>
			<td><a href="index.htm?sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row['B_02']?>"><? echo $row['B_02']; ?></a>&nbsp;</td>
			<td><? echo $row['B_02B']; ?></td>
			<td><? echo namaPNS($row['B_03A'],$row['B_03'],$row['B_03B']); ?>&nbsp;</td>
			<td><? echo getNaJab($row[B_02]); ?>&nbsp;</td>
			<td><? echo pktH($row['F_03']); ?>&nbsp;</td>
			<td><? echo tanggalnya($row['B_05'],0); ?>&nbsp;</TD>
			<td><? echo "1-".$bltmt."-".$thtmt; ?>&nbsp;</td>
			</tr>
			<?
		}
		?>
	  </table>
		<?
	}
?>
</table>