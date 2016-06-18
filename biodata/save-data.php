<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$opsi = $_GET['save'];

if ($opsi === 'lokasi_pegawai') {
    $loker  = $_POST['loker'];
    $B_02B  = $_POST['nip'];
    $q="update MASTFIP08 set A_01='".substr($loker,0,2)."', A_02='".substr($loker,2,2)."',A_03='".substr($loker,4,2)."', A_04='".substr($loker,6,2)."',A_05='".substr($loker,8,2)."' where B_02='".$B_02B."'";
    
    mysql_query($q) or die (mysql_error());
    if (mysql_affected_rows() > 0) { lethistory($sid,"UPDATE LOKASI KE ".subLokasiKerjaB($loker),$B_02B); }
    die(json_encode(array('act' => 'edit')));
}
if ($opsi === 'pegawai') {
    $NIP    = $_POST['nip'];
    $B_02B  = $_POST['B_02B'];
    $B_03A  = $_POST['B_03A'];
    $sid    = $_POST['sid'];
    $TGLAHIR= $_POST['TGLAHIR'];
    $B_03B  = $_POST['B_03B'];
    $B_04   = $_POST['B_04'];
    $B_06   = $_POST['B_06'];
    $B_07   = $_POST['B_07'];
    $B_08   = $_POST['B_08'];
    $B_09   = $_POST['B_09'];
    $B_11   = $_POST['B_11'];
    $B_12   = $_POST['B_12'];
    $gd     = $_POST['gd'];
    $J_01   = $_POST['J_01'];
    $L_1A   = $_POST['L_1A'];
    $L_02   = $_POST['L_02'];
    $L_03   = $_POST['L_03'];
    $L_04   = $_POST['L_04'];
    $B_NOTELP   = $_POST['B_NOTELP'];
    $B_NOARSIP  = $_POST['B_NOARSIP'];
    $nik    = $_POST['nik'];
    $kelrhn = ($_POST['kecamatan'] !== '')?$_POST['kecamatan']:"NULL";
    $check = mysql_num_rows(mysql_query("select B_02B from mastfip08 where B_02B = '$B_02B'"));
    $result['act'] = 'edit';
    $UploadDirectory	= '../Foto/'; //Upload Directory, ends with slash & make sure folder exist
    $NewFileName= "";
    if ($check === 0) {
        $insert = "insert into mastfip08 set B_02 = '$B_02B', B_02B = '$B_02B'";
        mysql_query($insert);
        $result['act'] = 'add';
        $result['nip'] = $B_02B;
    }
    if(isset($_FILES['mFile']['name'])) {

            $foto               = $_POST['mFile'];
            $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
            $FileTitle		= $B_02B;
            $ImageExt		= substr($FileName, strrpos($FileName, '.')); //file extension
            $FileType		= $_FILES['mFile']['type']; //file type
            //$FileSize		= $_FILES['mFile']["size"]; //file size
            $RandNumber   		= rand(0, 999); //Random number to make each filename unique.
            //$uploaded_date		= date("Y-m-d H:i:s");
            if ($foto !== '') {
                @unlink('../Foto/'.$foto);
            }
            switch(strtolower($FileType))
            {
                    //allowed file types
                    case 'image/png': //png file
//                        case 'image/gif': //gif file 
                    case 'image/jpeg': //jpeg file
//                        case 'application/pdf': //PDF file
//                        case 'application/msword': //ms word file
//                        case 'application/vnd.ms-excel': //ms excel file
//                        case 'application/x-zip-compressed': //zip file
//                        case 'text/plain': //text file
//                        case 'text/html': //html file
                            break;
                    default:
                            die('Unsupported File!'); //output error
            }


            //File Title will be used as new File name
            $NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle));
            $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
       //Rename and save uploded file to destination folder.
       if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName ))
       {
           mysql_query("update mastfip08 set foto = '$NewFileName' where B_02B = '".$B_02B."'");
           if (mysql_affected_rows() > 0) { lethistory($sid,"UPDATE FOTO ",$B_02B); }
       } else {
            die('error uploading File!');
       }
    }
    
    $B_03=addslashes($_POST['B_03']);
    $qupdate="update MASTFIP08 set B_02B='$B_02B',B_03A='$B_03A', B_03='$B_03', B_03B='$B_03B', ";
    $qupdate=$qupdate." B_04='$B_04', B_05='".date2mysql($TGLAHIR)."', ";
    $qupdate=$qupdate." B_06='$B_06',gd='$gd', B_07='$B_07', B_08='$B_08', B_09='$B_09', B_11='$B_11', B_12='$B_12', ";
    $qupdate=$qupdate." J_01='$J_01', L_1A='$L_1A', L_02='$L_02', L_03='$L_03', L_04='$L_04',B_NOTELP='$B_NOTELP',B_NOARSIP='$B_NOARSIP',nik='$nik', id_lokasi = $kelrhn ";
    $qupdate=$qupdate." where B_02B='".$B_02B."'";
    //echo $qupdate;
    mysql_query($qupdate) or die(mysql_error());
    if (mysql_affected_rows() > 0) { 
        lethistory($sid,"UPDATE IDENTITAS",$B_02B); 
    }
    
    $pegawai = mysql_fetch_array(mysql_query("select CONCAT_WS(' ',`B_02B`,' | ', `B_03`, `B_03B`) as identitas from mastfip08 where `B_02B` = '".$B_02B."' "));
    $result['identitas'] = $pegawai['identitas'];
    die(json_encode($result));
}

else if ($opsi === 'delete_user') {
    $id = $_GET['id'];
    mysql_query("delete from `user` where id = '$id'");
}

else if ($opsi === 'delete_pegawai') {
	$nip = $_GET['nip'];
	mysql_query("delete from mastfip08 where B_02 = '$nip'");
}

else if ($opsi === 'cpns') {
    $NIP    = $_POST['nip'];
    $D_02   = $_POST['D_02'];
    $TGTMTCAPEG = $_POST['TGTMTCAPEG'];
    $TGSKCAPEG  = $_POST['TGSKCAPEG'];
    $D_05   = $_POST['D_05'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $qupdate="update mastfip08 set D_02='$D_02', D_04='".date2mysql($TGTMTCAPEG)."',D_03='".date2mysql($TGSKCAPEG)."', D_05='$D_05' WHERE B_02='$NIP'";
    $res=mysql_query($qupdate) or die(mysql_error());	
    //upd_cp('1',$D_05,$D_02,$THSKCAPEG."-".$BLSKCAPEG."-".$TGSKCAPEG,$THTMTCAPEG."-".$BLTMTCAPEG."-".$TGTMTCAPEG,$NIP,$sid);
    lethistory($sid,'UPDATE CPNS',$NIP);
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

else if ($opsi === 'pns') {
    $NIP    = $_POST['nip'];
    $E_02   = $_POST['E_02'];
    $TGSKPNS= $_POST['TGSKPNS'];
    $TGTMTPNS = $_POST['TGTMTPNS'];
    $E_05   = $_POST['E_05'];
    $E_06   = $_POST['E_06'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    // ----------------- update MASTFIP08
    $qupdate="update MASTFIP08 set E_02='$E_02', E_03='".date2mysql($TGSKPNS)."', E_04='".date2mysql($TGTMTPNS)."', E_05='$E_05', E_06='$E_06' WHERE B_02='$NIP'";
    $res=mysql_query($qupdate) or die(mysql_error());
    //upd_cp('2',$E_05,$E_02,$THSKPNS."-".$BLSKPNS."-".$TGSKPNS,$THTMTPNS."-".$BLTMTPNS."-".$TGTMTPNS,$NIP,$sid);
    lethistory($sid,'UPDATE PNS',$NIP);
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

else if ($opsi === 'pangkat_gaji') {
    /*ALTER TABLE `mastfip08`  ADD `ipg_nomor` VARCHAR(100) NOT NULL,  ADD `ipg_tgl_surat` DATE NOT NULL,  ADD `ipg_tmt` DATE NOT NULL,  ADD `ib_nomor` VARCHAR(100) NOT NULL,  ADD `ib_tgl_surat` DATE NOT NULL,  ADD `ib_tmt` INT NOT NULL,  ADD `pi_nomor` VARCHAR(100) NOT NULL,  ADD `pi_tgl_surat` DATE NOT NULL,  ADD `pi_tmt` DATE NOT NULL;*/
    // update MASTFIP08
    $NIP = $_POST['nip'];
    $F_04A  = $_POST['F_04A'];
    $F_04B  = $_POST['F_04B'];
    $G_02A  = $_POST['G_02A'];
    $G_02B  = $_POST['G_02B'];
    $TGPKT  = $_POST['TGPKT'];
    $TGGAJI = $_POST['TGGAJI'];
    $F_03   = $_POST['F_03'];
    $F_01   = $_POST['F_01'];
    $TGGOL  = $_POST['TGGOL'];
    $F_SK   = $_POST['F_SK'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    
    /*TAMBAHAN BARU*/
    $ipg_no_surat  = $_POST['nomorsurat'];
    $ipg_tgl_surat = date2mysql($_POST['tglsurat']);
    $ipg_tmt       = date2mysql($_POST['tmt_ijin_penggunaan_gelar']);
    
    $ib_nomor      = $_POST['nomorsurat_ijin_belajar'];
    $ib_tgl_surat  = date2mysql($_POST['tglsurat_ijin_belajar']);
    $ib_tmt        = date2mysql($_POST['tmt_ijin_belajar']);
    
    $pi_nomor      = $_POST['nomorsurat_penyesuaian_ijasah'];
    $pi_tgl_surat  = date2mysql($_POST['tglsurat_penyesuaian_ijasah']);
    $pi_tmt        = date2mysql($_POST['tmt_penyesuaian_ijasah']);
    
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
    $q .=" ipg_nomor = '$ipg_no_surat', ipg_tgl_surat = '$ipg_tgl_surat', ipg_tmt = '$ipg_tmt', ";
    $q .=" ib_nomor = '$ib_nomor', ib_tgl_surat = '$ib_tgl_surat', ib_tmt = '$ib_tmt', ";
    $q .=" pi_nomor = '$pi_nomor', pi_tgl_surat = '$pi_tgl_surat', pi_tmt = '$pi_tmt', ";
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

else if ($opsi === 'jabatan') {
    
    //update MASTFIP08
    $NIP    = $_POST['nip'];
    $I_5A   = $_POST['I_5A'];
    $I_05   = $_POST['I_05'];
    $I_06   = $_POST['I_06'];
    $I_01   = $_POST['I_01'];
    $I_02   = $_POST['I_02'];
    
    $q="select KOJFU,NAJFU from TABJFU where KOJFU='$I_05'";
    $r=mysql_query($q) or die(mysql_error());
    $xo=mysql_fetch_array($r);
    
    $I_JB   = $_POST['I_JB'];
    $I_07   = isset($_POST['I_07'])?$_POST['I_07']:'';
    $TGSKJAB= $_POST['TGSKJAB'];
    $TGTMTJAB = $_POST['TGTMTJAB'];
    
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    if ($I_5A=='1') { $I_JB=addslashes(jabatan($I_05)); }
    if ($I_5A=='1' && $I_06=='99') { $I_5A='4'; }
    
    $q  ="update MASTFIP08 set I_01='$I_01', I_02='$I_02', I_03='".date2mysql($TGSKJAB)."', ";
    $q .="I_04='".date2mysql($TGTMTJAB)."', I_05='$I_05', ";
    $q .="I_JB='$I_JB', I_5A='$I_5A', I_07 = '$I_07', ";
    
    $q .="I_06='$I_06' where B_02='$NIP'";
    //echo $q;

    mysql_query($q) or die (mysql_error());
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE JABATAN AKHIR ".getNaJab($NIP),$NIP);

    $xtmt=date2mysql($TGTMTJAB);
    $xskj=date2mysql($TGSKJAB);
    $get_lokasi = tampil_lokasi($A_01, $A_02, $A_03, $A_04);
    $lokasi = ($get_lokasi !== '')?$get_lokasi:NULL;
    //----------update MASTJAB1------------
    $q="select * from MASTJAB1 where JF_03='$I_JB ".$lokasi."' and JF_01='$NIP' and JF_06='$xskj' and JF_07='$xtmt' and JF_04='$I_06' LIMIT 1";
    //echo $q;
    $r=mysql_query($q) or die(mysql_error());
    $j=mysql_num_rows($r);
    if ($j == 0)
    {
            $jmlrr=mysql_fetch_array(mysql_query("select JF_02 from MASTJAB1 where JF_01='$NIP' order by JF_02 desc limit 1"));
            $jmlr=$jmlrr[JF_02];
            $jmlr++;
            $q  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 	
            $q .="JF_01='$NIP',JF_02='$jmlr',JF_03='$I_JB ".$lokasi."',JF_04='$I_06',JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt'";
            //echo $q;
            mysql_query($q) or die (mysql_error());
            
            if (isset($_POST['is_kepala_sekolah'])) {
                $I_06 = $_POST['I_06x'];
                $I_02 = $_POST['I_02x'];
                $I_01 = $_POST['I_01x'];
                $xskj=date2mysql($_POST['TGSKJABx']);
                $xtmt=date2mysql($_POST['TGTMTJABx']);
                
                $get_lokasi = tampil_lokasi($A_01, $A_02, $A_03, $A_04);
                $lokasi = ($get_lokasi !== '')?$get_lokasi:NULL;
                $ks  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 	
                $ks .="JF_01='$NIP',JF_02='".($jmlr+1)."',JF_03='KEPALA SEKOLAH ".$lokasi."', ";
                $ks .="JF_04='$I_06',JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt'";
                //echo $ks;
                mysql_query($ks) or die (mysql_error());
                
                mysql_query("update mastfip08 set is_kepala_sekolah = 'Ya', I_01_kepsek = '$I_01' where `B_02B` = '".$NIP."' or `B_02` = '".$NIP."'");
            } else {
                mysql_query("update mastfip08 set is_kepala_sekolah = 'Tidak', I_01_kepsek = '' where `B_02B` = '".$NIP."' or `B_02` = '".$NIP."'");
            }
    }
    else
    {
            $aor=mysql_fetch_array(mysql_query("select ID from MASTJAB1 where JF_03='$I_JB ".$lokasi."' and JF_01='$NIP' and JF_06='$xskj' and JF_07='$xtmt' and JF_04='$I_06' LIMIT 1"));
            $nor=$aor[ID];
            $jmlrr=mysql_fetch_array(mysql_query("select JF_02 from MASTJAB1 where JF_01='$NIP' order by JF_02 desc limit 1"));
            $jmlr=$jmlrr[JF_02];
            $jmlr++;
            
            $q  ="update MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 
            $q .="JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt' where ID='$nor'";
            
            mysql_query($q) or die (mysql_error());
            if (isset($_POST['is_kepala_sekolah'])) {
                
                $I_06 = $_POST['I_06x'];
                $I_02 = $_POST['I_02x'];
                $I_01 = $_POST['I_01x'];
                $xskj=date2mysql($_POST['TGSKJABx']);
                $xtmt=date2mysql($_POST['TGTMTJABx']);
                
                $get_lokasi = tampil_lokasi($A_01, $A_02, $A_03, $A_04);
                $lokasi = ($get_lokasi !== '')?$get_lokasi:NULL;
                
                // check jika sudah kepala sekolah
                $check = mysql_num_rows(mysql_query("select * from MASTJAB1 where 
                    A_01 = '$A_01' and A_02 = '$A_02' and A_03 = '$A_03' and A_04 = '$A_04' and
                    JF_01 = '$NIP' and JF_03 = 'KEPALA SEKOLAH ".$lokasi."'"));
                if ($check === 0) {
                    $ks  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 	
                    $ks .="JF_01='$NIP',JF_02='".($jmlr)."',JF_03='KEPALA SEKOLAH ".$lokasi."',";
                    $ks .="JF_04='$I_06',JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt'";
                    //echo $ks;
                    mysql_query($ks) or die (mysql_error());
                } else {
                    mysql_query("delete from MASTJAB1 where 
                    A_01 = '$A_01' and A_02 = '$A_02' and A_03 = '$A_03' and A_04 = '$A_04' and
                    JF_01 = '$NIP' and JF_03 = 'KEPALA SEKOLAH ".$lokasi."'");
                    
                    $jmlrr=mysql_fetch_array(mysql_query("select JF_02 from MASTJAB1 where JF_01='$NIP' order by JF_02 desc limit 1"));
                    $jmlr=$jmlrr[JF_02];
                    $jmlr++;
                    
                    $ks  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', "; 	
                    $ks .="JF_01='$NIP',JF_02='".($jmlr)."',JF_03='KEPALA SEKOLAH ".$lokasi."',";
                    $ks .="JF_04='$I_06',JF_05='$I_02',JF_06='$xskj', JF_07='$xtmt'";
                    //echo $ks;
                    mysql_query($ks) or die (mysql_error());
                }
                
                mysql_query("update mastfip08 set is_kepala_sekolah = 'Ya', I_01_kepsek = '$I_01' where `B_02B` = '".$NIP."' or `B_02` = '".$NIP."'");
            } else {
                mysql_query("update mastfip08 set is_kepala_sekolah = 'Tidak', I_01_kepsek = '' where `B_02B` = '".$NIP."' or `B_02` = '".$NIP."'");
            }
    }
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE RIWAYAT JABATAN".getNaJab($NIP),$NIP);
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'pendidikan') {
    $NIP = $_POST['nip'];
    $H_1A   = $_POST['H_1A'];
    $H_1B   = $_POST['H_1B'];
    $arrtkdik=array('10'=>'SD','20'=>'SLTP','30'=>'SLTA','41'=>'D-I','42'=>'D-II','43'=>'D-III','44'=>'D-IV','50'=>'SARMUD','60'=>'SARMUD NON AK','70'=>'S1','80'=>'S2','90'=>'S3','99'=>'P');
    $jurusan=jurusan($H_1A,$H_1B);

    //-------------update dik umum akhir
    $tg_H_TGL_IJAZAH = $_POST['tg_H_TGL_IJAZAH'];
    $tgl_ijazah=date2mysql($tg_H_TGL_IJAZAH);
    $th_H_TGL_IJAZAH = substr($tgl_ijazah, 0, 4);
    $H_SEKOLAH  = $_POST['H_SEKOLAH'];
    $H_TEMPAT   = $_POST['H_TEMPAT'];
    $H_KASEK    = $_POST['H_KASEK'];
    $H_IJAZAH   = $_POST['H_IJAZAH'];
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

else if ($opsi === 'dikstruakhir') {
    $NIP    = $_POST['nip'];
    $H_4A   = $_POST['H_4A'];
    $TGDIKSTRU  = $_POST['TGDIKSTRU'];
    $q1="update MASTFIP08 set H_4A='$H_4A', H_4B='".date2mysql($TGDIKSTRU)."' where B_02='$NIP'";
    mysql_query($q1) or die (mysql_error());
    lethistory($sid,'UPDATE DIK STRU AKHIR '.dikStru($H_4A),$NIP);
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'ortu') {
    $NIP = $_POST['nip'];
    //------------------- CEK DATA AYAH ---------------------------
    $q1="select count(*) from MSTORTU1 WHERE NM_02='1' AND NM_01='$NIP' LIMIT 0,1";
    $r=mysql_query($q1);
    $o=mysql_fetch_array($r);
    
    $NM_041 = $_POST['NM_041'];
    $NM_051 = $_POST['NM_051'];
    $TGNM_061 = $_POST['TGNM_061'];
    if ($o['count(*)']=='1')
    {
            //----------------UPDATE DATA AYAH -----------------
            
            $NM_041=addslashes($NM_041);
            
            $NM_071 = $_POST['NM_071'];
            $q  ="update MSTORTU1 set NM_04='$NM_041',NM_05='$NM_051',NM_06='".date2mysql($TGNM_061)."', ";
            $q .="NM_07='$NM_071' WHERE NM_02='1' AND NM_01='$NIP'";
            $r=mysql_query($q);
            //echo $q;
    }
    else
    {
            //----------------INSERT DATA AYAH
            $NM_071 = $_POST['NM_071'];
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
    $NM_042     = $_POST['NM_042'];
    $TGNM_062   = $_POST['TGNM_062'];
    $NM_072     = $_POST['NM_072'];
    $NM_052     = $_POST['NM_052'];
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

else if ($opsi === 'keluarga') {
    $NIP    = $_POST['nip'];
    $ini    = $_POST['ini'];
    $q="select count(*) from MASTKEL1 WHERE KF_01='$NIP' AND KF_02='1' AND KF_03='1' LIMIT 0,1";
    $r=mysql_query($q);
    $o=mysql_fetch_array($r);
    if ($ini=='DATA SUAMI') { $KF_10='LAKI-LAKI'; } else { $KF_10='PEREMPUAN'; }
    
    $nip_couple = ($_POST['KF_04'] !== '')?$_POST['KF_04']:"NULL";
    $TGKF_05    = $_POST['TGKF_05'];
    $TGKF_06    = $_POST['TGKF_06'];
    $an         = $_POST['an'];
    $KF_07      = $_POST['KF_07'];
    $KF_09      = $_POST['KF_09'];
    $pasangan   = $_POST['pasangan_nonpns'];
    if ($nip_couple !== 'NULL') {
        $nip = mysql_fetch_array(mysql_query("select B_02, CONCAT_WS(' ',B_03, B_03B) as nama from mastfip08 where B_02B = '$nip_couple'"));
        $nip_couple = $nip['B_02'];
        $pasangan = $nip['nama'];
    }
    if ($o['count(*)']>'0')
    {
            //------------- UPDATE SUAMI/ISTRI---------------

            $q  ="update MASTKEL1 set KF_02='1',KF_03='1', KF_04 = '$pasangan', `NIP_COUPLE` = ".(($nip_couple !== 'NULL')?"'$nip_couple'":'NULL').",";
            $q .="KF_05='".date2mysql($TGKF_05)."',an='$an',KF_06='".date2mysql($TGKF_06)."', ";
            $q .="KF_07='$KF_07',KF_08='', ";
            $q .="KF_09='$KF_09',KF_10='$KF_10' WHERE KF_01='$NIP' AND KF_02='1' AND KF_03='1'";
            $r=mysql_query($q); 
    }
    else
    {
            //------------- INSERT SUAMI/ISTRI-----------------
            $q  ="insert into MASTKEL1 (KF_01,KF_02,KF_03,KF_04,KF_05,an,KF_06,KF_07,KF_08,KF_09,KF_10,NIP_COUPLE) VALUES ";
            $q .="('$NIP','1','1','$pasangan','".date2mysql($TGKF_05)."','$an','".date2mysql($TGKF_06)."', ";
            $q .="'$KF_07','','$KF_09','$KF_10',".(($nip_couple !== 'NULL')?"'$nip_couple'":'NULL').") ";
            $r=mysql_query($q); 
    }
    //echo $q; die;
    if (mysql_affected_rows() > 0) lethistory($sid,"UPDATE DATA SUAMI/ISTRI",$NIP);
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'anak') {
    $NIP   = $_POST['nip'];
    $KF_03 = $_POST['KF_03'];
    $KF_04 = $_POST['KF_04'];
    $KF_07 = $_POST['KF_07'];
    $KF_08 = $_POST['KF_08'];
    $KF_09 = $_POST['KF_09'];
    $KF_10 = $_POST['KF_10'];
    $upd   = $_POST['upd'];
    $KF_05 = $_POST['TGKF_05'];
    $ID    = $_POST['ID'];
    mysql_query("delete from MASTKEL1 where KF_01 = '$NIP' and KF_02 = '2'");
    foreach ($KF_03 as $i => $data) {
        
        $q="insert into MASTKEL1 (KF_01,KF_02,KF_03,KF_04,KF_05,KF_07,KF_08,KF_09,KF_10) ";
        $q=$q."values ('$NIP','2','$KF_03[$i]','".addslashes(strtoupper($KF_04[$i]))."','".date2mysql($KF_05[$i])."','$KF_07[$i]','$KF_08[$i]','".addslashes(strtoupper($KF_09[$i]))."', '$KF_10[$i]' )";
        
//        else {
//            $q="update MASTKEL1 set KF_02=2,KF_03=$KF_03[$i], KF_04='".addslashes(strtoupper($KF_04[$i]))."', KF_05='".date2mysql($KF_05[$i])."', KF_07='$KF_07[$i]', KF_08='$KF_08[$i]', KF_09='".addslashes(strtoupper($KF_09[$i]))."', KF_10='$KF_10[$i]' where KF_01='$NIP' and KF_02='2' and ID='$ID[$i]' ";
//        }
        mysql_query($q) or die (mysql_error());
        if (mysql_affected_rows() > 0) { lethistory($sid,"UPDATE DATA ANAK ".addslashes(strtoupper($KF_04[$i])),$NIP); }
    }
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'usersystem') {
    $password_baru = $_POST['password_baru'];
    $password_baru1= $_POST['password_baru1'];
    $id_user       = $_POST['id'];
    $nip           = $_POST['nama'];
    
    $username      = $_POST['username'];
    $id_group      = $_POST['group_user'];
    
    if ($password_baru!=='') {
        
        if ($id_user !== '') {
                $qi="update USER set B_02 = '$nip', username='$username',password='".md5($password_baru)."',id_group_user='$id_group' where id = '$id_user'";
        } else {
                $qi="insert into USER set B_02 = '$nip', username='$username',password='".md5($password_baru)."',id_group_user='$id_group'";
        }
        $ri=mysql_query($qi) or die(mysql_error());
        if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
        
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

else if ($opsi === 'groupusersystem') {
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

else if ($opsi === 'hakakses') {
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

else if ($opsi === 'skpsetting') {
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

else if ($opsi === 'skp') {
    $nip    = $_POST['nama'];
    $id_keg = $_POST['kegiatan'];
    $jumlah = $_POST['jumlah'];
    mysql_query("insert into rekap_skp set id_kegiatan_skp = '$id_keg', B_02 = '$nip', jumlah = '$jumlah'");
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'kategori_arsip') {
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

else if ($opsi === 'arsip_digital') {
    $id = $_POST['id'];
    $UploadDirectory	= '../arsip/'; //Upload Directory, ends with slash & make sure folder exist
    $NewFileName= "";
    $id_kategori= $_POST['kategori'];
    $nip        = $_POST['nip'];
    $keterangan = $_POST['keterangan'];
    //die($UploadDirectory);
        // replace with your mysql database details
    if (!@file_exists($UploadDirectory)) {
            //destination folder does not exist
            die('No upload directory');
    }
    if ($id === '') {
        if(isset($_FILES['mFile']['name'])) {

                $foto               = $_POST['foto'];
                $FileName           = strtolower($_FILES['mFile']['name']); //uploaded file name
                $FileTitle		= $_POST['nama_arsip'].'_'.$nip;
                $ImageExt		= substr($FileName, strrpos($FileName, '.')); //file extension
                $FileType		= $_FILES['mFile']['type']; //file type
                //$FileSize		= $_FILES['mFile']["size"]; //file size
                $RandNumber   		= rand(0, 99999); //Random number to make each filename unique.
                //$uploaded_date		= date("Y-m-d H:i:s");
                if ($foto !== '') {
                    @unlink('../arsip/'.$foto);
                }
                switch(strtolower($FileType))
                {
                        //allowed file types
//                        case 'image/png': //png file
//                        case 'image/gif': //gif file 
//                        case 'image/jpeg': //jpeg file
                        case 'application/pdf': //PDF file
//                        case 'application/msword': //ms word file
//                        case 'application/vnd.ms-excel': //ms excel file
//                        case 'application/x-zip-compressed': //zip file
//                        case 'text/plain': //text file
//                        case 'text/html': //html file
                                break;
                        default:
                                die('Unsupported File!'); //output error
                }


                //File Title will be used as new File name
                $NewFileName = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), strtolower($FileTitle));
                $NewFileName = $NewFileName.'_'.$RandNumber.$ImageExt;
           //Rename and save uploded file to destination folder.
           if(move_uploaded_file($_FILES['mFile']["tmp_name"], $UploadDirectory . $NewFileName ))
           {
                $query = "insert into arsip set 
                id_arsip_kategori = '$id_kategori',
                B_02 = '$nip',
                nama_file = '$NewFileName',
                keterangan = '$keterangan'";
                mysql_query($query);
           } else {
                //die('error uploading File!');
           }
        }
        
        $result['id'] = '';
        $result['act']= 'add';
        die(json_encode($result));
    }
}

else if ($opsi === 'baperjakat') {
    
    if ($_POST['id_baperjakat'] === '') {
        $nama   = $_POST['jabatan'];
        $awal   = date2mysql($_POST['awal']);
        $akhir  = date2mysql($_POST['akhir']);
        $nip    = $_POST['nip']; // array
        $pilih  = $_POST['pilih'];
        
        $insert = "insert into baperjakat set
                jabatan = '$nama',
                periode_mulai = '$awal',
                periode_selesai = '$akhir',
                status = 'Ditetapkan'";
        
        mysql_query($insert);
        $id = mysql_insert_id();
        foreach ($nip as $key => $data) {
            $insertt = "insert into detail_baperjakat set
                id_baperjakat = '$id',
                B_02 = '$data',
                terpilih = 'Tidak'";
            mysql_query($insertt);
        }

        mysql_query("update detail_baperjakat set terpilih = 'Ya' where id_baperjakat = '$id' and `B_02` = '$pilih'");
        $get = mysql_fetch_array(mysql_query("select * from mastfip08 where `B_02` = '$pilih'"));
        
        $q  ="insert into MASTJAB1 set A_01='".$get->A_01."',A_02='".$get->$A_02."',A_03='".$get->A_03."',A_04='".$get->A_04."', JF_01='".$get->B_02."', JF_03 = '$nama'";
        mysql_query($q);
        $result['status'] = TRUE;
        $result['act'] = 'add';
    }
    die(json_encode($result));
}

else if ($opsi === 'rpangkat') {
    $no     = $_POST['no'];
    $PF_03  = $_POST['PF_03'];
    $NIP    = $_POST['NIP'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $TGSK   = $_POST['TGSK'];
    $TGTMT  = $_POST['TGTMT'];
    $PF_04  = $_POST['PF_04'];
    $ID     = $_POST['ID'];
    foreach ($PF_03 as $key => $data) {
        
        $TGSKs = date2mysql($TGSK[$key]);
        $TGTMTs= date2mysql($TGTMT[$key]);
                
            //$q="select * from MASTPKT1 where PF_01='$NIP' and PF_03='".$PF_03[$key]."' and PF_05='".$TGSK."' and PF_06='".$TGTMT."' LIMIT 1";

            if ($ID[$key] === '')
            {
                    $q  ="insert into MASTPKT1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
                    $q .="PF_01='$NIP',PF_02='$no',PF_03='".$PF_03[$key]."',PF_04='".$PF_04[$key]."',PF_05='".$TGSKs."',PF_06='".$TGTMTs."'";
                    mysql_query($q) or die (mysql_error());
                    $result['status'] = TRUE;
                    $result['act'] = 'add';
            }
            else
            {
                    $q  ="update MASTPKT1 set ";
                    $q .="PF_04='".$PF_04[$key]."',PF_03='".$PF_03[$key]."',PF_05='".$TGSKs."',PF_06='".$TGTMTs."' where ID = '".$ID[$key]."'";
                    
                    mysql_query($q) or die (mysql_error());
                    $result['status'] = TRUE;
                    $result['act'] = 'edit';
            }
            $no++;
            if (mysql_affected_rows() > 0) $u++;
            // update MASTFIP08 untuk pkt terakhir;
            mysql_query("update MASTFIP08 set F_02='".$TGSK."', F_TMT='".$TGTMT."' where B_02='$NIP' and F_03='".$PF_03[$key]."'");		
    }
    if ($u > 0) { lethistory($sid,"UPDATE RIWAYAT PANGKAT",$NIP); }

    die(json_encode($result));
}

else if ($opsi === 'delete_rpangkat') {
    mysql_query("delete from mastpkt1 where `ID` = '".$_GET['id']."'");
    die(json_encode(array('status' => TRUE)));
}

else if ($opsi === 'rjabatan') {
    $u=0;
    $no     = $_POST['JF_02ORG'];
    $NIP    = $_POST['NIP'];
    $xtgjf07=$_POST['TGJF_07'];
    $xtgjf06=$_POST['TGJF_06'];
    $JF_03  = $_POST['JF_03'];
    $JF_04  = $_POST['JF_04'];
    $JF_05  = $_POST['JF_05'];
    $ID     = $_POST['ID'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    mysql_query("delete from mastjab1 where `JF_01` = '$NIP'");
    if (is_array($no)) {
    foreach ($no as $key => $data) {
    $I_JB=ereg_replace('\'','\"',$JF_03[$key]);
            //$j=mysql_num_rows(mysql_query("select * from MASTJAB1 where JF_01='$NIP' and JF_07='$xtgjf07' LIMIT 1"));
            //if ($ID[$key] === '') {
                $q  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
                $q .="JF_02='$data',JF_01='$NIP',JF_03='$I_JB',JF_04='".$JF_04[$key]."', ";
                $q .="JF_05='".$JF_05[$key]."',JF_06='".date2mysql($xtgjf06[$key])."', JF_07='".date2mysql($xtgjf07[$key])."'";
                mysql_query($q) or die (mysql_error());
                $result['act'] = 'edit';
            //}
//            else {
//                $q  ="update MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
//                $q .="JF_02='$JF_02ORG[$i]',JF_03='$I_JB',JF_04='$JF_04[$i]', ";
//                $q .="JF_05='$JF_05[$i]',JF_06='$xtgjf06', JF_07='$xtgjf07' where JF_01='$NIP' and ";
//                $q .="ID='$IDORG[$i]'";// and ";
///*			$q .="JF_03='$JF_03ORG[$i]' and ";
//                $q .="JF_04='$JF_04ORG[$i]' and ";
//                $q .="JF_05='$JF_05ORG[$i]' and ";
//                $q .="JF_06='$JF_06ORG[$i]' and ";
//                $q .="JF_07='$JF_07ORG[$i]' ";*/
//                mysql_query($q) or die (mysql_error());
//                $result['act'] = 'edit';
//            }
            if (mysql_affected_rows() > 0) $u++;			
    }
    }
    if ($u > 0) lethistory($sid,"UPDATE RIWAYAT JABATAN",$NIP);
    die(json_encode($result));
}

else if ($opsi === 'rtanda_jasa') {
    $ID     = $_POST['ID'];
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    $JS_03  = $_POST['JS_03'];
    $JS_04  = $_POST['JS_04'];
    $JS_05  = $_POST['JS_05'];
    $JS_06  = $_POST['JS_06'];
    $JS_07  = $_POST['JS_07'];
    $TGJS_05= $_POST['TGJS_05'];
    $ID     = $_POST['ID'];
    if ($JS_03) {
        foreach ($JS_03 as $key => $data) {
                $xtgjs05=date2mysql($TGJS_05[$key]);
                $JS03=strtoupper($JS_03[$key]);
                $JS07=strtoupper($JS_07[$key]);
                $auto = mysql_num_rows(mysql_query("select * from mstjasa1 where `A_01` = '$A_01' and `A_02` = '$A_02' and `A_03` = '$A_03' and `A_04` = '$A_04' and `JS_01` = '$NIP'"));
                if ($ID[$key] === '') {
                    $q  ="insert into MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
                    $q .="JS_01='$NIP',JS_02='".($auto+1)."',JS_03='$JS03',JS_04='$JS_04[$key]',JS_05='$xtgjs05', ";
                    $q .="JS_06='$JS_06[$key]',JS_07='$JS07'";
                    mysql_query($q) or die (mysql_error());
                    $result['act'] = 'add';
                } else {
                    $q  ="update MSTJASA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
                    $q .="JS_02='$i',JS_03='$JS03',JS_04='$JS_04[$key]',JS_05='$xtgjs05', ";
                    $q .="JS_06='$JS_06[$key]',JS_07='$JS07' where ID = '".$ID[$key]."'";

                    mysql_query($q) or die (mysql_error());
                    $result['act'] = 'edit';
                }
                if (mysql_affected_rows() > 0) $u++;
        }
    }
    if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TANDA JASA",$NIP);
    die(json_encode($result));
}

else if ($opsi === 'rtluarnegeri') {
    
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    $TG_03  = $_POST['TG_03'];
    $TG_04  = $_POST['TG_04'];
    $TG_05  = $_POST['TG_05'];
    $TG_06  = $_POST['TG_06'];
    $TGTG_07= $_POST['TGTG_07'];
    $TGTG_08= $_POST['TGTG_08'];
    $TGTG_09= $_POST['TGTG_09'];
    mysql_query("delete from MSTTGAS1 where TG_01 = '$NIP'");
    if ($TG_03) {
        foreach ($TG_03 as $i => $data) {
            $TG03=strtoupper($TG_03[$i]);
            $TG04=strtoupper($TG_04[$i]);
            $TG05=strtoupper($TG_05[$i]);
            $xtgtg07    = date2mysql($TGTG_07[$i]);
            $xtgtg08    = date2mysql($TGTG_08[$i]);
            $xtgtg09    = date2mysql($TGTG_09[$i]);

            $q  ="insert into MSTTGAS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
            $q .="TG_01='$NIP',TG_02='".($i+1)."',TG_03='$TG03',TG_04='$TG04',TG_05='$TG05', ";
            $q .="TG_06='$TG_06[$i]',TG_07='$xtgtg07',TG_08='$xtgtg08',TG_09='$xtgtg09'";

            mysql_query($q) or die (mysql_error());
            $result['act'] = 'add';

            if (mysql_affected_rows() > 0) $u++;
        }
    }
    if ($u > 0) lethistory($sid,"UPDATE RIWAYAT TUGAS KE LN",$NIP);
    die(json_encode($result));
}

else if ($opsi === 'rbahasa') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $BS_03  = $_POST['BS_03'];
    $BS_04  = $_POST['BS_04'];
    $BS_05  = $_POST['BS_05'];
    mysql_query("delete from MSTBHSA1 where `BS_01` = '$NIP'");
    if ($BS_03) {
        foreach ($BS_03 as $i => $data) {
            $BS04=strtoupper($BS_04[$i]);

            $q  ="insert into MSTBHSA1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
            $q .="BS_01='$NIP',BS_02='$i',BS_03='$BS_03[$i]',BS_04='$BS04',BS_05='$BS_05[$i]'";
            mysql_query($q) or die (mysql_error());
            $result['act'] = 'edit';
            if (mysql_affected_rows() > 0) $u++;
        }
    }
    lethistory($sid,"UPDATE KEMAMPUAN BAHASA",$NIP);
    die(json_encode($result));
}

else if ($opsi === 'rdikum') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $DK_03  = $_POST['DK_03'];
    $DK_04  = $_POST['DK_04'];
    $DK_05  = $_POST['DK_05'];
    $DK_06  = $_POST['DK_06'];
    $DK_07  = $_POST['DK_07'];
    $DK_08  = $_POST['DK_08'];
    $TGDK_09= $_POST['TGDK_09'];
    
    mysql_query("delete from MSTPEND1 where DK_01 = '$NIP'");
    if ($DK_03) {
        foreach ($DK_03 as $i => $data) {

            $xtgdk09=  date2mysql($TGDK_09[$i]);
            $DK04=addslashes(strtoupper($DK_04[$i]));
            $DK05=addslashes(strtoupper($DK_05[$i]));
            $DK06=addslashes(strtoupper($DK_06[$i]));
            $DK07=addslashes(strtoupper($DK_07[$i]));

            $q  ="insert into MSTPEND1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
            $q .="DK_01='$NIP',DK_02='$i',DK_03='$DK_03[$i]',DK_04='$DK04',DK_05='$DK05', ";
            $q .="DK_06='$DK06',DK_07='$DK07',DK_08='$DK_08[$i]',DK_09='$xtgdk09'";
            
            mysql_query($q) or die (mysql_error());
        }
    }
    $result['act'] = 'edit';
    lethistory($sid,"UPDATE PENDIDIKAN UMUM",$NIP);
    die(json_encode($result));
}

else if ($opsi === 'rdikstru') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    $aJab=array(1=>"SEPADA","SEPALA","SEPADYA","ADUM","ADUMLA","SPAMA","SESPA","SPAMEN","SESPANAS","SPATI","LEMHANAS","DIKLATPIM Tk.I","DIKLATPIM Tk.II","DIKLATPIM Tk.III","DIKLATPIM Tk.IV","DIKLATPIM PEMDA");
    mysql_query("delete from MSTSTRU1 where LT_01 = '$NIP'");
    if ($LT_03) {
        foreach ($LT_03 as $i => $data) {
            $xtglt07    = date2mysql($TGLT_07[$i]);
            $xtglt08    = date2mysql($TGLT_08[$i]);
            $xtglt11    = date2mysql($TGLT_11[$i]);


            $LT03=$aJab[$LT_03[$i]];

            $LT04=strtoupper($LT_04[$i]);
            $LT05=strtoupper($LT_05[$i]);

            $q  ="insert into MSTSTRU1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
            $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
            $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
            $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

            mysql_query($q) or die (mysql_error());

        }
    }
    lethistory($sid,"UPDATE RIWAYAT DIKLAT STRUKTURAL",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rdikfung') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    mysql_query("delete from MSTFUNG1 where LT_01 = '$NIP'");
    foreach ($LT_03 as $i => $data) {
        $xtglt07=date2mysql($TGLT_07[$i]);
        $xtglt08=date2mysql($TGLT_08[$i]);
        $xtglt11=date2mysql($TGLT_11[$i]);
        $LT03=strtoupper($LT_03[$i]);
        $LT04=strtoupper($LT_04[$i]);
        $LT05=strtoupper($LT_05[$i]);
        
        $q  ="insert into MSTFUNG1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
        $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
        $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
        $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

        mysql_query($q) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT DIKLAT FUNGSIONAL",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rdiktekn') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    mysql_query("delete from MSTTEKN1 where LT_01 = '$NIP'");
    foreach ($LT_03 as $i => $data) {
        $xtglt07=date2mysql($TGLT_07[$i]);
        $xtglt08=date2mysql($TGLT_08[$i]);
        $xtglt11=date2mysql($TGLT_11[$i]);
        $LT03=strtoupper($LT_03[$i]);
        $LT04=strtoupper($LT_04[$i]);
        $LT05=strtoupper($LT_05[$i]);
        
        $q  ="insert into MSTTEKN1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
        $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
        $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
        $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

        mysql_query($q) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT DIKLAT TEKNIS",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rtatar') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    mysql_query("delete from MSTPTAR1 where LT_01 = '$NIP'");
    foreach ($LT_03 as $i => $data) {
        $xtglt07=date2mysql($TGLT_07[$i]);
        $xtglt08=date2mysql($TGLT_08[$i]);
        $xtglt11=date2mysql($TGLT_11[$i]);
        $LT03=strtoupper($LT_03[$i]);
        $LT04=strtoupper($LT_04[$i]);
        $LT05=strtoupper($LT_05[$i]);
        
        $q  ="insert into MSTPTAR1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
        $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
        $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
        $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

        mysql_query($q) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT PENATARAN",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rsemi') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    mysql_query("delete from MSTSEMI1 where LT_01 = '$NIP'");
    foreach ($LT_03 as $i => $data) {
        $xtglt07=date2mysql($TGLT_07[$i]);
        $xtglt08=date2mysql($TGLT_08[$i]);
        $xtglt11=date2mysql($TGLT_11[$i]);
        $LT03=strtoupper($LT_03[$i]);
        $LT04=strtoupper($LT_04[$i]);
        $LT05=strtoupper($LT_05[$i]);
        
        $q  ="insert into MSTSEMI1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
        $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
        $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
        $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

        mysql_query($q) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT SEMINAR/LOKAKARYA/SIMPOSIUM",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rkursus') {
    $A_01   = $_POST['A_01'];
    $A_02   = $_POST['A_02'];
    $A_03   = $_POST['A_03'];
    $A_04   = $_POST['A_04'];
    $NIP    = $_POST['NIP'];
    
    $LT_03  = $_POST['LT_03'];
    $LT_04  = $_POST['LT_04'];
    $LT_05  = $_POST['LT_05'];
    $LT_06  = $_POST['LT_06'];
    $LT_09  = $_POST['LT_09'];
    $LT_10  = $_POST['LT_10'];
    
    $TGLT_07= $_POST['TGLT_07'];
    $TGLT_08= $_POST['TGLT_08'];
    $TGLT_11= $_POST['TGLT_11'];
    mysql_query("delete from MSTKURS1 where LT_01 = '$NIP'");
    foreach ($LT_03 as $i => $data) {
        $xtglt07=date2mysql($TGLT_07[$i]);
        $xtglt08=date2mysql($TGLT_08[$i]);
        $xtglt11=date2mysql($TGLT_11[$i]);
        $LT03=strtoupper($LT_03[$i]);
        $LT04=strtoupper($LT_04[$i]);
        $LT05=strtoupper($LT_05[$i]);
        
        $q  ="insert into MSTKURS1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
        $q .="LT_01='$NIP',LT_02='$i',LT_03='$LT03',LT_04='$LT04',LT_05='$LT05', ";
        $q .="LT_06='$LT_06[$i]',LT_07='$xtglt07',LT_08='$xtglt08',LT_09='$LT_09[$i]', ";
        $q .="LT_10='$LT_10[$i]', LT_11='$xtglt11'";

        mysql_query($q) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT KURSUS DLM NEGERI / LUAR NEGERI",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rhukuman') {
    $nip    = $_POST['NIP'];
    $bobot  = $_POST['bobot']; // array
    $id_jenis_hukuman = $_POST['jns_hukuman']; // array
    $tanggal_sk  = $_POST['tgl_sk']; // array
    $tanggal_tmt = $_POST['tmt_sk']; // array
    $masa_berlaku= $_POST['masa_berlaku']; // array
    
    mysql_query("delete from tb_riwayat_hukuman where nip = '".$nip."'");
    foreach ($id_jenis_hukuman as $key => $data) {
        $sql = "insert into tb_riwayat_hukuman
            set nip = '".$nip."',
                bobot = '".$bobot[$key]."',
                id_jenis_hukuman = '".$data."',
                tanggal_sk = '".  date2mysql($tanggal_sk[$key])."',
                tmt_sk = '".  date2mysql($tanggal_tmt[$key])."',
                masa_berlaku = '".$masa_berlaku[$key]."'
            ";
        mysql_query($sql) or die (mysql_error());
    }
    lethistory($sid,"UPDATE RIWAYAT HUKUMAN ",$nip);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'rpekerjaan') {
    $nip    = $_POST['NIP'];
    $perusahaan = $_POST['perusahaan'];
    $jabatan    = $_POST['jabatan'];
    $tgl_bekerja = $_POST['tgl_bekerja'];
    $tgl_berhenti = $_POST['tgl_berhenti'];
    $alasan_berhenti = $_POST['alasan_berhenti'];
    mysql_query("delete from tb_riwayat_pekerjaan where nip = '".$nip."'");
    foreach ($perusahaan as $key => $data) {
        $sql = "insert into tb_riwayat_pekerjaan
            set nip = '".$nip."',
                perusahaan = '".$perusahaan[$key]."',
                jabatan = '".$jabatan[$key]."',
                mulai_bekerja = '".  date2mysql($tgl_bekerja[$key])."',
                berhenti_bekerja = '".  date2mysql($tgl_berhenti[$key])."',
                alasan_berhenti = '".$alasan_berhenti[$key]."'
            ";
    
        mysql_query($sql) or die (mysql_error());
    }
    
    lethistory($sid,"UPDATE RIWAYAT PEKERJAAN ",$NIP);
    $result['act'] = 'edit';
    die(json_encode($result));
}

else if ($opsi === 'ubahnip') {
    $nip1   = $_POST['nip1'];
    $nip2   = $_POST['nip2'];
    
    $check  = mysql_fetch_object(mysql_query("select count(*) as jumlah from mastfip08 where `B_02` = '$nip2'"));
    
    $result['jumlah'] = TRUE;
    if ($check->jumlah > 0) {
        $result['jumlah'] = FALSE;
        $result['status'] = FALSE;
    } else {
        $atabel=array(1=>"MASTFIP08","MASTJAB1","MASTKEL1","MASTPKT1","MSTBHSA1","MSTFUNG1","MSTJASA1","MSTKURS1","MSTORTU1","MSTPEND1","MSTPTAR1","MSTSEMI1","MSTSTRU1","MSTTEKN1","MSTTGAS1","MASTJFU");
        $afield=array(1=> "B_02",     "JF_01",   "KF_01",   "PF_01",   "BS_01",   "LT_01",   "JS_01",   "LT_01",   "NM_01",   "DK_01",   "LT_01",   "LT_01",   "LT_01",   "LT_01",   "TG_01",   "NIP");

         for ($i=1;$i<=count($atabel);$i++)
         {
            $q="update $atabel[$i] set $afield[$i]='$nip2' where $afield[$i]='$nip1' ";

            mysql_query($q) or die (mysql_error());
         }
         $result['status'] = TRUE;
    }
    die(json_encode($result));
}
?>