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
        $('#cetak').click(function() {
            window.location='include/i_nominatif.php?'+$('#nominatif1').serialize();
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
        
        $('#uk').blur(function() {
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
        });
        $('#subuk').focus(function() {
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
        });
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
                              <option value="0" <? if ($jabatan=='0') echo "selected" ; ?>>Staff</option>
                              <option value="1" <? if ($jabatan=='1') echo "selected" ; ?>>Struktural</option>
                              <option value="2" <? if ($jabatan=='2') echo "selected" ; ?>>Fungsional</option>
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
                            <select name="kecamatan" id="kecamatan" class="form-control" style="width: 300px;">
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
                                      if ($_SESSION['skpd'] !== '12' and $_SESSION['nama_group'] !== 'Administrator') {
                                        $id_skpd = $_SESSION['skpd'];
                                      }
                                      if ($_SESSION['nama_group'] === 'Admin SKPD') {
                                        $id_skpd = $_SESSION['skpd'];
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
                          <td id="label-uk"></td>
                          <td>
                            <select name="subuk" id="subuk" class="form-control" style="width: 300px;">
                                
                            </select>
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
    </div>
    <div class="toolbar-right">
        <button class="btn" data-target=".bs-modal-lg" id="cetak"><i class="fa fa-file-excel-o"></i> Export Excel</button>
    </div>
</div> 
<div id="result" style="overflow-x: auto; width: 100%;">
    
</div>