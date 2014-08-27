<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$opsi = $_GET['save'];

if ($opsi === 'pegawai') {
    $NIP = $_POST['nip'];
    $q="update MASTFIP08 set A_01='".substr($loker,0,2)."', A_02='".substr($loker,2,2)."',A_03='".substr($loker,4,2)."', A_04='".substr($loker,6,2)."',A_05='".substr($loker,8,2)."' where B_02='".$_POST['nip']."'";
    mysql_query($q) or die (mysql_error());
    if (mysql_affected_rows() > 0) { lethistory($sid,"UPDATE LOKASI KE ".subLokasiKerjaB($loker),$NIP); }
    
    $B_03=addslashes($B_03);
    $qupdate="update MASTFIP08 set B_02B='$B_02B',B_03A='$B_03A', B_03='$B_03', B_03B='$B_03B', ";
    $qupdate=$qupdate." B_04='$B_04', B_05='".date2mysql($TGLAHIR)."', ";
    $qupdate=$qupdate." B_06='$B_06',gd='$gd', B_07='$B_07', B_08='$B_08', B_09='$B_09', B_11='$B_11', B_12='$B_12', ";
    $qupdate=$qupdate." J_01='$J_01', L_1A='$L_1A', L_02='$L_02', L_03='$L_03', L_04='$L_04',B_NOTELP='$B_NOTELP',B_NOARSIP='$B_NOARSIP',nik='$nik' ";
    $qupdate=$qupdate." where B_02='".$_POST['nip']."'";
    //echo $qupdate;
    mysql_query($qupdate) or die(mysql_error());
    if (mysql_affected_rows() > 0) { 
        lethistory($sid,"UPDATE IDENTITAS",$NIP); 
    }
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'cpns') {
    $NIP = $_POST['nip'];
    $qupdate="update mastfip08 set D_02='$D_02', D_04='".date2mysql($TGTMTCAPEG)."',D_03='".date2mysql($TGSKCAPEG)."', D_05='$D_05' WHERE B_02='$NIP'";
    $res=mysql_query($qupdate) or die(mysql_error());	
    //upd_cp('1',$D_05,$D_02,$THSKCAPEG."-".$BLSKCAPEG."-".$TGSKCAPEG,$THTMTCAPEG."-".$BLTMTCAPEG."-".$TGTMTCAPEG,$NIP,$sid);
    //lethistory($sid,'UPDATE CPNS',$NIP);
    //update MASTPKT1 PF_01=1
    $jml=mysql_num_rows(mysql_query("select PF_01 from mastpkt1 where PF_01='$NIP' and PF_02='1' LIMIT 1"));
    if ($jml === 0)
    {
            $q  ="insert into mastpkt1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04', PF_01='$NIP',";
            $q .="PF_02='1',PF_03='$D_05', PF_04='$D_02', PF_06='".date2mysql($TGTMTCAPEG)."', ";
            $q .="PF_05='".date2mysql($TGSKCAPEG)."'";
            mysql_query($q) or die (mysql_error());
    }
    else
    {
            $q  ="update mastpkt1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04', ";
            $q .="PF_03='$D_05', PF_04='$D_02', PF_06='".date2mysql($TGTMTCAPEG)."', ";
            $q .="PF_05='".date2mysql($TGSKCAPEG)."' ";
            $q .="where PF_02='1' and PF_01='$NIP'";
            mysql_query($q) or die (mysql_error());
    }
    if (mysql_affected_rows() > 0) { lethistory($sid,"UPDATE CPNS",$NIP); }
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'pns') {
    $NIP = $_POST['nip'];
    // ----------------- update MASTFIP08
    $qupdate="update MASTFIP08 set E_02='$E_02', E_03='".date2mysql($TGSKPNS)."', E_04='".date2mysql($TGTMTPNS)."', E_05='$E_05', E_06='$E_06' WHERE B_02='$NIP'";
    $res=mysql_query($qupdate) or die(mysql_error());
    //upd_cp('2',$E_05,$E_02,$THSKPNS."-".$BLSKPNS."-".$TGSKPNS,$THTMTPNS."-".$BLTMTPNS."-".$TGTMTPNS,$NIP,$sid);
    //lethistory($sid,'UPDATE PNS',$NIP);
    //update MASTPKT1 PF_01=2
    $jml=mysql_num_rows(mysql_query("select PF_01 from MASTPKT1 where PF_01='$NIP' and PF_02='2' LIMIT 1"));
    if ($jml == 0)
    {
            $q  ="insert into MASTPKT1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04', PF_01='$NIP',";
            $q .="PF_02='2',PF_03='$E_05', PF_04='$E_02', PF_06='".date2mysql($TGTMTPNS)."', ";
            $q .="PF_05='".date2mysql($TGSKPNS)."'";
            mysql_query($q) or die (mysql_error());
    }
    else
    {
            $q  ="update MASTPKT1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04', ";
            $q .="PF_03='$E_05', PF_04='$E_02', PF_06='".date2mysql($TGTMTPNS)."', ";
            $q .="PF_05='".date2mysql($TGSKPNS)."' ";
            $q .="where PF_02='2' and PF_01='$NIP' LIMIT 1";
            mysql_query($q) or die (mysql_error());
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE PNS",$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'pangkat_gaji') {
    // update MASTFIP08
    $NIP = $_POST['nip'];
    if (strlen($F_04A) >= 0 && strlen($F_04A) < 2) $F_04A='0'.$F_04A;
    if (strlen($F_04B) >= 0 && strlen($F_04B) < 2) $F_04B='0'.$F_04B;
    if (strlen($G_02A) >= 0 && strlen($G_02A) < 2) $G_02A='0'.$G_02A;
    if (strlen($G_02B) >= 0 && strlen($G_02B) < 2) $G_02B='0'.$G_02B;


    //$myTh1=date("Y-m-d", mktime(0,0,0,$TGPKT,$BLPKT,$THPKT));
    //$mygaji1=date("Y-m-d", mktime(0,0,0,$TGGAJI,$BLGAJI,$THGAJI));
    $myTh1 = date2mysql($TGPKT);
    $mygaji1 = date2mysql($TGGAJI);
    if ($myTh1 > $mygaji1) {
        if ($F_04A > $G_02A) {
            $mymker=$G_02A;
        } else {
            $mymker=$F_04A;
        }
    } else {
        if ($F_04A < $G_02A) {
            $mymker=$G_02A;
        } else {
            $mymker=$F_04A;
        }
    }
    //echo $F_03." - ".$mymker;
    $G_03=gaji($F_03,$mymker);

    $q  ="update MASTFIP08 set F_01='$F_01', F_02='".date2mysql($TGGOL)."', ";
    $q .="F_SK='$F_SK', F_03='$F_03', F_PK='".pktH($F_03)."',F_04='".$F_04A.$F_04B."', G_01='".date2mysql($TGGAJI)."', ";
    $q .= "F_TMT = '".date2mysql($TGPKT)."',G_02='".$G_02A.$G_02B."', G_03='$G_03' where B_02='$NIP'";
    //echo $q;
    mysql_query($q) or die (mysql_error());
    lethistory($sid,'UPDATE PANGKAT DAN GAJI TERAKHIR '.pktH($F_03),$NIP);


    // update mastpkt1
    $q="select PF_02,PF_03 from MASTPKT1 where PF_01='$NIP' and PF_03='$F_03' LIMIT 1";
    $r=mysql_query($q);

    $PF_02=0;
    if (mysql_num_rows($r) == 0) {
        $q1="select PF_02 from MASTPKT1 where PF_01='$NIP' order by PF_02 desc";
        $r1=mysql_query($q1);
        $oo=mysql_fetch_array($r1);
        $PF_02=intval($oo['PF_02'])+1;
        // insert 
        $q  ="insert into MASTPKT1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04', ";
        $q .="PF_01='$NIP',PF_02='$PF_02',PF_03='$F_03',PF_04='$F_SK', ";
        $q .="PF_05='".date2mysql($TGGOL)."', PF_06='".date2mysql($TGPKT)."' ";
        mysql_query($q) or die (mysql_error());
    }
    else {
        $oo=mysql_fetch_array($r);
        $PF_02=$oo['PF_02'];
        $q  ="update MASTPKT1 set A_01='$A_01', A_02='$A_02',A_03='$A_03', A_04='$A_04',";
        $q .="PF_04='$F_SK', PF_05='".date2mysql($TGGOL)."', PF_06='".date2mysql($TGPKT)."' ";
        $q .="where PF_01='$NIP' and PF_02='$PF_02' and PF_03='$F_03'";
        mysql_query($q) or die (mysql_error());
    }
    lethistory($sid,'UPDATE RIWAYAT PANGKAT '.pktH($F_03),$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'jabatan') {
    
    //update MASTFIP08
    $NIP = $_POST['nip'];
    if ($I_5A=='1') $I_JB=addslashes(jabatan($I_05));
    if ($I_5A=='1' && $I_06=='99') $I_5A='4';

    $q  ="update MASTFIP08 set I_01='$I_01', I_02='$I_02', I_03='".date2mysql($TGSKJAB)."', ";
    $q .="I_04='".date2mysql($TGTMTJAB)."', I_05='$I_05', ";
    $q .="I_JB='$I_JB', I_5A='$I_5A',";
    $q .="I_06='$I_06' where B_02='$NIP'";
    //echo $q;

    mysql_query($q) or die (mysql_error());
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE JABATAN AKHIR ".getNaJab($NIP),$NIP);

    $xtmt=date2mysql($TGTMTJAB);
    $xskj=date2mysql($TGSKJAB);
    //----------update MASTJAB1------------
    $q="select * from MASTJAB1 where JF_03='$I_JB' and JF_01='$NIP' and JF_06='$xskj' and JF_07='$xtmt' and JF_04='$I_06' LIMIT 1";
    //echo $q;
    $r=mysql_query($q) or die(mysql_error());
    $j=mysql_num_rows($r);
    if ($j == 0)
    {
            $jmlrr=mysql_fetch_array(mysql_query("select JF_02 from MASTJAB1 where JF_01='$NIP' order by JF_02 desc limit 1"));
            $jmlr=$jmlrr[JF_02];
            $jmlr++;
            $q  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 	
            $q .="JF_01='$NIP',JF_02='$jmlr',JF_03='$I_JB',JF_04='$I_06',JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt'";
            //echo $q;
            //mysql_query($q) or die (mysql_error());
    }
    else
    {
            $aor=mysql_fetch_array(mysql_query("select ID from MASTJAB1 where JF_03='$I_JB' and JF_01='$NIP' and JF_06='$xskj' and JF_07='$xtmt' and JF_04='$I_06' LIMIT 1"));
            $nor=$aor[ID];
            $q  ="update MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 
            $q .="JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt' where ID='$nor'";
            //echo $q;
            mysql_query($q) or die (mysql_error());
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE RIWAYAT JABATAN".getNaJab($NIP),$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'pendidikan') {
    $NIP = $_POST['nip'];
    $arrtkdik=array('10'=>'SD','20'=>'SLTP','30'=>'SLTA','41'=>'D-I','42'=>'D-II','43'=>'D-III','44'=>'D-IV','50'=>'SARMUD','60'=>'SARMUD NON AK','70'=>'S1','80'=>'S2','90'=>'S3','99'=>'P');
    $jurusan=jurusan($H_1A,$H_1B);

    //-------------update dik umum akhir
    $tgl_ijazah=date2mysql($tg_H_TGL_IJAZAH);
    $th_H_TGL_IJAZAH = substr($tgl_ijazah, 0, 4);
    $q1="update MASTFIP08 set H_1A='$H_1A', H_1B='$H_1B', H_02='$th_H_TGL_IJAZAH',H_SEKOLAH='$H_SEKOLAH',H_TEMPAT='$H_TEMPAT',H_KASEK='$H_KASEK',
    H_IJAZAH='$H_IJAZAH',H_TGL_IJAZAH='$tgl_ijazah' where B_02='$NIP'";
    //echo $q1;
    mysql_query($q1) or die (mysql_error());
    if (mysql_affected_rows() > 0) lethistory($sid,'UPDATE DIK UMUM AKHIR '.tktDidik($H_1A).' '.jurusan($H_1A,$H_1B),$NIP);

    //-------------update rwyt dik umum'
    $qc="select * from MSTPEND1 where DK_01='$NIP' and DK_03='$arrtkdik[$H_1A]'";
    $rc=mysql_query($qc) or die(mysql_error());
    if (mysql_num_rows($rc)>0) {
            $q="update MSTPEND1 set DK_04='$jurusan',DK_05='$H_SEKOLAH',DK_06='$H_TEMPAT',DK_07='$H_KASEK',DK_08='$H_IJAZAH',DK_09='$tgl_ijazah'
            where DK_01='$NIP' and DK_03='$arrtkdik[$H_1A]'";
    } else {
            $q="insert into MSTPEND1 set DK_04='$jurusan',DK_05='$H_SEKOLAH',DK_06='$H_TEMPAT',DK_07='$H_KASEK',DK_08='$H_IJAZAH',DK_09='$tgl_ijazah',
            DK_01='$NIP',DK_03='$arrtkdik[$H_1A]'";
    }
    mysql_query($q) or die(mysql_error());
    if (mysql_affected_rows() > 0) lethistory($sid,'UPDATE RIWAYAT DIK UMUM',$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'dikstruakhir') {
    $NIP = $_POST['nip'];
    $q1="update MASTFIP08 set H_4A='$H_4A', H_4B='".date2mysql($TGDIKSTRU)."' where B_02='$NIP'";
    mysql_query($q1) or die (mysql_error());
    lethistory($sid,'UPDATE DIK STRU AKHIR '.dikStru($H_4A),$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'ortu') {
    $NIP = $_POST['nip'];
    //------------------- CEK DATA AYAH ---------------------------
    $q1="select count(*) from MSTORTU1 WHERE NM_02='1' AND NM_01='$NIP' LIMIT 0,1";
    $r=mysql_query($q1);
    $o=mysql_fetch_array($r);
    if ($o['count(*)']=='1')
    {
            //----------------UPDATE DATA AYAH -----------------
            $NM_041=addslashes($NM_041);
            $q  ="update MSTORTU1 set NM_04='$NM_041',NM_05='$NM_051',NM_06='".date2mysql($TGNM_061)."', ";
            $q .="NM_07='$NM_071' WHERE NM_02='1' AND NM_01='$NIP'";
            $r=mysql_query($q);
            //echo $q;
    }
    else
    {
            //----------------INSERT DATA AYAH
            $NM_041=addslashes($NM_041);
            $q  ="insert into MSTORTU1 (NM_01,NM_02,NM_03,NM_04,NM_05,NM_06,NM_07) VALUES ";
            $q .="('$NIP','1','AYAH','$NM_041','$NM_051','".date2mysql($TGNM_061)."', ";
            $q .="'$NM_071') ";
            $r=mysql_query($q);
            //echo $q;
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE DATA AYAH",$NIP);

    //------------------- CEK DATA IBU ---------------------------
    $q1="select count(*) from MSTORTU1 WHERE NM_02='2' AND NM_01='$NIP' LIMIT 0,1";
    $r=mysql_query($q1);
    $o=mysql_fetch_array($r);
    if ($o['count(*)']=='1')
    {
            //----------------UPDATE DATA IBU -----------------
            $NM_042=addslashes($NM_042);
            $q  ="update MSTORTU1 set NM_04='$NM_042',NM_05='$NM_052',NM_06='".date2mysql($TGNM_062)."', ";
            $q .="NM_07='$NM_072' WHERE NM_02='2' AND NM_01='$NIP'";
            $r=mysql_query($q);
            //echo $q;
    }
    else
    {
            //----------------INSERT DATA IBU--------------------
            $NM_042=addslashes($NM_042);
            $q  ="insert into MSTORTU1 (NM_01,NM_02,NM_03,NM_04,NM_05,NM_06,NM_07) VALUES ";
            $q .="('$NIP','2','IBU','$NM_042','$NM_052','".date2mysql($TGNM_062)."', ";
            $q .="'$NM_072') ";
            $r=mysql_query($q);
            //echo $q;
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE DATA IBU",$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'keluarga') {
    $NIP = $_POST['nip'];
    $q="select count(*) from MASTKEL1 WHERE KF_01='$NIP' AND KF_02='1' AND KF_03='1' LIMIT 0,1";
    $r=mysql_query($q);
    $o=mysql_fetch_array($r);
    if ($ini=='DATA SUAMI') { $KF_10='LAKI-LAKI'; } else { $KF_10='PEREMPUAN'; }
    
    $nip_couple = $_POST['KF_04'];
    if ($o['count(*)']>'0')
    {
            //------------- UPDATE SUAMI/ISTRI---------------

            $q  ="update MASTKEL1 set KF_02='1',KF_03='1', `NIP_COUPLE` = '$nip_couple', ";
            $q .="KF_05='".date2mysql($TGKF_05)."',an='$an',KF_06='".date2mysql($TGKF_06)."', ";
            $q .="KF_07='$KF_07',KF_08='', ";
            $q .="KF_09='$KF_09',KF_10='$KF_10' WHERE KF_01='$NIP' AND KF_02='1' AND KF_03='1'";
            $r=mysql_query($q); 
    }
    else
    {
            //------------- INSERT SUAMI/ISTRI-----------------
            $q  ="insert into MASTKEL1 (KF_01,KF_02,KF_03,KF_04,KF_05,an,KF_06,KF_07,KF_08,KF_09,KF_10,NIP_COUPLE) VALUES ";
            $q .="('$NIP','1','1',NULL,'".date2mysql($TGKF_05)."','$an','".date2mysql($TGKF_06)."', ";
            $q .="'$KF_07','','$KF_09','$KF_10','$nip_couple') ";
            $r=mysql_query($q); 
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE DATA SUAMI/ISTRI",$NIP);
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'usersystem') {
    $password_baru = md5($_POST['password_baru']);
    $password_baru1= md5($_POST['password_baru1']);
    $id_user       = $_POST['id'];
    $nip           = $_POST['nama'];
    
    $username      = $_POST['username'];
    $id_group      = $_POST['group_user'];
    if ($password_baru!=='') {
        if ($password_baru!=$password_baru1) {
                $msg="Password tidak sama.";
        } else {
                if ($id_user !== '') {
                        $qi="update USER set B_02 = '$nip', username='$username',password='$password_baru',id_group_user='$id_group' where id = '$id_user'";
                } else {
                        $qi="insert into USER set B_02 = '$nip', username='$username',password='$password_baru',id_group_user='$id_group'";
                }
                $ri=mysql_query($qi) or die(mysql_error());
                if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
        }
    } else {
        if ($id_user !== '') {
                $qi="update USER set B_02 = '$nip', username='$username',id_group_user='$id_group' where id = '$id_user'";
        } else {
                $qi="insert into USER set B_02 = '$nip', username='$username',id_group_user='$id_group'";
        }
        $ri=mysql_query($qi) or die(mysql_error());
        if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
    }
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'groupusersystem') {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    if ($id !== '') {
        mysql_query("update group_users set nama = '$nama' where id = '$id'") or die(mysql_error());
        if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
        $act = "edit";
    } else {
        mysql_query("insert into group_users (nama) VALUES ('$nama')") or die(mysql_error());
        $act = "add";
    }
    die(json_encode(array('status' => TRUE, 'act' => $act)));
}

if ($opsi === 'hakakses') {
    $id_group   = $_POST['id'];
    $privileges = $_POST['data'];
    if (is_array($privileges)) {
        mysql_query("delete from grant_privileges where id_group_users = '$id_group'");
        foreach ($privileges as $key => $data) {
            $insert = "insert into grant_privileges set
                id_group_users = '$id_group',
                id_privileges = '$data'";
            mysql_query($insert);
        }
    }
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'skpsetting') {
    $id         = $_POST['id'];
    $nama       = $_POST['nama'];
    $jml_bln    = $_POST['jml_bulan'];
    $target     = $_POST['target'];
    if ($id === '') {
        mysql_query("insert into kegiatan_skp set nama = '$nama', jumlah_bulan = '$jml_bln', target = '$target'");
        $act = 'add';
    } else {
        mysql_query("update kegiatan_skp set nama = '$nama', jumlah_bulan = '$jml_bln', target = '$target' where id = '$id'");
        $act = 'edit';
    }
    die(json_encode(array('status' => TRUE, 'act' => $act)));
}

if ($opsi === 'skp') {
    $nip    = $_POST['nama'];
    $id_keg = $_POST['kegiatan'];
    $jumlah = $_POST['jumlah'];
    mysql_query("insert into rekap_skp set id_kegiatan_skp = '$id_keg', B_02 = '$nip', jumlah = '$jumlah'");
    die(json_encode(array('status' => TRUE)));
}

if ($opsi === 'kategori_arsip') {
    $id     = $_POST['id'];
    $nama   = $_POST['nama'];
    $keterangan = $_POST['keterangan'];
    if ($id === '') {
        $sql = "insert into arsip_kategori set nama = '$nama', keterangan = '$keterangan'";
        $act = 'add';
    } else {
        $sql = "update arsip_kategori set nama = '$nama', keterangan = '$keterangan' where id = '$id'";
        $act = 'edit';
    }
    mysql_query($sql);
    die(json_encode(array('status' => TRUE, 'act' => $act)));
}
?>
