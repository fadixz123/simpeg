<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);

$golongan=array("11","12","13","14","21","22","23","24","31","32","33","34","41","42","43","44","45");
?>
<link rel="stylesheet" href="../css/template_css.css" media="all" />
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript" src="../Scripts/jquery.min.js" ></script>
<script type="text/javascript">
    function cetak() {
        //setTimeout(function(){ window.close();},300);
        $('button').hide();
        window.print();
        $('button').show();
    }
</script>
<h3>
    REKAPITULASI JUMLAH PEJABAT FUNGSIONAL TERTENTU (JFT)<br/>
    DI LINGKUNGAN PEMERINTAH KABUPATEN PEKALONGAN<br/>
    <span style="font-weight: normal">KEADAAN: <?= strtoupper(date("d F Y")) ?></span>
</h3>

<table width="100%" class="table-print">
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Jabatan Fungsional Tertentu</th>
        <th colspan="<?= count($golongan) ?>">GOLONGAN / RUANG</th>
        <th rowspan="2">Jumlah</th>
    </tr>
    <tr>
        <th width="40" align="center">I/a</th>
        <th width="40" align="center">I/b</th>
        <th width="40" align="center">I/c</th>
        <th width="40" align="center">I/d</th>
        <th width="40" align="center">II/a</th>
        <th width="40" align="center">II/b</th>
        <th width="40" align="center">II/c</th>
        <th width="40" align="center">II/d</th>
        <th width="40" align="center">III/a</th>
        <th width="40" align="center">III/b</th>
        <th width="40" align="center">III/c</th>
        <th width="40" align="center">IIId</th>
        <th width="38" align="center">IV/a</th>
        <th width="38" align="center">IV/b</th>
        <th width="39" align="center">IV/c</th>
        <th width="39" align="center">IV/d</th>
        <th width="39" align="center">IV/e</th>
    </tr>
    
    <?php
    $sql = mysql_query("select * from tabfng1 order by `KFUNG` asc");
    $no = 1; $total = 0;
    $total_1a = 0; $total_1b = 0; $total_1c = 0; $total_1d = 0;
    $total_2a = 0; $total_2b = 0; $total_2c = 0; $total_2d = 0; 
    $total_3a = 0; $total_3b = 0; $total_3c = 0; $total_3d = 0; 
    $total_4a = 0; $total_4b = 0; $total_4c = 0; $total_4d = 0; $total_4e = 0; 
    while ($data = mysql_fetch_array($sql)) { ?>
    <tr valign="top">
        <td align="center"><?= $no++ ?></td>
        <td><?= $data['NFUNG'] ?></td>
        <?php
        $total_left = 0;
        foreach ($golongan as $key => $value) { 
            $htg_jumlah = mysql_fetch_array(mysql_query("select count(*) as jumlah from mastfip08 where `I_05` = '".$data['KFUNG']."' and `F_03` = '".$value."' and `A_01` != '99' and `I_05` != '' and `I_05` is not NULL"));
            $total_left += $htg_jumlah['jumlah'];
        ?>
        <td align="center"><?= ($htg_jumlah['jumlah'] !== '0')?$htg_jumlah['jumlah']:NULL ?></td>
        <?php 
        //$golongan=array("11","12","13","14","21","22","23","24","31","32","33","34","41","42","43","44","45");
            if ($value === '11') { $total_1a += $htg_jumlah['jumlah']; }
            if ($value === '12') { $total_1b += $htg_jumlah['jumlah']; }
            if ($value === '13') { $total_1c += $htg_jumlah['jumlah']; }
            if ($value === '14') { $total_1d += $htg_jumlah['jumlah']; }
            
            if ($value === '21') { $total_2a += $htg_jumlah['jumlah']; }
            if ($value === '22') { $total_2b += $htg_jumlah['jumlah']; }
            if ($value === '23') { $total_2c += $htg_jumlah['jumlah']; }
            if ($value === '24') { $total_2d += $htg_jumlah['jumlah']; }
            
            if ($value === '31') { $total_3a += $htg_jumlah['jumlah']; }
            if ($value === '32') { $total_3b += $htg_jumlah['jumlah']; }
            if ($value === '33') { $total_3c += $htg_jumlah['jumlah']; }
            if ($value === '34') { $total_3d += $htg_jumlah['jumlah']; }
            
            if ($value === '41') { $total_4a += $htg_jumlah['jumlah']; }
            if ($value === '42') { $total_4b += $htg_jumlah['jumlah']; }
            if ($value === '43') { $total_4c += $htg_jumlah['jumlah']; }
            if ($value === '44') { $total_4d += $htg_jumlah['jumlah']; }
            if ($value === '45') { $total_4e += $htg_jumlah['jumlah']; }
        } 
        ?>
        <td align="center"><?= $total_left ?></td>
    </tr>
    <?php 
        $total += $total_left;
        }
    ?>
    <tr>
        <td colspan="2" align="center">TOTAL</td>
        <td align="center"><?= $total_1a ?></td>
        <td align="center"><?= $total_1b ?></td>
        <td align="center"><?= $total_1c ?></td>
        <td align="center"><?= $total_1d ?></td>
        
        <td align="center"><?= $total_2a ?></td>
        <td align="center"><?= $total_2b ?></td>
        <td align="center"><?= $total_2c ?></td>
        <td align="center"><?= $total_2d ?></td>
        
        <td align="center"><?= $total_3a ?></td>
        <td align="center"><?= $total_3b ?></td>
        <td align="center"><?= $total_3c ?></td>
        <td align="center"><?= $total_3d ?></td>
        
        <td align="center"><?= $total_4a ?></td>
        <td align="center"><?= $total_4b ?></td>
        <td align="center"><?= $total_4c ?></td>
        <td align="center"><?= $total_4d ?></td>
        <td align="center"><?= $total_4e ?></td>
        
        <td align="center"><?= $total ?></td>
    </tr>
</table>

<center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>