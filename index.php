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
<link rel="stylesheet" href="include/font-awesome-4.4.0//css/font-awesome.min.css" />
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
    $(function() {
        $('.mypopover').popover({
            trigger:'click',
            animation: true,
            placement: 'bottom',
            html: true,
            title: '<small>Recent(2), message request (1) </small>'
        }).on("show.bs.popover", function () { $(this).data("bs.popover").tip().css("width", "400px"); }); 
    });
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
    
    function load_menu(url) {
        var position = url;

        localStorage.setItem("dkv3_url_position", position);
        $.ajax({
            url: url,
            data: '',
            cache: false,
            success: function (data) {
                //$('form').remove();
                $('#main-content').empty();
                $('#main-content').html(data);
            }
        });
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
    
    $sql = mysql_query("select count(*) as jumlah from (select *
        from tb_message_detail
        where nip_penerima = '".$_SESSION['nip_baru']."' and status_baca = 'Belum'
            group by status_baca) as sq
        ");
    $rowx = mysql_fetch_array($sql);
    ?>
    <div class="link2">
        <?php 
        function datetimexfmysql($dt, $time = NULL) {
            $var = explode(" ", $dt);
            $var1 = explode("-", $var[0]);
            $var2 = "$var1[2]/$var1[1]/$var1[0]";
            if ($time != NULL) {
                return $var2 . ' ' . $var[1];
            } else {
                return $var2;
            }
        }
        if (isset($_SESSION['username'])) { 
            $detail = "<table width='100%'>";
                $query = "select mf2.foto, mf2.`B_02B` as nip, mf2.B_06, CONCAT_WS(' ',mf2.`B_03`,mf2.`B_03B`) as nama, md.message, md.waktu
                    from tb_message_detail md
                    join mastfip08 mf on (mf.`B_02B` = md.nip_penerima)
                    join mastfip08 mf2 on (md.nip_pengirim = mf2.`B_02B`)
                    where md.nip_penerima = '".$_SESSION['nip_baru']."' 
                        group by md.nip_pengirim";
                
                $sql_pesan = mysql_query($query);
                $no = 1;
                while($rowy = mysql_fetch_array($sql_pesan)) {
                    $mess = mysql_fetch_array(mysql_query("select message, waktu from tb_message_detail where status_baca = 'Belum' or status_baca = 'Sudah' and nip_pengirim = '".$rowy['nip']."' and nip_penerima = '".$_SESSION['nip']."' order by id desc limit 1"));
                    $foto = $rowy['foto'];
                    if ($rowy['foto'] === '' and $rowy['B_06'] === '1') {
                        $foto = 'default-l.png';
                    }
                    if ($rowy['foto'] === '' and $rowy['B_06'] === '2') {
                        $foto = 'default-p.png';
                    }
                    $detail.="<tr onclick=location.href='index.php?do=message&id=".$rowy['nip']."&sid=".$_GET['sid']."' class='".(($no%2===0)?'even':'odd')."' valign='top'><td width='15%'><img style='background: #ccc; padding: 3px; margin-right: 10px;' src='Foto/".$foto."' width='50px' height='50px' /></td>
                        <td>
                            <b><small>".$rowy['nama']."</small></b>
                            <p><small>".((strlen($mess['message']) < 50)?$mess['message']:substr($mess['message'],0,50).' ...')."</small></p>
                            <p style='font-size: 10px; margin-top: 12px;'>".datetimexfmysql($mess['waktu'], true)."</p>
                        </td>
                    </tr>";
                    $no++;
                }
                $detail.="</table>";
            ?>
        <button class="btn btn-xs btn-primary mypopover" data-container="body" data-toggle="popover" data-placement="top" data-content="<?= $detail ?>"><i class="fa fa-envelope"></i> <?= ($rowx['jumlah'] === '0')?'Tidak ada pesan baru':'Ada '.$rowx['jumlah'].' pesan baru' ?> </button> | Anda Login Sebagai: <b><?= $_SESSION['nama'] ?></b>
        
        <?php } else { ?>
            Tamu
        <?php } ?>
    </div>
</div>
<div id="pagewidth-1024">
	
	<div id="outer-1024">
		
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
<!--                    <div class="module">
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
                    </div>-->
                <?php } ?>
                </div>
                
                <div id="maincol-wide-1024">
                        <div class="clr"></div>
			<div class="content">
				<a name="content"></a>
				<table class="blog" cellpadding="0" cellspacing="0"><tbody><tr>
				  <td valign="top" id="main-content">&nbsp;
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
                case 'lacak': include("include/lacak.php"); break;
                case 'profil_sekolah': include("include/profile_sekolah.php"); break;
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