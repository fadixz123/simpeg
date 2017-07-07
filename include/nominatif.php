
<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!$urut) { $urut='pkt'; }

$qcu="select distinct A_02 from TABLOKB08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) { $hasupt=true; }
?>
<script type="text/javascript">
    $(function() {
        get_list_nominatif(1);
        $('[data-toggle="popover"]').popover({
            html: true
        }).on("show.bs.popover", function () { $(this).data("bs.popover").tip().css("min-width", "500px"); });
        
        $(document).on('click', '#checkall', function() {
            var checked = $('#checkall').is(':checked');
            if (checked === true) {
                $('.checkbox input[type=checkbox]').attr('checked','checked');
            } else {
                $('.checkbox input[type=checkbox]').removeAttr('checked');
            }
        });
        
        $('#subuk').select2({
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

        $('body').on('click', function (e) {
            if ($(e.target).data('toggle') !== 'popover'
                && $(e.target).parents('.popover.in').length === 0) { 
                $('[data-toggle="popover"]').popover('hide');
            }
        });
        $('#cetak_excel').click(function() {
            window.location='include/i_nominatif.php?'+$('#nominatif1').serialize()+'&'+$('#dinamic_kolom').serialize();
        });
        
        $('#cetak_nominatif').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var x = screen.width/2 - dWidth/2;
            window.open('include/cetak-nominatif.php?'+$('#nominatif1').serialize(),'Cetak Golongan','width='+dWidth+', left='+x);
        });
        
        $('#jabfung-autoshow').hide();
        $('#searching').click(function() {
            $('#datamodal_search').modal('show');
        });
        $('#jabatan').change(function() {
            var value = $(this).val();
            if (value === '2') {
                $('#jabfung-autoshow').show();
            } else {
                $('#jabfung-autoshow').hide();
            }
        });
        
        $('#dik').change(function() {
            $.ajax({
                url: 'include/autocomplete.php?search=jurusan',
                dataType: 'json',
                data: 'kode='+$(this).val(),
                success: function(data) {
                    $('#jur').empty();
                    stri = '<option value="">Semua ...</option>';
                    $('#jur').append(stri);
                    $.each(data, function(i, v) {
                        str = '<option value="'+v.kod+'">'+v.ket+'</option>';
                        $('#jur').append(str);
                    });
                }
            }); 
        });
        
        
        /*$('#uk').blur(function() {
            $.ajax({
                url: 'include/autocomplete.php?search=suk_upt',
                dataType: 'json',
                data: 'uk='+$(this).val(),
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    $('#subuk').empty();
                    if (data.label === 'Induk/UPT') {
                        stri = '<option value="all">Semua ...</option>'+
                                '<option value="00">INDUK</option>';
                    } else {
                        stri = '<option value="">Semua ...</option>';
                    }
                    $('#label-uk').html(data.label);
                    $('#hasupt').val(data.hasupt);
                    $('#subuk').append(stri);
                    $.each(data.data, function(i, v) {
                        str = '<option value="'+v.code+'">'+v.NALOK+'</option>';
                        $('#subuk').append(str);
                    });
                }, complete: function() {
                    hide_ajax_indicator();
                }, error: function() {
                    hide_ajax_indicator();
                }
            });
        });*/
        /*$('#subuk').focus(function() {
            $.ajax({
                url: 'include/autocomplete.php?search=suk_upt',
                dataType: 'json',
                data: 'uk='+$('#uk').val(),
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    $('#subuk').empty();
                    if (data.label === 'Induk/UPT') {
                        stri = '<option value="all">Semua ...</option>'+
                                '<option value="00">INDUK</option>';
                    } else {
                        stri = '<option value="">Semua ...</option>';
                    }
                    $('#label-uk').html(data.label);
                    $('#hasupt').val(data.hasupt);
                    $('#subuk').append(stri);
                    var str = '<option value="00">Induk/UPT</option>';
                    $.each(data.data, function(i, v) {
                        str+= '<option value="'+v.code+'">'+v.NALOK+'</option>';
                    });
                    $('#subuk').append(str);
                }, complete: function() {
                    hide_ajax_indicator();
                }, error: function() {
                    hide_ajax_indicator();
                }
            });
        });*/
//        $('#kecamatan').select2({
//            ajax: {
//                url: 'include/autocomplete.php?search=kecamatan',
//                dataType: 'json',
//                quietMillis: 100,
//                data: function (term, page) { // page is the one-based page number tracked by Select2
//                    return {
//                        q: term, //search term
//                        page: page, // page number
//                    };
//                },
//                results: function (data, page) {
//                    var more = (page * 20) < data.total; // whether or not there are more results available
//
//                    // notice we return the value of more so Select2 knows if more results can be loaded
//                    return {results: data.data, more: more};
//                }
//            },
//            formatResult: function(data){
//                var markup = data.lokasi_nama;
//                return markup;
//            }, 
//            formatSelection: function(data){
//                $('#s2id_kecamatan a .select2-chosen').html(data.lokasi_nama);
//                return data.list;
//            }
//        });
    });
    
    function cetak(id) {
        var wWidth = $(window).width();
        var dWidth = wWidth * 0.5;
        var wHeight= $(window).height();
        var dHeight= wHeight * 1;
        var x = screen.width/2 - dWidth/2;
        var y = screen.height/2 - dHeight/2;
        window.open('CETAKFIP/index.php?nip='+id+'&sid=<?= $sid ?>','Cetak Profile','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
    }
    
    function export_excel() {
        window.location='include/i_nominatif.php?'+$('#nominatif1').serialize()+'&'+$('#dinamic_kolom').serialize();
    }
    
    function paging(page, tab, search) {
        get_list_nominatif(page);
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function reload_data() {
        reset_form();
        get_list_nominatif(1);
    }
    
    function load_detail(url, id) {
        $('#detail-pegawai').empty();
        $('#datamodal_search_detail').modal('show');
        $('#cetak_profile').attr('onclick','cetak(\''+id+'\')');
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
    
    function get_list_nominatif(page) {
        $.ajax({
            type: 'GET',
            url: 'include/nominatif-list.php?page='+page,
            data: $('#nominatif1').serialize(),
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
</script>
<h4 class="title">NOMINATIF</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Nominatif Pegawai</a></li>
</ul>
<div id="datamodal_search" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4> Parameter Pencarian</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
                <form id="nominatif1" action="?sid=<?=$sid?>&do=nominatif" method="post">
                      <table width="100%">

                          <tr> 
                          <td width="25%" align="left" height="12">Golongan:</td>
                          <td width="610" align="left">
                            <select name="gol1" id="gol1" class="form-control-static" >
                                <option value="">Pilih ...</option>
                                <option value="11" selected="selected">I/a</option>
                                <option value="12">I/b</option>
                                <option value="13">I/c</option>
                                <option value="14">I/d</option>
                                <option value="21">II/a</option>
                                <option value="22">II/b</option>
                                <option value="23">II/c</option>
                                <option value="24">II/d</option>
                                <option value="31">III/a</option>
                                <option value="32">III/b</option>
                                <option value="33">III/c</option>
                                <option value="34">III/d</option>
                                <option value="41">IV/a</option>
                                <option value="42">IV/b</option>
                                <option value="43">IV/c</option>
                                <option value="44">IV/d</option>
                                <option value="45">IV/e</option>
                            </select>
                              <span class="form-control-label">s . d</span>
                            <select name="gol2" id="gol2" class="form-control-static">
                                <option value="">Pilih ...</option>
                                <option value="11">I/a</option>
                                <option value="12">I/b</option>
                                <option value="13">I/c</option>
                                <option value="14">I/d</option>
                                <option value="21">II/a</option>
                                <option value="22">II/b</option>
                                <option value="23">II/c</option>
                                <option value="24">II/d</option>
                                <option value="31">III/a</option>
                                <option value="32">III/b</option>
                                <option value="33">III/c</option>
                                <option value="34">III/d</option>
                                <option value="41">IV/a</option>
                                <option value="42">IV/b</option>
                                <option value="43">IV/c</option>
                                <option value="44">IV/d</option>
                                <option value="45" selected="selected">IV/e</option>
                            </select>
                </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left"></td>
                          <td width="610" align="left"><input type="checkbox" name="nullinclude" value="Ya" /> <i>Termasuk yang golongannya kosong</i></td>
                          </tr>
                        <tr> 
                          <td width="175" align="left">Eselon:</td>
                          <td width="610" align="left">
                            <select name="eselon" id="eselon" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($eselon=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="str" <? if ($eselon=='str') echo "selected" ; ?>>Struktural</option>
                              <option value="11" <? if ($eselon=='11') echo "selected" ; ?>>1A</option>
                              <option value="12" <? if ($eselon=='12') echo "selected" ; ?>>1B</option>
                              <option value="2" <? if ($eselon=='2') echo "selected" ; ?>>2</option>
                              <option value="21" <? if ($eselon=='21') echo "selected" ; ?>>2A</option>
                              <option value="22" <? if ($eselon=='22') echo "selected" ; ?>>2B</option>
                              <option value="3" <? if ($eselon=='3') echo "selected" ; ?>>3</option>
                              <option value="31" <? if ($eselon=='31') echo "selected" ; ?>>3A</option>
                              <option value="32" <? if ($eselon=='32') echo "selected" ; ?>>3B</option>
                              <option value="4" <? if ($eselon=='4') echo "selected" ; ?>>4</option>
                              <option value="41" <? if ($eselon=='41') echo "selected" ; ?>>4A</option>
                              <option value="42" <? if ($eselon=='42') echo "selected" ; ?>>4B</option>
                                  <option value="51" <? if ($eselon=='51') echo "selected" ; ?>>5A</option>

                            </select>
                        </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Status Kepegawaian:</td>
                          <td width="610" align="left">
                            <select name="status" id="status" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($status=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($status=='1') echo "selected" ; ?>>CPNS</option>
                              <option value="2" <? if ($status=='2') echo "selected" ; ?>>PNS</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Jabatan:</td>
                          <td width="610" align="left">
                            <select name="jabatan" id="jabatan" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($jabatan=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Fungsional Umum</option>
                              <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
                              <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional Tertentu</option>
                            </select>
                          </td>
                        </tr>
                        
                        <tr id="jabfung-autoshow"> 
                          <td width="175" align="left">Jabatan Fungsional:</td>
                          <td width="610" align="left">
                            <select name="jabfung" id="jabfung" class="form-control" style="width: 300px;">
                              <option value="">Semua ...</option>
                                <?
                                $qfung="select * from TABFNG1 order by NFUNG";
                                $rfung=mysql_query($qfung) or die(mysql_error());
                                while ($rofung=mysql_fetch_array($rfung)) {
                                ?>
                                <option value="<?=$rofung[KFUNG]?>" <?= $jabfung==$rofung[KFUNG] ? "selected" : ""?>><?=$rofung[NFUNG]?></option> 
                                <? } ?>
                            </select>
                          </td>
                        </tr>
                        
                        <tr>
                          <td width="175" align="left">Diklat:</td>
                          <td width="610" align="left">
                            <select name="diklat" id="diklat" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($diklat=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($diklat=='1') echo "selected" ; ?>>LEMHANAS</option>
                              <option value="2" <? if ($diklat=='2') echo "selected" ; ?>>SESPA/SEPAMEN</option>
                              <option value="3" <? if ($diklat=='3') echo "selected" ; ?>>SEPADYA/SPAMA</option>
                              <option value="4" <? if ($diklat=='4') echo "selected" ; ?>>SEPALA/ADUMLA</option>
                              <option value="5" <? if ($diklat=='5') echo "selected" ; ?>>SEPADA/ADUM</option>
                              <option value="6" <? if ($diklat=='6') echo "selected" ; ?>>DIKLATPIM
                              Tk.I</option>
                              <option value="7" <? if ($diklat=='7') echo "selected" ; ?>>DIKLATPIM
                              Tk.II</option>
                              <option value="8" <? if ($diklat=='8') echo "selected" ; ?>>DIKLATPIM
                              Tk.III</option>
                              <option value="9" <? if ($diklat=='9') echo "selected" ; ?>>DIKLATPIM
                              Tk.IV</option>
                              <option value="10" <? if ($diklat=='10') echo "selected" ; ?>>DIKLATPIM
                              PEMDA</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Jenis Kelamin:</td>
                          <td width="610" align="left">
                            <select name="kelamin" id="kelamin" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
                              <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Agama:</td>
                          <td width="610" align="left">
                            <select name="agama" id="agama" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($agama=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($agama=='1') echo "selected" ; ?>>Islam</option>
                              <option value="2" <? if ($agama=='2') echo "selected" ; ?>>Kristen</option>
                              <option value="3" <? if ($agama=='3') echo "selected" ; ?>>Katholik</option>
                              <option value="4" <? if ($agama=='4') echo "selected" ; ?>>Hindu</option>
                              <option value="5" <? if ($agama=='5') echo "selected" ; ?>>Budha</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Pendidikan:</td>
                          <td width="610" align="left">
                            <select name="dik" id="dik" class="form-control" style="width: 300px;">
                              <option value="all" <? if ($dik=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="10" <? if ($dik=='10') echo "selected" ; ?>>SD</option>
                              <option value="20" <? if ($dik=='20') echo "selected" ; ?>>SMP</option>
                              <option value="30" <? if ($dik=='30') echo "selected" ; ?>>SMA</option>
                              <option value="41" <? if ($dik=='41') echo "selected" ; ?>>DIPLOMA
                              I</option>
                              <option value="42" <? if ($dik=='42') echo "selected" ; ?>>DIPLOMA
                              II</option>
                              <option value="43" <? if ($dik=='43') echo "selected" ; ?>>DIPLOMA
                              III</option>
                              <option value="44" <? if ($dik=='44') echo "selected" ; ?>>DIPLOMA
                              IV</option>
                              <option value="50" <? if ($dik=='50') echo "selected" ; ?>>SARMUD
                              NON AKADEMI</option>
                              <option value="60" <? if ($dik=='60') echo "selected" ; ?>>SARMUD
                              AKADEMI</option>
                              <option value="70" <? if ($dik=='70') echo "selected" ; ?>>S 1</option>
                              <option value="80" <? if ($dik=='80') echo "selected" ; ?>>S 2</option>
                              <option value="90" <? if ($dik=='90') echo "selected" ; ?>>S 3</option>
                            </select>
                          </td>
                        </tr>
                        
                        <tr> 
                          <td width="175" align="left">Jurusan:</td>
                          <td width="610" align="left">
                            <select name="jur" id="jur" class="form-control" style="width: 300px;">
                                <option value="">Semua ...</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Alamat Kecamatan:</td>
                          <td width="610" align="left">
                            <select name="kecamatan" class="form-control" style="width: 300px;">
                                <option value="">Semua ...</option>
                                <?php 
                                $query = mysql_query("select lokasi_ID as id, lokasi_nama 
                                        from inf_lokasi
                                        where 

                                        lokasi_kelurahan = '0000' 
                                        and lokasi_kecamatan != '00' 
                                        and lokasi_kabupatenkota in ('26,75')
                                        and lokasi_propinsi = '33' order by lokasi_nama"); 
                                while ($data = mysql_fetch_object($query)) { ?>
                                <option value="<?= $data->id ?>"><?= $data->lokasi_nama ?></option>
                                <?php }
                                ?>
                                
                            </select>
                          </td>
                        </tr>
                        
                        <tr> 
                          <td width="175" align="left">Nama Sekolah:</td>
                          <td width="610" align="left">
                              <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" style="width: 300px;" />
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Status Perkawinan:</td>
                          <td width="610" align="left">
                                <select name="J_01" class="form-control" style="width: 300px;">
                                <option value="">-</option>
                                <option value="1">KAWIN</option>
                                <option value="2">BELUM KAWIN</option>
                                <option value="3">JANDA/DUDA</option>
                                </select>
                          </td>
                        </tr>
                        <tr>
                          <td>Unit Kerja:</td>
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
                                      //echo $id_skpd;
                                      $lsuk=listUnitKerja($id_skpd);
                                      foreach($lsuk as $key=>$value) {
                                      ?>
                                      <option value="<?=$value[0]?>"><?= ucfirst(strtolower($value[1]))?></option>
                                      <? } ?>
                                </select>
                              <input type="hidden" id="hasupt" name="hasupt" />
                          </td>
                        </tr>
                
                        <tr>
                          <td id="label-uk">Sub Unit Kerja</td>
                          <td>
                              <input type="text" name="subuk" id="subuk" class="select2-input" />
<!--                            <select name="subuk" id="subuk" class="form-control" style="width: 300px;">
                                
                            </select>-->
                          </td>
                        </tr>
                
                        <tr>
                          <td>Urut:</td>
                          <td> 
                              <input type="radio" name="urut" value="pkt" id="pkt" <?= $urut=='pkt'? "checked" : ""?>> <label for="pkt">Pangkat</label>
                              <input type="radio" name="urut" value="str" id="str" <?= $urut=='str'? "checked" : ""?>> <label for="str">Struktur Organisasi</label>
                          </td>
                        </tr>
                        </table>
                    </form>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal"><i class="fa fa-refresh"></i> Cancel</button>
                <button class="btn" data-target=".bs-modal-lg" id="cetak_nominatif"><i class="fa fa-print"></i> Cetak</button>
                <button type="button" class="btn btn-primary" onclick="get_list_nominatif(1);"><i class="fa fa-eye"></i> Tampilkan</button>
            </div>
        </div>
    </div>
</div>
</div>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="searching" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-search"></i> Search</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
        <?php
        $detail = "<form id='dinamic_kolom'>
            <div class='checkbox'>
                <label><input type='checkbox' id='checkall'><b>Check all / Uncheck all</b></label>
            </div><br/>
            <table width='120%' cellpadding='0'>
            <tbody><tr valign=top><td width='40%'>
                <table width='100%' class='table table-striped table-hover'>
                <tbody>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='niplama' value=''>NIP Lama</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='nipbaru' value=''>NIP Baru</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='nama' value=''>Nama</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='alamat' value=''>Alamat</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='tempatlahir' value=''>Tempat Lahir</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='tmtcpns' value=''>TMT CPNS</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='jekel' value=''>Jenis Kelamin</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='jabatan_check' value=''>Jabatan</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='unitkerja' value=''>Unit Kerja</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='subunitkerja' value=''>Sub Unit Kerja</label>
                        </div>
                    </td></tr>
                </tbody>
                </table>
            </td><td width='40%'>
                <table width='100%' class='table table-striped table-hover'>
                <tbody>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='subsubunitkerja' value=''>Sub Sub Unit Kerja</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='eselon_check' value=''>Eselon</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='gr' value=''>G / R</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='tmt' value=''>TMT</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='pendidikan' value=''>Pendidikan</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='jurusan' value=''>Jurusan</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='lulus' value=''>Lulus</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='namasekolah' value=''>Nama Sekolah</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='tmtjabatan' value=''>TMT Jabatan</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='nomorskjabatan' value=''>Nomor SK Jabatan</label>
                        </div>
                    </td></tr>
                </tbody>
                </table>
            </td>
            </td><td width='40%'>
                <table width='100%' class='table table-striped table-hover'>
                <tbody>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='masakerja_check' value=''>Masa Kerja</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='tmteselon_check' value=''>TMT Eselon</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='diklat_check' value=''>Diklat</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='statuspegawai_check' value=''>Status Pegawai</label>
                        </div>
                    </td></tr>
                    <tr><td>
                        <div class='checkbox'>
                            <label><input type='checkbox' name='agama_check' value=''>Agama</label>
                        </div>
                    </td></tr>
                </tbody>
                </table>
            </td>
            </tr>
            <tr><td></td></tr>
            </table></form>
            <button class='btn btn-xs btn-primary' onclick='export_excel();'><i class='fa fa-download'></i> Oke</button>
            ";
        ?>
        <button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-placement="bottom" data-title="Pilih Nama Kolom" data-content="<?= $detail ?>" id="cetak"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    </div>
    <div class="toolbar-right">
        
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
            <button type="button" class="btn btn-primary" id="cetak_profile"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    </div>
</div>

<div id="result" style="overflow-x: auto; width: 100%;">
    
</div>
