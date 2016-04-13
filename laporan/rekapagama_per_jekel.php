<?
include ("../include/config.inc");
include ("../include/fungsi.inc");
$conn=mysql_connect($server,$user,$pass);
mysql_select_db($db,$conn);
?>
<html>

<head>
<title>Jumlah Pegawai Negeri Sipil Berdasarkan Agama</title>
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

$agama=array("1","2","3","4","5");
$r=listUnitKerjaNoBiro();
?>
    <h1>JUMLAH PEGAWAI NEGERI SIPIL BERDASARKAN JENIS KELAMIN DAN
    AGAMA<br>
    KEADAAN PER: TAHUN ANGGARAN<br>
    PEMERINTAH <?=$KAB?></h1>
    <table  width="100%" class="table-print">
      <tr>
        <th width="2%" rowspan="3">NO</th>
        <th width="38%" rowspan="3">UNIT KERJA</th>
        <th colspan="12" width="60%">AGAMA</th>
        
      </tr>
      <tr>
          <th colspan="5">LAKI-LAKI</th>
          <th width="5%" rowspan="2">JUMLAH</th>
          <th colspan="5">PEREMPUAN</th>
          <th width="5%" rowspan="2">JUMLAH</th>
      </tr>
      <tr>
        <th width="5%">ISLAM</th>
        <th width="5%">PROTESTAN</th>
        <th width="5%">KATOLIK</th>
        <th width="5%">HINDU</th>
        <th width="5%">BUDHA</th>
        
        <th width="5%">ISLAM</th>
        <th width="5%">PROTESTAN</th>
        <th width="5%">KATOLIK</th>
        <th width="5%">HINDU</th>
        <th width="5%">BUDHA</th>
        
      </tr>
      <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
        <th>8</th>
        <th>9</th>
        <th>10</th>
        <th>11</th>
        <th>12</th>
        <th>13</th>
        <th>14</th>
      </tr>
<?
    $ii=0;
    foreach ($r as $key=>$row) {
        $ii++;
        for ($i=0;$i<=4;$i++) {
                $query="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and B_06 = '1' and (F_03 is not null or F_03<>'') and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                $row1[$i]=mysql_fetch_array(mysql_query($query));
        }
        $query1="select count(*) as jml from MASTFIP08 where B_07<>'' and (F_03 is not null or F_03<>'') and B_06 = '1' and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row2=mysql_fetch_array(mysql_query($query1));
        
        for ($i=0;$i<=4;$i++) {
                $query2="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and B_06 = '2' and (F_03 is not null or F_03<>'') and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                $row3[$i]=mysql_fetch_array(mysql_query($query2));
        }
        $query3="select count(*) as jml from MASTFIP08 where B_07<>'' and (F_03 is not null or F_03<>'') and B_06 = '2' and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row4=mysql_fetch_array(mysql_query($query3));
        
?>
      <tr>
        <td align="center"><?=$ii?></td>
        <td><?=$row[1]?></td>
        <td align="center"><?=$row1[0][jml]?></td>
        <td align="center"><?=$row1[1][jml]?></td>
        <td align="center"><?=$row1[2][jml]?></td>
        <td align="center"><?=$row1[3][jml]?></td>
        <td align="center"><?=$row1[4][jml]?></td>
        <td align="center"><?=$row2[jml]?></td>
        
        <td align="center"><?=$row3[0][jml]?></td>
        <td align="center"><?=$row3[1][jml]?></td>
        <td align="center"><?=$row3[2][jml]?></td>
        <td align="center"><?=$row3[3][jml]?></td>
        <td align="center"><?=$row3[4][jml]?></td>
        <td align="center"><?=$row4[jml]?></td>
      </tr>
<?}
        for ($i=0;$i<=4;$i++) {
            $query2="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and B_06 = '1' and F_03 is not null and F_03<>'' and A_01<>'99'";
            $row3[$i]=mysql_fetch_array(mysql_query($query2));
        }
        $query3="select count(*) as jml from MASTFIP08 where B_07<>'' and B_06 = '1' and B_07 is not null and F_03 is not null and F_03<>'' and A_01<>'99'";
        $row4=mysql_fetch_array(mysql_query($query3));
        
        for ($i=0;$i<=4;$i++) {
            $queryp="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and B_06 = '2' and F_03 is not null and F_03<>'' and A_01<>'99'";
            $rowp[$i]=mysql_fetch_array(mysql_query($queryp));
        }
        $query4p="select count(*) as jml from MASTFIP08 where B_07<>'' and B_06 = '2' and B_07 is not null and F_03 is not null and F_03<>'' and A_01<>'99'";
        $row4p=mysql_fetch_array(mysql_query($query4p));
?>
      <tr>
        <td align="center">&nbsp;</td>
        <td><b>JUMLAH</b></td>
        <td align="center"><?=$row3[0][jml]?></td>
        <td align="center"><?=$row3[1][jml]?></td>
        <td align="center"><?=$row3[2][jml]?></td>
        <td align="center"><?=$row3[3][jml]?></td>
        <td align="center"><?=$row3[4][jml]?></td>
        <td align="center"><?=$row4[jml]?></td>
        
        <td align="center"><?=$rowp[0][jml]?></td>
        <td align="center"><?=$rowp[1][jml]?></td>
        <td align="center"><?=$rowp[2][jml]?></td>
        <td align="center"><?=$rowp[3][jml]?></td>
        <td align="center"><?=$rowp[4][jml]?></td>
        <td align="center"><?=$row4p[jml]?></td>
      </tr>
    </table>
<center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>

