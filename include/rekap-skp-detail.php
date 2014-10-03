<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if ($cari) {
	
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
                  ?>
                  <tr>
                    <td colspan="3" valign="top">
      <!--<a href="?sid=<?=$sid?>&do=biodata&page=awal&NIP=<?=$row[B_02]?>">Edit Biodata PNS ini</a>-->
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
                       </table>
                    </td>
                  </tr>
                  <?
                  }
                  ?>
  </table>
<h4 class="title">Rekap Data</h4>
<table class="table table-bordered table-stripped table-hover no-margin">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="65%" class="left">Nama Kegiatan</th>
            <th width="10%">Target</th>
            <th width="10%">Sudah</th>
            <th width="10%">Sisa</th>
        </tr>
    </thead>
    <tbody>
        <?php
//        $sql = mysql_query("select k.nama, sum(r.jumlah) as subtotal, k.target 
//            from kegiatan_skp k 
//            left join rekap_skp r on (k.id = r.id_kegiatan_skp)
//            left join mastfip08 m on (r.B_02 = m.B_02)
//            where r.B_02 = '".$_GET['nip']."' group by k.id
//            ");
        $sql = mysql_query("select k.*,
        IFNULL((select sum(r.jumlah)
            from rekap_skp r
            left join mastfip08 m on (r.B_02 = m.B_02)
            where r.B_02 = '".$_GET['nip']."' and r.id_kegiatan_skp = k.id),'0') as subtotal
        from kegiatan_skp k order by k.nama");
        $no = 0;
        while ($data = mysql_fetch_array($sql)) { 
            $no++; 
            ?>
        <tr class="<?= ($no%2===0)?'even':'odd' ?>">
            <td align="center"><?=$no+$offset?></td>
            <td><?= $data['nama'] ?></td>
            <td align="center"><?= $data['target'] ?></td>
            <td align="center"><?= $data['subtotal'] ?></td>
            <td align="center"><?= ($data['target']-$data['subtotal']) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>