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
<link rel="stylesheet" href="../css/template_css.css" media="all" />
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
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$pendidikan=array("-","10","20","30","41","42","43","44","50","60","70","80","90","99");
$kelamin=array("1","2");
$r=listUnitKerjaNoBiro();

?>
<h1>JUMLAH PEGAWAI NEGERI SIPIL MENURUT STATUS PEGAWAI DAN PENDIDIKAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
<table width="100%" class="table-print">
  <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">INSTANSI</th>
        <th colspan="15">CPNS</th>
        <th colspan="15">PNS</th>
        <th rowspan="2">Jumlah<?=$row1[8][jml]?></th>
  </tr>
  <tr>
        <th align="right">&lt; SD</th>
        <th align="right">SD</th>
        <th align="right">SMP</th>
        <th align="right">SMA</th>
        <th align="right">D1</th>
        <th align="right">D2</th>
        <th align="right">D3</th>
        <th align="right">D4</th>
        <th>SM.Non Ak</th>
        <th>SM.Ak</th>
        <th align="right">S1</th>
        <th align="right">S2</th>
        <th align="right">S3</th>
        <th align="right">PROFESI</th>
        <th align="right">JML</th>
        <th align="right">&lt; SD</th>
        <th align="right">SD</th>
        <th align="right">SMP</th>
        <th align="right">SMA</th>
        <th align="right">D1</th>
        <th align="right">D2</th>
        <th align="right">D3</th>
        <th align="right">D4</th>
        <th>SM.Non Ak</th>
        <th>SM.Ak</th>
        <th align="right">S1</th>
        <th align="right">S2</th>
        <th align="right">S3</th>
        <th align="right">PROFESI</th>
        <th align="right">JML</th>
  </tr>
<?php
$ii=0;
$total_atas_ke_bawah = 0;
foreach ($r as $key=>$row) {
	$ii++;
        $sumL[$key] = 0;
        $query3="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row3=mysql_fetch_array(mysql_query($query3));
?>
  <tr>
    <td width="17" align="right"><?=$ii?></td>
    <td width="349"><?=$row[1]?></td>
    <?php
    $jmll = 0;
    
    for ($j=0;$j<=count($pendidikan)-1;$j++) {
        $query="select count(*) as jml from MASTFIP08 where B_09='1' and (F_03 is not null or F_03<>'') and H_1A = '".$pendidikan[$j]."' and H_1A<>'' and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $rowsl= mysql_fetch_array(mysql_query($query));
        $jmll = $jmll + $rowsl['jml'];
        ?>
        <td width="26" align="center"><?=$rowsl['jml']?></td>
    <?php 
        
    } ?>
        <td width="26" align="center"><?=$jmll?></td>
    <?php
    $jmlp = 0;
    for ($j=0;$j<=count($pendidikan)-1;$j++) {
        $query="select count(*) as jml from MASTFIP08 where B_09='2' and (F_03 is not null or F_03<>'') and H_1A = '".$pendidikan[$j]."' and H_1A<>'' and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $rowsp= mysql_fetch_array(mysql_query($query));
        $jmlp = $jmlp + $rowsp['jml'];
        ?>
        <td width="26" align="center"><?=$rowsp['jml']?></td>
    <?php } ?>
    <td width="27" align="center"><?=$jmlp?></td>
    <td width="42" align="center"><?=$row3[jml]?></td>
  </tr>
<?
$total_atas_ke_bawah += $row3[jml];
}
for ($i=1;$i<=2;$i++) {
        for ($j=0;$j<=count($pendidikan)-1;$j++) {
                $query4="select sum(jml) as jml from (select count(*) as jml from MASTFIP08 where B_09='".$i."' and (F_03 is not null or F_03<>'') and H_1A = '".$pendidikan[$j]."' and H_1A<>'' and H_1A is not null and A_01<>'99' and A_01 <> '') as jml";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                
                $row4[$i][$j]=mysql_fetch_array(mysql_query($query4));
        }
        $query5="select count(*) as jml from MASTFIP08 where B_09='$i' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A<>'' and H_1A is not null";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        //echo $query."</br>";
        $row5[$i]=mysql_fetch_array(mysql_query($query5));
}
$query6="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A is not null";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
$row6=mysql_fetch_array(mysql_query($query6));
?>
  <tr>
    <td width="17">&nbsp;</td>
    <td width="349">JUMLAH</td>
    <td width="26" align="center"><?=$row4[1][0][jml]?></td>
    <td width="26" align="center"><?=$row4[1][1][jml]?></td>
    <td width="26" align="center"><?=$row4[1][2][jml]?></td>
    <td width="26" align="center"><?=$row4[1][3][jml]?></td>
    <td width="26" align="center"><?=$row4[1][4][jml]?></td>
    <td width="26" align="center"><?=$row4[1][5][jml]?></td>
    <td width="26" align="center"><?=$row4[1][6][jml]?></td>
    <td width="26" align="center"><?=$row4[1][7][jml]?></td>
    <td width="26" align="center"><?=$row4[1][8][jml]?></td>
    <td width="26" align="center"><?=$row4[1][9][jml]?></td>
    <td width="26" align="center"><?=$row4[1][10][jml]?></td>
    <td width="26" align="center"><?=$row4[1][11][jml]?></td>
    <td width="26" align="center"><?=$row4[1][12][jml]?></td>
    <td width="26" align="center"><?=$row4[1][13][jml]?></td>
    <td width="26" align="center"><?=$row5[1][jml]?></td>
    
    <td width="26" align="center"><?=$row4[2][0][jml]?></td>
    <td width="26" align="center"><?=$row4[2][1][jml]?></td>
    <td width="26" align="center"><?=$row4[2][2][jml]?></td>
    <td width="26" align="center"><?=$row4[2][3][jml]?></td>
    <td width="26" align="center"><?=$row4[2][4][jml]?></td>
    <td width="26" align="center"><?=$row4[2][5][jml]?></td>
    <td width="26" align="center"><?=$row4[2][6][jml]?></td>
    <td width="26" align="center"><?=$row4[2][7][jml]?></td>
    <td width="26" align="center"><?=$row4[2][8][jml]?></td>
    <td width="27" align="center"><?=$row4[2][9][jml]?></td>
    <td width="27" align="center"><?=$row4[2][10][jml]?></td>
    <td width="27" align="center"><?=$row4[2][11][jml]?></td>
    <td width="27" align="center"><?=$row4[2][12][jml]?></td>
    <td width="27" align="center"><?=$row4[2][13][jml]?> </td>
    <td width="27" align="center"><?=$row5[2][jml]?></td>
    <td width="42" align="center"><?=$total_atas_ke_bawah ?></td>
  </tr>
</table>
<center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
