<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>
<head>
<title>Jumlah PNS per Pangkat/Golongan</title>
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="all" />
<script type="text/javascript" src="../Scripts/jquery.min.js" ></script>
<link rel="stylesheet" href="../css/template_css.css" media="all" />
<script type="text/javascript">
    function cetak() {
//        setTimeout(function(){ window.close();},300);
        $('button').hide();
        window.print();
        $('button').show();
    }
</script>
</head>

<body>
    <div class="page">
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$golongan=array("11","12","13","14","21","22","23","24","31","32","33","34","41","42","43","44","45");
$golbesar=array("1","2","3","4");
$r=listUnitKerjaNoBiro();
?>
    
<h1>JUMLAH PEGAWAI NEGERI SIPIL PER PANGKAT/GOLONGAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
<table class="table-print" width="100%">
    <thead>
  <tr>
    <th width="350" align="center">INSTANSI</th>
    <th width="40" align="center">I/a</th>
    <th width="40" align="center">I/b</th>
    <th width="40" align="center">I/c</th>
    <th width="40" align="center">I/d</th>
    <th width="40" align="center">Jml gol. I</th>
    <th width="40" align="center">II/a</th>
    <th width="40" align="center">II/b</th>
    <th width="40" align="center">II/c</th>
    <th width="40" align="center">II/d</th>
    <th width="40" align="center">Jml gol. II</th>
    <th width="40" align="center">III/a</th>
    <th width="40" align="center">III/b</th>
    <th width="40" align="center">III/c</th>
    <th width="40" align="center">IIId</th>
    <th width="40" align="center">Jml gol. III</th>
    <th width="38" align="center">IV/a</th>
    <th width="38" align="center">IV/b</th>
    <th width="39" align="center">IV/c</th>
    <th width="39" align="center">IV/d</th>
    <th width="39" align="center">IV/e</th>
    <th width="40" align="center">Jml gol. IV</th>
    <th width="40" align="center">Jumlah</th>
  </tr>
    </thead>
<?php
foreach ($r as $key=>$value) {
	for ($i=0;$i<=16;$i++) {
		$query="select count(*) as jml from MASTFIP08 where F_03='$golongan[$i]' ";
                if (strlen($value[0])==2) { $query.="and A_01='".$value[0]."' "; }
                else { $query.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
		$query.="and A_01<>'99'";
		$row1[$i]=mysql_fetch_array(mysql_query($query));
		$row4[$i][jml]=$row4[$i][jml]+$row1[$i][jml];
	}
	for ($i=0;$i<=3;$i++) {
	$query2="select count(*) as jml from MASTFIP08 where substring(F_03,1,1)='$golbesar[$i]' ";
        if (strlen($value[0])==2) { $query2.="and A_01='".$value[0]."' "; }
        else { $query2.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
	$query2.="and A_01<>'99'";
	//echo $query2."</br>";
	$row2[$i]=mysql_fetch_array(mysql_query($query2));
	$row5[$i][jml]=$row5[$i][jml]+$row2[$i][jml];
}
	$query3="select count(*) as jml from MASTFIP08 where ";
        if (strlen($value[0])==2) { $query3.="A_01='".$value[0]."' "; }
        else { $query3.="A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
	$query3.="and A_01<>'99' and F_03<>'' and F_03 is not null";
	$row3=mysql_fetch_array(mysql_query($query3));
	$row6[jml]=$row6[jml]+$row3[jml];
?>
  <tr>
    <td width="350"><?=$value[1]?>&nbsp;</td>
    <td width="40" align="center"><?=$row1[0][jml]?></td>
    <td width="40" align="center"><?=$row1[1][jml]?></td>
    <td width="40" align="center"><?=$row1[2][jml]?></td>
    <td width="40" align="center"><?=$row1[3][jml]?></td>
    <td width="40" align="center"><?=$row2[0][jml]?></td>
    <td width="40" align="center"><?=$row1[4][jml]?></td>
    <td width="40" align="center"><?=$row1[5][jml]?></td>
    <td width="40" align="center"><?=$row1[6][jml]?></td>
    <td width="40" align="center"><?=$row1[7][jml]?></td>
    <td width="40" align="center"><?=$row2[1][jml]?></td>
    <td width="40" align="center"><?=$row1[8][jml]?></td>
    <td width="40" align="center"><?=$row1[9][jml]?></td>
    <td width="40" align="center"><?=$row1[10][jml]?></td>
    <td width="40" align="center"><?=$row1[11][jml]?></td>
    <td width="40" align="center"><?=$row2[2][jml]?></td>
    <td width="38" align="center"><?=$row1[12][jml]?></td>
    <td width="38" align="center"><?=$row1[13][jml]?></td>
    <td width="39" align="center"><?=$row1[14][jml]?></td>
    <td width="39" align="center"><?=$row1[15][jml]?></td>
    <td width="39" align="center"><?=$row1[16][jml]?></td>
    <td width="40" align="center"><?=$row2[3][jml]?></td>
    <td width="40" align="center"><?=$row3[jml]?></td>
  </tr>
<? } ?>
  <tr>
    <td width="350">JUMLAH</td>
    <td width="40" align="center"><?=$row4[0][jml]?></td>
    <td width="40" align="center"><?=$row4[1][jml]?></td>
    <td width="40" align="center"><?=$row4[2][jml]?></td>
    <td width="40" align="center"><?=$row4[3][jml]?></td>
    <td width="40" align="center"><?=$row5[0][jml]?></td>
    <td width="40" align="center"><?=$row4[4][jml]?></td>
    <td width="40" align="center"><?=$row4[5][jml]?></td>
    <td width="40" align="center"><?=$row4[6][jml]?></td>
    <td width="40" align="center"><?=$row4[7][jml]?></td>
    <td width="40" align="center"><?=$row5[1][jml]?></td>
    <td width="40" align="center"><?=$row4[8][jml]?></td>
    <td width="40" align="center"><?=$row4[9][jml]?></td>
    <td width="40" align="center"><?=$row4[10][jml]?></td>
    <td width="40" align="center"><?=$row4[11][jml]?></td>
    <td width="40" align="center"><?=$row5[2][jml]?></td>
    <td width="38" align="center"><?=$row4[12][jml]?></td>
    <td width="38" align="center"><?=$row4[13][jml]?></td>
    <td width="39" align="center"><?=$row4[14][jml]?></td>
    <td width="39" align="center"><?=$row4[15][jml]?></td>
    <td width="39" align="center"><?=$row4[16][jml]?></td>
    <td width="40" align="center"><?=$row5[3][jml]?></td>
    <td width="40" align="center"><?=$row6[jml]?></td>
  </tr>
</table>
        </div>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
