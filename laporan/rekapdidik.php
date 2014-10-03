<?php
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>
<head>
<title>Jumlah PNS Menurut Pendidikan</title>
<link rel="stylesheet" href="../css/printing-A4-landscape.css" media="print" />
<script type="text/javascript">
    function cetak() {
        setTimeout(function(){ window.close();},300);
        window.print();    
    }
</script>
</head>

<body onload="cetak();">
<?
$tahun=date("Y");
$thskr=$tahun-56;
$thskr1=$tahun-61;
$tglok=$thskr."-".date("m")."-".date("d");
$tglok1=$thskr1."-".date("m")."-".date("d");

$pendidikan=array("0","1","2","3","4","5","6","7","8","9");
$kelamin=array("1","2");
$r=listUnitKerjaNoBiro();
?>
<h1>JUMLAH PEGAWAI NEGERI SIPIL MENURUT JENIS KELAMIN DAN PENDIDIKAN<br>PEMERINTAH <?=$KAB?><br>KEADAAN PER: <?=tanggalnya(date("Y-m-d"),0);?></h1>
<table width="100%" class="tabel-laporan">
  <tr>
    <td width="17" align="center" rowspan="2"><b><font face="Verdana" size="1">
    No</font></b></td>
    <td width="349" align="center" rowspan="2"><font face="Verdana" size="1"><b>INSTANSI</b></font></td>
    <td width="285" align="center" colspan="11"><b>
    <font face="Verdana" size="1">LAKI-LAKI</font></b></td>
    <td width="287" align="center" colspan="11"><b>
    <font face="Verdana" size="1">PEREMPUAN</font></b></td>
    <td width="42" align="center" rowspan="2"><font face="Verdana" size="1"><b>Jumlah</b></font><?=$row1[8][jml]?></td>
  </tr>
  <tr>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">&lt;SD</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SD</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SMP</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SMA</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D1</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D2</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D3</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S1</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S2</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S3</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">JML</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">&lt;SD</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SD</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SMP</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">SMA</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D1</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D2</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">D3</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S1</font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S2</font></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">S3</font></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><font size="1">JML</font></td>
  </tr>
<?
$ii=0;
foreach ($r as $key=>$row) {
	$ii++;
        $query3="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row3=mysql_fetch_array(mysql_query($query3));
        for ($i=1;$i<=2;$i++) {
                for ($j=0;$j<=9;$j++) {
                        $query="select count(*) as jml from MASTFIP08 where B_06='$i' and (F_03 is not null or F_03<>'') and H_1A like '".substr($pendidikan[$j],0,1)."%' and H_1A<>'' and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                        $row1[$i][$j]=mysql_fetch_array(mysql_query($query));
                }
                $query2="select count(*) as jml from MASTFIP08 where B_06='$i' and (F_03 is not null or F_03<>'') and H_1A<>'' and H_1A is not null and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                $row2[$i]=mysql_fetch_array(mysql_query($query2));
        }
?>
  <tr>
    <td width="17" align="right" style="font-family: Verdana; font-size: 8pt"><?=$ii?></td>
    <td width="349" style="font-family: Verdana; font-size: 8pt"><?=$row[1]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][0][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][2][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][3][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][4][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][5][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][6][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][7][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][8][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[1][9][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row2[1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][0][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][2][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][3][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][4][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][5][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][6][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][7][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][8][jml]?></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row1[2][9][jml]?></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row2[2][jml]?></td>
    <td width="42" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row3[jml]?></td>
  </tr>
<?
}
for ($i=1;$i<=2;$i++) {
        for ($j=0;$j<=9;$j++) {
                $query4="select count(*) as jml from MASTFIP08 where B_06='$i' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A like '$j%'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                $row4[$i][$j]=mysql_fetch_array(mysql_query($query4));
        }
        $query5="select count(*) as jml from MASTFIP08 where B_06='$i' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A<>'' and H_1A is not null";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row5[$i]=mysql_fetch_array(mysql_query($query5));
}
$query6="select count(*) as jml from MASTFIP08 where H_1A<>'' and (F_03 is not null or F_03<>'') and A_01<>'99' and H_1A is not null";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
$row6=mysql_fetch_array(mysql_query($query6));
?>
  <tr>
    <td width="17" style="font-family: Verdana; font-size: 8pt">&nbsp;</td>
    <td width="349" style="font-family: Verdana; font-size: 8pt"><font face="Verdana" size="1"><b>JUMLAH</b></font></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][0][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][2][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][3][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][4][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][5][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][6][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][7][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][8][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[1][9][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row5[1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][0][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][1][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][2][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][3][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][4][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][5][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][6][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][7][jml]?></td>
    <td width="26" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][8][jml]?></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row4[2][9][jml]?></td>
    <td width="27" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row5[2][jml]?></td>
    <td width="42" align="right" style="font-family: Verdana; font-size: 8pt"><?=$row6[jml]?></td>
  </tr>
</table>
</body>

</html>
