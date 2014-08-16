<?php
include ("../include/config.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$j=mysql_num_rows(mysql_query("select user from LOGUSER where sid='$sid' LIMIT 1"));
if (1)
{
include ("fungsi.inc");
include ("detil.inc");

$q="select * from MASTFIP08 where B_02='$NIP' LIMIT 1";
$r=mysql_query($q) or die (mysql_error());
$row=mysql_fetch_array($r);

$uker=$row["A_01"];
$quk="select kd,nm from TABLOK08 where substring(kd,1,2)='$uker'";
$ruk=mysql_query($quk) or die (mysql_error());
$ouk=mysql_fetch_array($ruk);

$qlo="select NALOK from TABLOKB08 where KOLOK='".$uker.$row['A_02'].$row['A_03'].$row['A_04'].$row['A_05']."'";
$rlo=mysql_query($qlo) or die (mysql_error());
$olo=mysql_fetch_array($rlo);

$qjb="select * from TABLOKB08 where KOLOK='".$row['I_05']."'";
$rjb=mysql_query($qjb) or die (mysql_error());
$ojb=mysql_fetch_array($rjb);
?>
<html>
<head>
<link rel="stylesheet" href="../css/printing-A4.css" media="print" />
<script type="text/javascript">
    function cetak() {
        setTimeout(function(){ window.close();},300);
        window.print();    
    }
</script>
<title>CETAK BIODATA</title>

</head>

<body onload="cetak();">
<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="700" id="AutoNumber1">
  <tr>
      <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
          <TD align="center"><B>BIODATA PNS</B></TD>
          
          </TR> 
    </table>
    </td>
    </tr>
    <tr>
      <td>
      <table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber2">
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>LOKASI KERJA </b></td>
          <td rowspan="15" align="center" valign="top"> 
            &nbsp;<img src="../showfoto.php?nip=<?=$row[B_02]?>" border="1" width="120"> 
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">NAMA UNIT KERJA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <? echo $ouk['nm']; ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">SUB UNIT KERJA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <? //if (substr($ojb['esel'],0,1) !='2')
		echo $olo['NALOK'];  ?>
          </td>
        </tr>
        
        
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>IDENTITAS</b></td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">NIP </td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <?= $row[B_02B]!='' ? print_nip_baru(trim($row[B_02B])) : print_nip($row[B_02]) ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">NAMA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <? echo print_nama($row['B_03A'],stripslashes($row['B_03']),$row['B_03B']); ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">TEMPAT/TANGGAL LAHIR</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><?=$row[B_04]?>
            / 
            <? echo format_tanggal_1($row['B_05']); ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">04.</td>
          <td width="27%">JENIS KELAMIN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <? if ($row['B_06']=='1') echo "LAKI-LAKI"; else echo "PEREMPUAN"; ?>
          </td>
        </tr>
		<tr> 
          <td width="2%" align="right">05.</td>
          <td width="27%">GOLONGAN DARAH</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["gd"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">06.</td>
          <td width="27%">AGAMA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <?
          switch($row['B_07'])
          {
          	case "1" : echo "ISLAM";break;
          	case "2" : echo "KRISTEN";break;
          	case "3" : echo "KATHOLIK";break;
          	case "4" : echo "HINDU";break;
          	case "5" : echo "BUDHA";break;
          }
          ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">07.</td>
          <td width="27%">STATUS</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <? if ($row['B_09']=='1') echo "CPNS"; else echo "PNS"; ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">08.</td>
          <td width="27%">JENIS KEPEGAWAIAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%">PNS Daerah Otonom</td>
        </tr>
        <tr> 
          <td width="2%" align="right">09.</td>
          <td width="27%">STATUS PERKAWINAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"> 
            <?
          switch($row['J_01'])
          {
          	case '1':echo "KAWIN";break;
          	case '2':echo "BELUM KAWIN";break;
          	case '3':echo "JANDA/DUDA";break;
          }
          ?>
          </td>
        </tr>
        <tr> 
          <td width="2%" align="right">10.</td>
          <td width="27%">KEDUDUKAN PEGAWAI</td>
          <td width="4%" align="center">:</td>
          <td width="49%">
          <?
          switch($row['B_11'])
          {
          	case '1' : echo "PEGAWAI AKTIF";break;
          	case '2' : echo "PEJABAT NEGARA";break;
          	case '3' : echo "CUTI DI LUAR TANGGUNGAN NEGARA";break;
          	case '4' : echo "PENERIMA UANG TUNGGU";break;
          	case '5' : echo "BEBAS TUGAS";break;
          	case '6' : echo "TUGAS BELAJAR";break;
          	case '7' : echo "SKORSING";break;
        }
        ?>
          </td>
        </tr>
        <tr> 
          <td valign="top" width="2%" align="right">11.</td>
          <td valign="top" width="27%">TINGKAT PENDIDIKAN SEKOLAH 
	    <td valign="top" width="4%" align="center">:</td>
          <td valign="top" width="49%"><?=tktDidik($row[H_1A])?></td>
          
        </tr>
        <tr> 
          <td valign="top" width="2%" align="right">12.</td>
          <td valign="top" width="27%">ALAMAT RUMAH</td>
          <td valign="top" width="4%" align="center">:</td>
          <td valign="top" width="49%"><? echo $row["B_12"]; ?></td>
        </tr>
		<tr> 
          <td valign="top" width="2%" align="right">13.</td>
          <td valign="top" width="27%">NO Telpon / HP</td>
          <td valign="top" width="4%" align="center">:</td>
          <td valign="top" width="49%"><? echo $row["B_NOTELP"]; ?></td>
        </tr>
        <tr> 
          <td width="2%" align="right">14.</td>
          <td width="27%">NOMOR KARPEG</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["B_08"]; ?></td>
        </tr>
        <tr> 
          <td width="2%" align="right">15.</td>
          <td width="27%">NOMOR KARTU ASKES</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["L_1A"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <?
        /*
        ?>
        <tr> 
          <td width="2%" align="right">13.</td>
          <td width="27%">KARTU TASPEN</td>
          <td width="4%" align="center">:</td>
          <td width="49%">&nbsp;</td>
          <td width="18%">&nbsp;</td>
        </tr>
        <?
        */
        ?>
        <tr> 
          <td width="2%" align="right">16.</td>
          <td width="27%">NOMOR KARIS/KARSU</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["L_04"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">17.</td>
          <td width="27%">NPWP</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["L_03"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
		<tr> 
          <td width="2%" align="right">18.</td>
          <td width="27%">N I K</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["nik"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>PENGANGKATAN SEBAGAI CPNS</b></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">NOMOR SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["D_02"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">TANGGAL SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row['D_03']); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">TMT CPNS</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row['D_04']); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">04.</td>
          <td width="27%">PANGKAT/GOLONGAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><?=namapkt($row[D_05])." (".pktH($row['D_05']).")" ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>PENGANGKATAN SEBAGAI PNS</b></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">NOMOR SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["E_02"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">TANGGAL SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row['E_03']); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">TMT PNS</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row['E_04']); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">04.</td>
          <td width="27%">PANGKAT/GOLONGAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><?=namapkt($row[E_05])." (".pktH($row['E_05']).")"?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">05.</td>
          <td width="27%">SUMPAH JANJI</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? if ($row['E_06']=='1') echo "SUDAH"; else echo "BELUM"; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>PANGKAT/GOLONGAN TERAKHIR</b></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <?
        	$pjb="select * from TABPJB where KODE='".$row['F_01']."'";
              	$res=mysql_db_query("kabpkl",$pjb);
                $ro=mysql_fetch_array($res);
                
               
          $rr="select * from MASTPKT1 where PF_01='$NIP' and PF_03='".$row['F_03']."'";
          $rr2=dbquery("kabpkl",$rr);
          $oo2=mysql_fetch_array($rr2);
         
                ?>
              
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">DITETAPKAN OLEH</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $ro['NAMA']; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">NOMOR SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $oo2["PF_04"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">TANGGAL SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row["F_02"]); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">04.</td>
          <td width="27%">PANGKAT/GOLONGAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><?=namapkt($row[F_03])." (".pktH($row['F_03']).")"?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">05.</td>
          <td width="27%">TMT PANGKAT</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($oo2["PF_06"]); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">06.</td>
          <td width="27%">MASA KERJA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo substr($row["F_04"],0,2)." TAHUN ".substr($row["F_04"],2,2)." BULAN"; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>KENAIKAN GAJI BERKALA TERAKHIR</b></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">TMT GAJI BERKALA</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row["G_01"]); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">MASA KERJA GAJI</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo substr($row["G_02"],0,2) ; ?> TAHUN <? echo substr($row["G_02"],2,2) ; ?> BULAN</td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">GAJI POKOK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo gaji($row["F_03"],substr($row["F_04"],0,2)); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="4" bgcolor="#CCCCCC"><b>JABATAN STRUKTURAL/FUNGSIONAL/FUNGSIONAL 
            UMUM</b></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right"></td>
          <td width="27%">JABATAN SAAT INI</td>
          <td width="4%" align="center">:</td>
          <td width="49%">
          <?
            switch($p[I_00])
            {
            	case "1"	: echo "Struktural";break;                                      
		case "2"	: echo "Fungsional tertentu";break;                             
		case "3"	: echo "Struktural dan Fungsional Tertentu (rangkap)";break;    
		case "4"	: echo "Fungsional Umum/Staf.";break;                           
		           
	    }
	    ?>  
          </td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">01.</td>
          <td width="27%">JAB. FUNG TERTENTU</td>
          <td width="4%" align="center">:</td>
          <td width="49%">
          <?if ($row[I_06]=='99' and $row[I_05] !='999') echo $row[I_JB]."&nbsp; TMT : ".format_tanggal($row[I_04])?> 
          </td>
          <td width="18%">&nbsp;</td>
        </tr>
        <?
        $pjb="select * from TABPJB where KODE='".$row['I_01']."'";
              $res=mysql_db_query($db,$pjb);
              $ro2=mysql_fetch_array($res)
              ?>
        <tr> 
          <td width="2%" align="right">02.</td>
          <td width="27%">DITETAPKAN OLEH</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $ro2['NAMA']; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">03.</td>
          <td width="27%">NOMOR SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["I_02"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">04.</td>
          <td width="27%">TANGGAL SK</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal($row["I_03"]); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">05.</td>
          <td width="27%">NAMA JABATAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo $row["I_JB"]; ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">06.</td>
          <td width="27%">TMT JABATAN</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo format_tanggal_1($row["I_04"]); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        <tr> 
          <td width="2%" align="right">07.</td>
          <td width="27%">ESELON</td>
          <td width="4%" align="center">:</td>
          <td width="49%"><? echo eselon($row['I_06']); ?></td>
          <td width="18%">&nbsp;</td>
        </tr>
        
        
        

      </table>
      </td>
    </tr>
    
  </table>
  <p STYLE="page-break-after: always"><font face="Arial" size="1">halaman 1</font></p>
  <? include ("CetakBaru_next.inc"); ?>
</body>
</html>
<?
}
else { ?>
<SCRIPT>window.close()</SCRIPT>
<?
}

mysql_close();
?>
