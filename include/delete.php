<?php
include('../include/config.inc');
include('../include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$opsi = $_GET['delete'];

if ($opsi === 'arsip_kategori') {
    $id = $_GET['id'];
    mysql_query("delete from arsip_kategori where id = '$id'");
}

if ($opsi === 'arsip') {
    $id = $_GET['id'];
    $nama_file = $_GET['nama_file'];
    mysql_query("delete from arsip where id = '$id'");
    if ($nama_file !== '') {
        @unlink('../arsip/'.$nama_file);
    }
}
?>