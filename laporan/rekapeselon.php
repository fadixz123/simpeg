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
$r=listUnitKerjaNoBiro($_GET['uk']);
?>
        <h3>JUMLAH PEGAWAI NEGERI SIPIL MENURUT ESELON JABATAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h3>
  <table class="table-print" width="100%">
      <thead>
    <tr>
      <th width="30">No</th>
      <th width="400">UNIT KERJA</th>
      <th width="58" align="center">I/A</th>
      <th width="58" align="center">I/B</th>
      <th width="58" align="center">II/A</th>
      <th width="58" align="center">II/B</th>
      <th width="58" align="center">III/A</th>
      <th width="58" align="center">III/B</th>
      <th width="58" align="center">IV/A</th>
      <th width="58" align="center">IV/B</th>
      <th width="58" align="center">V/A</th>
      <th width="58" align="center">JUMLAH</th>
    </tr>
    </thead>
<?
    $ii=0;
    $jmltot=0;
    foreach($r as $key=>$row) {
    	$ii++;
        for ($i=0;$i<=8;$i++) {
                $query="select count(*) as jml from MASTFIP08 where I_06='$eselon[$i]' and A_01='".substr($row[0],0,2)."' and A_01<>'99' and I_5A='1'";
			//echo $query;
                $row1[$i]=mysql_fetch_array(mysql_query($query));
		$row2[$i][jml]=$row2[$i][jml]+$row1[$i][jml];
        }
$jumlah=$row1[0][jml]+$row1[1][jml]+$row1[2][jml]+$row1[3][jml]+$row1[4][jml]+$row1[5][jml]+$row1[6][jml]+$row1[7][jml]+$row1[8][jml];
$jmltot=$jmltot+$jumlah;
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
    </tr>
<?php
    if (isset($_GET['uk'])) {
    if ($row['kd'] === '04' or $row['kd'] === '07') {
        $query = mysql_query("select substring(KOLOK,1,8) as KODELOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='".$row['kd']."' and KOLOK like '%0000' order by KOLOK");
        
        while ($result = mysql_fetch_array($query)) { ?>
        <tr>
            <td></td>
            <td width="350" style="padding-left: 10px;"> - <?=$result['NALOK']?></td>
            <?php 
            $n = 1;
            $subtotal = 0;
            for ($i=0;$i<=8;$i++) {
                $query2 = "select count(*) as jml from MASTFIP08 where I_06='$eselon[$i]' and A_01='".substr($result[0],0,2)."'and A_02='".substr($result['KODELOK'],2,2)."' and A_03='".substr($result['KODELOK'],4,2)."' and A_01<>'99' and I_5A='1'";
                //echo $query2.'<br/>';
                $jumlah = mysql_fetch_array(mysql_query($query2));
                $subtotal += $jumlah['jml'];
                ?>
            <td align="center"><?= $jumlah['jml'] ?></td>
            <?php 
            $n++;
            } ?>
            <td align="center"><?= $subtotal ?></td>
        </tr>
<?php    
        }
    }
    }
}
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
    </tr>
  </table>
        </div>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>
