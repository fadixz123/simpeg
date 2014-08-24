<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

if (!$urut) $urut='pkt';

$qcu="select distinct A_02 from TABLOKB08 where A_01='$uk'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
?>
<script type="text/javascript">
    $(function() {
        $('#cetak').click(function() {
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/i_nominatif.html?gol1=<?=$gol1?>&gol2=<?=$gol2?>&radio1=<?=$radio1?>&status=<?=$status?>&eselon=<?=$eselon?>&jabatan=<?=$jabatan?>&jabfung=<?=$jabfung?>&dik=<?=$dik?>&jur=<?=$jur?>&diklat=<?=$diklat?>&kelamin=<?=$kelamin?>&agama=<?=$agama?>&unitkerja=<?=$uk?>&subuk=<?=$subuk?>&urut=<?=$urut?>','myPoppp','width='+dWidth+', height='+dHeight+', left='+x+',top='+y)
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
        
        $('#uk').change(function() {
            $.ajax({
                url: 'include/autocomplete.php?search=suk_upt',
                dataType: 'json',
                data: 'uk='+$(this).val(),
                success: function(data) {
                    $('#subuk').empty();
                    if (data.label === 'Induk/UPT') {
                        stri = '<option value="all">Semua ...</option>'+
                                '<option value="00">INDUK</option>';
                    } else {
                        stri = '<option value="">Semua ...</option>';
                    }
                    $('#label-uk').html(data.label);
                    $('#subuk').append(stri);
                    $.each(data.data, function(i, v) {
                        str = '<option value="'+v.code+'">'+v.NALOK+'</option>';
                        $('#subuk').append(str);
                    });
                }
            });
        });
    });
    
    function paging(page, tab, search) {
        
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function get_list_nominatif() {
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
    <div class="modal-dialog" style="width: 700px; height: 100%;">
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
                              <option value="11" <? if ($gol1=='11') echo "selected"; ?>>I/a</option>
                              <option value="12" <? if ($gol1=='12') echo "selected"; ?>>I/b</option>
                              <option value="13" <? if ($gol1=='13') echo "selected"; ?>>I/c</option>
                              <option value="14" <? if ($gol1=='14') echo "selected"; ?>>I/d</option>
                              <option value="21" <? if ($gol1=='21') echo "selected"; ?>>II/a</option>
                              <option value="22" <? if ($gol1=='22') echo "selected"; ?>>II/b</option>
                              <option value="23" <? if ($gol1=='23') echo "selected"; ?>>II/c</option>
                              <option value="24" <? if ($gol1=='24') echo "selected"; ?>>II/d</option>
                              <option value="31" <? if ($gol1=='31') echo "selected"; ?>>III/a</option>
                              <option value="32" <? if ($gol1=='32') echo "selected"; ?>>III/b</option>
                              <option value="33" <? if ($gol1=='33') echo "selected"; ?>>III/c</option>
                              <option value="34" <? if ($gol1=='34') echo "selected"; ?>>III/d</option>
                              <option value="41" <? if ($gol1=='41') echo "selected"; ?>>IV/a</option>
                              <option value="42" <? if ($gol1=='42') echo "selected"; ?>>IV/b</option>
                              <option value="43" <? if ($gol1=='43') echo "selected"; ?>>IV/c</option>
                              <option value="44" <? if ($gol1=='44') echo "selected"; ?>>IV/d</option>
                              <option value="45" <? if ($gol1=='45') echo "selected"; ?>>IV/e</option>
                            </select>
                              <span class="form-control-label">s . d</span>
                <select name="gol2" id="gol2" class="form-control-static">
                  <option value="11" <? if ($gol2=='11') echo "selected"; ?>>I/a</option>
                  <option value="12" <? if ($gol2=='12') echo "selected"; ?>>I/b</option>
                  <option value="13" <? if ($gol2=='13') echo "selected"; ?>>I/c</option>
                  <option value="14" <? if ($gol2=='14') echo "selected"; ?>>I/d</option>
                  <option value="21" <? if ($gol2=='21') echo "selected"; ?>>II/a</option>
                  <option value="22" <? if ($gol2=='22') echo "selected"; ?>>II/b</option>
                  <option value="23" <? if ($gol2=='23') echo "selected"; ?>>II/c</option>
                  <option value="24" <? if ($gol2=='24') echo "selected"; ?>>II/d</option>
                  <option value="31" <? if ($gol2=='31') echo "selected"; ?>>III/a</option>
                  <option value="32" <? if ($gol2=='32') echo "selected"; ?>>III/b</option>
                  <option value="33" <? if ($gol2=='33') echo "selected"; ?>>III/c</option>
                  <option value="34" <? if ($gol2=='34') echo "selected"; ?>>III/d</option>
                  <option value="41" <? if ($gol2=='41') echo "selected"; ?>>IV/a</option>
                  <option value="42" <? if ($gol2=='42') echo "selected"; ?>>IV/b</option>
                  <option value="43" <? if ($gol2=='43') echo "selected"; ?>>IV/c</option>
                  <option value="44" <? if ($gol2=='44') echo "selected"; ?>>IV/d</option>
                  <option value="45" <? if ($gol2=='45') echo "selected"; ?>>IV/e</option>
                </select>
                &nbsp;

                <input type="radio" name="radio1" value="1" class="radio1" <? if ($radio1==1) echo "checked"; ?>>
                keatas&nbsp;
                <input type="radio" name="radio1" value="2" class="radio1" <? if ($radio1==2) echo "checked"; ?>>
                kebawah
                <input type="radio" name="radio1" value="3" class="radio1" <? if ($radio1==3) echo "checked"; ?>>
                antara </td>
                          </tr>
                        <tr> 
                          <td width="175" align="left">Eselon:</td>
                          <td width="610" align="left">
                            <select name="eselon" id="eselon" class="form-control">
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
                            <select name="status" id="status" class="form-control">
                              <option value="all" <? if ($status=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($status=='1') echo "selected" ; ?>>CPNS</option>
                              <option value="2" <? if ($status=='2') echo "selected" ; ?>>PNS</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Jabatan:</td>
                          <td width="610" align="left">
                            <select name="jabatan" id="jabatan" class="form-control">
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
                            <select name="jabfung" id="jabfung" class="form-control">
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
                            <select name="diklat" id="diklat" class="form-control">
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
                            <select name="kelamin" id="kelamin" class="form-control">
                              <option value="all" <? if ($kelamin=='all') echo "selected" ; ?>>Semua ...</option>
                              <option value="1" <? if ($kelamin=='1') echo "selected" ; ?>>Laki-laki</option>
                              <option value="2" <? if ($kelamin=='2') echo "selected" ; ?>>Perempuan</option>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td width="175" align="left">Agama:</td>
                          <td width="610" align="left">
                            <select name="agama" id="agama" class="form-control">
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
                            <select name="dik" id="dik" class="form-control">
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
                            <select name="jur" id="jur" class="form-control">
                                <option value="">Semua ...</option>
                            </select>
                          </td>
                        </tr>
                        
                        <tr>
                          <td>Unit Kerja:</td>
                          <td>
                            <select name="uk" id="uk" class="form-control">
                            <option value="all">Semua ...</option>
                            <?
                            $quk="select * from tablok08 order by kd";
                            $ruk=mysql_query($quk) or die(mysql_error());
                            while ($rouk=mysql_fetch_array($ruk)) {
                                        ?>
                                        <option value="<?=$rouk[kd]?>" <?= $rouk[kd]==$uk ? "selected" : ""?>><?=$rouk[nm]?></option>
                                        <? } ?>
                            </select></td>
                        </tr>
                
                        <tr>
                          <td id="label-uk"></td>
                          <td>
                            <select name="subuk" id="subuk" class="form-control">
                                
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
                <button type="button" class="btn btn-primary" onclick="get_list_nominatif();"><i class="fa fa-search"></i> Tampilkan</button>
                <button type="button" class="btn btn-primary" id="cetak"><i class="fa fa-print"></i> Cetak</button>
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
</div> 
<div id="result">
    <table class="table table-bordered table-stripped table-hover" id="table_data_no">
        <thead>      
        <tr bgcolor="#CCCCCC">
            <th>No</th>
            <th>NIP</th>
            <th>NAMA</th>
            <th>TGL LHR</th>
            <th>JABATAN</th>
            <th>UNIT KERJA</th>
            <th>Esl</th>
            <th>GOL/RNG</th>
        </tr>
        </thead>
    </table>
</div>