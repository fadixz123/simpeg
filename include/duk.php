<?php
include('include/fungsi.inc');

$tglskr=date("Y");
$pensiun=($tglskr-56)."-".date("m");
$pensiun1=($tglskr-61)."-".date("m")."-".date("d");
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
            window.open('include/cetak_duk.php?starthal=<?=$starthal?>&stophal=<?=$stophal?>&akhir=<?=$akhir?>&A_01=<?=$unitkerja?>&eselon='+cetakDUK.eselon.value+'&jabatan='+cetakDUK.jabatan.value+'&kelamin='+cetakDUK.kelamin.value+'&agama='+cetakDUK.agama.value+'&GOL1='+cetakDUK.gol1.value+'&GOL2='+cetakDUK.gol2.value+'','myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
        });
        
    });
</script>
<h4 class="title">DAFTAR URUT KEPANGKATAN</h4>
<form name="cetakDUK">
<table width="100%">
          <?
          if ($gol1=='') $gol1='11';
          ?>
          <tr>
            <td width="15%">Golongan Antara:</td>
            <td width="603">
              <select name="gol1" id="gol1" class="form-control-static" onChange="window.location='index.htm?do=duk&sid=<?=$sid?>&sid2=<?=$myid?>&gol1='+this.value+''">
                <option value="45" <? if ($gol1=='45') echo "selected"; ?>>IV/e</option>
                <option value="44" <? if ($gol1=='44') echo "selected"; ?>>IV/d</option>
                <option value="43" <? if ($gol1=='43') echo "selected"; ?>>IV/c</option>
                <option value="42" <? if ($gol1=='42') echo "selected"; ?>>IV/b</option>
                <option value="41" <? if ($gol1=='41') echo "selected"; ?>>IV/a</option>
                <option value="34" <? if ($gol1=='34') echo "selected"; ?>>III/d</option>
                <option value="33" <? if ($gol1=='33') echo "selected"; ?>>III/c</option>
                <option value="32" <? if ($gol1=='32') echo "selected"; ?>>III/b</option>
                <option value="31" <? if ($gol1=='31') echo "selected"; ?>>III/a</option>
                <option value="24" <? if ($gol1=='24') echo "selected"; ?>>II/d</option>
                <option value="23" <? if ($gol1=='23') echo "selected"; ?>>II/c</option>
                <option value="22" <? if ($gol1=='22') echo "selected"; ?>>II/b</option>
                <option value="21" <? if ($gol1=='21') echo "selected"; ?>>II/a</option>
                <option value="14" <? if ($gol1=='14') echo "selected"; ?>>I/d</option>
                <option value="13" <? if ($gol1=='13') echo "selected"; ?>>I/c</option>
                <option value="12" <? if ($gol1=='12') echo "selected"; ?>>I/b</option>
                <option value="11" <? if ($gol1=='11') echo "selected"; ?>>I/a</option>
              </select>
			s/d
			<select name="gol2" id="gol2" class="form-control-static" onChange="window.location='index.htm?do=duk&sid=<?=$sid?>&sid2=<?=$myid?>&gol1=<?=$gol1?>&gol2='+this.value+''">
			  <option value="45" <? if ($gol2=='45') echo "selected"; ?>>IV/e</option>
			  <option value="44" <? if ($gol2=='44') echo "selected"; ?>>IV/d</option>
			  <option value="43" <? if ($gol2=='43') echo "selected"; ?>>IV/c</option>
			  <option value="42" <? if ($gol2=='42') echo "selected"; ?>>IV/b</option>
			  <option value="41" <? if ($gol2=='41') echo "selected"; ?>>IV/a</option>
			  <option value="34" <? if ($gol2=='34') echo "selected"; ?>>III/d</option>
			  <option value="33" <? if ($gol2=='33') echo "selected"; ?>>III/c</option>
			  <option value="32" <? if ($gol2=='32') echo "selected"; ?>>III/b</option>
			  <option value="31" <? if ($gol2=='31') echo "selected"; ?>>III/a</option>
			  <option value="24" <? if ($gol2=='24') echo "selected"; ?>>II/d</option>
			  <option value="23" <? if ($gol2=='23') echo "selected"; ?>>II/c</option>
			  <option value="22" <? if ($gol2=='22') echo "selected"; ?>>II/b</option>
			  <option value="21" <? if ($gol2=='21') echo "selected"; ?>>II/a</option>
			  <option value="14" <? if ($gol2=='14') echo "selected"; ?>>I/d</option>
			  <option value="13" <? if ($gol2=='13') echo "selected"; ?>>I/c</option>
			  <option value="12" <? if ($gol2=='12') echo "selected"; ?>>I/b</option>
			  <option value="11" <? if ($gol2=='11') echo "selected"; ?>>I/a</option>
			</select></td>
			</tr>
<?
if ($gol1=='') $gol1='11';
if ($gol2=='') $gol2='45';
?>
<tr>
  <td>Unit Kerja:</td>
  <td><select name="uk" id="uk" class="form-control-static" onChange="window.location='index.htm?sid=<?=$sid?>&do=duk&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja='+this.value+''">
    <option value="">Pilih...</option>
    <option value="xx" <?= $unitkerja=='xx' ? "selected" : ""?>>Semua Unit Kerja</option>
    <?
    $lsuk=listUnitKerja();
    foreach($lsuk as $key=>$value) {
    ?>
    <option value="<?=$value[0]?>" <?= $value[0]==$unitkerja ? "selected" : ""?>><?=  ucwords(strtolower($value[1]))?></option>
    <? } ?>
  </select>
  </td>
</tr>
        <tr valign="top">
          <td align="left">Eselon:
          <td align="left"><select name="eselon" id="eselon" class="form-control-static" onChange="window.location='index.htm?sid=<?=$sid?>&do=duk&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja=<?=$unitkerja?>&uks=<?=$uks?>&eselon='+this.value+'&jabatan=<?=$jabatan?>&kelamin=<?=$kelamin?>&agama=<?=$agama?>'">
            <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua...</option>
            <option value="str" <? if ($eselon=='str') echo "selected" ; ?>>Struktural</option>
            <option value="11" <? if ($eselon=='11') echo "selected" ; ?>>1A</option>
            <option value="12" <? if ($eselon=='12') echo "selected" ; ?>>1B</option>
            <option value="21" <? if ($eselon=='21') echo "selected" ; ?>>2A</option>
            <option value="22" <? if ($eselon=='22') echo "selected" ; ?>>2B</option>
            <option value="31" <? if ($eselon=='31') echo "selected" ; ?>>3A</option>
            <option value="32" <? if ($eselon=='32') echo "selected" ; ?>>3B</option>
            <option value="41" <? if ($eselon=='41') echo "selected" ; ?>>4A</option>
            <option value="42" <? if ($eselon=='42') echo "selected" ; ?>>4B</option>
          </select>          
        <tr valign="top">
          <td align="left">Jabatan:</td>
          <td align="left"><select name="jabatan" id="jabatan" class="form-control-static" onChange="window.location='index.htm?sid=<?=$sid?>&do=duk&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja=<?=$unitkerja?>&uks=<?=$uks?>&eselon=<?=$eselon?>&jabatan='+this.value+'&kelamin=<?=$kelamin?>&agama=<?=$agama?>'">
            <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua...</option>
            <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
            <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
            <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
          </select></td>
        </tr>
        <tr valign="top">
          <td align="left">Jenis Kelamin:</td>
          <td align="left"><select name="kelamin" id="kelamin" class="form-control-static" onChange="window.location='index.htm?sid=<?=$sid?>&do=duk&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja=<?=$unitkerja?>&uks=<?=$uks?>&eselon=<?=$eselon?>&jabatan=<?=$jabatan?>&kelamin='+this.value+'&agama=<?=$agama?>'">
            <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
            <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
          </select></td>
        </tr>
        <tr valign="top">
          <td align="left">Agama:</td>
          <td align="left"><select name="agama" id="agama" class="form-control-static" onChange="window.location='index.htm?sid=<?=$sid?>&do=duk&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja=<?=$unitkerja?>&uks=<?=$uks?>&eselon=<?=$eselon?>&jabatan=<?=$jabatan?>&kelamin=<?=$kelamin?>&agama='+this.value+''">
            <option value="all" <? if ($agama=='all') echo "selected" ; ?>>Semua...</option>
            <option value="1" <? if ($agama=='1') echo "selected" ; ?>>Islam</option>
            <option value="2" <? if ($agama=='2') echo "selected" ; ?>>Kristen</option>
            <option value="3" <? if ($agama=='3') echo "selected" ; ?>>Katholik</option>
            <option value="4" <? if ($agama=='4') echo "selected" ; ?>>Hindu</option>
            <option value="5" <? if ($agama=='5') echo "selected" ; ?>>Budha</option>
          </select></td>
        </tr>
 
<?
if ($starthal=='') $starthal=1;
if ($stophal =='') $stophal=$starthal;

if ($unitkerja !='')
{
if ($unitkerja == 'xx'){
$Q="select count(*) as Jumlah from MASTFIP08 where A_01 !='99' and A_01 !='' ";
}else{
if (strlen($unitkerja)==2) $Q="select count(*) as Jumlah from MASTFIP08 where A_01 ='$unitkerja' ";
else $Q="select count(*) as Jumlah from MASTFIP08 where A_01 ='".substr($unitkerja,0,2)."' and A_02 ='".substr($unitkerja,2,2)."' and A_03 ='".substr($unitkerja,4,2)."' ";
}
if ($jabatan!='' && $jabatan!='all') {
	if ($jabatan=='2') $query="and (I_5A='2' or I_5A='4') ";
	else $query.="and I_5A='$jabatan' ";
}
if ($eselon!='' && $eselon!='all' && $eselon!='str') {
        $query.="and I_06='$eselon' ";
}
if ($eselon=='str') {
        $query.="and I_06<>'99' and I_06 is not null ";
}
if ($kelamin!='' && $kelamin!='all') {
        $query.="and B_06='$kelamin' ";
}
if ($agama!='' && $agama!='all') {
        $query.="and B_07='$agama' ";
}
$Q.=$query;
$Q.="and F_03 >= '$gol1' and F_03 <= '$gol2' and B_09='2' order by F_03 DESC,F_TMT ASC,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC";

$row=mysql_fetch_array(mysql_query($Q));   

$akhir=$row[Jumlah];
if (intval($row[Jumlah]) <=21)
{
	$starthal=1;
	$stophal=1;
}
else
{
	$tothal=intval($row[Jumlah]);
	
	$sisa1 = $tothal - 21;
	if ($sisa1 <= 22)
	{
		$starthal=1;
		$stophal=2;
	}
	else
	{
		
		$sisa2=$sisa1 % 22;
		
		$halini= ($sisa1-$sisa2)/22;
		$starthal=1;
		$stophal=$halini +2;
		
	
	}

} 
  
}
?>
          <tr>
              <td></td>
            <td>
                <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
            </td>
          </tr>
</table>
</form>
