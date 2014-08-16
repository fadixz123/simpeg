<?php
if (isset($_SESSION['username'])) { ?>
<script type="text/javascript" src="Scripts/library.js"></script>
<script type="text/javascript">
	$(function() {
                $('#mytab a:first').tab('show');
                my_ajax('include/skp-input.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab1');
                
                $(".link_tab").live('click',function() {
                        var tab_id = $(this).attr('id');
                        switch(tab_id){
                            case 'inputskp':
                                if ($('#tab1').html() === '') {
                                    my_ajax('include/skp-input.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab1');
                                }
                            break;
                            case 'settingskp':
                                if ($('#tab2').html() === '') {
                                    my_ajax('include/skp-setting.php?sid=<?=$sid?>&do=cari&nip=<?=$nip?>&cari=NIP','#tab2');
                                }
                            break;
                        }
                        $('.link').unbind('click');
                        return false;
                });
	});
        
        function paging(page, tab) {
            if (tab === 1) {
                load_data_skp_input(page);
            }
            if (tab === 2) {
                load_data_skp_setting(page);
            }
        }
</script>

<h4 class="title">MANAJEMEN SKP</h4>
<ul id="mytab" class="nav nav-tabs">
  <li class="link_tab" id="inputskp"><a href="#tab1" data-toggle="tab"> Input SKP </a></li>
  <li class="link_tab" id="settingskp"><a href="#tab2" data-toggle="tab"> Setting SKP</a></li>
</ul>
                  
<div class="tab-content">
  <div class="tab-pane" id="tab1"></div>
  <div class="tab-pane" id="tab2"></div>
</div>
<?php } else { 
     header("location: index.php?do=sessoff&sid".$_GET['sid']);
} ?>