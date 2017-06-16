<?php
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
header_excel('rekap-nominatif.xls');
?>
<body>
<?php
$unitkerja  = $_GET['uk'];

$qcu="select distinct A_02 from TABLOKB08 where A_01='$unitkerja'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
//$uk     = $_GET['uk'];
$subuk  = $_GET['subuk'];
$hasupt = $_GET['hasupt'];
$radio1 = $_GET['radio1'];
$gol1   = $_GET['gol1'];
$gol2   = $_GET['gol2'];
$status = $_GET['status'];
$jabatan= $_GET['jabatan'];
$jabfung= $_GET['jabfung'];
$eselon = $_GET['eselon'];
$kelamin= $_GET['kelamin'];
$agama  = $_GET['agama'];
$diklat = $_GET['diklat'];
$dik    = $_GET['dik'];
$jur    = $_GET['jur'];
//$urut   = $_GET['urut'];
$kecamatan = $_GET['kecamatan'];
$nama_sekolah = $_GET['nama_sekolah'];
$kawin  = $_GET['J_01'];
$nullinclude = isset($_GET['nullinclude'])?$_GET['nullinclude']:'Tidak';
if ($unitkerja !='') {
	$tahun=date("Y");
	$thskr=$tahun-56;
	$thskr1=$tahun-61;
	$tglok=$thskr."-".date("m");//."-".date("d");
	$tglok1=$thskr1."-".date("m")."-".date("d");
        if ($gol1=='') { $gol1='11'; }
        if ($gol2=='') { $gol2='45'; }
	$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B','5A');
		
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

	$query="select * from MASTFIP08 where `A_01` != '99' ";
	if ($unitkerja!='all') {
                if (strlen($unitkerja)==2) { $query.="and A_01='".$unitkerja."' "; }
                else { $query.="and A_01='".substr($unitkerja,0,2)."' and A_02='".substr($unitkerja,2,2)."' and A_03='".substr($unitkerja,4,2)."' "; }
        } else { $query.="and A_01<>'99' "; }

	if ($subuk!=='' && $subuk!=='all') {
                if ($hasupt === 'true') { $query.="and A_02='$subuk' "; }
                else if ($subuk === 'induk') {
                    if ($uk === '04') {
                        $query.="and A_03 in ('00','01','02','03','04','05')";
                    }
                    if ($uk === '07') {
                        $query.="and A_03 in ('00','01','02','03','04')";
                    }
                }
                else { $query.="and concat(A_01,A_02,A_03,A_04,A_05) like '".$subuk."%' "; }
        }
	
        //if ($radio1=='') { $radio1=1; }
        //switch($radio1) {
        //	case 1: $query.="and F_03 >= '" . $gol1. "' ";break;
        //	case 2: $query.="and F_03 <= '" . $gol1. "' ";break;
        //	case 3: 
        if ($gol1 !== '' or $gol2 !== '') {
            $query.="and (F_03 between '" . $gol1. "' and '" . $gol2 ."') ";
        }

        //}

	if ($status!='all') {
		$query.="and B_09='$status' ";
	}
	if ($jabatan!=='all') {
            if ($jabatan=='2') { 
                $query.="and (I_5A='2' or I_5A='4') "; 
            } else { 
                $query.="and I_5A='$jabatan' "; 
            }
	}
	if ($jabfung!=='') {
		$query.="and (I_5A='2' or I_5A='4') and I_05='$jabfung' ";
	}
	if ($eselon!='all' && $eselon!='str') {
                if (strlen($eselon)==1) { $query.="and I_06 like '".$eselon."%' "; } else { $query.="and I_06='$eselon' "; }
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
        if ($kecamatan !== '') {
            $query.=" and id_lokasi = '$kecamatan'";
        }
        if ($nama_sekolah !== '') {
            $query.=" and H_SEKOLAH like ('%".$nama_sekolah."%')";
        }
        if ($kawin !== '') {
            $query.=" and J_01 = '".$kawin."'";
        }
        if ($nullinclude === 'Ya') {
            $query.=" or F_03 is NULL ";
        }
	$query.="order by F_03 DESC,F_TMT ASC, I_06,F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC ";
	$no=0;
        //echo $query;
	$r=mysql_query($query) or die (mysql_error());
?>
<table>
<tr><td align="center" colspan="17"><h3>UNIT KERJA : 
<?php   if ($unitkerja!='all') {
            if (strlen($unitkerja)==2) { 
                echo lokasiKerjaB($unitkerja);
            }
            else {
                echo sublokasiKerjaB($unitkerja);
            }
        } else {
            echo "SEMUA UNIT KERJA";
            
        }
?><br><?= $subuk!='' && $subuk!='all' ? ( $hasupt ? sublokasiKerjaB($unitkerja,$subuk,'00','00','00') : sublokasiKerjaB(substr($subuk,0,2),substr($subuk,2,2),substr($subuk,4,2),substr($subuk,6,2),substr($subuk,8,2))) : ""?></h3></td></tr>
<tr><td colspan="17">
<?php
if ($eselon!='all' && $eselon!='str') { echo "Eselon : ".eselon($eselon)."<br>"; }
if ($kelamin!='all') { echo "Jenis kelamin : ".jenisKelamin($kelamin)."<br>"; }
if ($agama!='all') { echo "Agama : ".agama1($agama)."<br>"; }
?>
</td></tr>
</table>
<table width="100%" border="1">
  <tr>
    <th>NO</th>
    <?php if (isset($_GET['niplama'])) { ?>
    <th>NIP LAMA</th>
    <?php } ?>
    <?php if (isset($_GET['nipbaru'])) { ?>
    <th>NIP BARU</th>
    <?php } ?>
    <?php if (isset($_GET['nama'])) { ?>
    <th >NAMA</th>
    <?php } ?>
    <?php if (isset($_GET['alamat'])) { ?>
    <th>ALAMAT</th>
    <?php } ?>
    <?php if (isset($_GET['tempatlahir'])) { ?>
    <th>TEMPAT LAHIR</th>
    <?php } ?>
    <?php if (isset($_GET['tgllahir'])) { ?>
    <th>TGL LAHIR</th>
    <?php } ?>
    <?php if (isset($_GET['tmtcpns'])) { ?>
    <th>TMT CPNS</th>
    <?php } ?>
    <?php if (isset($_GET['jekel'])) { ?>
    <th>JENIS KELAMIN</th>
    <?php } ?>
    <?php if (isset($_GET['jabatan_check'])) { ?>
    <th>JABATAN</th>
    <?php } ?>
    <?php if (isset($_GET['subsubunitkerja'])) { ?>
    <th>SUB SUB UNIT KERJA</th>
    <?php } ?>
    <?php if (isset($_GET['subunitkerja'])) { ?>
    <th>SUB UNIT KERJA</th>
    <?php } ?>
    <?php if (isset($_GET['unitkerja'])) { ?>
    <th>UNIT KERJA</th>
    <?php } ?>
    <?php if (isset($_GET['eselon_check'])) { ?>
    <th>ESEL</th>
    <?php } ?>
    <?php if (isset($_GET['gr'])) { ?>
    <th>G/R</th>
    <?php } ?>
    <?php if (isset($_GET['tmt'])) { ?>
    <th>TMT</th>
    <?php } ?>
    <?php if (isset($_GET['pendidikan'])) { ?>
    <th>PENDIDIKAN</th>
    <?php } ?>
    <?php if (isset($_GET['jurusan'])) { ?>
    <th>JURUSAN</th>
    <?php } ?>
    <?php if (isset($_GET['lulus'])) { ?>
    <th>LULUS</th>
    <?php } ?>
    <?php if (isset($_GET['namasekolah'])) { ?>
    <th>NAMA SEKOLAH</th>
    <?php } ?>
    <?php if (isset($_GET['tmtjabatan'])) { ?>
    <th>TMT JABATAN</th>
    <?php } ?>
    <?php if (isset($_GET['nomorskjabatan'])) { ?>
    <th>NO. SK JABATAN</th>
    <?php } ?>
    <?php if (isset($_GET['masakerja_check'])) { ?>
    <th>Masa Kerja</th>
    <?php } ?>
    <?php if (isset($_GET['tmteselon_check'])) { ?>
    <th>TMT Eselon</th>
    <?php } ?>
    <?php if (isset($_GET['diklat_check'])) { ?>
    <th>Diklat</th>
    <?php } ?>
    <?php if (isset($_GET['statuspegawai_check'])) { ?>
    <th>Status Pegawai</th>
    <?php } ?>
    <?php if (isset($_GET['agama_check'])) { ?>
    <th>Agama</th>
    <?php } ?>
  </tr>
  <?php
  
		$z=0;
		while ($row=mysql_fetch_array($r)) {
		  	$no++;
			$z++;
                        $detail = "<table>
                        <tr><td style='border: none; border-bottom: 1px solid #000;'>".ucwords(strtolower(subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03].$row[A_04])))."</td></tr>
                        <tr><td style='border: none; border-bottom: 1px solid #000;'>".ucwords(strtolower(subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03])))."</td></tr>
                        <tr><td style='border: none;'>".ucwords(strtolower(lokasiKerjaB($row[A_01])))."</td></tr>
                        </table>
                        ";
        if ($row['I_05'] === '00018') {
            $qjenjang="select * from TABJENJANG_GURU where KJENJANG = '".$row['I_07']."'";
        } else {
            $qjenjang="select * from TABJENJANG where KJENJANG = '".$row['I_07']."'";
        }
        $nama_jenjang = mysql_fetch_array(mysql_query($qjenjang));
        ?>
  <tr>
    <td align="center"><?=$no?></td>
    <?php if (isset($_GET['niplama'])) { ?>
    <td align="center"><?=$row[B_02]?>&nbsp;</td>
    <?php } ?>
    <?php if (isset($_GET['nipbaru'])) { ?>
    <td><?=$row[B_02B] =='' ? $row[B_02] : format_nip_baru($row[B_02B])?>&nbsp;</td>
    <?php } ?>
    <?php if (isset($_GET['nama'])) { ?>
    <td><?=namaPNS($row[B_03A],$row[B_03],$row[B_03B])?></td>
    <?php } ?>
    <?php if (isset($_GET['alamat'])) { ?>
    <td><?=$row[B_12]?></td>
    <?php } ?>
    <?php if (isset($_GET['tempatlahir'])) { ?>
    <td><?=$row[B_04]?></td>
    <?php } ?>
    <?php if (isset($_GET['tmtcpns'])) { ?>
    <td align="center"><?= datefmysql($row[B_05])?></td>
    <?php } ?>
    <?php if (isset($_GET['tgllahir'])) { ?>
    <td><?=datefmysql($row[D_04])?></td>
    <?php } ?>
    <?php if (isset($_GET['jekel'])) { ?>
    <td><?= jenisKelamin($row[B_06])?></td>
    <?php } ?>
    <?php if (isset($_GET['jabatan_check'])) { ?>
    <td><?= getNaJab($row[B_02])?> <?= $nama_jenjang['JENJANG'] ?></td>
    <?php } ?>
    <?php if (isset($_GET['unitkerja'])) { ?>
    <td><?=ucwords(strtolower(subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03].$row[A_04])))?></td>
    <?php } ?>
    <?php if (isset($_GET['subunitkerja'])) { ?>
    <td><?=ucwords(strtolower(subLokasiKerjaB($row[A_01].$row[A_02].$row[A_03]))) ?></td>
    <?php } ?>
    <?php if (isset($_GET['subsubunitkerja'])) { ?>
    <td><?=ucwords(strtolower(lokasiKerjaB($row[A_01])))?></td>
    <?php } ?>
    <?php if (isset($_GET['eselon_check'])) { ?>
    <td align="center"><?=eselon($row[I_06])?></td>
    <?php } ?>
    <?php if (isset($_GET['gr'])) { ?>
    <td align="center"><?=pktH($row[F_03])?></td>
    <?php } ?>
    <?php if (isset($_GET['tmt'])) { ?>
    <td align="center"><?=  datefmysql($row[F_TMT])?></td>
    <?php } ?>
    <!--<td><?=$row[B_12]?></td>-->
    <?php if (isset($_GET['pendidikan'])) { ?>
    <td><?= tktdidik($row[H_1A])?></td>
    <?php } ?>
    <?php if (isset($_GET['jurusan'])) { ?>
    <td><?= jurusan($row[H_1A],$row[H_1B])?></td>
    <?php } ?>
    <?php if (isset($_GET['lulus'])) { ?>
    <td><?=($row[H_02])?></td>
    <?php } ?>
    <?php if (isset($_GET['namasekolah'])) { ?>
    <td><?= $row['H_SEKOLAH'] ?></td>
    <?php } ?>
    <?php if (isset($_GET['tmtjabatan'])) { ?>
    <td><?=datefmysql($row['I_04']); ?></td>
    <?php } ?>
    <?php if (isset($_GET['nomorskjabatan'])) { ?>
    <td><?=($row['I_02'])?> </td>
    <?php } ?>
    <?php if (isset($_GET['masakerja_check'])) { ?>
    <td><?= substr($row['F_04'],0,2)." TAHUN ".substr($row['F_04'],2,2)." BULAN"; ?></td>
    <?php } ?>
    <?php if (isset($_GET['tmteselon_check'])) { ?>
    <td><?= format_tanggal($row['I_04']); ?></td>
    <?php } ?>
    <?php if (isset($_GET['diklat_check'])) { ?>
    <td><?= dikstru($row['H_4A']) ?></td>
    <?php } ?>
    <?php if (isset($_GET['statuspegawai_check'])) { ?>
    <td><?php 
        if ($row["B_09"] === '1') {
            echo "CPNS";
        }
        if ($row["B_09"] === '2') {
            echo "PNS";
        }
    ?></td>
    <?php } ?>
    <?php if (isset($_GET['agama_check'])) { ?>
    <td><?= agama1($row["B_07"]) ?></td>
    <?php } ?>

  </tr>
  <?php } ?>
</table>
<?php } ?>

        
</body>
