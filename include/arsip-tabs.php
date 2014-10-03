<?php
$sid = $_GET['sid'];
$nip = $_GET['nip'];
?>
<script type="text/javascript" src="Scripts/library.js"></script>
<script type="text/javascript">
	$(function() {
                $('#mytab a:first').tab('show');
                my_ajax('include/main-detail.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab1');
                $('body').unbind('click');
                $(".link_tab").die('click').live('click',function() {
                        var tab_id = $(this).attr('id');
                        switch(tab_id){
                            case 'pegawai':
                                if ($('#tab1').html() === '') {
                                    my_ajax('include/main-detail.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab1');
                                }
                            break;
                            case 'arsip':
                                if ($('#tab2').html() === '') {
                                    my_ajax('include/arsip-input.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab2');
                                }
                            break;
                            
                        }
                        return false;
                });
	});
</script>


<ul id="mytab" class="nav nav-tabs">
  <li class="link_tab" id="pegawai"><a href="#tab1" data-toggle="tab"> Data Pegawai</a></li>
  <li class="link_tab" id="arsip"><a href="#tab2" data-toggle="tab"> Arsip</a></li>
</ul>
                  
<div class="tab-content">
  <div class="tab-pane" id="tab1"></div>
  <div class="tab-pane" id="tab2"></div>
</div>

             