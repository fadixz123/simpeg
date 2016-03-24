<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$nip = $_GET['nip'];
if (isset($_GET['cari'])) {
	//echo $_GET['B_03'];
	if (strlen($_GET['B_03']) > 0 && isset($_GET['uk'])) {
		$q="select A_01,A_02,A_03,A_04,B_02,B_03A,B_03,B_03B,I_05,I_06,F_03 from MASTFIP08 where B_03 LIKE '%".$_GET['B_03']."%' ";
		if ($_GET['uk'] != 'all') {
			$q.="and A_01='".$_GET['uk']."'";
		}
		$q.="order by I_06 ASC, F_03 DESC";
		$r=mysql_query($q) or die (mysql_error());
		if (mysql_num_rows($r) >= 1) $status=2; else $status=4;
	}
	
	if (isset($_GET['nip']) && (strlen($_GET['nip'])==9 || strlen($_GET['nip'])==18)) {
		$q="select A_01,A_02,A_03,A_04,B_02,B_03A,B_03,B_03B,I_05,I_06,F_03 from MASTFIP08 where B_02='$nip' or B_02B='$nip' LIMIT 1";
		$r=mysql_query($q) or die (mysql_error());
		if (mysql_num_rows($r) == 1) {
			$status=1;
			$ro=mysql_fetch_array($r);
			$nip=$ro[B_02];
		} else $status=4;
	}
}

?>
<table width="100%">
<?php if ($status==2) { ?>
            <tr>
              <td colspan="3">

              <table border="1" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber5">
                <tr>
                  <td width="6%" align="center" style="font-family: Tahoma; font-size: 8pt">
                  No</td>
                  <td width="44%" align="center" style="font-family: Tahoma; font-size: 8pt">
                  Nama<br>
                  NIP</td>
                  <td width="50%" align="center" style="font-family: Tahoma; font-size: 8pt">
                  Unit Kerja<br>
                  Jabatan</td>
                </tr>
               	<?
		$no=0;
		$q="select * from MASTFIP08 where B_03 LIKE '%$B_03%' ";
		if ($uk != 'all') {
			$q .="and A_01='".substr($uk,0,2)."' ";
		}
		$q .="order by I_06 ASC, F_03 DESC";
                
               	$r=mysql_query($q) or die (mysql_error());
               	while($row=mysql_fetch_array($r)) {
               		$no++;
               		?>
                      <tr>
                        <td width="6%" align="right" class="td.kecil" style="font-family: Tahoma; font-size: 8pt" valign="top"><?=$no?></td>
                        <td width="44%" class="td.kecil" style="font-family: Tahoma; font-size: 8pt" valign="top">
                        <?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?><br>
                        [ <a href="index.htm?sid=<?=$sid?>&do=cari&nip=<?=$row[B_02]?>&cari=NIP"><font style="font-family: Tahoma; font-size: 8pt"><?=$row[B_02]?> / <?=format_nip_baru($row[B_02B])?></a> ]</td>
                        <td width="50%" class="td.kecil" style="font-family: Tahoma; font-size: 8pt" valign="top">
                        <?=subLokasiKerjaB($row[A_01],$row[A_02],$row[A_03],$row[A_04],$row[A_05])?>
                        <?=lokasiKerjaB($row[A_01])?><br>
                        <?=getNaJab($row[B_02])?></td>
                      </tr>
                      	<?
                }
                ?>
                    </table>
                    </td>
                  </tr>
                  <?
                  }
                  if ($status==1) {
	               	$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' or B_02B='".$_GET['nip']."' LIMIT 1";
					$r=mysql_query($q) or die (mysql_error());
					$row=mysql_fetch_array($r);
                  ?>
                  <tr>
                    <td height="200" colspan="3" valign="top">
      <!--<a href="?sid=<?=$sid?>&do=biodata&page=awal&NIP=<?=$row[B_02]?>">Edit Biodata PNS ini</a>-->
                        <div class="fotoshow">
                            <?php if ($row['foto'] !== '') { ?>
                            <img src="Foto/<?=$row['foto']?>" border="1" width="120" style="position: absolute; right: 0;"> 
                          <?php } else { ?>
                        &nbsp;<img src="showfoto.php?nip=<?=$row[B_02]?>" border="1" width="120" style="position: absolute; right: 0;"> 
                          <?php } ?>
                        </div>
                        <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
                         <tr> 
                           <td colspan="3" class="sectiontableheader">IDENTITAS</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Nama</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo namaPNS($row[B_03A],$row[B_03],$row[B_03B]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">NIP</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <?=$row[B_02]?> / <?=format_nip_baru($row[B_02B])?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Tempat/Tanggal Lahir</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo $row["B_04"]; ?>
                             / 
                             <? echo format_tanggal($row["B_05"],1); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Agama</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo agama1($row["B_07"]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Jenis Kelamin</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo jeniskelamin($row["B_06"]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Alamat</td>
                           <td width="4" align="center" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo $row["B_12"]; ?>
                           </td>
                         </tr>
                         <tr> 
                            <td colspan="3" class="sectiontableheader" ><b>PENGANGKATAN SEBAGAI CPNS</b></td>
                          </tr>
                          <tr> 
                            <td>NOMOR SK</td>
                            <td align="center">:</td>
                            <td><? echo $row["D_02"]; ?></td>
                          </tr>
                          <tr> 
                            <td>TANGGAL SK</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row['D_03']); ?></td>
                          </tr>
                          <tr> 
                            <td>TMT CPNS</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row['D_04']); ?></td>
                          </tr>
                          <tr> 
                            <td colspan="3" class="sectiontableheader" >PENGANGKATAN SEBAGAI PNS</td>
                          </tr>
                          <tr>
                            <td>NOMOR SK</td>
                            <td align="center">:</td>
                            <td><? echo $row["E_02"]; ?></td>
                          </tr>
                          <tr>
                            <td>TANGGAL SK</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row['E_03']); ?></td>
                          </tr>
                          <tr> 
                            <td>TMT PNS</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row['E_04']); ?></td>
                          </tr>
                          <tr> 
                            <td>PANGKAT/GOLONGAN</td>
                            <td align="center">:</td>
                            <td><?=namapkt($row[E_05])." (".pktH($row['E_05']).")"?></td>
                          </tr>
                          <tr> 
                            <td>SUMPAH JANJI</td>
                            <td align="center">:</td>
                            <td><? if ($row['E_06']=='1') echo "SUDAH"; else echo "BELUM"; ?></td>
                          </tr>
                          <tr> 
                            <td>PANGKAT/GOLONGAN</td>
                            <td align="center">:</td>
                            <td><?=namapkt($row[D_05])." (".pktH($row['D_05']).")" ?></td>
                          </tr>
                         <tr> 
                           <td colspan="3" class="sectiontableheader"  >PANGKAT/GOLONGAN TERAKHIR</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Pangkat/Golongan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo namapkt($row["F_03"]) . " ( ".pktH($row["F_03"]).")"; ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">TMT Pangkat/Golongan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo format_tanggal($row["F_TMT"]); ?>
                           </td>
                         </tr>
                         <?php
                           if ($row['I_05'] === '00018') {
                              $qjenjang="select * from TABJENJANG_GURU where KJENJANG = '".$row['I_07']."'";
                          } else {
                              $qjenjang="select * from TABJENJANG where KJENJANG = '".$row['I_07']."'";
                          }
                          $nama_jenjang = mysql_fetch_array(mysql_query($qjenjang));
                         ?>
                         <tr> 
                           <td colspan="3" class="sectiontableheader" >JABATAN TERAKHIR</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Nama Jabatan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo getNaJab($row[B_02]).' '.$nama_jenjang['JENJANG']; ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Unit Kerja</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo lokasiKerjaB($row[A_01]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">TMT Jabatan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo format_tanggal($row[I_04]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Eselon</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? if ($row[I_06] != '99') { echo eselon($row[I_06]); }?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Masa Kerja</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo substr($row[F_04],0,2)." TAHUN ".substr($row[F_04],2,2)." BULAN"; ?>
                           </td>
                         </tr>
                         <tr> 
                           <td colspan="3" class="sectiontableheader" >PENDIDIKAN UMUM TERAKHIR</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Tingkat</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo tktdidik($row["H_1A"]); ?>

                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Jurusan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo jurusan($row[H_1A],$row[H_1B]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Tahun Lulus</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo $row[H_02]; ?>
                           </td>
                         </tr>
                         <tr> 
                           <td colspan="3" class="sectiontableheader" >DIKLAT STRUKTURAL TERAKHIR</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Nama Diklat</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo dikstru($row[H_4A]); ?>
                           </td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Tanggal</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"><? echo format_tanggal($row[H_4B]); ?></td>
                         </tr>
                         <tr> 
                            <td colspan="3" class="sectiontableheader"><b>KENAIKAN GAJI BERKALA TERAKHIR</b></td>
                          </tr>
                          <tr> 
                            <td>TMT GAJI BERKALA</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row["G_01"]); ?></td>
                          </tr>
                          <tr> 
                            <td>MASA KERJA GAJI</td>
                            <td align="center">:</td>
                            <td><? echo substr($row["G_02"],0,2) ; ?> TAHUN <? echo substr($row["G_02"],2,2) ; ?> BULAN</td>
                          </tr>
                          <tr> 
                            <td>GAJI POKOK</td>
                            <td align="center">:</td>
                            <td><? echo gaji($row["F_03"],substr($row["F_04"],0,2)); ?></td>
                          </tr>
                         <tr> 
                            <td colspan="3" class="sectiontableheader">JABATAN STRUKTURAL/FUNGSIONAL/FUNGSIONAL UMUM</td>
                          </tr>
                          <tr> 
                            <td>JABATAN SAAT INI</td>
                            <td align="center">:</td>
                            <td>
                            <?
                              switch($p[I_00])
                              {
                                  case "1"	: echo "Struktural";break;                                      
                                  case "2"	: echo "Fungsional tertentu";break;                             
                                  case "3"	: echo "Struktural dan Fungsional Tertentu (rangkap)";break;    
                                  case "4"	: echo "Fungsional Umum/Staf.";break;                           

                              }
                              ?>  
                            </td>
                          </tr>
                          <tr> 
                            <td>JAB. FUNG TERTENTU</td>
                            <td align="center">:</td>
                            <td>
                            <?if ($row[I_06]=='99' and $row[I_05] !='999') echo $row[I_JB]."&nbsp; TMT : ".format_tanggal($row[I_04])?> 
                            </td>
                          </tr>
                          <?
                          $pjb="select * from TABPJB where KODE='".$row['I_01']."'";
                                $res=mysql_db_query($db,$pjb);
                                $ro2=mysql_fetch_array($res)
                                ?>
                          <tr> 
                            <td>DITETAPKAN OLEH</td>
                            <td align="center">:</td>
                            <td><? echo $ro2['NAMA']; ?></td>
                          </tr>
                          <tr>
                            <td>NOMOR SK</td>
                            <td align="center">:</td>
                            <td><? echo $row["I_02"]; ?></td>
                          </tr>
                          <tr>
                            <td>TANGGAL SK</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal($row["I_03"]); ?></td>
                          </tr>
                          <tr>
                            <td>NAMA JABATAN</td>
                            <td align="center">:</td>
                            <td><? echo $row["I_JB"].' '.$nama_jenjang['JENJANG']; ?></td>
                          </tr>
                          <tr>
                            <td>TMT JABATAN</td>
                            <td align="center">:</td>
                            <td><? echo format_tanggal_1($row["I_04"]); ?></td>
                          </tr>
                          <tr>
                            <td>ESELON</td>
                            <td align="center">:</td>
                            <td><? echo eselon($row['I_06']); ?></td>
                          </tr>
                       </table>
                    </td>
                  </tr>
                  <?
                  }
                  ?>
  </table>
<?php 

include '../CETAKFIP/CetakBaru_next.inc'; ?>