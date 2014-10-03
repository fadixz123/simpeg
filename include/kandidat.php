<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

	//echo $_GET['B_03'];
$q="select * from MASTFIP08 where B_02='".$_GET['nip']."' or B_02B='".$_GET['nip']."' LIMIT 1";
$r=mysql_query($q) or die (mysql_error());
$row=mysql_fetch_array($r);
?>
<style type="text/css">
    .rincian { float: left; }
    .rincian tr { vertical-align: top; }
    .wrapper { width: 33%; border: 1px solid #ccc; display: inline-block; max-height: 400px; overflow-y: auto; }
</style>
<div class="wrapper">
<input type="hidden" name="nip[]" value="<?= $_GET['nip'] ?>" />
<table width="100%" class="rincian">
    <tr>
      <td height="200" colspan="3" valign="top">
          <table width="100%" class="table table-condensed table-bordered table-hover no-margin">
           <tr> 
               <td colspan="3" class="sectiontableheader"><input type="radio" name="pilih" value="<?= $_GET['nip'] ?>" /> IDENTITAS</td>
           </tr>
           <tr>
                <td>Foto</td>
                <td>:</td>
                <td><div class="fotoshow"><img src="showfoto.php?nip=<?=$row['B_02']?>" width="120"> </div></td>
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
  </table>
</div>