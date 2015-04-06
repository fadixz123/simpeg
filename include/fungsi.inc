<?
session_start();
function oursid($sid)
{
        $q="select user from LOGUSER where sid='$sid'";

        $r=mysql_query($q) or die (mysql_error());
        $o=mysql_fetch_row($r);
        $iduser=$o[0];

        $q="select * from USER where username='$iduser'";
        $r=mysql_query($q) or die (mysql_error());
        $o=mysql_fetch_array($r);
        $namauser=$o['id'];

        $time=date("H:i:s");
        $date=date("Y:m:d");
        return array($namauser,$time,$date);
}

function header_excel($namaFile) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,
            pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // header untuk nama file
    header("Content-type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment;
            filename=" . $namaFile . "");
    header("Content-Transfer-Encoding: binary ");
}

function lethistory($sid,$what,$NIP)
{
        list($username,$time,$date)=oursid($sid);
        $q="insert into HISTORY set tanggal='$date', jam='$time', id_user='".$_SESSION['id_user']."', app='BIODATA', nipedit='$NIP', subapp='edit', what='$what'";
        //echo $q;
        mysql_query($q) or die(mysql_error());
}

function namaPNS($B_03A,$B_03,$B_03B)
{
	if ($B_03A!='') $dpn=$B_03A.". ";else $dpn="";
        if ($B_03B!='') $nama= $dpn.stripslashes($B_03).", ".$B_03B; else $nama= $dpn.stripslashes($B_03); 
	return $nama;
}

function tanggalnya($tanggal,$k) {
	if ($k=='0') {
		$tanggal1=substr($tanggal,8,2)."-".substr($tanggal,5,2)."-".substr($tanggal,0,4);
		return $tanggal1;
	}
}

function jabatan($kojab)
{
	$q="select NAJAB from TABLOKB08 where KOLOK='$kojab'";
	$rr=mysql_query($q);
	$oo=mysql_fetch_array($rr);
	if (mysql_num_rows($rr)==0) $hasil="-"; else
	$hasil=$oo[NAJAB];
	
	return $hasil;
}

function lokasiKerja($A_01) {
	$oq="select NM from TABLOK where SUBSTRING(KD,1,2)='$A_01' LIMIT 1";
	$or=mysql_query($oq);
	$orow=mysql_fetch_array($or);
	return $orow[NM];
}

function lokasiKerjaB($A_01) {
	$oq="select nm from TABLOK08 where kd='$A_01' LIMIT 1";
	$or=mysql_query($oq);
	$orow=mysql_fetch_row($or);
	return $orow[0];
}

function subLokasiKerja($A_01,$A_02,$A_03,$A_04) {
	$oq="select NALOK from TABLOKB where KOLOK='".$A_01.$A_02.$A_03.$A_04."' LIMIT 1";
	$or=mysql_query($oq);
	$orow=mysql_fetch_array($or);
	return $orow[NALOK];
}
	
function subLokasiKerjaB($A_01,$A_02="",$A_03="",$A_04="",$A_05="") {
	$oq="select NALOK from TABLOKB08 where KOLOK like '".$A_01.$A_02.$A_03.$A_04.$A_05."%' LIMIT 1";
	$or=mysql_query($oq) or die(mysql_error());
	$orow=mysql_fetch_row($or);
	return $orow[0];
}
	
function eselon($eselon){
	switch ($eselon){
		case '11': $thisesel="I.a";break;
		case '12': $thisesel="I.b";break;
		case '21': $thisesel="II.a";break;
		case '22': $thisesel="II.b";break;
		case '31': $thisesel="III.a";break;
		case '32': $thisesel="III.b";break;
		case '41': $thisesel="IV.a";break;
		case '42': $thisesel="IV.b";break;
		case '51': $thisesel="V.a";break;
		case '52': $thisesel="V.b";break;
		default: $thisesel="-";break;
	}
	
	return $thisesel;
}

function namaPkt($pangkat){
switch(intval($pangkat)) {
  case 11: $pkt_nya="JURU MUDA";break;
  case 12: $pkt_nya="JURU MUDA TK I";break;
  case 13: $pkt_nya="JURU";break;
  case 14: $pkt_nya="JURU TK I";break;
  case 21: $pkt_nya="PENGATUR MUDA";break;
  case 22: $pkt_nya="PENGATUR MUDA TK I";break;
  case 23: $pkt_nya="PENGATUR";break;
  case 24: $pkt_nya="PENGATUR TK I";break;
  case 31: $pkt_nya="PENATA MUDA";break;
  case 32: $pkt_nya="PENATA MUDA TK I";break;
  case 33: $pkt_nya="PENATA";break;
  case 34: $pkt_nya="PENATA TK I";break;
  case 41: $pkt_nya="PEMBINA";break;
  case 42: $pkt_nya="PEMBINA TK I";break;
  case 43: $pkt_nya="PEMBINA UTAMA MUDA";break;
  case 44: $pkt_nya="PEMBINA UTAMA MADYA";break;
  case 45: $pkt_nya="PEMBINA UTAMA";break;
  default : $pkt_nya="";
}	
return $pkt_nya;
}

function pktH($pkt){
	switch($pkt){
		case "11" : $hasil='I/a';break;
		case "12" : $hasil='I/b';break;
		case "13" : $hasil='I/c';break;
		case "14" : $hasil='I/d';break;
		case "21" : $hasil='II/a';break;
		case "22" : $hasil='II/b';break;
		case "23" : $hasil='II/c';break;
		case "24" : $hasil='II/d';break;
		case "31" : $hasil='III/a';break;
		case "32" : $hasil='III/b';break;
		case "33" : $hasil='III/c';break;
		case "34" : $hasil='III/d';break;
		case "41" : $hasil='IV/a';break;
		case "42" : $hasil='IV/b';break;
		case "43" : $hasil='IV/c';break;
		case "44" : $hasil='IV/d';break;
		case "45" : $hasil='IV/e';break;
	}
	return $hasil;
}

function ortu($NIP,$pos,$field)
{
	$q="select * from MSTORTU1 where NM_01='$NIP' and NM_03='$pos'";
	$res=mysql_query($q);
	$o=mysql_fetch_array($res);
	$hasil=$o[$field];
	return $hasil;
}

function format_tanggal($tanggal)
{
	$tanggal1=substr($tanggal,8,2)."-".substr($tanggal,5,2)."-".substr($tanggal,0,4);
	return $tanggal1;
}

function format_nip_lama($nip) {
	$niplama=substr($nip,0,3)." ".substr($nip,3,3)." ".substr($nip,6,3);
	return $niplama;
}

function format_nip_baru($nip) {
	$nipbaru=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
	return $nipbaru;
}

function gaji($gol1,$thmasker1)
{
	$gaji="select GJ_BR from TABGAJI where PKT='$gol1' and MSK='$thmasker1'";
	$rgaji=mysql_query($gaji);
	$ogaji=mysql_fetch_array($rgaji);
	$gaji=$ogaji["GJ_BR"];
	return $gaji;
}

function tktDidik($tk) {
	switch($tk) {
		case "10" : $didik="SD";break;
		case "20" : $didik="SLTP";break;
		case "30" : $didik="SLTA";break;
		case "41" : $didik="D I";break;
		case "42" : $didik="D II";break;
		case "43" : $didik="D III";break;
		case "44" : $didik="D IV";break;
		case "50" : $didik="SARMUD NON AKADEMI";break;
		case "60" : $didik="SARMUD AKADEMI";break;
		case "70" : $didik="S1";break;
		case "80" : $didik="S2";break;
		case "90" : $didik="S3";break;
		default : $didik="-";
	}
	return $didik;
}

function dikStru($tk) {
	switch($tk) {
		case "1" : $stru="LEMHANAS";break;
		case "2" : $stru="SESPA/SEPAMEN";break;
		case "3" : $stru="SEPADYA/SPAMA";break;
		case "4" : $stru="SEPALA/ADUMLA";break;
		case "5" : $stru="SEPADA/ADUM";break;
		case "6" : $stru="DIKLATPIM Tk.I";break;
		case "7" : $stru="DIKLATPIM Tk.II";break;
		case "8" : $stru="DIKLATPIM Tk.III";break;
		case "9" : $stru="DIKLATPIM Tk.IV";break;
		case "10" : $stru="DIKLATPIM PEMDA";break;
		default: $stru="-";
	}
	return $stru;
}

function jurusan($didik,$jur)
{   
    if ($didik !== '-') {
	$q1="select * from TABDIK".$didik." where kod='$jur'";
	$r=mysql_query($q1);
        $o1=mysql_fetch_array($r);
        $hasil=$o1["ket"];
        return $hasil;
    }
}

function agama1($kode)
{
	switch(intval($kode)) {
            case null: $agama=""; break;
            case '': $agama=""; break;
            case 1: $agama="ISLAM"; break;
            case 2: $agama="KRISTEN"; break;
            case 3: $agama="KATHOLIK"; break;
            case 4: $agama="HINDU"; break;
            case 5: $agama="BUDHA"; break;
	}
	return $agama;
}

function jenisKelamin($kode) {
	switch(intval($kode)) {
		case 1: $jenisKelamin="LAKI-LAKI";break;
		case 2: $jenisKelamin="PEREMPUAN";break;
	}
	return $jenisKelamin;
}

function status_kawin($kode) {
    switch(intval($kode)) {
        case 1: $status="KAWIN";break;
        case 2: $status="BELUM KAWIN";break;
        case 3: $status="DUDA";            break;
        case 4: $status="JANDA";            break;
    }
    return $status;
}
	
function masaKerAsli($masapalsu,$masa) {
	$tahun=floor($masa/356);
	if ($tahun<>0) {
		$bulan=floor(($masa-($tahun*356))/30);
	} else {
		$bulan=floor($masa/30);
	}
	$thasli=substr($masapalsu,0,2)-$tahun;
	$blasli=substr($masapalsu,2,2)-$bulan;
	if ($blasli>12) {$blasli=$blasli-12;$thasli=$thasli+1;}
	if (strlen($thasli<2)) $thasli="0".$thasli;
	if (strlen($blasli<2)) $blasli="0".$blasli;
	return $thasli.$blasli;
}

function format_tanggal_1($tanggal)
{
        $aBulan= array(1=>'Januari','Pebruari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
        $tanggal1=substr($tanggal,8,2)." ".$aBulan[intval(substr($tanggal,5,2))]." ".substr($tanggal,0,4);
        return $tanggal1;
}

function listUnitKerja() {
	$q1="select kd,nm from TABLOK08 where kd<>'99' order by kd";
	$r1=mysql_query($q1);
//	$q2="select KOLOK,NALOK from TABLOKB08 where KOLOK like '02%' and ESEL like '22' order by KOLOK";
//	$r2=mysql_query($q2);
//	$listuk[]=mysql_fetch_array($r1);
//	$listuk[]=mysql_fetch_array($r1);
//	for ($i=0;$i < mysql_num_rows($r2);$i++) {$listuk[]=mysql_fetch_array($r2);}
	for ($i=0;$i < mysql_num_rows($r1);$i++) {$listuk[]=mysql_fetch_array($r1);}
	return $listuk;
}

function listUnitKerjaNoBiro() {
        $q1="select kd,nm from TABLOK08 where kd<>'99' order by kd";
        $r1=mysql_query($q1);
        for ($i=0;$i < mysql_num_rows($r1);$i++) {$listuk[]=mysql_fetch_array($r1);}
        return $listuk;
}

function listSubUnitKerja($uk) {
	$ql="select KOLOK,NALOK from TABLOKB08 ";
	if (strlen($uk)==2) $ql.="where A_01='$uk' ";
	else $ql.="where A_01='".substr($uk,0,2)."' and A_02 ='".substr($uk,2,2)."' and A_03 ='".substr($uk,4,2)."' ";
	$ql.="order by KOLOK";
	$rl=mysql_query($ql) or die(mysql_error());
	for ($i=1;$i < mysql_num_rows($rl);$i++) {$listuk[]=mysql_fetch_array($rl);}
	return $listuk;
}

function getNaJFU($nip) {
//	$q="select b.NAJFU from MASTJFU a,TABJFU b where a.JABBARU=b.KOJFU and a.NIP='$nip'";
	$q="select b.NAJFU from MASTFIP08 a,TABJFU b where a.I_05=b.KOJFU and a.B_02='$nip'";
	$r=mysql_query($q) or die(mysql_error());
	$ro=mysql_fetch_row($r);
	if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJFK($nip) {
	$q="select I_JB from MASTFIP08 where B_02='$nip'";
	$r=mysql_query($q) or die(mysql_error());
	$ro=mysql_fetch_row($r);
	if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJabStru($nip) {
	$q="select b.NAJAB from MASTFIP08 a left join TABLOKB08 b on (a.I_05=b.KOLOK) where a.B_02='$nip'";
	$r=mysql_query($q) or die(mysql_error());
	$ro=mysql_fetch_row($r);
	if (mysql_num_rows($r)==0) return 0; else return $ro[0];
}

function getNaJab($nip) {
        $q="select I_5A,I_JB from MASTFIP08 where B_02='$nip'";
        $r=mysql_query($q) or die(mysql_error());
        $ro=mysql_fetch_row($r);
        switch ($ro[0]) {
		case '1':
		case '4': $nama=getNaJabStru($nip);break;
		case '2': $nama=getNaJFK($nip);break;
		default: $nama=getNaJFU($nip);break;
	}
	if ($nama=='0') $nama="<i>Belum diseting</i>";
	return $nama;
}

function namaLokasiKerja($kd) {
	$kolok=$kd;
	$queryjab="select * from TABLOKB08 where KOLOK='$kd'";
	$rjab=mysql_query($queryjab);
	$rowjab=mysql_fetch_array($rjab);
	$esel=$rowjab['ESEL'];

	while ($kolok!='') {
		$isparent=true;
		$q1="select * from TABLOKB08 where KOLOK<'$kolok' and ESEL<'$esel' and substring(KOLOK,1,2)=substring('$kolok',1,2) order by KOLOK desc,ESEL desc limit 1";
		$rl1=mysql_query($q1);
		$rol1=mysql_fetch_array($rl1);
		$parentkolok=rtrim($rol1[KOLOK],'0');
		$parentlen=strlen($parentkolok);
		$testkolok=substr($kd,0,$parentlen);
		if ($parentkolok!=$testkolok) $isparent=false;
		$kolok=$rol1[KOLOK];
		$esel=$rol1[ESEL];
		if (substr($rol1[NALOK],0,7)!="ASISTEN" && $isparent) $namauk.=" ".$rol1[NALOK];
	}
	return $namauk;
}

function page_summary($total_data, $halaman, $dataperpage) {
    $total_page = ceil($total_data/$dataperpage);
    return '<div class="page_summary">Page '.$halaman.' of '.$total_page.' Total '.$total_data.' Data(s)</div>';
}

function paging_ajax($jmldata, $dataPerPage, $klik, $tab = NULL, $search) {
    /*
     * Parameter '$search' dalam bentuk string , bisa json string atau yang lain
     * contoh 1#nama_barang#nama_pabrik
     */

    $showPage = NULL;
    ob_start();
    echo "
        <ul class='pagination pointer'>";
    if (!empty($klik)) {
        $noPage = $klik;
    } else {
        $noPage = 1;
    }

    $dataPerPage = $dataPerPage;


    $jumData = $jmldata;
    $jumPage = ceil($jumData / $dataPerPage);
    $get = $_GET;
    
    if ($jumData > $dataPerPage) {
        $onclick = null;
        if ($noPage > 1) {
            $get['page'] = ($noPage - 1);
            $onclick = $klik;
        }
        $prev = null;
        $last = ' class="last-block" ';
        if ($klik > 1) {
            $prev = "onClick=\"paging(" . ($klik - 1) . "," . $tab . ", '" . $search . "')\" ";
        }
        echo "<li class='page-prev' $prev>Prev</li>";
        for ($page = 1; $page <= $jumPage; $page++) {
            if ((($page >= $noPage - 3) && ($page <= $noPage + 3)) || ($page == 1) || ($page == $jumPage)) {
                if (($showPage == 1) && ($page != 2))
                    echo "<li class='titik'>...</li>";
                if (($showPage != ($jumPage - 1)) && ($page == $jumPage))
                    echo "<li class='titik'>...</li>";
                if ($page == $noPage)
                    echo " <li class='noblock'>" . $page . "</li> ";
                else {
                    $get['page'] = $page;
                    if ($tab != NULL) {
                        $get['tab'] = $tab;
                    }
                    $next = "onClick=\"paging(" . $page . "," . $tab . ", '" . $search . "')\" ";
                    //echo " <a class='block' href='?" . generate_get_parameter($get) . "'>" . $page . "</a> ";
                    if ($page == $jumPage) {
                        echo '<li  class="block" ' . $next . '>' . $page . '</li>';
                    } else {
                        echo '<li class="block" ' . $next . '>' . $page . '</li>';
                    }
                }
                $showPage = $page;
            }
        }
        $next = null;
        if ($klik < $jumPage) {
            $next = "onClick=\"paging(" . ($klik + 1) . "," . $tab . ", '" . $search . "')\" ";
        }
        echo "<li class='page-next' $next >Next</div>";
    }
    echo "</ul>";

    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
}

function generate_get_parameter($get, $addArr = array(), $removeArr = array()) {
    if ($addArr == null)
        $addArr = array();
    foreach ($removeArr as $rm) {
        unset($get[$rm]);
    }
    $link = "";
    $get = array_merge($get, $addArr);
    foreach ($get as $key => $val) {
        if ($link == null) {
            $link.="$key=$val";
        }else
            $link.="&$key=$val";
    }
    return $link;
}
function date2mysql($tgl) {
    $new = null;
    $tgl = explode("/", $tgl);
    if (empty($tgl[2]))
        return "";
    $new = "$tgl[2]-$tgl[1]-$tgl[0]";
    return $new;
}

function datefmysql($tgl) {
    if ($tgl == '' || $tgl == null) {
        return "";
    } else {
        $tgl = explode("-", $tgl);
        $new = $tgl[2] . "/" . $tgl[1] . "/" . $tgl[0];
        return $new;
    }
}

function datetimefmysql($dt, $time = NULL) {
    $var = explode(" ", $dt);
    $var1 = explode("-", $var[0]);
    $var2 = "$var1[2]/$var1[1]/$var1[0]";
    if ($time != NULL) {
        return $var2 . ' ' . $var[1];
    } else {
        return $var2;
    }
}

function datetimetomysql($dt) {
    // $dt = 2013-03-06 00:00:00
    $var = explode(" ", $dt);
    $date = explode("-", $var[0]);
    $time = explode(":", $var[1]);

    return $date[2] . "/" . $date[1] . "/" . $date[0] . " " . $time[0] . ":" . $time[1];
}

function get_tkt_didik($val) {
    switch ($val) {
        case '0': $didik="10";            break;
        case '1': $didik="20";            break;
        case '2': $didik="30";            break;
        case '3': $didik="41";            break;
        case '4': $didik="42";            break;
        case '5': $didik="43";            break;
        case '6': $didik="44";            break;
        case '7': $didik="70";            break;
        case '8': $didik="80";            break;
        case '9': $didik="90";
        default : $didik="-";
    }
    return $didik;
}

?>
