<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!$urut) $urut='pkt';

$qcu="select distinct A_02 from TABLOKB08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td colspan="2" align="right" valign="top"></td>
        </tr>
        <tr> 
          <td colspan="2" class="componentheading">EXPORT DATA PEGAWAI UNTUK WEB BKD</td>
        </tr>
        <tr> 
          <td colspan="2" align="right"></td>
        </tr>
        <form name="nominatif1" action="?sid=<?=$sid?>&do=expor" method="post">
          <tr> 
          <td width="175" align="left" height="12"> Golongan</td>
          <td width="610" align="left">
            <select name="gol1" >
              <option value="11" <? if ($gol1=='11') echo "selected"; ?>>I/a</option>
              <option value="12" <? if ($gol1=='12') echo "selected"; ?>>I/b</option>
              <option value="13" <? if ($gol1=='13') echo "selected"; ?>>I/c</option>
              <option value="14" <? if ($gol1=='14') echo "selected"; ?>>I/d</option>
              <option value="21" <? if ($gol1=='21') echo "selected"; ?>>II/a</option>
              <option value="22" <? if ($gol1=='22') echo "selected"; ?>>II/b</option>
              <option value="23" <? if ($gol1=='23') echo "selected"; ?>>II/c</option>
              <option value="24" <? if ($gol1=='24') echo "selected"; ?>>II/d</option>
              <option value="31" <? if ($gol1=='31') echo "selected"; ?>>III/a</option>
              <option value="32" <? if ($gol1=='32') echo "selected"; ?>>III/b</option>
              <option value="33" <? if ($gol1=='33') echo "selected"; ?>>III/c</option>
              <option value="34" <? if ($gol1=='34') echo "selected"; ?>>III/d</option>
              <option value="41" <? if ($gol1=='41') echo "selected"; ?>>IV/a</option>
              <option value="42" <? if ($gol1=='42') echo "selected"; ?>>IV/b</option>
              <option value="43" <? if ($gol1=='43') echo "selected"; ?>>IV/c</option>
              <option value="44" <? if ($gol1=='44') echo "selected"; ?>>IV/d</option>
              <option value="45" <? if ($gol1=='45') echo "selected"; ?>>IV/e</option>
            </select>
s/d
<select name="gol2" >
  <option value="11" <? if ($gol2=='11') echo "selected"; ?>>I/a</option>
  <option value="12" <? if ($gol2=='12') echo "selected"; ?>>I/b</option>
  <option value="13" <? if ($gol2=='13') echo "selected"; ?>>I/c</option>
  <option value="14" <? if ($gol2=='14') echo "selected"; ?>>I/d</option>
  <option value="21" <? if ($gol2=='21') echo "selected"; ?>>II/a</option>
  <option value="22" <? if ($gol2=='22') echo "selected"; ?>>II/b</option>
  <option value="23" <? if ($gol2=='23') echo "selected"; ?>>II/c</option>
  <option value="24" <? if ($gol2=='24') echo "selected"; ?>>II/d</option>
  <option value="31" <? if ($gol2=='31') echo "selected"; ?>>III/a</option>
  <option value="32" <? if ($gol2=='32') echo "selected"; ?>>III/b</option>
  <option value="33" <? if ($gol2=='33') echo "selected"; ?>>III/c</option>
  <option value="34" <? if ($gol2=='34') echo "selected"; ?>>III/d</option>
  <option value="41" <? if ($gol2=='41') echo "selected"; ?>>IV/a</option>
  <option value="42" <? if ($gol2=='42') echo "selected"; ?>>IV/b</option>
  <option value="43" <? if ($gol2=='43') echo "selected"; ?>>IV/c</option>
  <option value="44" <? if ($gol2=='44') echo "selected"; ?>>IV/d</option>
  <option value="45" <? if ($gol2=='45') echo "selected"; ?>>IV/e</option>
</select>
&nbsp;

<input type="radio" name="radio1" value="1" class="radio1" <? if ($radio1==1) echo "checked"; ?>>
keatas&nbsp;
<input type="radio" name="radio1" value="2" class="radio1" <? if ($radio1==2) echo "checked"; ?>>
kebawah
<input type="radio" name="radio1" value="3" class="radio1" <? if ($radio1==3) echo "checked"; ?>>
antara&nbsp;&nbsp;&nbsp;</td>
          </tr>
        <tr> 
          <td width="175" align="left">Eselon</td>
          <td width="610" align="left">
            <select name="eselon" >
              <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua</option>
              <option value="str" <? if ($eselon=='str') echo "selected" ; ?>>Struktural</option>
              <option value="11" <? if ($eselon=='11') echo "selected" ; ?>>1A</option>
              <option value="12" <? if ($eselon=='12') echo "selected" ; ?>>1B</option>
              <option value="2" <? if ($eselon=='2') echo "selected" ; ?>>2</option>
              <option value="21" <? if ($eselon=='21') echo "selected" ; ?>>2A</option>
              <option value="22" <? if ($eselon=='22') echo "selected" ; ?>>2B</option>
              <option value="3" <? if ($eselon=='3') echo "selected" ; ?>>3</option>
              <option value="31" <? if ($eselon=='31') echo "selected" ; ?>>3A</option>
              <option value="32" <? if ($eselon=='32') echo "selected" ; ?>>3B</option>
              <option value="4" <? if ($eselon=='4') echo "selected" ; ?>>4</option>
              <option value="41" <? if ($eselon=='41') echo "selected" ; ?>>4A</option>
              <option value="42" <? if ($eselon=='42') echo "selected" ; ?>>4B</option>
		  <option value="51" <? if ($eselon=='51') echo "selected" ; ?>>5A</option>

            </select>
&nbsp;&nbsp;
	</td>
        </tr>
        <tr> 
          <td width="175" align="left">Status Kepegawaian</td>
          <td width="610" align="left">
            <select name="status" >
              <option value="all" <? if ($status=='all') echo "selected" ; ?>>Semua</option>
              <option value="1" <? if ($status=='1') echo "selected" ; ?>>CPNS</option>
              <option value="2" <? if ($status=='2') echo "selected" ; ?>>PNS</option>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="175" align="left">Jabatan</td>
          <td width="610" align="left">
            <select name="jabatan" onchange="nominatif1.submit();">
              <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua</option>
              <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
              <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
              <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
            </select>
          </td>
        </tr>
	<? if ($jabatan=='2') { ?>
        <tr> 
          <td width="175" align="left">Jabatan Fungsional</td>
          <td width="610" align="left">
            <select name="jabfung">
              <option value="">Semua</option>
		<?
		$qfung="select * from TABFNG1 order by NFUNG";
		$rfung=mysql_query($qfung) or die(mysql_error());
		while ($rofung=mysql_fetch_array($rfung)) {
		?>
		<option value="<?=$rofung[KFUNG]?>" <?= $jabfung==$rofung[KFUNG] ? "selected" : ""?>><?=$rofung[NFUNG]?></option> 
		<? } ?>
            </select>
          </td>
        </tr>
	<? } ?>
        <tr>
          <td width="175" align="left">Diklat</td>
          <td width="610" align="left">
            <select name="diklat" >
              <option value="all" <? if ($diklat=='all') echo "selected" ; ?>>Semua</option>
              <option value="1" <? if ($diklat=='1') echo "selected" ; ?>>LEMHANAS</option>
              <option value="2" <? if ($diklat=='2') echo "selected" ; ?>>SESPA/SEPAMEN</option>
              <option value="3" <? if ($diklat=='3') echo "selected" ; ?>>SEPADYA/SPAMA</option>
              <option value="4" <? if ($diklat=='4') echo "selected" ; ?>>SEPALA/ADUMLA</option>
              <option value="5" <? if ($diklat=='5') echo "selected" ; ?>>SEPADA/ADUM</option>
              <option value="6" <? if ($diklat=='6') echo "selected" ; ?>>DIKLATPIM
              Tk.I</option>
              <option value="7" <? if ($diklat=='7') echo "selected" ; ?>>DIKLATPIM
              Tk.II</option>
              <option value="8" <? if ($diklat=='8') echo "selected" ; ?>>DIKLATPIM
              Tk.III</option>
              <option value="9" <? if ($diklat=='9') echo "selected" ; ?>>DIKLATPIM
              Tk.IV</option>
              <option value="10" <? if ($diklat=='10') echo "selected" ; ?>>DIKLATPIM
              PEMDA</option>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="175" align="left">Jenis
                  Kelamin</td>
          <td width="610" align="left">
            <select name="kelamin" >
              <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua</option>
              <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
              <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="175" align="left">Agama</td>
          <td width="610" align="left">
            <select name="agama" >
              <option value="all" <? if ($agama=='all') echo "selected" ; ?>>Semua</option>
              <option value="1" <? if ($agama=='1') echo "selected" ; ?>>Islam</option>
              <option value="2" <? if ($agama=='2') echo "selected" ; ?>>Kristen</option>
              <option value="3" <? if ($agama=='3') echo "selected" ; ?>>Katholik</option>
              <option value="4" <? if ($agama=='4') echo "selected" ; ?>>Hindu</option>
              <option value="5" <? if ($agama=='5') echo "selected" ; ?>>Budha</option>
            </select>
          </td>
        </tr>
        <tr> 
          <td width="175" align="left">Pendidikan</td>
          <td width="610" align="left">
            <select name="dik" onchange="nominatif1.submit();">
              <option value="all" <? if ($dik=='all') echo "selected" ; ?>>Semua</option>
              <option value="10" <? if ($dik=='10') echo "selected" ; ?>>SD</option>
              <option value="20" <? if ($dik=='20') echo "selected" ; ?>>SMP</option>
              <option value="30" <? if ($dik=='30') echo "selected" ; ?>>SMA</option>
              <option value="41" <? if ($dik=='41') echo "selected" ; ?>>DIPLOMA
              I</option>
              <option value="42" <? if ($dik=='42') echo "selected" ; ?>>DIPLOMA
              II</option>
              <option value="43" <? if ($dik=='43') echo "selected" ; ?>>DIPLOMA
              III</option>
              <option value="44" <? if ($dik=='44') echo "selected" ; ?>>DIPLOMA
              IV</option>
              <option value="50" <? if ($dik=='50') echo "selected" ; ?>>SARMUD
              NON AKADEMI</option>
              <option value="60" <? if ($dik=='60') echo "selected" ; ?>>SARMUD
              AKADEMI</option>
              <option value="70" <? if ($dik=='70') echo "selected" ; ?>>S 1</option>
              <option value="80" <? if ($dik=='80') echo "selected" ; ?>>S 2</option>
              <option value="90" <? if ($dik=='90') echo "selected" ; ?>>S 3</option>
            </select>
          </td>
        </tr>
	<? if ($dik!='all') { ?>
        <tr> 
          <td width="175" align="left">Jurusan</td>
          <td width="610" align="left">
            <select name="jur">
              <option value="">Semua</option>
		<?
		$qj="select * from TABDIK".$dik." order by ket";
		$rj=mysql_query($qj);
		while ($roj=mysql_fetch_array($rj)) {
		?>
		<option value="<?=$roj[kod]?>" <?=$roj[kod]==$jur ? "selected": ""?>><?=$roj[ket]?></option>
		<? } ?>
            </select>
          </td>
        </tr>
	<? } ?>
        <tr>
          <td>Unit Kerja</td>
          <td>
            <select name="uk" onchange="nominatif1.submit();">
            <option value="all">Semua</option>
            <?
	    $quk="select * from tablok08 order by kd";
	    $ruk=mysql_query($quk) or die(mysql_error());
            while ($rouk=mysql_fetch_array($ruk)) {
			?>
			<option value="<?=$rouk[kd]?>" <?= $rouk[kd]==$uk ? "selected" : ""?>><?=$rouk[nm]?></option>
			<? } ?>
            </select></td>
        </tr>
<? if ($hasupt) { ?>
        <tr>
          <td>Induk/UPT</td>
          <td>
            <select name="subuk" >
            <option value="all">Semua</option>
            <option value="00" <? if ($subuk=='00') echo "selected "?>>INDUK</option>
        <?
        $qupt="select * from TABLOKB08 where A_01='$uk' and A_02<>'00' and A_03 like '00' and A_04 like '00' order by A_02";
        $rupt=mysql_query($qupt) or die(mysql_error());
        while ($roupt=mysql_fetch_array($rupt)) {
			?>
			<option value="<?=$roupt[A_02]?>" <?= $roupt[A_02]==$subuk ? "selected" : ""?>><?=$roupt[NALOK]?></option>
			<? } ?>
            </select>
          </td>
        </tr>
<? } else { ?>
        <tr>
          <td>Sub Unit Kerja</td>
          <td>
            <select name="subuk" >
            <option value="all">Semua</option>
        <?
        $rupt=listSubUnitKerja($uk);
        foreach ($rupt as $key=>$value) {
                        ?>
                        <option value="<?=$value[0]?>" <?= $value[0]==$subuk ? "selected" : ""?>><?=$value[1]?></option>
                        <? } ?>
            </select>
          </td>
        </tr>
<? }?>
        <tr>
          <td>Urut</td>
          <td>
	  <input type="radio" name="urut" value="pkt" <?= $urut=='pkt'? "checked" : ""?>>Pangkat
	  <input type="radio" name="urut" value="str" <?= $urut=='str'? "checked" : ""?>>Struktur Org
          </td>
        </tr>

        <tr >
        <td height="10" valign="top">&nbsp;</td>
        <td height="10" valign="top"><strong>
          <input type="submit" name="cari" value="Cari" class="tombol">
          <input type="button" class="tombol" value="Cetak" name="cetak" onClick="window.open('include/expor.html?gol1=<?=$gol1?>&gol2=<?=$gol2?>&radio1=<?=$radio1?>&status=<?=$status?>&eselon=<?=$eselon?>&jabatan=<?=$jabatan?>&jabfung=<?=$jabfung?>&dik=<?=$dik?>&jur=<?=$jur?>&diklat=<?=$diklat?>&kelamin=<?=$kelamin?>&agama=<?=$agama?>&unitkerja=<?=$uk?>&subuk=<?=$subuk?>&urut=<?=$urut?>','myPoppp'/*,'WIDTH=800, HEIGHT=600, SCROLLBARS=YES, MENUBAR=YES'*/)">
        </strong></td>
      </tr>
		</form>
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-60;
$tglok=$thskr."-".date("m");//."-".date("d");
$tglok1=$thskr1."-".date("m");//."-".date("d");

$query="select * from MASTFIP08 where 1 ";
if ($uk!='all') {
	if (strlen($uk)==2) $query.="and A_01='".$uk."' ";
	else $query.="and A_01='".substr($uk,0,2)."' and A_02='".substr($uk,2,2)."' and A_03='".substr($uk,4,2)."' ";
} else $query.="and A_01<>'99' ";

if ($subuk!='' && $subuk!='all') {
	if ($hasupt) $query.="and A_02='$subuk' ";
	else $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".rtrim($subuk,'0')."%' ";
}

if ($radio1=='') $radio1=1;
switch($radio1) {
	case 1: $query.="and F_03 >= '" . $gol1. "' ";break;
	case 2: $query.="and F_03 <= '" . $gol1. "' ";break;
	case 3: $query.="and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";break;
}

if ($status!='all') {
	$query.="and B_09='$status' ";
}
if ($jabatan!='all') {
	if ($jabatan==2) $query.="and (I_5A='2' or I_5A='4') ";
	else $query.="and I_5A='$jabatan' ";
}
if ($jabfung!='') {
	$query.="and (I_5A='2' or I_5A='4') and I_05='$jabfung' ";
}
if ($eselon!='all' && $eselon!='str') {
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
if ($urut=='str') $query.="order by I_05 ";
else $query.="order by F_03 DESC,F_TMT ASC,I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";

$result=mysql_query($query) or die (mysql_error());
$jrec=mysql_num_rows($result);
?>
      
      <tr > 
          <td height="10" colspan="2" valign="top">
          Hasil : <? echo $jrec; ?> Record
        </td>
        </tr>
  
        <tr> 
          <td colspan="2" valign="top"> 
		  <? if ($cari) { ?>
            <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#000000" class="moduletable" style="border-collapse: collapse">
              <tr bgcolor="#CCCCCC">
                <td width="23" align="center"><strong>
                No</strong></td>
                <td width="150" align="center"><strong>
                NIP</strong></td>
                <td width="238" align="center"><strong>
                NAMA</strong></td>
                <td width="75" align="center"><strong>
                TGL LHR</strong></td>
                <td width="285" align="center"><strong>
                JABATAN</strong></td>
                <td align="center" colspan="3"><strong>
                UNIT KERJA</strong></td>
                <td width="26" align="center"><strong>
                Esl</strong></td>
                <td width="33" align="center"><strong>
                GOL/<br>
                RNG</strong></td>
              </tr>
<?
$no=0;

while ($row=mysql_fetch_array($result)) {
	$no++;	
?>
              <tr>
                <td width="23" valign="top" align="right"><?=$no; ?></td>
                <td width="150" valign="top"><a href="?&sid=<?=$sid?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?= $row[B_02B]=='' ? $row[B_02] : format_nip_baru($row[B_02B])?></a></td>
                <td width="238" valign="top">
                  <a href="?&sid=<?=$sid; ?>&do=cari&cari=1&nip=<?=$row[B_02]?>"><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B]) ?></a></td>
                <td width="75" align="center" valign="top"><?=format_tanggal($row[B_05]); ?></td>
                <td width="285" valign="top"><?= getNaJab($row[B_02])?></td>
                <td width="285" valign="top"><?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03].$row[A_04])?></td>
                <td width="285" valign="top"><?=subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03])?></td>
                <td width="285" valign="top"><?=lokasiKerjaB($row[A_01])?></td>
                <td width="26" valign="top" align="center">
                <?= $row[I_06]=='99' ? "-" : eselon($row[I_06])?>
                </td>
                <td width="33" valign="top" align="center">
                <?=pktH($row[F_03])?></td>
              </tr>
<? } ?>
            </table>
<? } ?>
          </td>
        </tr>
</table>
