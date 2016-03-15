<?php
session_start();
include('config.inc');
include('fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$save = $_GET['save'];
if ($save === 'message') {
    $nip1 = $_POST['nip1'];
    $nip2 = $_POST['nip2'];
    $message = $_POST['message'];
    $check = mysql_fetch_array(mysql_query("select id, count(*) as jumlah from tb_message where nip1 = '$nip1' and nip2 = '$nip2'"));
    //echo "select id, count(*) as jumlah from tb_message where nip1 = '$nip1' and nip2 = '$nip2'";
    $id = $check['id'];
    if ($check['jumlah'] === '0') {
        mysql_query("insert into tb_message set nip1 = '$nip1', nip2 = '$nip2'");
        $id = mysql_insert_id();
    }
    mysql_query("insert into tb_message_detail set id_message = '$id', message = '$message'");
    die(json_encode(array('status' => TRUE)));
}