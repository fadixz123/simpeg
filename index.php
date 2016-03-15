<?php
session_start();
include("include/config.inc");
$isloggedin=false;
//if ($sid==='') $sid=md5(date("Y-m-d").date("H:i:s").$REMOTE_ADDR."ItsABeautifulDay");

$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

$oq="select NALOKP from TABLOKB08 where KOLOK='".$uk."00000000' LIMIT 1";
$or=mysql_query($oq);
if ($or === FALSE) {
    die(mysql_error());
}
$orow=mysql_fetch_row($or);
$nama_unit_kerja=$orow[0];

if (isset($_GET['logout'])) {
	mysql_query("delete from LOGUSER where sid='$sid' LIMIT 1") or die (mysql_error());
        session_destroy();
        mysql_query("update user set status_online = '0' where id = '".$_SESSION['id_user']."'");
        header("location: index.php?sid=".$sid);
}


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
	if ($j > 0 )
	{
		$roj=mysql_fetch_row($rj);
		$level=$roj[1];
		$isloggedin=true;
		}
if (isset($_SESSION['username'])) {

?>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SIM Pegawai | BKD Kab. Pekalongan - <?=$nama_unit_kerja?></title>
<meta name="robots" content="index, follow" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="shortcut icon" href="images/Logo_Kab.Pekalongan.png" />
<link href="css/template_css.css" rel="stylesheet" type="text/css" />
<link href="css/css_color_blue.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/bootstrap-modal.css" />
<link rel="stylesheet" href="css/bootstrap-dialog.css" />
<link rel="stylesheet" href="css/bootstrap-editable.css" />
<link rel="stylesheet" href="css/datepicker3.css" />
<link rel="stylesheet" href="include/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="Scripts/pnotify/jquery.pnotify.default.css" />
<script type="text/javascript" src="Scripts/library.js"></script>
<script type="text/javascript" src="Scripts/jquery.min.js"></script>
<script type="text/javascript" src="Scripts/select2.js"></script>
<script type="text/javascript" src="Scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="Scripts/bootstrap-modal.js"></script>
<script type="text/javascript" src="Scripts/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="Scripts/bootbox.js"></script>
<script type="text/javascript" src="Scripts/jquery.blockUI.js"></script>
<script type="text/javascript" src="Scripts/pnotify/jquery.pnotify.min.js"></script>

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript">
    function show_ajax_indicator(){
        $('body').block({ 
              message: '<span><img src="images/loading-black.gif" /> Loading ...</span>', 
              css: { 
                  border: '1px solid #ccc',
                  padding: '5px',
                  backgroundColor: '#f4f4f4', 
                  '-webkit-border-radius': '10px', 
                  '-moz-border-radius': '10px', 
                  opacity: 1, 
                  width: '120px',
                  color: '#000' 
              } 
        }); 
    }

    function hide_ajax_indicator(){
      $('body').unblock(); 
    }
    
</script>
</head>


<body onLoad="">
<div id="Layer1">
    <div class="logo"></div>
    <div class="link">
        <a href="index.php?sid=<?= $_GET['sid'] ?>&do=home">Home</a> 
        <?php if (isset($_SESSION['username'])) { ?>
            &nbsp; | &nbsp; <a href="index.php?sid=<?= $_GET['sid'] ?>&logout=true"> <?= $_SESSION['username'] ?> (Logout)</a>
        <?php } ?>
    </div>
    <?php
    echo $_SESSION['nip_baru'];
    $sql = mysql_query("select count(*) as jumlah from (select m.id
        from tb_message m
        join tb_message_detail md on (md.id_message = m.id)
        where m.nip2 = '".$_SESSION['nip_baru']."' and md.status_baca = 'Belum'
            group by m.id) as sq
        ");
    $rowx = mysql_fetch_array($sql);
    ?>
    <div class="link2">
        Anda Login Sebagai:
        <?php if (isset($_SESSION['username'])) { ?>
        <b><?= $_SESSION['nama'] ?></b> | <span class="fa fa-envelope"></span> <?= ($rowx['jumlah'] === '0')?'Tidak ada pesan baru':'Ada '.$rowx['jumlah'].' pesan baru' ?> 
        <?php } else { ?>
            Tamu
        <?php } ?>
    </div>
</div>
<div id="pagewidth-1024">
	
	<div id="outer-1024">
		<div id="pathway">
                    <?php 
                    $q="select username,password from USER where username='$username' and password='$password' LIMIT 1";
                    $r=mysql_query($q) or die(mysql_error());
                    $j=mysql_num_rows($r);
                    ?>
                    <span class="pathway">Simpeg Online BKD 2012  </span>
                </div>
		<div id="leftcol">
                    <?php if (isset($_SESSION['username'])) { ?>
                    <?php
                    $sql = mysql_query("select m.* from group_users g 
                        join grant_privileges gp on (g.id = gp.id_group_users)
                        join privileges p on (gp.id_privileges = p.id)
                        join module m on (p.id_module = m.id)
                        where gp.id_group_users = '".$_SESSION['group_user']."' group by m.id
                        ");
                        while($data = mysql_fetch_array($sql)) { ?>
                            <div class="module">
                                <div><div><div>
                                    <h3><?= $data['nama'] ?></h3>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <?php
                                        $sql2 = mysql_query("select p.* from group_users g 
                                        join grant_privileges gp on (g.id = gp.id_group_users)
                                        join privileges p on (gp.id_privileges = p.id)
                                        join module m on (p.id_module = m.id)
                                        where gp.id_group_users = '".$_SESSION['group_user']."' and m.id = '".$data['id']."'");
                                        while ($data2 = mysql_fetch_array($sql2)) { ?>
                                        <tr align="left">
                                            <td><a href="<?= $data2['url'] ?><?= $_GET['sid'] ?>" class="mainlevel"><img src="images/icons/<?= $data2['icon'] ?>" align="center" /> <?= $data2['menu'] ?></a></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    </div></div></div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                    <div class="module">
			<div><div><div>
                        <h3>Login Form</h3>	
                            <form action="index.php" method="post" name="login">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody><tr>
                                        <td>
                                                <label for="mod_login_username">
                                                        Username			</label>
                                                <br>
                                                <input name="username" id="mod_login_username" class="inputbox" alt="username" size="10" type="text">
                                                <br>
                                                <label for="mod_login_password">
                                                        Password			</label>
                                                <br>
                                                <input id="mod_login_password" name="password" class="inputbox" size="10" alt="password" type="password">
                                                <br>
                                                <input name="submit" type="submit" class="button" id="submit" value="Login">
                                        </td>
                                </tr></tbody>
                            </table>
                            <input name="sid" value="<?=$sid?>" type="hidden" />
                            </form>
                        </div></div></div>
                    </div>
                    <?php } ?>
                <?php if($_SESSION['nama_group'] === 'Administrator') { ?>
                    <div class="module">
                        <div>
                            <div>
                                <div>
                                    <h3>User Online</h3>
                                    <?php
                                    $sql = mysql_query("select count(*) as jumlah from user where status_online = '1'");
                                    $row = mysql_fetch_array($sql);
                                    
                                    ?>
                                    <i>(<?= $row['jumlah'] ?>) User sedang online</i><br/><br/>
                                    <table width="100%">
                                    <?php
                                    $sql1 = mysql_query("select u.id, CONCAT_WS(' ',m.B_03,m.B_03B) as nama, m.B_02B from user u join mastfip08 m on (u.B_02 = m.B_02) where u.status_online = '1'");
                                    while ($row1 = mysql_fetch_array($sql1)) { 
                                        if ($row1['id'] !== $_SESSION['id_user']) { ?>
                                        <tr valign="top"><td width="5%"><img src="images/icons/user.png" align="left" width="10px" /></td><td width="95%"> <a href="index.php?do=message&id=<?= $row1['B_02B'] ?>&sid=<?= $_GET['sid'] ?>"> <?= $row1['nama'] ?></a></td></tr>
                                        <?php } else { ?>
                                        <tr valign="top"><td width="5%"><img src="images/icons/user.png" align="left" width="10px" /></td><td width="95%"> <?= $row1['nama'] ?></td></tr>
                                        <?php } ?>
                                    <?php }
                                    ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>
                
        <div id="maincol-wide-1024">
                <div class="clr"></div>
			<div class="content">
				<a name="content"></a>
				<table class="blog" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td valign="top">&nbsp;
				  <!-- content goes here -->
				  <?php
	switch($_GET['do']) {
		case 'biodata'		: include("biodata/main.php");break;
                case 'cari'	: include("include/cari.php"); break;
		case 'cari_adv'	: include("include/cari_adv_form.php");break;
		case 'rekap'	: include("include/rekap.php");break;
		case 'pensiun'	: include("include/pensiun.php");break;
		case 'struktur' : include("include/struktur.php");break;
		case 'duk'	: include("include/duk.php");break;
		case 'nominatif': include("include/nominatif.php");break;
		case 'nominatif2': include("include/nominatif2.php");break;
		case 'nominatifa': include("include/nominatif_alamat.php");break;
		case 'ulangtahun'   : include("include/ulangtahun.php");break;
		case 'berkala'   : include("include/nomberkala.php");break;
		case 'kpreg'   : include("include/nomkp.php");break;
		case 'laporan'   : include("laporan/main.php");break;
		case 'cekdata'   : include("include/cekdata.php");break;
		case 'export'   : include("include/export.php");break;
		case 'edituser'   : include("webmaster/edituser.php");break;
                case 'groupuser'   : include("webmaster/groupuser.php");break;
		case 'ubahnip'   : include("webmaster/ubahnip.php");break;
		case 'history'   : include("webmaster/aktivitas.php");break;
		case 'expor'   : include("include/expor.php");break;
		case 'detilhistory'   : include("webmaster/detailaktivitas.php");break;
                case 'skp'   : include("include/skp-tabs.php");break;
                case 'rekapskp'   : include("include/rekap-skp.php");break;
                case 'baperjakat': include("include/baperjakat.php"); break;
                case 'arsip': include("include/arsip.php"); break;
                case 'arsip_kategori': include("include/arsip-kategori.php"); break;
                case 'message': include("include/message.php"); break;
		default : include("include/berita.php");
	}
	?>
				  </td>
				  </tr></tbody></table>			
			</div>
		</div>
				<div class="clr"></div>
	</div>
    </div>
    <div id="footer-1024">
        <div align="center">&COPY; BKD Kabupaten Pekalongan 2014 - Bidang Data dan Pembinaan Pegawai</div>
    </div>
</body>
</html>
<?php } else { 
    header("location: login.php");
}
?>