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
  <table width="100%" class="tabel-laporan">
    <tr>
      <th width="28"><b>No</b></th>
      <th width="374"><b>UNIT KERJA</b></th>
      <th width="58" align="center"><b>&lt;= 20</b></th>
      <th width="58" align="center"><b>21 s/d 25</b></th>
      <th width="58" align="center"><b>26 s/d 30</b></th>
      <th width="58" align="center"><b>31 s/d 35</b></th>
      <th width="58" align="center"><b>36 s/d 40</b></th>
      <th width="58" align="center"><b>41 s/d 45</b></th>
      <th width="58" align="center"><b>46 s/d 50</b></th>
      <th width="58" align="center"><b>51 s/d 55</b></th>
      <th width="58" align="center"><b>&gt; 55</b></th>
      <th width="58" align="center"><b>JUMLAH</b></th>
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
                $row1[$i]=mysql_fetch_array(mysql_query($query));
                $tglbawah=$umur[$i];
        }
   $jmlumur=$row1[0][jml]+$row1[1][jml]+$row1[2][jml]+$row1[3][jml]+$row1[4][jml]+$row1[5][jml]+$row1[6][jml]+$row1[7][jml]+$row1[8][jml];
?>
    <tr>
        <td width="28" align="right"><?=$ii?>&nbsp;</td>
        <td width="374"><?=$value[1]?>&nbsp;</td>
        <td width="58" align="right"><?=$row1[0][jml]?></td>
        <td width="58" align="right"><?=$row1[1][jml]?></td>
        <td width="58" align="right"><?=$row1[2][jml]?></td>
        <td width="58" align="right"><?=$row1[3][jml]?></td>
        <td width="58" align="right"><?=$row1[4][jml]?></td>
        <td width="58" align="right"><?=$row1[5][jml]?></td>
        <td width="58" align="right"><?=$row1[6][jml]?></td>
        <td width="58" align="right"><?=$row1[7][jml]?></td>
        <td width="58" align="right"><?=$row1[8][jml]?></td>
        <td width="58" align="right"><?=$jmlumur?></td>
    </tr>
<?php }
$tglbawah=0;
for ($i=0;$i < count($umur);$i++) {
        $u1=intval($thskr)-$tglbawah;
        $u2=intval($thskr)-$umur[$i];
        $query="select count(*) as jml from MASTFIP08 where B_05<='".$u1."-".$blskr."-".$tgskr."' and B_05>'".$u2."-".$blskr."-".$tgskr."' and A_01<>'99'";
        $row2[$i]=mysql_fetch_array(mysql_query($query));
        $tglbawah=$umur[$i];
        }
$jmlumur=$row2[0][jml]+$row2[1][jml]+$row2[2][jml]+$row2[3][jml]+$row2[4][jml]+$row2[5][jml]+$row2[6][jml]+$row2[7][jml]+$row2[8][jml];
?>
    <tr>
      <td width="28">&nbsp;</td>
      <td width="374"><b>JUMLAH</b></td>
      <td width="58" align="right"><?=$row2[0][jml]?></td>
      <td width="58" align="right"><?=$row2[1][jml]?></td>
      <td width="58" align="right"><?=$row2[2][jml]?></td>
      <td width="58" align="right"><?=$row2[3][jml]?></td>
      <td width="58" align="right"><?=$row2[4][jml]?></td>
      <td width="58" align="right"><?=$row2[5][jml]?></td>
      <td width="58" align="right"><?=$row2[6][jml]?></td>
      <td width="58" align="right"><?=$row2[7][jml]?></td>
      <td width="58" align="right"><?=$row2[8][jml]?></td>
      <td width="58" align="right"><?=$jmlumur?></td>
    </tr>
  </table>
</td></tr>
</table>
    <center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>
</html>
