<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>
<head>
<title>Jumlah PNS Menurut Pendidikan</title>
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
</head>

<body>
    <div class="page">
<?php
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$pendidikan=array("10","20","30","41","42","43","44","50","60","70","80","90","99");
$kelamin=array("1","2");
$q="select * from TABLOK08 where kd<>'99' order by kd";
$r=mysql_query($q);
?>
<h1>JUMLAH PEGAWAI NEGERI SIPIL MENURUT PENDIDIKAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
<table width="100%" class="tabel-laporan">
    <thead>
  <tr>
    <th width="17" align="center" rowspan="2">No.</th>
    <th width="349" align="center" rowspan="2">INSTANSI</th>
    <th width="285" align="center" colspan="13">TINGKAT PENDIDIKAN</th>
    <th width="26" align="center" rowspan="2">JML</th>
  </tr>
  
  <tr>
    <th width="26">SD</th>
    <th width="26">SMP</th>
    <th width="26">SMA</th>
    <th width="26">D1</th>
    <th width="26">D2</th>
    <th width="26">D3</th>
    <th width="26">D4</th>
    <th width="26">SM.Non Ak</th>
    <th width="26">SM.Ak</th>
    <th width="26">S1</th>
    <th width="26">S2</th>
    <th width="26">S3</th>
    <th width="26">PROFESI</th>
  </tr>
  </thead>
  <tbody>
<?php
$ii=0;
$total1 = 0; $total2 = 0; $total3 = 0; $total4 = 0; $total5 = 0; $total6 = 0; $total7 = 0; $total8 = 0; $total9 = 0; $total10 = 0; $total11 = 0; $total12 = 0;
$total_atas_ke_bawah = 0;
while ($row=mysql_fetch_array($r)) {
	$ii++;
        $query3="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and H_1A is not null and A_01='".substr($row[kd],0,2)."' and A_01<>'99'";
        $row3=mysql_fetch_array(mysql_query($query3));
                for ($j=0;$j<count($pendidikan);$j++) {
                        $query="select count(*) as jml from MASTFIP08 where (F_03 is not null or F_03<>'') and H_1A = '$pendidikan[$j]' and H_1A<>'' and H_1A is not null and A_01='".substr($row[kd],0,2)."' and A_01<>'99'";
                        $row1[$j]=mysql_fetch_array(mysql_query($query));
                }
                $query2="select count(*) as jml from MASTFIP08 where (F_03 is not null or F_03<>'') and H_1A<>'' and H_1A is not null and A_01='".substr($row[kd],0,2)."' and A_01<>'99'";
                $row2=mysql_fetch_array(mysql_query($query2));
?>
  <tr>
    <td width="17" align="center"><?=$ii?></td>
    <td width="349"><?=$row[nm]?></td>
    <td width="26" align="center"><?=$row1[0][jml]?></td>
    <td width="26" align="center"><?=$row1[1][jml]?></td>
    <td width="26" align="center"><?=$row1[2][jml]?></td>
    <td width="26" align="center"><?=$row1[3][jml]?></td>
    <td width="26" align="center"><?=$row1[4][jml]?></td>
    <td width="26" align="center"><?=$row1[5][jml]?></td>
    <td width="26" align="center"><?=$row1[6][jml]?></td>
    <td width="26" align="center"><?=$row1[7][jml]?></td>
    <td width="26" align="center"><?=$row1[8][jml]?></td>
    <td width="26" align="center"><?=$row1[9][jml]?></td>
    <td width="26" align="center"><?=$row1[10][jml]?></td>
    <td width="26" align="center"><?=$row1[11][jml]?></td>
    <td width="26" align="center"><?=$row1[12][jml]?></td>
    <td width="26" align="center"><?=$row2[jml]?></td>
  </tr>
<?
$total1 += $row1[0]['jml'];
$total2 += $row1[1]['jml'];
$total3 += $row1[2]['jml'];
$total4 += $row1[3]['jml'];
$total5 += $row1[4]['jml'];
$total6 += $row1[5]['jml'];
$total7 += $row1[6]['jml'];
$total8 += $row1[7]['jml'];
$total9 += $row1[8]['jml'];
$total10 += $row1[9]['jml'];
$total11 += $row1[10]['jml'];
$total12 += $row1[11]['jml'];
$total13 += $row1[12]['jml'];
$total_atas_ke_bawah += $row2['jml'];
}
	$j=0;
        for ($j=0;$j<count($pendidikan);$j++) {
                $query4="select count(*) as jml from MASTFIP08 where (F_03 is not null or F_03<>'') and H_1A = '$pendidikan[$j]' and H_1A<>'' and H_1A is not null and A_01<>'99'";
                $row4[$j]=mysql_fetch_array(mysql_query($query4));
        }
        $query5="select count(*) as jml from MASTFIP08 where (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A<>'' and H_1A is not null";
        $row5=mysql_fetch_array(mysql_query($query5));

$query6="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A is not null";
$row6=mysql_fetch_array(mysql_query($query6));
?>
  <tr>
    <td width="17" style="font-family: Verdana; font-size: 8pt">&nbsp;</td>
    <td width="349" style="font-family: Verdana; font-size: 8pt"><font face="Verdana" size="1"><b>JUMLAH</b></td>
    <td width="26" align="center"><?=$total1?></td>
    <td width="26" align="center"><?=$total2?></td>
    <td width="26" align="center"><?=$total3?></td>
    <td width="26" align="center"><?=$total4?></td>
    <td width="26" align="center"><?=$total5?></td>
    <td width="26" align="center"><?=$total6 ?></td>
    <td width="26" align="center"><?=$total7?></td>
    <td width="26" align="center"><?=$total8?></td>
    <td width="26" align="center"><?=$total9?></td>
    <td width="26" align="center"><?=$total10?></td>
    <td width="26" align="center"><?=$total11?></td>
    <td width="26" align="center"><?=$total12?></td>
    <td width="26" align="center"><?=$total13?></td>
    <td width="26" align="center"><?=$total_atas_ke_bawah ?></td>
  </tr>
  </tbody>
</table>
<center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
