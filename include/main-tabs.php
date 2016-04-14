<?php
$sid = $_GET['sid'];
$nip = $_GET['nip'];
$nama= $_GET['nama'];
?>
<script type="text/javascript" src="Scripts/library.js"></script>
<script type="text/javascript">
	$(function() {
                $('#mytab a:first').tab('show');
                my_ajax('include/main-detail.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab1');
                
                $(".link_tab").die('click').live('click',function() {
                        var tab_id = $(this).attr('id');
                        switch(tab_id){
                            case 'pegawai':
                                //if ($('#tab1').html() === '') {
                                    my_ajax('include/main-detail.php?sid=<?=$sid?>&do=cari&nama=<?=$nama?>&nip=<?=$nip?>&cari=NIP','#tab1');
                                //}
                            break;
                            case 'lokid':
                                if ($('#tab2').html() === '') {
                                    my_ajax('biodata/lokid.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab2');
                                }
                            break;
                            case 'cpnspns':
                                if ($('#tab3').html() === '') {
                                    my_ajax('biodata/cpnspns.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab3');
                                }
                            break;
                            case 'pktgaji':
                                if ($('#tab4').html() === '') {
                                    my_ajax('biodata/pktgaji.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab4');
                                }
                            break;
                            case 'jabakhir':
                                if ($('#tab5').html() === '') {
                                    my_ajax('biodata/jabatan.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab5');
                                }
                            break;
                            case 'pddakhir':
                                if ($('#tab6').html() === '') {
                                    my_ajax('biodata/dik.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab6');
                                }
                            break;
                            case 'ortu':
                                if ($('#tab7').html() === '') {
                                    my_ajax('biodata/ortu.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab7');
                                }
                            break;
                            case 'keluarga':
                                if ($('#tab8').html() === '') {
                                    my_ajax('biodata/smistri.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab8');
                                }
                            break;
                            case 'anak':
                                if ($('#tab9').html() === '') {
                                    my_ajax('biodata/anak.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab9');
                                }
                            break;
                            case 'riwayat':
                                if ($('#tab10').html() === '') {
                                    my_ajax('biodata/riwayat.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab10');
                                }
                            break;
                            
                        }
                        $('.link').unbind('click');
                        return false;
                });
	});
</script>


<ul id="mytab" class="nav nav-tabs">
  <li class="link_tab" id="pegawai"><a href="#tab1" data-toggle="tab"> Data Pegawai</a></li>
  <li class="link_tab" id="lokid"><a href="#tab2" data-toggle="tab"> Lokasi & Identitas</a></li>
  <li class="link_tab" id="cpnspns"><a href="#tab3" data-toggle="tab">CPNS & PNS</a></li>
  <li class="link_tab" id="pktgaji"><a href="#tab4" data-toggle="tab">Pangkat & Eselon</a></li>
  <li class="link_tab" id="jabakhir"><a href="#tab5" data-toggle="tab">Jabatan Terakhir</a></li>
  <li class="link_tab" id="pddakhir"><a href="#tab6" data-toggle="tab">Pendidikan Akhir</a></li>
  <li class="link_tab" id="ortu"><a href="#tab7" data-toggle="tab">Ortu</a></li>
  <li class="link_tab" id="keluarga"><a href="#tab8" data-toggle="tab">Suami / Istri</a></li>
  <li class="link_tab" id="anak"><a href="#tab9" data-toggle="tab">Anak</a></li>
  <li class="link_tab" id="riwayat"><a href="#tab10" data-toggle="tab">Riwayat</a></li>
</ul>
                  
<div class="tab-content">
  <div class="tab-pane" id="tab1"></div>
  <div class="tab-pane" id="tab2"></div>
  <div class="tab-pane" id="tab3"></div>
  <div class="tab-pane" id="tab4"></div>
  <div class="tab-pane" id="tab5"></div>
  <div class="tab-pane" id="tab6"></div>
  <div class="tab-pane" id="tab7"></div>
  <div class="tab-pane" id="tab8"></div>
  <div class="tab-pane" id="tab9"></div>
  <div class="tab-pane" id="tab10"></div>
</div>

             