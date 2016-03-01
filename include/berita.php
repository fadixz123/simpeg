<?php
session_start();
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
?>
<h4 class='title'>SISTEM INFORMASI MANAJEMEN KEPEGAWAIAN <?=$nama_unit_kerja?></h4>
<?php
$query = "select m.* from group_users g 
        join grant_privileges gp on (g.id = gp.id_group_users)
        join privileges p on (gp.id_privileges = p.id)
        join module m on (p.id_module = m.id)
        where gp.id_group_users = '".$_SESSION['group_user']."' group by m.id
        ";

$sql = mysql_query($query); ?>
<table>
<?php
        while($data = mysql_fetch_array($sql)) { ?>
        <tr><td><h5><?= $data['keterangan'] ?></h5></td></tr>
        <tr><td>
        <?php
        $sql2 = mysql_query("select p.* from group_users g 
            join grant_privileges gp on (g.id = gp.id_group_users)
            join privileges p on (gp.id_privileges = p.id)
            join module m on (p.id_module = m.id)
            where gp.id_group_users = '".$_SESSION['group_user']."' and m.id = '".$data['id']."'");
            while ($data2 = mysql_fetch_array($sql2)) { ?>
                <div class="wrapp-icon" onclick="location.href='<?= $data2['url'] ?><?= $_GET['sid'] ?>'">
                    <div class="wrapp-image">
                        <img src="./images/cpanel/home/<?= $data2['icon'] ?>" />
                    </div>
                    <div class="wrapp-keterangan">
                        <b><?= $data2['menu'] ?></b><br/><p><?= $data['keterangan'] ?> <?= $data2['menu'] ?></p>
                    </div>
                </div>
            <?php } ?>
            </td></tr>
<?php } ?>
</table>