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
    <h1>JUMLAH PEGAWAI NEGERI SIPIL BERDASARKAN 
    AGAMA<br>
    KEADAAN PER: TAHUN ANGGARAN<br>
    PEMERINTAH <?=$KAB?></h1>
    <table  width="100%" class="tabel-laporan">
      <tr>
        <th width="1%" rowspan="2" align="center">NO</th>
        <th width="51%" rowspan="2" align="center">UNIT KERJA</th>
        <th width="29%" colspan="5" align="center">
        <p align="center">AGAMA</th>
        <th width="9%" rowspan="2" align="center">JUMLAH</th>
      </tr>
      <tr>
        <th width="8%" align="center">ISLAM</th>
        <th width="8%" align="center">PROTESTAN</th>
        <th width="8%" align="center">KATOLIK
        </th>
        <th width="8%" align="center">HINDU</th>
        <th width="8%" align="center">BUDHA</th>
      </tr>
      <tr>
        <th width="1%" align="center">1</th>
        <th width="51%" align="center">2</th>
        <th width="8%" align="center">3</th>
        <th width="8%" align="center">4</th>
        <th width="8%" align="center">5</th>
        <th width="8%" align="center">6</th>
        <th width="8%" align="center">7</th>
        <th width="9%" align="center">8</th>
      </tr>
<?
    $ii=0;
    foreach ($r as $key=>$row) {
        $ii++;
        for ($i=0;$i<=4;$i++) {
                $query="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and (F_03 is not null or F_03<>'') and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
                $row1[$i]=mysql_fetch_array(mysql_query($query));
        }
        $query1="select count(*) as jml from MASTFIP08 where B_07<>'' and (F_03 is not null or F_03<>'') and A_01='".substr($row[0],0,2)."' and A_01<>'99'";// and ((substring(B_05,1,7) >= '$tglok' and I_5A<>2) or (B_05 >= '$tglok1' and I_5A=2))";
        $row2=mysql_fetch_array(mysql_query($query1));
?>
      <tr>
        <td width="1%" align="center"><?=$ii?></td>
        <td width="51%"><?=$row[1]?></td>
        <td width="8%" align="center"><?=$row1[0][jml]?></td>
        <td width="8%" align="center"><?=$row1[1][jml]?></td>
        <td width="8%" align="center"><?=$row1[2][jml]?></td>
        <td width="8%" align="center"><?=$row1[3][jml]?></td>
        <td width="8%" align="center"><?=$row1[4][jml]?></td>
        <td width="9%" align="center"><?=$row2[jml]?></td>
      </tr>
<?}
for ($i=0;$i<=4;$i++) {
                $query2="select count(*) as jml from MASTFIP08 where B_07='$agama[$i]' and F_03 is not null and F_03<>'' and A_01<>'99'";
                $row3[$i]=mysql_fetch_array(mysql_query($query2));
        }
        $query3="select count(*) as jml from MASTFIP08 where B_07<>'' and B_07 is not null and F_03 is not null and F_03<>'' and A_01<>'99'";
        $row4=mysql_fetch_array(mysql_query($query3));
?>
      <tr>
        <td width="1%" align="right">&nbsp;</td>
        <td width="51%"><b>JUMLAH</b></td>
        <td width="8%" align="right"><?=$row3[0][jml]?></td>
        <td width="8%" align="right"><?=$row3[1][jml]?></td>
        <td width="8%" align="right"><?=$row3[2][jml]?></td>
        <td width="8%" align="right"><?=$row3[3][jml]?></td>
        <td width="8%" align="right"><?=$row3[4][jml]?></td>
        <td width="9%" align="right"><?=$row4[jml]?></td>
      </tr>
    </table>
<center><button onclick="cetak();">Cetak</button></center>
    <br/><br/><br/>
</body>

</html>

