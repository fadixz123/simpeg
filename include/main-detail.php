<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$sid = $_GET['sid'];
$nip = $_GET['nip'];
$B_03= $_GET['nama'];
if (isset($_GET['cari'])) {
	
	if (strlen($B_03) > 0 && isset($uk)) {
		$q="select A_01,A_02,A_03,A_04,B_02,B_03A,B_03,B_03B,I_05,I_06,F_03 from MASTFIP08 where B_03 LIKE '%$B_03%' ";
                
		if ($uk != 'all') {
			$q.="and A_01='$uk' ";
		}
		$q.="order by I_06 ASC, F_03 DESC";
		$r=mysql_query($q) or die (mysql_error());
		if (mysql_num_rows($r) >= 1) $status=2; else $status=4;
	}
	
	if (isset($nip) && (strlen($nip)==9 || strlen($nip)==18)) {
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
<br/>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="Scripts/pnotify/jquery.pnotify.min.js"></script>
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
	               	$q="select * from MASTFIP08 where B_02='$nip' or B_02B='$nip' LIMIT 1";
					$r=mysql_query($q) or die (mysql_error());
					$row=mysql_fetch_array($r);
                        $url = 'showfoto.php?nip='.$row['B_02'];
                        if ($row['foto'] !== '') {
                            $url = 'Foto/'.$row['foto'];
                        }
                  ?>
                  <tr>
                    <td height="200" colspan="3" valign="top">
      <!--<a href="?sid=<?=$sid?>&do=biodata&page=awal&NIP=<?=$row[B_02]?>">Edit Biodata PNS ini</a>-->
                        <div style="position: absolute; right: 0;"><img src="<?= $url ?>" width="120"> </div>
                        <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
                         <tr> 
                           <td colspan="3" class="sectiontableheader">IDENTITAS</td>
                         </tr>
                         <tr> 
                           <td width="23%" class="garisbawah">Nama</td>
                           <td width="1%" align="center" class="garisbawah">:</td>
                           <td width="76%"> 
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
                         <tr> 
                           <td colspan="3" class="sectiontableheader" >JABATAN TERAKHIR</td>
                         </tr>
                         <tr> 
                           <td width="170" class="garisbawah">Nama Jabatan</td>
                           <td width="4" class="garisbawah">:</td>
                           <td width="335"> 
                             <? echo getNaJab($row[B_02]); ?>
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
                             <? if ($row[I_06] != '99') echo eselon($row[I_06]);?>
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
                       </table>
                    </td>
                  </tr>
                  <?
                  }
                  ?>
  </table>