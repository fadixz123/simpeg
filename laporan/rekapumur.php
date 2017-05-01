<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>
<head>
<title>Jumlah PNS Menurut Umur</title>
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
<?php
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$umur=array("20","25","30","35","40","45","50","55","1000");
$r=listUnitKerjaNoBiro($_GET['uk']);
?>
<h1>JUMLAH PEGAWAI NEGERI SIPIL MENURUT UMUR<br>PEMERINTAH <?=$KABI?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
  <table width="100%" class="table-print">
    <tr>
      <th width="2%">No</th>
      <th width="38%">UNIT KERJA</th>
      <th width="6%">&lt;= 20</th>
      <th width="6%">21 s/d 25</th>
      <th width="6%">26 s/d 30</th>
      <th width="6%">31 s/d 35</th>
      <th width="6%">36 s/d 40</th>
      <th width="6%">41 s/d 45</th>
      <th width="6%">46 s/d 50</th>
      <th width="6%">51 s/d 55</th>
      <th width="6%">&gt; 55</th>
      <th width="6%">JUMLAH</th>
    </tr>
<?php
    $ii=0;
    $thskr=date("Y");
    $blskr=date("m");
    $tgskr=date("d");
foreach ($r as $key=>$value) {
        $ii++;
        $tglbawah=0;
        for ($i=0;$i < count($umur);$i++) {
                $u1=intval($thskr)-$tglbawah;
		$u2=intval($thskr)-$umur[$i];
                $query="select count(*) as jml from MASTFIP08 where B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' ";
                                if (strlen($value[0])==2) { $query.="and A_01='".$value[0]."' "; }
                                else { $query.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
                //echo $query.'</br>';
                $row1[$i]=mysql_fetch_array(mysql_query($query));
                $tglbawah=$umur[$i];
        }
   $jmlumur=$row1[0][jml]+$row1[1][jml]+$row1[2][jml]+$row1[3][jml]+$row1[4][jml]+$row1[5][jml]+$row1[6][jml]+$row1[7][jml]+$row1[8][jml];
?>
    <tr>
        <td align="center"><?=$ii?>&nbsp;</td>
        <td><?=$value[1]?>&nbsp;</td>
        <td align="center"><?=$row1[0][jml]?></td>
        <td align="center"><?=$row1[1][jml]?></td>
        <td align="center"><?=$row1[2][jml]?></td>
        <td align="center"><?=$row1[3][jml]?></td>
        <td align="center"><?=$row1[4][jml]?></td>
        <td align="center"><?=$row1[5][jml]?></td>
        <td align="center"><?=$row1[6][jml]?></td>
        <td align="center"><?=$row1[7][jml]?></td>
        <td align="center"><?=$row1[8][jml]?></td>
        <td align="center"><?=$jmlumur?></td>
    </tr>
<?php 
    if (isset($_GET['uk'])) {
    if ($value['kd'] === '04' or $value['kd'] === '07') {
        $query = mysql_query("select substring(KOLOK,1,8) as KODELOK,NALOK from TABLOKB08 where substring(KOLOK,1,2)='".$value['kd']."' and KOLOK like '%0000' order by KOLOK");
        
        while ($result = mysql_fetch_array($query)) { ?>
        <tr>
            <td></td>
            <td width="350" style="padding-left: 10px;"> - <?=$result['NALOK']?></td>
            <?php 
            $n = 1;
            $tglbawah=0;
            $subtotal = 0;
            for ($i=0;$i < count($umur);$i++) {
                $u1=intval($thskr)-$tglbawah;
		$u2=intval($thskr)-$umur[$i];
                $query2="select count(*) as jml from MASTFIP08 where B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' ";                                
                $query2.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($result['KODELOK'],2,2)."' and A_03='".substr($result['KODELOK'],4,2)."' and A_01<>'99'";
                //echo $query2.'<br/>';
                $jumlah = mysql_fetch_array(mysql_query($query2));
                $subtotal += $jumlah['jml'];
                $tglbawah=$umur[$i];
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
$tglbawah=0;
for ($i=0;$i < count($umur);$i++) {
        $u1=intval($thskr)-$tglbawah;
        $u2=intval($thskr)-$umur[$i];
        $query="select count(*) as jml from MASTFIP08 where B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' and A_01<>'99'";
        if (isset($_GET['uk'])) {
            $query.=" and A_01 IN ('04','07')";
        }
        $row2[$i]=mysql_fetch_array(mysql_query($query));
        $tglbawah=$umur[$i];
        }
        $jmlumur=$row2[0][jml]+$row2[1][jml]+$row2[2][jml]+$row2[3][jml]+$row2[4][jml]+$row2[5][jml]+$row2[6][jml]+$row2[7][jml]+$row2[8][jml];
?>
    <tr>
      <td>&nbsp;</td>
      <td><b>JUMLAH</b></td>
      <td align="center"><?=$row2[0][jml]?></td>
      <td align="center"><?=$row2[1][jml]?></td>
      <td align="center"><?=$row2[2][jml]?></td>
      <td align="center"><?=$row2[3][jml]?></td>
      <td align="center"><?=$row2[4][jml]?></td>
      <td align="center"><?=$row2[5][jml]?></td>
      <td align="center"><?=$row2[6][jml]?></td>
      <td align="center"><?=$row2[7][jml]?></td>
      <td align="center"><?=$row2[8][jml]?></td>
      <td align="center"><?=$jmlumur?></td>
    </tr>
  </table>
</td></tr>
</table>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>
</html>
