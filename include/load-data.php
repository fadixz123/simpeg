<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$data = $_GET['data'];
if ($data === 'message') {
    $query = "select * from (
        select md.id, mf.foto, md.waktu, CONCAT_WS(' ',mf.`B_03`,mf.`B_03B`) as nama, md.message
        from tb_message_detail md
        join mastfip08 mf on (md.nip_pengirim = mf.`B_02B`)
        where md.nip_penerima = '".$_SESSION['nip']."' and md.nip_pengirim = '".$_GET['nip']."'
            UNION ALL
        select md2.id, mf2.foto, md2.waktu, CONCAT_WS(' ',mf2.`B_03`,mf2.`B_03B`) as nama, md2.message
        from tb_message_detail md2
        join mastfip08 mf2 on (md2.nip_pengirim = mf2.`B_02B`)
        where md2.nip_pengirim = '".$_SESSION['nip']."' and md2.nip_penerima = '".$_GET['nip']."'
            ) a order by id asc";
    
    $sql = mysql_query($query);
    $nilai = '';
    while($row = mysql_fetch_object($sql)) {
        $nilai[] = $row;
    }
    die(json_encode(array('data' => $nilai)));
}