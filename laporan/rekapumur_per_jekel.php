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
$r=listUnitKerjaNoBiro();
?>
<h1>JUMLAH PEGAWAI NEGERI SIPIL MENURUT UMUR<br>PEMERINTAH <?=$KABI?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
  <table width="100%" class="table-print">
    <tr>
        <th width="2%" rowspan="2">No</th>
        <th width="38%" rowspan="2">UNIT KERJA</th>
        <th colspan="9">LAKI-LAKI</th>
        <th rowspan="2">JUMLAH</th>
        <th colspan="9">PEREMPUAN</th>
        <th rowspan="2">JUMLAH</th>
    </tr>
    <tr>
        <th width="3%">&lt;= 20</th>
        <th width="3%">21 s/d 25</th>
        <th width="3%">26 s/d 30</th>
        <th width="3%">31 s/d 35</th>
        <th width="3%">36 s/d 40</th>
        <th width="3%">41 s/d 45</th>
        <th width="3%">46 s/d 50</th>
        <th width="3%">51 s/d 55</th>
        <th width="3%">&gt; 55</th>
        
        <th width="3%">&lt;= 20</th>
        <th width="3%">21 s/d 25</th>
        <th width="3%">26 s/d 30</th>
        <th width="3%">31 s/d 35</th>
        <th width="3%">36 s/d 40</th>
        <th width="3%">41 s/d 45</th>
        <th width="3%">46 s/d 50</th>
        <th width="3%">51 s/d 55</th>
        <th width="3%">&gt; 55</th>
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
                $query="select count(*) as jml from MASTFIP08 where B_06 = '1' and B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' ";
                                if (strlen($value[0])==2) { $query.="and A_01='".$value[0]."' "; }
                                else { $query.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
                $row1[$i]=mysql_fetch_array(mysql_query($query));
                $tglbawah=$umur[$i];
        }
        $jmlumur=$row1[0][jml]+$row1[1][jml]+$row1[2][jml]+$row1[3][jml]+$row1[4][jml]+$row1[5][jml]+$row1[6][jml]+$row1[7][jml]+$row1[8][jml];
        
        $tglbawah2=0;
        for ($i=0;$i < count($umur);$i++) {
                $u1=intval($thskr)-$tglbawah2;
		$u2=intval($thskr)-$umur[$i];
                $query="select count(*) as jml from MASTFIP08 where B_06 = '2' and B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' ";
                                if (strlen($value[0])==2) { $query.="and A_01='".$value[0]."' "; }
                                else { $query.="and A_01='".substr($value[0],0,2)."' and A_02='".substr($value[0],2,2)."' and A_03='".substr($value[0],4,2)."' "; }
                $row2[$i]=mysql_fetch_array(mysql_query($query));
                $tglbawah2=$umur[$i];
        }
        $jmlumur2=$row2[0][jml]+$row2[1][jml]+$row2[2][jml]+$row2[3][jml]+$row2[4][jml]+$row2[5][jml]+$row2[6][jml]+$row2[7][jml]+$row2[8][jml];
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
        
        <td align="center"><?=$row2[0][jml]?></td>
        <td align="center"><?=$row2[1][jml]?></td>
        <td align="center"><?=$row2[2][jml]?></td>
        <td align="center"><?=$row2[3][jml]?></td>
        <td align="center"><?=$row2[4][jml]?></td>
        <td align="center"><?=$row2[5][jml]?></td>
        <td align="center"><?=$row2[6][jml]?></td>
        <td align="center"><?=$row2[7][jml]?></td>
        <td align="center"><?=$row2[8][jml]?></td>
        <td align="center"><?=$jmlumur2?></td>
    </tr>
<?php }
    $tglbawah=0;
    for ($i=0;$i < count($umur);$i++) {
        $u1=intval($thskr)-$tglbawah;
        $u2=intval($thskr)-$umur[$i];
        $query="select count(*) as jml from MASTFIP08 where B_06 = '1' and B_05 <= '".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' and A_01<>'99'";
        $row2[$i]=mysql_fetch_array(mysql_query($query));
        $tglbawah=$umur[$i];
    }
    $jmlumur=$row2[0][jml]+$row2[1][jml]+$row2[2][jml]+$row2[3][jml]+$row2[4][jml]+$row2[5][jml]+$row2[6][jml]+$row2[7][jml]+$row2[8][jml];
    
    $tglbawah2=0;
    for ($i=0;$i < count($umur);$i++) {
        $u1=intval($thskr)-$tglbawah2;
        $u2=intval($thskr)-$umur[$i];
        $queryp="select count(*) as jml from MASTFIP08 where B_06 = '2' and B_05 <= '".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' and A_01<>'99'";
        $row2p[$i]=mysql_fetch_array(mysql_query($queryp));
        $tglbawah2=$umur[$i];
    }
    $jmlumur2=$row2p[0][jml]+$row2p[1][jml]+$row2p[2][jml]+$row2p[3][jml]+$row2p[4][jml]+$row2p[5][jml]+$row2p[6][jml]+$row2p[7][jml]+$row2p[8][jml];
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
        
        <td align="center"><?=$row2p[0][jml]?></td>
        <td align="center"><?=$row2p[1][jml]?></td>
        <td align="center"><?=$row2p[2][jml]?></td>
        <td align="center"><?=$row2p[3][jml]?></td>
        <td align="center"><?=$row2p[4][jml]?></td>
        <td align="center"><?=$row2p[5][jml]?></td>
        <td align="center"><?=$row2p[6][jml]?></td>
        <td align="center"><?=$row2p[7][jml]?></td>
        <td align="center"><?=$row2p[8][jml]?></td>
        <td align="center"><?=$jmlumur2?></td>
    </tr>
  </table>
</td></tr>
</table>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>
</html>
