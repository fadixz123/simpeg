<script src="Scripts/highchart/highcharts.js"></script>
<!--<script src="Scripts/highchart/themes/grid.js"></script>-->
<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if (!$uk) $uk='all';
?>
<script type="text/javascript">
    $(function() {
        $('#tampilkan').click(function() {
            $.ajax({
                url: 'include/autocomplete.php?search=show_graph',
                data: $('#form-search-rekap').serialize(),
                dataType: 'json',
                success: function(data) {
                    var jenis = $('#what').val();
                    if (jenis === '5' || jenis === '6' || jenis === '7' || jenis === '8') {
                        draw_pie_chart('#result', data);
                    } else {
                        draw_bar_chart('#result', data);
                    }
                }
            });
            return false;
        });
    });
    function draw_bar_chart(div, data) {
        $(div).highcharts({
            chart: {
                type: 'bar'
            },
            exporting: {
                enabled: false
            },
            title: {
                text: data.title
            },
            xAxis: {
                categories: data.nama
            },
            yAxis: {
                title: {
                    text: 'Jumlah'
                }
            },
            series: [{
                name : 'Jumlah Pegawai',
                data: data.jumlah
            }]
        });
    }
    
    function draw_pie_chart(div, data) {
        $(div).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: data.title
            },
            tooltip: {
                pointFormat: '{point.y} pegawai ({point.percentage:.1f} %)'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b><br/>{point.y} pegawai ({point.percentage:.1f} %)'
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: data.kategori,
                data: data.data
            }]
        });
    }
</script>
<h4 class="title">REKAP DATA PNS</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">Rekap Grafis</a></li>
</ul>
<form id="form-search-rekap">
<table width="100%">
  
  <tr>
    <td width="15%">Unit Kerja:</td>
    <td><select name="uk" class="form-control" style="width: 300px;">
    <option value="all" <?= $uk=='all' ? "selected" : ""?>>Semua Unit Kerja</option>
    <?
    $lsuk=listUnitKerja();
    foreach($lsuk as $key=>$value) {
    ?>
    <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=ucfirst(strtolower($value[1]))?></option>
    <? } ?>
	</select></td>
  </tr>
  <tr>
    <td width="288">Rekap Berdasarkan:</td>
    <td width="464"><select name="what" class="form-control" id="what" style="width: 300px;">
    <option>Pilih</option>
    <option value="1" <? if ($what=="1") echo "selected"; ?>>Golongan</option>
    <option value="2" <? if ($what=="2") echo "selected"; ?>>Pendidikan Struktural</option>
    <option value="3" <? if ($what=="3") echo "selected"; ?>>Pendidikan Umum</option>
    <option value="4" <? if ($what=="4") echo "selected"; ?>>Eselon</option>
    <option value="5" <? if ($what=="5") echo "selected"; ?>>Agama</option>
    <option value="6" <? if ($what=="6") echo "selected"; ?>>Jenis Kelamin</option>
    <option value="7" <? if ($what=="7") echo "selected"; ?>>Usia</option>
    <option value="8" <? if ($what=="8") echo "selected"; ?>>Status Perkawinan</option>
    </select></td>
  </tr>
  <tr>
  <td></td>
  <td><button type="button" class="btn btn-primary" id="tampilkan"><i class="fa fa-eye"></i> Tampilkan</button></td>
  </tr>
  </table>
</form>
<div id="result" style="width: 100%;"></div>
  