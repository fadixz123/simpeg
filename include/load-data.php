<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$data = $_GET['data'];
if ($data === 'message') {
    $sql = mysql_query("select * from (
        select md.*, mf.foto, CONCAT_WS(' ',mf.`B_03`, mf.`B_03B`) as nama
        from tb_message_detail md
        join tb_message m on (md.id_message = m.id)
        join mastfip08 mf on (m.nip1 = mf.`B_02B`)
        where mf.`B_02` = '".$_SESSION['nip']."'
            UNION ALL
        select md.*, mf.foto, CONCAT_WS(' ',mf.`B_03`, mf.`B_03B`) as nama
        from tb_message_detail md
        join tb_message m on (md.id_message = m.id)
        join mastfip08 mf on (m.nip1 = mf.`B_02B`)
        where mf.`B_02` = '".$_GET['nip']."') a 
            order by id
            ");
    $nilai = '';
    while($row = mysql_fetch_object($sql)) {
        $nilai[] = $row;
    }
    die(json_encode(array('data' => $nilai)));
}