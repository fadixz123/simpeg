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
    mysql_query("insert into tb_message_detail set nip_pengirim = '".$nip1."', nip_penerima = '".$nip2."', message = '$message'");
    die(json_encode(array('status' => TRUE)));
}