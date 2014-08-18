<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (isset($_GET['search'])) {
    $cari = $_GET['search'];
    $q = $_GET['q'];
    $page  = isset($_GET['page'])?$_GET['page']:NULL;
    $limit = 20;
    $start = (($page - 1) * $limit);
    if ($cari === 'pegawai') {
        $param = "";
        if ($_GET['uk'] !== 'all') {
            $param.= " and A_01 = '".$_GET['uk']."'";
        }
        if (isset($_GET['skpd'])) {
            $param.=" and A_01 = '".$_GET['skpd']."'";
        }
        if ($_GET['suk'] !== '') {
            $param.=" having kode_sub_lokasi like ('".$_GET['suk']."')";
        }
        $data= array();
        $query = "select CONCAT(`A_01`,`A_02`, `A_03`, `A_04`, `A_05`) as kode_sub_lokasi, `B_02` as id, `B_02B` as nip_baru, 
                CONCAT_WS(' ',`B_02`, ' | ', `B_02B`, '<br/>', `B_03`,`B_03B`) as list, CONCAT_WS(' ',`B_03`,`B_03B`) as nama_pegawai 
                from mastfip08 
                where `B_02` like ('%".$q."%') or `B_02B` like ('%".$q."%') or `B_03` like ('%".$q."%') $param";
        //echo $query.' limit '.$start.', '.$limit;
        $sql = mysql_query($query.' limit '.$start.', '.$limit);
        while ($rows = mysql_fetch_object($sql)) {
            $data[] = $rows;
        }
        $pilih[] = array('id'=>'', 'list' => '<i>Semua pegawai ...</i>');
        $total = mysql_num_rows(mysql_query($query));
        die(json_encode(array('data' => array_merge($pilih, $data), 'total' => $total)));
    }
    
    if ($cari === 'pegawai_pasangan') {
        $param = "";
        if ($_GET['pasangan'] === 'DATA ISTRI') {
            $param = " and B_06 = '2'";
        }
        if ($_GET['pasangan'] === 'DATA SUAMI') {
            $param = " and B_06 = '1'";
        }
        $data= array();
        $query = "select CONCAT(`A_01`,`A_02`, `A_03`, `A_04`, `A_05`) as kode_sub_lokasi, `B_02` as id, `B_02B` as nip_baru, `B_02B` as id, 
                CONCAT_WS(' ',`B_02`, ' | ', `B_02B`, '<br/>', `B_03`,`B_03B`) as list, CONCAT_WS(' ',`B_03`,`B_03B`) as nama_pegawai 
                from mastfip08 
                where (`B_02` like ('%".$q."%') or `B_02B` like ('%".$q."%') or `B_03` like ('%".$q."%')) $param";
        //echo $query.' limit '.$start.', '.$limit;
        $sql = mysql_query($query.' limit '.$start.', '.$limit);
        while ($rows = mysql_fetch_object($sql)) {
            $data[] = $rows;
        }
        $pilih[] = array('id'=>'', 'list' => '<i>Semua pegawai ...</i>');
        $total = mysql_num_rows(mysql_query($query));
        die(json_encode(array('data' => array_merge($pilih, $data), 'total' => $total)));
    }
    
    if ($cari === 'suk') { // pencarian sub unit kerja (SUK)
        $data = array();
        $uk   = $_GET['uk'];
        $param= NULL;
        if ($uk !== '') {
            $param = " and NALOK like ('%".$q."%')";
        }
        $query = "select `KOLOK` as id, `NALOK` as list from tablokb08 where `A_01` = '".$uk."' $param";
        $sql = mysql_query($query);
        while ($rows = mysql_fetch_object($sql)) {
            $data[] = $rows;
        }
        $pilih[] = array('id'=>'', 'list' => '<i>Semua ...</i>');
        $total = mysql_num_rows(mysql_query($query));
        die(json_encode(array('data' => array_merge($pilih, $data), 'total' => $total)));
    }
    
    if ($cari === 'hakakses') {
        $id_group = $_GET['id_group'];
        $query = "select p.*,m.nama as module, g.id_group_users from privileges p
        join module m on (m.id = p.id_module)
        left join grant_privileges g on 
        (p.id = g.id_privileges and g.id_group_users = '".$id_group."')
        order by m.id, p.menu";
        //echo $query;
        $sql = mysql_query($query);
        $data = array();
        while ($rows = mysql_fetch_object($sql)) {
            $data[] = $rows;
        }
        die(json_encode($data));
    }
    
    if ($cari === 'logmein_fucker') {
        $isloggedin=false;
        $sid = NULL;
        $sid=md5(date("Y-m-d").date("H:i:s").$REMOTE_ADDR."ItsABeautifulDay");
        if (isset($_POST['username'])) {
		$q="select u.*, m.`A_01`, m.`A_02`, m.`A_03`, m.`A_04`, m.`A_05`,m.`B_03` as nama, g.nama as nama_group from USER u
                    join mastfip08 m on (u.B_02 = m.B_02)
                    join group_users g on (u.id_group_user = g.id)
                    where u.username='".$_POST['username']."' and password='".md5($_POST['password'])."'";
                //echo $q;
		$r=mysql_query($q) or die(mysql_error());
		$j=mysql_num_rows($r);
		
		if ($j > 0) {
			$ro=mysql_fetch_array($r);
                        $_SESSION['username'] = $ro['username'];
                        $_SESSION['group_user'] = $ro['id_group_user'];
                        $_SESSION['nama_group'] = $ro['nama_group'];
                        $_SESSION['skpd'] = $ro['A_01'];
                        $_SESSION['nama'] = $ro['nama'];
			mysql_query("delete from LOGUSER where TANGGAL='0000-00-00'") or die (mysql_error());
			$xtgl=date("Y-m-d",mktime(0,0,0,date("m")  ,date("d")-1,date("Y")));
			mysql_query("delete from LOGUSER where TANGGAL <= '$xtgl'") or die (mysql_error());		
			mysql_query("insert into LOGUSER set sub_app='".$ro[level]."', user='$username', sid='$sid',TANGGAL='".date("Y-m-d")."'") or die (mysql_error());
		}
	}
	$qj="select user,sub_app from LOGUSER where sid='$sid' LIMIT 1";
	$rj=mysql_query($qj) or die(mysql_error());
	$j=mysql_num_rows($rj);
	if ($j > 0 ) {
            $roj=mysql_fetch_row($rj);
            $level=$roj[1];
            $isloggedin=true;
            $result['status'] = TRUE;
            $result['sid'] = $sid;
        } else {
            $result['status'] = FALSE;
        }
        die(json_encode($result));
    }
}
?>
