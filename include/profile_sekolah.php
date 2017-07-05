<?php
session_start();
include("include/config.inc");
include("include/fungsi.inc");
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$warnaMenu = '#FFFFFF';
$sid = $_GET['sid'];
$NIP = $_GET['nip'];
$j=mysql_num_rows(mysql_query("select user from LOGUSER where sid='$sid' LIMIT 1"));
if ($j > 0 ) {
	$sid2=md5(date("Y-m-d").date("H:i:s").$REMOTE_ADDR);
	$juser=mysql_num_rows(mysql_query("select SID from LOGUSER where sub_app='administrator'"));
	if ($cekYT=='YA') {
		$qAdd="insert into MASTFIP08 set B_02='$NIP'";
		mysql_query($qAdd) or die(mysql_error());
	}
	else if ($cekYT=='TIDAK') $NIP='';
	?>
<script type="text/javascript" src="Scripts/bootstrap-datepicker.js"></script>
<SCRIPT type="text/javascript">
    function reload_data() {
            reset_form();
            search_data_pns(1);
        }
        
        function reset_form() {
            $('input[type=text], input[type=hidden], select, textarea').val('');
            $('a .select2-chosen').html('&nbsp;');
        }
        
        function print_data(sid, nip) {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('CETAKFIP/index.php?sid='+sid+'&NIP='+nip,'Cetak Penerimaan','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
        }
        
        $(function() {
       
            $('#fucker').datepicker();
            search_data_pns(1);
            $('#searching').click(function() {
                $('#datamodal_search').modal('show');
            });
            $('#tambah').click(function() {
                $('#datamodal_search_detail').modal('show');
                load_detail('include/main-tabs.php?sid=<?=$sid?>&do=cari&nip=&cari=NIP');
            });
            $('#nip').select2({
                ajax: {
                    url: 'include/autocomplete.php?search=pegawai',
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) { // page is the one-based page number tracked by Select2
                        return {
                            q: term, //search term
                            page: page, // page number
                            uk: $('#uk').val(),
                            suk: ($('#suk').val() === undefined)?$('#suks').val():$('#suk').val()
                        };
                    },
                    results: function (data, page) {
                        var more = (page * 20) < data.total; // whether or not there are more results available

                        // notice we return the value of more so Select2 knows if more results can be loaded
                        return {results: data.data, more: more};
                    }
                },
                formatResult: function(data){
                    var markup = data.list;
                    return markup;
                }, 
                formatSelection: function(data){
                    return data.list;
                }
            });
            $('#suk').select2({
                ajax: {
                    url: 'include/autocomplete.php?search=suk',
                    dataType: 'json',
                    quietMillis: 100,
                    data: function (term, page) { // page is the one-based page number tracked by Select2
                        return {
                            q: term, //search term
                            page: page, // page number
                            uk: $('#uk').val()
                        };
                    },
                    results: function (data, page) {
                        var more = (page * 20) < data.total; // whether or not there are more results available

                        // notice we return the value of more so Select2 knows if more results can be loaded
                        return {results: data.data, more: more};
                    }
                },
                formatResult: function(data){
                    var markup = data.list;
                    return markup;
                }, 
                formatSelection: function(data){
                    return data.list;
                }
            });
            /*$('#uk').change(function() {
                $.ajax({
                    url: 'include/autocomplete.php?search=suk',
                    data: 'q='+$('#uk').val(),
                    dataType: 'json',
                    success: function(data) {
                        $('#suk').html('<option value="">Semua sub unit kerja ...</option>');
                        $.each(data, function(i, v) {
                            $('#suk').append('<option value="'+v.KOLOK+'">'+v.NALOK+'</option>');
                        });
                    }
                });
            });*/
        });
        
        function cetak(id) {
            window.open('CETAKFIP/index.php?nip='+id+'&sid=<?= $sid ?>');
        }
        
        function search_data_pns(page) {
            $.ajax({
                type: 'GET',
                url: 'include/profil_sekolah-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
                data: $('#form-search').serialize(),
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    hide_ajax_indicator();
                    $('#datamodal_search').modal('hide');
                    $('#result').html(data);
                }
            });
        }
        
        function save_profile(i) {
            var id_lok  = $('#id_lok'+i).val();
            var rombel  = $('#rombel'+i).val();
            var jml_siswa = $('#jml_siswa'+i).val();
            var alamat  = $('#alamat'+i).val();
            var email   = $('#email'+i).val();
            var telp    = $('#telp'+i).val();
            $.ajax({
                type: 'POST',
                url: 'biodata/save-data.php?save=profil_sekolah',
                data: 'id_lok='+id_lok+'&rombel='+rombel+'&jml_siswa='+jml_siswa+'&alamat='+alamat+'&email='+email+'&telp='+telp,
                dataType: 'json',
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    hide_ajax_indicator();
                    if (data.act === 'add') {
                        message_add_success();
                    } else {
                        message_edit_success();
                    }
                    var page = $('.noblock').html();
                    search_data_pns(page);
                },
                error: function() {
                    hide_ajax_indicator();
                    message_edit_failed();
                }
            });
        }
        
        function load_detail(url, id) {
            $('#detail-pegawai').empty();
            $('#datamodal_search_detail').modal('show');
            $('#cetak').attr('onclick','cetak(\''+id+'\')');
            $.ajax({
                type: 'GET',
                url: url,
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    hide_ajax_indicator();
                    $('#detail-pegawai').html(data);
                }
            });
            return false;
        }
		
        function delete_pegawai(url, page) {
			bootbox.dialog({
          message: "Anda yakin akan menghapus data ini?",
          title: "Konfirmasi",
          buttons: {
            batal: {
                label: '<i class="fa fa-refresh"></i> Tidak',
                className: "btn-default",
                callback: function() {

                }
            },
            save: {
                label: '<i class="fa fa-check-circle"></i>  Ya',
                className: "btn-primary",
                callback: function() {
                    $.ajax({
						type: 'GET',
						url: url,
						beforeSend: function() {
							show_ajax_indicator();
						},
						success: function(data) {
							hide_ajax_indicator();
							search_data_pns(page);
						}
					});
                }
            }
            }
        });
		}
        
        function paging(page, tab, search) {
            search_data_pns(page);
        }
        
        function load_riwayat(nip) {
            /*switch ($page)
            {
                    case "awal" 	: include ("awal.inc");break;
                    case "lokid"	: include ("lokid.php");break;
                    case "cpnspns"	: include ("cpnspns.php");break;
                    case "pkt"	: include ("pktgaji.php");break;
                    case "dik"	: include ("dik.php");break;
                    case "jab"	: include ("jabatan.php");break;
                    case "rpk"	: include ("rpkt.inc");break;
                    case "rjb"	: include ("rjab.inc");break;
                    case "rtj"	: include ("rtj.inc");break;
                    case "rtg"	: include ("rln.inc");break;
                    case "bhs"	: include ("bahasa.inc");break;
                    case "rdu"	: include ("rdikum.inc");break;
                    case "rst"	: include ("rdikstru.inc");break;
                    case "rfu" 	: include ("rdikfung.inc");break;
                    case "rdt" 	: include ("rdiktekn.inc");break;
                    case "rpt" 	: include ("rtatar.inc");break;
                    case "rsm" 	: include ("rsemi.inc");break;
                    case "rku" 	: include ("rkursus.inc");break;
                    case "ortu"	: include ("ortu.php");break;
                    case "smistri"	: include ("smistri.php");break;
                    case "anak"	: include ("anak.php");break;
                    case "pupns"	: include ("pupns.inc");break;

            }*/
            var riwayat = $('#do').val();
            var url = '';
            if (riwayat === 'rpk') { url = 'biodata/rpkt.php'; }
            if (riwayat === 'rjb') { url = 'biodata/rjab.php'; }
            if (riwayat === 'rtj') { url = 'biodata/rtj.php'; }
            if (riwayat === 'rtg') { url = 'biodata/rln.php'; }
            if (riwayat === 'bhs') { url = 'biodata/bahasa.php'; }
            if (riwayat === 'rdu') { url = 'biodata/rdikum.php'; }
            if (riwayat === 'rst') { url = 'biodata/rdikstru.php'; }
            if (riwayat === 'rfu') { url = 'biodata/rdikfung.php'; }
            if (riwayat === 'rdt') { url = 'biodata/rdiktekn.php'; }
            if (riwayat === 'rpt') { url = 'biodata/rtatar.php'; }
            if (riwayat === 'rsm') { url = 'biodata/rsemi.php'; }
            if (riwayat === 'rku') { url = 'biodata/rkursus.php'; }
            if (riwayat === 'rhd') { url = 'biodata/rhukuman.php'; }
            if (riwayat === 'rpkj') { url = 'biodata/rpekerjaan.php'; }
        
            if (riwayat !== '') {
                $.ajax({
                    type: 'GET',
                    url: url+'?sid=<?= $sid ?>&nip='+nip,
                    beforeSend: function() {
                        show_ajax_indicator();
                    },
                    success: function(data) {
                        hide_ajax_indicator();
                        $('#load-riwayat').html(data);
                    }
                });
            }
        }
</script>
<h4 class="title">PROFILE SEKOLAH</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Profile</a></li>
</ul>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 
<table width="100%">
<!------------- input NIP ------------>
<?
if (strlen($NIP)==0) {
	?>
	<tr>
	<td width="800" height="1"></td>
	</tr>
<!--	<tr>
	  <td height="500" align="center" valign="top" class="componentheading">
	     <table width="100%" cellpadding="0" cellspacing="0" border="0">
	     <form name="cekNIP" method="post" action="index.htm?sid=<?=$sid?>&do=biodata&page=biodata&page=awal">
	     <tr bgcolor="#CCCCCC" class="sectiontableheader" height="30">
	       <td width="20%"><font color="#FFFFFF">Masukkan
           NIP </font></td>
	       <td width="1%">:
	       </td>
	       <td>
	       <input type="text" name="NIP" maxlength="18" width="20" >
	       <input type="submit" name="cariNIP" value="CARI NIP" class="tombol">
	       </td>
	       </tr>
	     </form>
	     </table>	
	  </td>
	</tr>-->
<!------------------------------------>
<?
}
else if (strlen($NIP)!=0) {
	
	$q="select B_02,B_02B,B_03A,B_03,B_03B from MASTFIP08 where B_02='$NIP' or B_02B='$NIP' LIMIT 1";
	$r=mysql_query($q) or die(mysql_error());
	if (mysql_num_rows($r)==0) {
		
		?>
<!--		<tr>
		<td height="1" class="componentheading"></td>
		</tr>
		<form name="cekNIPAgain" method="post" action="index.htm?sid=<?=$sid?>&do=biodata&page=cari">
		<input type="hidden" name="NIP" value="<?=$NIP?>">
		<tr height="30">
		<td height="30" bgcolor="#CCCCCC" class="sectiontableheader"><font color="#FFFFFF">NIP Belum ADA, akan ditambah?</font>		<input type="submit" name="cekYT" value="YA" class="tombol">
		<input type="submit" name="cekYT" value="TIDAK" class="tombol">
		</td>
		</tr>
		</form>
		<tr>
		<td>&nbsp;</td>
		</tr>-->
	<?
	}
	else if(mysql_num_rows($r)==1) {
		$sid2=md5(date("H:i:s").date("Y-m-d"));
		$row=mysql_fetch_array($r);
		$NIP=$row[B_02];
		?>
		<tr>
		<td height="1"></td>
		</tr>
		<tr>
	  	  <td align="center" valign="top">
	     	  <table width="100%" cellpadding="0" cellspacing="0" border="0">
	     	    <tr height="15">
	     	      <td valign="top" class="sectiontableheader">
	     	      	  | 
	     	          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=awal&NIP=<?=$NIP?>">Awal</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=lokid&NIP=<?=$NIP?>">Lokasi&amp;Identitas</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=cpnspns&NIP=<?=$NIP?>">CPNS&PNS</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=pkt&NIP=<?=$NIP?>">Pkt&amp;Gaji</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=jab&NIP=<?=$NIP?>">JabAkhir</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=dik&NIP=<?=$NIP?>">DikAkhir</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=ortu&NIP=<?=$NIP?>">Ortu</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=smistri&NIP=<?=$NIP?>">Suami/Istri</a>
                          | 
                          <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=anak&NIP=<?=$NIP?>">Anak</a>
                  |</td>
                </tr>
                      <tr height="25">
                      <td valign="top" class="sectiontableheader">
                          |
                             Riwayat &nbsp;
                           <select size="1" name="do"  onChange="window.location='index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page='+this.value+'&NIP=<?=$NIP?>'">
                              <option value="">Pilih Riwayat</option>
                              <option value="rpk" <? if ($page=='rpk') echo "selected"?>>RIWAYAT PANGKAT</option>
  	    		               <option value="rjb"  <? if ($page=='rjb') echo "selected"?>>RIWAYAT JABATAN</option>
  	    		               <option value="rtj"  <? if ($page=='rtj') echo "selected"?>>RIWAYAT TANDA JASA</option>
  	    		               <option value="rtg"  <? if ($page=='rtg') echo "selected"?>>RIWAYAT TUGAS KE LUAR NEGERI</option>
  			                   <option value="bhs"  <? if ($page=='bhs') echo "selected"?>>PENGUASAAN BAHASA</option>
  			                   <option value="rdu"  <? if ($page=='rdu') echo "selected"?>>RIWAYAT PENDIDIKAN UMUM</option>
  			                   <option value="rst"  <? if ($page=='rst') echo "selected"?>>RIWAYAT DIKLAT STRUKTURAL</option>
  			                   <option value="rfu"  <? if ($page=='rfu') echo "selected"?>>RIWAYAT DIKLAT FUNGSIONAL</option>
  			                   <option value="rdt"  <? if ($page=='rdt') echo "selected"?>>RIWAYAT DIKLAT TEKNIS</option>
  			                   <option value="rpt"  <? if ($page=='rpt') echo "selected"?>>RIWAYAT PENATARAN</option>
  			                   <option value="rsm"  <? if ($page=='rsm') echo "selected"?>>RIWAYAT SEMI/LOKA/SIMP</option>
  			                   <option value="rku"  <? if ($page=='rku') echo "selected"?>>RIWAYAT
  			                   KURSUS DI DLM & LUAR NEGERI</option>
                            </select>
                        | 
                        <a href="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=pupns&NIP=">NIP Lain</a>
                        
	     	      </td>
	     	    </tr>
	     	  </table>
     	  </td>
  </tr>
	     	<tr>
		<td height="1"></td>
		</tr>
		<tr bgColor="#999999" height="20">
		<td height="20" bgcolor="#CCCCCC" class="sectiontableheader" >| NIP : 
		  <?=$NIP?> / <?=format_nip_baru($row[B_02B])?>
		  | 
		  <?=namaPNS($row[B_03A],stripslashes($row[B_03]),$row[B_03B])?> 
		  |</td>
		</tr>
		<tr>
		  <td valign="top">
		  <?
			switch ($page)
			{
				case "awal" 	: include ("awal.inc");break;
				case "lokid"	: include ("lokid.php");break;
				case "cpnspns"	: include ("cpnspns.php");break;
				case "pkt"	: include ("pktgaji.php");break;
				case "dik"	: include ("dik.php");break;
				case "jab"	: include ("jabatan.php");break;
				case "rpk"	: include ("rpkt.inc");break;
				case "rjb"	: include ("rjab.inc");break;
				case "rtj"	: include ("rtj.inc");break;
				case "rtg"	: include ("rln.inc");break;
				case "bhs"	: include ("bahasa.inc");break;
				case "rdu"	: include ("rdikum.inc");break;
				case "rst"	: include ("rdikstru.inc");break;
				case "rfu" 	: include ("rdikfung.inc");break;
				case "rdt" 	: include ("rdiktekn.inc");break;
				case "rpt" 	: include ("rtatar.inc");break;
				case "rsm" 	: include ("rsemi.inc");break;
				case "rku" 	: include ("rkursus.inc");break;
				case "ortu"	: include ("ortu.php");break;
				case "smistri"	: include ("smistri.php");break;
				case "anak"	: include ("anak.php");break;
				case "pupns"	: include ("pupns.inc");break;
				
			}
		  ?>	
		  </td>
		</tr>
		<?
	}
}
?>
<!------------------------------------>

<!------------ footer ---------------->
<!------------------------------------>
</table>
<div id="datamodal_search" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Parameter Pencarian </h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <form id="form-search" role="form" class="form-horizontal">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <table width="100%" id="autohide" class="user-define">
                        <tr>
                            <td width="25%">Unit Kerja:</td>
                            <td>
                                <select name="uk" class="form-control" id="uk" style="width: 300px;">
                                    <?php
                                    $id_skpd = NULL;
                                    if ($_SESSION['skpd'] !== '20' and $_SESSION['nama_group'] !== 'Administrator') {
                                      $id_skpd = $_SESSION['skpd'];
                                    }
                                    if (strtolower($_SESSION['nama_group']) === 'admin skpd' or strtolower($_SESSION['nama_group']) === 'admin sub skpd') {
                                      $id_skpd = $_SESSION['skpd'];
                                    }
                                    if (strtolower($_SESSION['nama_group']) === 'opd baru') {
                                        $id_skpd = NULL;
                                    }
                                    if ($id_skpd === NULL) {
                                        echo '<option value="all">Semua unit kerja...</option>';
                                    }
                                    $lsuk=listUnitKerja($id_skpd);
                                    foreach($lsuk as $key=>$value) {
                                    ?>
                                    <option value="<?=$value[0]?>"><?= ucfirst(strtolower($value[1]))?></option>
                                    <? } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Sub Unit Kerja:</td>
                            <td>
                                <!--<select name="suk" class="form-control" id="suk"></select>-->
                                <?php 
                                $subuk = listSubUnitKerja($_SESSION['skpd'].$_SESSION['subskpd1']);
                                if (strtolower($_SESSION['nama_group']) === 'admin sub skpd') { ?>
                                <select name="suk" class="form-control" id="suks" style="width: 300px;">
                                    <option value="">Semua ...</option>
                                    <?php foreach($subuk as $dataxx) { ?>
                                    <option value="<?= $dataxx[0] ?>"><?= $dataxx[1]  ?></option>
                                    <?php } ?>
                                </select>
                                <?php } else { ?>
                                <input type="text" name="suk" class="select2-input" id="suk">
                                <?php } ?>
                            </td>
                      </tr>
                      <tr>
                      <td width="15%">NIP / Nama:</td>
                      <td>
                        <input type="text" name="nip" class="select2-input" id="nip">

                      </tr>
                    </table>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="search_data_pns(1);"><i class="fa fa-eye"></i> Tampilkan</button>
        </div>
    </div>
    </div>
</div>
<div id="datamodal_search_detail" class="modal fade">
    <div class="modal-dialog" style="width: 1124px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Detail Data Pegawai - <span id="nip_nama"></span></h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                        <div id="detail-pegawai"></div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Close</button>
            <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    </div>
</div>
<div id="result"></div>
<?
mysql_close();
}
else {
	mysql_close();	
	echo "Anda harus login terlebih dahulu.";
}
?>