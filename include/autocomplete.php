<?php
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
}
?>
