<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>
<head>
<title>Jumlah PNS Menurut Eselon Jabatan</title>
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
    <div class="page">
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$eselon=array("11","12","21","22","31","32","41","42","51");
//$q="select * from TABLOK where kd<>'99000000' order by kd";
$r=listUnitKerjaNoBiro();
?>
        <h3>JUMLAH PEGAWAI NEGERI SIPIL MENURUT ESELON JABATAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h3>
  <table class="table-print" width="100%">
      <thead>
    <tr>
        <th width="30" rowspan="2">No</th>
        <th width="400" rowspan="2">UNIT KERJA</th>
        <th colspan="9">LAKI-LAKI</th>
        <th width="58" align="center" rowspan="2">JUMLAH</th>
        <th colspan="9">PEREMPUAN</th>
        <th width="58" align="center" rowspan="2">JUMLAH</th>
    </tr>
    <tr>
        <th width="58" align="center">I/A</th>
        <th width="58" align="center">I/B</th>
        <th width="58" align="center">II/A</th>
        <th width="58" align="center">II/B</th>
        <th width="58" align="center">III/A</th>
        <th width="58" align="center">III/B</th>
        <th width="58" align="center">IV/A</th>
        <th width="58" align="center">IV/B</th>
        <th width="58" align="center">V/A</th>
       
        <th width="58" align="center">I/A</th>
        <th width="58" align="center">I/B</th>
        <th width="58" align="center">II/A</th>
        <th width="58" align="center">II/B</th>
        <th width="58" align="center">III/A</th>
        <th width="58" align="center">III/B</th>
        <th width="58" align="center">IV/A</th>
        <th width="58" align="center">IV/B</th>
        <th width="58" align="center">V/A</th>
        
    </tr>
    </thead>
<?
    $ii=0;
    $jmltot=0; $jmltot2 = 0;
    foreach($r as $key=>$row) {
    	$ii++;
        for ($i=0;$i<=8;$i++) {
                $query="select count(*) as jml from MASTFIP08 where B_06 = '1' and I_06='$eselon[$i]' and A_01='".substr($row[0],0,2)."' and A_01<>'99' and I_5A='1'";
			//echo $query;
                $row1[$i]=mysql_fetch_array(mysql_query($query));
		$row2[$i][jml]=$row2[$i][jml]+$row1[$i][jml];
        }
        $jumlah=$row1[0][jml]+$row1[1][jml]+$row1[2][jml]+$row1[3][jml]+$row1[4][jml]+$row1[5][jml]+$row1[6][jml]+$row1[7][jml]+$row1[8][jml];
        $jmltot=$jmltot+$jumlah;
        
        for ($i=0;$i<=8;$i++) {
                $query="select count(*) as jml from MASTFIP08 where B_06 = '2' and I_06='$eselon[$i]' and A_01='".substr($row[0],0,2)."' and A_01<>'99' and I_5A='1'";
			//echo $query;
                $row3[$i]=mysql_fetch_array(mysql_query($query));
		$row4[$i][jml]=$row4[$i][jml]+$row3[$i][jml];
        }
        $jumlah2 = $row3[0][jml]+$row3[1][jml]+$row3[2][jml]+$row3[3][jml]+$row3[4][jml]+$row3[5][jml]+$row3[6][jml]+$row3[7][jml]+$row3[8][jml];
        $jmltot2=$jmltot2+$jumlah2;
?>
    <tr>
      <td width="28" align="center"><?=$ii?></td>
      <td width="374"><?=$row[1]?></td>
      <td width="58" align="center"><?=$row1[0][jml]?></td>
      <td width="58" align="center"><?=$row1[1][jml]?></td>
      <td width="58" align="center"><?=$row1[2][jml]?></td>
      <td width="58" align="center"><?=$row1[3][jml]?></td>
      <td width="58" align="center"><?=$row1[4][jml]?></td>
      <td width="58" align="center"><?=$row1[5][jml]?></td>
      <td width="58" align="center"><?=$row1[6][jml]?></td>
      <td width="58" align="center"><?=$row1[7][jml]?></td>
      <td width="58" align="center"><?=$row1[8][jml]?></td>
      <td width="58" align="center"><?=$jumlah?></td>
      
      <td width="58" align="center"><?=$row3[0][jml]?></td>
      <td width="58" align="center"><?=$row3[1][jml]?></td>
      <td width="58" align="center"><?=$row3[2][jml]?></td>
      <td width="58" align="center"><?=$row3[3][jml]?></td>
      <td width="58" align="center"><?=$row3[4][jml]?></td>
      <td width="58" align="center"><?=$row3[5][jml]?></td>
      <td width="58" align="center"><?=$row3[6][jml]?></td>
      <td width="58" align="center"><?=$row3[7][jml]?></td>
      <td width="58" align="center"><?=$row3[8][jml]?></td>
      <td width="58" align="center"><?=$jumlah2?></td>
    </tr>
<? }
/*for ($i=0;$i<=7;$i++) {
	$query="select count(*) as jml from MASTFIP1 where I_06='$eselon[$i]' and A_01<>'99' and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
	//echo $query;
	$row2[$i]=mysql_fetch_array(mysql_query($query));
        }
$jumlah=$row2[0][jml]+$row2[1][jml]+$row2[2][jml]+$row2[3][jml]+$row2[4][jml]+$row2[5][jml]+$row2[6][jml]+$row2[7][jml];*/
?>
    <tr>
      <td width="28">&nbsp;</td>
      <td width="374"><b>JUMLAH</b></td>
      <td width="58" align="center"><?=$row2[0][jml]?></td>
      <td width="58" align="center"><?=$row2[1][jml]?></td>
      <td width="58" align="center"><?=$row2[2][jml]?></td>
      <td width="58" align="center"><?=$row2[3][jml]?></td>
      <td width="58" align="center"><?=$row2[4][jml]?></td>
      <td width="58" align="center"><?=$row2[5][jml]?></td>
      <td width="58" align="center"><?=$row2[6][jml]?></td>
      <td width="58" align="center"><?=$row2[7][jml]?></td>
      <td width="58" align="center"><?=$row2[8][jml]?></td>
      <td width="58" align="center"><?=$jmltot?></td>
      
      <td width="58" align="center"><?=$row4[0][jml]?></td>
      <td width="58" align="center"><?=$row4[1][jml]?></td>
      <td width="58" align="center"><?=$row4[2][jml]?></td>
      <td width="58" align="center"><?=$row4[3][jml]?></td>
      <td width="58" align="center"><?=$row4[4][jml]?></td>
      <td width="58" align="center"><?=$row4[5][jml]?></td>
      <td width="58" align="center"><?=$row4[6][jml]?></td>
      <td width="58" align="center"><?=$row4[7][jml]?></td>
      <td width="58" align="center"><?=$row4[8][jml]?></td>
      <td width="58" align="center"><?=$jmltot2?></td>
    </tr>
  </table>
        </div>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
