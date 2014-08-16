<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
      <table width="638" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td width="638" align="right"></td>
        </tr>
        <tr> 
          <td width="638" align="right"><b></b></td>
        </tr>
        <tr> 
          <td align="right" width="510"></td>
        </tr>
        <form name="nominatif1" action="<? echo $PHP_SELF; ?>" method="get">
        <input type="hidden" name="do" value="nominatifa">
        <input type="hidden" name="sid" value="<? echo $sid; ?>">
        <tr> 
          <td width="638" align="left" valign="bottom" height="12" bgcolor="DDDDDD"><font face="Tahoma" size="1"><b><font size="2">
          &nbsp;Golongan </b>&nbsp; 
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
            <font face="Tahoma" size="2">s/d 
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
            <font face="Tahoma" size="2"> keatas&nbsp; 
            <input type="radio" name="radio1" value="2" class="radio1" <? if ($radio1==2) echo "checked"; ?>>
            <font size="2" face="Tahoma">kebawah  
            <input type="radio" name="radio1" value="3" class="radio1" <? if ($radio1==3) echo "checked"; ?>>
            <font face="Tahoma" size="2">antara&nbsp;<b>&nbsp;</b>&nbsp;</td>
        </tr>
        <tr valign="top"> 
          <td width="638" align="left">&nbsp;<font face="Tahoma" size="2"><b>Eselon 
            &nbsp;&nbsp;</b> 
            <select name="eselon" >
            <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua</option>
            <option value="str" <? if ($eselon=='str') echo "selected" ; ?>>Struktural</option>
            <option value="11" <? if ($eselon=='11') echo "selected" ; ?>>1A</option>
            <option value="12" <? if ($eselon=='12') echo "selected" ; ?>>1B</option>
            <option value="21" <? if ($eselon=='21') echo "selected" ; ?>>2A</option>
            <option value="22" <? if ($eselon=='22') echo "selected" ; ?>>2B</option>
            <option value="31" <? if ($eselon=='31') echo "selected" ; ?>>3A</option>
            <option value="32" <? if ($eselon=='32') echo "selected" ; ?>>3B</option>
            <option value="41" <? if ($eselon=='41') echo "selected" ; ?>>4A</option>
            <option value="42" <? if ($eselon=='42') echo "selected" ; ?>>4B</option>
	      <option value="51" <? if ($eselon=='51') echo "selected" ; ?>>5A</option>
            </select>&nbsp;&nbsp;<input type="checkbox" name="ignore" value="1" <?if ($ignore) echo "checked"?>>Termasuk usia pensiun</td></tr>
            &nbsp; 
        <tr valign="top"> 
          <td width="638" align="left" bgcolor="DDDDDD">&nbsp;<font face="Tahoma" size="2"><b>Jabatan 
            &nbsp;&nbsp;</b> 
            <select name="jabatan" >
            <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua</option>
            <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
            <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
            <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
            </select></td></tr>
        <tr valign="top">
          <td width="638" align="left">&nbsp;<font face="Tahoma" size="2"><b>Diklat
            &nbsp;&nbsp;</b>
            <select name="diklat" >
            <option value="all" <? if ($diklat=='all') echo "selected" ; ?>>Semua</option>
            <option value="1" <? if ($diklat=='1') echo "selected" ; ?>>LEMHANAS</option>
            <option value="2" <? if ($diklat=='2') echo "selected" ; ?>>SESPA/SEPAMEN</option>
            <option value="3" <? if ($diklat=='3') echo "selected" ; ?>>SEPADYA/SPAMA</option>
            <option value="4" <? if ($diklat=='4') echo "selected" ; ?>>SEPALA/ADUMLA</option>
            <option value="5" <? if ($diklat=='5') echo "selected" ; ?>>SEPADA/ADUM</option>
            <option value="6" <? if ($diklat=='6') echo "selected" ; ?>>DIKLATPIM Tk.I</option>
            <option value="7" <? if ($diklat=='7') echo "selected" ; ?>>DIKLATPIM Tk.II</option>
            <option value="8" <? if ($diklat=='8') echo "selected" ; ?>>DIKLATPIM Tk.III</option>
            <option value="9" <? if ($diklat=='9') echo "selected" ; ?>>DIKLATPIM Tk.IV</option>
            <option value="10" <? if ($diklat=='10') echo "selected" ; ?>>DIKLATPIM PEMDA</option>
            </select></td></tr>
        <tr valign="top"> 
          <td width="638" align="left" bgcolor="DDDDDD">&nbsp;<font face="Tahoma" size="2"><b>Jenis Kelamin 
            &nbsp;&nbsp;</b> 
            <select name="kelamin" >
            <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua</option>
            <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
            <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
            </select></td></tr>
        <tr valign="top"> 
          <td width="638" align="left">&nbsp;<font face="Tahoma" size="2"><b>Agama 
            &nbsp;&nbsp;</b> 
            <select name="agama" >
            <option value="all" <? if ($agama=='all') echo "selected" ; ?>>Semua</option>
            <option value="1" <? if ($agama=='1') echo "selected" ; ?>>Islam</option>
            <option value="2" <? if ($agama=='2') echo "selected" ; ?>>Kristen</option>
            <option value="3" <? if ($agama=='3') echo "selected" ; ?>>Katholik</option>
            <option value="4" <? if ($agama=='4') echo "selected" ; ?>>Hindu</option>
            <option value="5" <? if ($agama=='5') echo "selected" ; ?>>Budha</option>
            </select></td></tr>
        <tr valign="top"> 
          <td width="638" align="left">&nbsp;<font face="Tahoma" size="2"><b>Pendidikan 
            &nbsp;&nbsp;</b> 
            <select name="dik" >
            <option value="all" <? if ($dik=='all') echo "selected" ; ?>>Semua</option>
            <option value="10" <? if ($dik=='10') echo "selected" ; ?>>SD</option>
            <option value="20" <? if ($dik=='20') echo "selected" ; ?>>SMP</option>
            <option value="30" <? if ($dik=='30') echo "selected" ; ?>>SMA</option>
            <option value="41" <? if ($dik=='41') echo "selected" ; ?>>DIPLOMA I</option>
            <option value="42" <? if ($dik=='42') echo "selected" ; ?>>DIPLOMA II</option>
            <option value="43" <? if ($dik=='43') echo "selected" ; ?>>DIPLOMA III</option>
            <option value="44" <? if ($dik=='44') echo "selected" ; ?>>DIPLOMA IV</option>
            <option value="50" <? if ($dik=='50') echo "selected" ; ?>>SARMUD NON AKADEMI</option>
            <option value="60" <? if ($dik=='60') echo "selected" ; ?>>SARMUD AKADEMI</option>
            <option value="70" <? if ($dik=='70') echo "selected" ; ?>>S 1</option>
            <option value="80" <? if ($dik=='80') echo "selected" ; ?>>S 2</option>
            <option value="90" <? if ($dik=='90') echo "selected" ; ?>>S 3</option>
            </select></td></tr>
        <tr valign="top"> 
          <td width="638" align="left" bgcolor="DDDDDD">&nbsp;<font face="Tahoma" size="2"><b>Unit 
            Kerja&nbsp;</b> 
            <select name="unitkerja" >
            <option value="">--Pilih Unit Kerja--</option>
            <?
//            if ($gol1>=42) { 
            ?>
            <option value="all" <? if ($unitkerja=='all') echo "selected" ; ?>>Semua</option>
            	<?
//            }
            	$query="select * from TABLOK";
            	$res=mysql_query($query);
            	while ($row=mysql_fetch_array($res))
            	{
            	?>
            	<option value="<? echo $row["kd"]; ?>" <? if ($unitkerja==$row["kd"]) echo "selected"; ?>><? echo $row["nm"]; ?></option>
            	<?
        	}
        	?>
            </select>
            &nbsp; 
            <input type="submit" name="cari" value="Cari" class="tombol">&nbsp;&nbsp;
	  </td>
        </tr>
<?if ($unitkerja) {?>
<tr>
  <td>&nbsp;<font face="tahoma" size="2"><b>Dinas/Balai:&nbsp;</b>
    <select name="uks" >
<?	switch($unitkerja) {
		case '02000000': include 'nom_pns02.inc';break;
		case '21000000': include 'nom_pns21.inc';break;
		case '22000000': include 'nom_pns22.inc';break;
		case '23000000': include 'nom_pns23.inc';break;
		case '24000000': include 'nom_pns24.inc';break;
		case '25000000': include 'nom_pns25.inc';break;
		case '26000000': include 'nom_pns26.inc';break;
		case '27000000': include 'nom_pns27.inc';break;
		case '28000000': include 'nom_pns28.inc';break;
		case '29000000': include 'nom_pns29.inc';break;
		case '30000000': include 'nom_pns30.inc';break;
		case '31000000': include 'nom_pns31.inc';break;
		case '32000000': include 'nom_pns32.inc';break;
		case '34000000': include 'nom_pns34.inc';break;
		case '35000000': include 'nom_pns35.inc';break;
		case '36000000': include 'nom_pns36.inc';break;
		case '37000000': include 'nom_pns37.inc';break;
		case '38000000': include 'nom_pns38.inc';break;
		case '39000000': include 'nom_pns39.inc';break;
	}?>
      </select>
      <input type="submit" name="cari" value="Cari" class="tombol">
   </td>
  </tr>
<?}?> 
        </form>
<?

$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B','5A');
$aNama=array(1=>'IA','IB','IIA','IIB','IIIA','IIIB','IVA','IVB','VA');
$aGol=array(1=>'11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');
$aNama=array(1=>'I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e');

//----------- processing nominatif here ------
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m");//."-".date("d");
$tglok1=$thskr1."-".date("m");//."-".date("d");

if ($radio1=='') $radio1=1;
if ($unitkerja!='all') {
switch($radio1) {
case 1:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 >= '" . $gol1. "' ";
break;
case 2:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 <= '" . $gol1. "' ";
break;
case 3:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";
break;
}
} else {
switch($radio1) {
case 1:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01!='99' and F_03 >= '" . $gol1. "' ";
break;
case 2:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01!='99' and F_03 <= '" . $gol1. "' ";
break;
case 3:
$query="select A_01,B_02, B_03A, B_03, B_03B, B_12, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01!='99' and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2 ."' ";
break;
}
}
if (!$ignore) {
	$query.="and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (substring(B_05,1,7) >= '$tglok1' and I_5A=2)) ";
}
if ($jabatan!='all') {
	$query.="and I_5A='$jabatan' ";
}
if ($eselon!='all' && $eselon!='str') {
	$query.="and I_06='$eselon' ";
}
if ($eselon=='str') {
	$query.="and I_06<>'99' and I_06 is not null ";
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
if ($uks) {
switch ($unitkerja) {
case '02000000':include "nom_pns02_rule.inc";break;
case '21000000':include "nom_pns21_rule.inc";break;
case '22000000':include "nom_pns22_rule.inc";break;
case '23000000':include "nom_pns23_rule.inc";break;
case '24000000':include "nom_pns24_rule.inc";break;
case '25000000':include "nom_pns25_rule.inc";break;
case '26000000':include "nom_pns26_rule.inc";break;
case '27000000':include "nom_pns27_rule.inc";break;
case '28000000':include "nom_pns28_rule.inc";break;
case '29000000':include "nom_pns29_rule.inc";break;
case '30000000':include "nom_pns30_rule.inc";break;
case '31000000':include "nom_pns31_rule.inc";break;
case '32000000':include "nom_pns32_rule.inc";break;
case '34000000':include "nom_pns34_rule.inc";break;
case '35000000':include "nom_pns35_rule.inc";break;
case '36000000':include "nom_pns36_rule.inc";break;
case '37000000':include "nom_pns37_rule.inc";break;
case '38000000':include "nom_pns38_rule.inc";break;
case '39000000':include "nom_pns39_rule.inc";break;
}
}
$query.="order by F_03 DESC,F_02 ASC, F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
//echo $query;
$result=mysql_db_query("bkd",$query) or die (mysql_error());
$jrec=mysql_num_rows($result);
?>
      <tr valign="top" > 
          <td width="638" height="10" bgcolor="#FFCC66">&nbsp;<b><font face="Tahoma" size="1" color="FFFFFF">
          Hasil : <? echo $jrec; ?> Record</b>
            <input type="button" class="tombol" value="Cetak" name="cetak" onClick="window.open('include/i_nominatifa.html?gol1=<?=$gol1?>&gol2=<?=$gol2?>&radio1=<?=$radio1?>&eselon=<?=$eselon?>&jabatan=<?=$jabatan?>&diklat=<?=$diklat?>&ignore=<?=$ignore?>&kelamin=<?=$kelamin?>&agama=<?=$agama?>&unitkerja=<?=$unitkerja?>&uks=<?=$uks?>','myPoppp'/*,'WIDTH=800, HEIGHT=600, SCROLLBARS=YES, MENUBAR=YES'*/)"></td>
      </tr>
  
        <tr valign="top"> 
          <td colspan="2" width="638"> 
            <table width="638" border="0" cellpadding="1" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111">
              <tr>
                <td width="23" style="border-style: solid; border-width: 1" align="center">
                <b><font face="Tahoma" size="1">No</b></td>
                <td style="border-style: solid; border-width: 1" width="248" align="center">
                <b><font face="Tahoma" size="1">NAMA</b></td>
                <td style="border-style: solid; border-width: 1" width="285" align="center">
                <b><font face="Tahoma" size="1">JABATAN</b></td>
                <td style="border-style: solid; border-width: 1" width="285" align="center">
                <b><font face="Tahoma" size="1">ALAMAT</b></td>
                <td style="border-style: solid; border-width: 1" width="285" align="center">
                <b><font face="Tahoma" size="1">UNIT KERJA</b></td>
              </tr>
<?
$no=0;
while ($row=mysql_fetch_array($result))
{
	
	$tglku=$row["B_05"];
	$thenip=$row["B_02"];
	$esid=array_search($row["F_03"],$aGol);
	$golnya=$aNama[$esid];
	if (strlen($row["B_03A"])>0) $nama=$row["B_03A"]." ".stripslashes($row["B_03"])." ".$row["B_03B"];
	else $nama=stripslashes($row["B_03"])." ".$row["B_03B"];
	

	$no++;	
?>
              <tr>
                <td width="23" style="border-style: solid; border-width: 1" valign="top" align="right">
                <font face="Tahoma" size="1"><? echo $no; ?></td>
                <td style="border-style: solid; border-width: 1" width="248" valign="top">
                <font face="Tahoma" size="1"><? echo $nama; ?><br><? echo $thenip; ?><br><? echo $golnya; ?></td>
                <td style="border-style: solid; border-width: 1" width="285" valign="top">
                <font face="Tahoma" size="1"><? echo $row["I_JB"]; ?></td>
                <td style="border-style: solid; border-width: 1" width="285" valign="top">
                <font face="Tahoma" size="1"><? echo $row["B_12"]; ?></td>
                <td style="border-style: solid; border-width: 1" width="285" valign="top">
                <font face="Tahoma" size="1"><? echo lokasiKerja($row[A_01]); ?></td>
              </tr>
<?

}

	
?>
              
            </table>
          </td>
        </tr>
        
      </table>
