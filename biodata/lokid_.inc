<?
if ($updlokid)
{
	$q="update MASTFIP08 set A_01='".substr($loker,0,2)."',A_02='".substr($loker,2,2)."', A_03='".substr($loker,4,2)."', A_04='".substr($loker,6,2)."', A_05='".substr($loker,8,2)."' where B_02='$NIP'";
	mysql_query($q) or die ("this update lokasi error :".mysql_error());
	
}
if ($updid)
{
	$B_03=addslashes($B_03);
  	$qupdate="update MASTFIP08 set B_02B='$B_02B',B_03A='$B_03A', B_03='$B_03', B_03B='$B_03B', ";
	$qupdate=$qupdate." B_04='$B_04', B_05='".$THLAHIR."-".$BLLAHIR."-".$TGLAHIR."', ";
	$qupdate=$qupdate." B_06='$B_06', B_07='$B_07', B_08='$B_08', B_09='$B_09', B_11='$B_11', B_12='$B_12', ";
	$qupdate=$qupdate." J_01='$J_01', L_1A='$L_1A', L_02='$L_02', L_03='$L_03', L_04='$L_04' ";
	$qupdate=$qupdate." WHERE B_02='$NIP'";
	
	mysql_query($qupdate) or die ("this update identitas error :".mysql_error());
	//lethistory($sid,"UPDATE IDENTITAS",$NIP);
}

if ($buker=='') {
$q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
if ($row[A_01] !='') $buker=$row[A_01];
if ($row[A_02] !='' && $row[A_03] !='' && $row[A_04] !='' ) $loker=$row[A_01].$row[A_02].$row[A_03].$row[A_04].$row[A_05];
}
?>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
<form name="lokasi" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=lokid&NIP=<?=$NIP?>" method="post">
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow2; ?>"> 
              <div align="center"><b>::</b></div>
            </td>
            <td width="154" bgcolor="<? echo $warnarow2; ?>"> <b> L 
              O K A S I  K E R J A</b></td>
            <td width="12" bgcolor="<? echo $warnarow2; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" align="left" height="22" bgcolor="<? echo $warnarow2; ?>">&nbsp; 
            </td>
          </tr>
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"></div>
            </td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"><strong>  </strong>UNIT 
              KERJA</td>
	    <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td bgcolor="<? echo $warnarow; ?>">  
              <select name="buker" class="pilihan2" 
              onChange="window.location='?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=lokid&NIP=<?=$NIP?>&buker='+this.value+''">
                <option value="">-</option>
                <? 
	            $quker="select KD,NM from TABLOK08 order by kd";
    	        $ruker=mysql_query($quker) or die(mysql_error());
				while($ouker=mysql_fetch_array($ruker)) { ?>
                <option value="<?=substr($ouker[KD],0,2); ?>" <? if (substr($ouker[KD],0,2)==$buker) echo "selected"; ?>><? echo $ouker[NM]; ?></option>
                <? } ?>
              </select> </td>
          </tr>
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"> </div>
            </td>
            <td width="154" bgcolor="<? echo $warnarow; ?>">  SUB UNIT KERJA</td>
            <? 
            
            $qloker="select KOLOK,NALOK from TABLOKB08 where A_01='$buker' order by KOLOK";
            //echo $qloker;
            $rloker=mysql_query($qloker);
            
            ?>
	    <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td bgcolor="<? echo $warnarow; ?>">  
              <select name="loker"   >
                <option value="">-</option>
                <? while($oloker=mysql_fetch_array($rloker)) { ?>
                <option value="<?=$oloker[KOLOK] ?>" <? if ($oloker[KOLOK]==$loker) echo "selected" ; ?>><?=$oloker[NALOK]; ?></option>
                <? } ?>
              </select></td>
          </tr>
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow2; ?>">&nbsp;</td>
            <td width="154" bgcolor="<? echo $warnarow2; ?>">&nbsp; </td>
			<td width="12" bgcolor="<? echo $warnarow2; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td bgcolor="<? echo $warnarow2; ?>">   
              <input name="updlokid" type="submit" class="tombol2" tabindex='1' value="SIMPAN LOKASI">
            </td>
          </tr>
        </form>
      </table>
<? // ----------------------- identitas ------------------------------------ ?>
<?
$q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
$row=mysql_fetch_array(mysql_query($q));
?>
	<table width="100%" border="0" cellspacing="1" cellpadding="1">
        <form name="identitas" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=lokid&NIP=<?=$NIP?>" method="post">
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow2; ?>"> 
              <div align="center"><b>A</b></div>
            </td>
            <td colspan="3" height="22" bgcolor="<? echo $warnarow2; ?>"> <b>I D E N T I T A S  P E G A W A I</b> </td>
          </tr>
          <tr valign="top" height="20"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 01</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Nip Pegawai </td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>"> <b> 
              <? echo $NIP; ?> / <?=format_nip_baru($row[B_02B])?>
              </b> </td>
          </tr>
		  <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 02</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> NIP Baru</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="B_02B" value="<?=$row[B_02B]?>" maxlength="18">
            </td>
          </tr>
		  <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 03</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Nama Pegawai</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="B_03A" value="<? echo $row[B_03A]; ?>" size="4">
              <input type="text" name="B_03" value="<? echo stripslashes($row[B_03]); ?>" size="30">
              <input type="text" name="B_03B" value="<? echo $row[B_03B]; ?>" size="6">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 04</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Tempat Lahir</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="B_04" size="30" value="<? echo $row[B_04]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 05</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Tanggal Lahir</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input name="TGLAHIR" value="<? echo substr($row[B_05],8,2); ?>" size="2" maxlength="2">
              - 
              <input name="BLLAHIR" value="<? echo substr($row[B_05],5,2); ?>" size="2" maxlength="2">
              - 
              <input name="THLAHIR" value="<? echo substr($row[B_05],0,4); ?>" size="4" maxlength="4">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 06</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Jenis Kelamin</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <? $B_06=$row[B_06]; ?>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <select name="B_06"  >
                <option value="">-</option>
                <option value="1" <? if ($B_06=='1') echo "selected"; ?> >LAKI-LAKI</option>
                <option value="2" <? if ($B_06=='2') echo "selected"; ?>>PEREMPUAN</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 07</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> A g a m a</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <? $B_07=$row[B_07]; ?>
              <select name="B_07"  >
                <option value="">-</option>
                <option value="1" <? if ($B_07=='1') echo "selected"; ?>>ISLAM</option>
                <option value="2" <? if ($B_07=='2') echo "selected"; ?>>KRISTEN</option>
                <option value="3" <? if ($B_07=='3') echo "selected"; ?>>KATHOLIK</option>
                <option value="4" <? if ($B_07=='4') echo "selected"; ?>>HINDU</option>
                <option value="5" <? if ($B_07=='5') echo "selected"; ?>>BUDHA</option>
                <option value="5" <? if ($B_07=='6') echo "selected"; ?>>KONGHUCU</option>
                <option value="5" <? if ($B_07=='7') echo "selected"; ?>>LAINNYA</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 08</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Status Pegawai</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <? $B_09=$row[B_09]; ?>
              <select name="B_09"  >
                <option value="">-</option>
                <option value="1" <? if ($B_09=='1') echo "selected";?>>CPNS</option>
                <option value="2" <? if ($B_09=='2') echo "selected";?>>PNS</option>
              </select>
            </td>
          </tr>
          <tr valign="top" height="20"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 09</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Jenis Kepegawaian</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <? echo "<b>PNS Daerah Otonom</b>"; ?>
            </td>
          </tr>
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 10</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Status Perkawinan</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <select name="J_01"  >
                <option value="">-</option>
                <option value="1" <? if ($row[J_01]=='1') echo "selected"; ?>>KAWIN</option>
                <option value="2" <? if ($row[J_01]=='2') echo "selected"; ?>>BELUM 
                KAWIN</option>
                <option value="3" <? if ($row[J_01]=='3') echo "selected"; ?>>JANDA/DUDA</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 11</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Kedudukan Pegawai</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <? $B_11=$row[B_11]; ?>
              <select name="B_11"  >
                <option value="">-</option>
                <option value="1" <? if ($B_11=='1') echo "selected"; ?>>PEGAWAI AKTIF</OPTION>
                <option value="2" <? if ($B_11=='2') echo "selected"; ?>>PEJABAT NEGARA</OPTION>
                <option value="3" <? if ($B_11=='3') echo "selected"; ?>>CUTI DILUAR TANGGUNGAN NEGARA</OPTION>
                <option value="4" <? if ($B_11=='4') echo "selected"; ?>>PENERIMA UANG TUNGGU</OPTION>
                <option value="5" <? if ($B_11=='5') echo "selected"; ?>>BEBAS TUGAS</OPTION>
                <option value="6" <? if ($B_11=='6') echo "selected"; ?>>TUGAS BELAJAR</OPTION>
                <option value="7" <? if ($B_11=='7') echo "selected"; ?>>SKORSING</OPTION>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 12</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Alamat Rumah</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <textarea name="B_12" rows="3" cols="40"><? echo $row[B_12]; ?></textarea>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 13</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Nomor Karpeg</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="B_08" value="<? echo $row[B_08]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 14</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Nomor Kartu 
              ASKES </td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">   
              <input type="text" name="L_1A" value="<? echo $row[L_1A]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 15</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Kartu Taspen</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <select name="L_02"  >
                <option value="">-</option>
                <option value="1"  <? if ($row[L_02]=='1') echo "selected"; ?>>SUDAH</option>
                <option value="2"  <? if ($row[L_02]=='2') echo "selected"; ?>>BELUM</option>
              </select>
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 16</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> Nomor Karis 
              / Karsu</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="L_04" value="<? echo $row[L_04]; ?>">
            </td>
          </tr>
          <tr valign="top"> 
            <td width="21" bgcolor="<? echo $warnarow; ?>"> 17</td>
            <td width="154" bgcolor="<? echo $warnarow; ?>"> N P W P</td>
            <td width="12" bgcolor="<? echo $warnarow; ?>"> 
              <div align="center"><b>:</b></div>
            </td>
            <td width="378" bgcolor="<? echo $warnarow; ?>">  
              <input type="text" name="L_03" value="<? echo $row[L_03]; ?>">
            </td>
          </tr>
          <tr> 
            <td width="21" bgcolor="<? echo $warnarow2; ?>">&nbsp;</td>
            <td width="154" bgcolor="<? echo $warnarow2; ?>">&nbsp;</td>
            <td width="12" bgcolor="<? echo $warnarow2; ?>">&nbsp;</td>
            <td width="378" bgcolor="<? echo $warnarow2; ?>">   
              <input type="submit" class="tombol2" value="SIMPAN IDENTITAS" name="updid">
            </td>
          </tr>
        </form>
      </table>
