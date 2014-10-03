<?
function pktt($h,$no,$NIP) 
{
	?>
	<tr> 
    <td bgcolor="CCCCCC"><b>RIWAYAT PANGKAT (GOLONGAN RUANG)</b></td>
  </tr>
  <tr> 
    <td> 
    <table width="99%" cellspacing="0" cellpadding="1" border="1" style="border-collapse: collapse" bordercolor="#111111">
              <tr align="center" bgcolor="DDDDDD"> 
                <td width="3%"><b>NO</b></td>
                <td width="32%"><b>PANGKAT (GOL/RUANG)</b></td>
                <td width="40%"><b>NO SURAT KEPUTUSAN</b></td>
                <td width="12%"><b>TGL SK</b></td>
                <td width="12%"><b>TMT</b></td>
              </tr>
              <? 
              while ($row=mysql_fetch_array($h))
              {
              	$i++;
              ?>
              <tr> 
                <td width="3%" align="right" ><?=$i?>.</td>
                <td width="32%"  align="center"><?=namapkt($row[PF_03])." (".pktH($row['PF_03']).")"; ?></td>
                <td width="40%"><? if (strlen($row['PF_04']) == 0 ) echo "&nbsp;"; else echo $row['PF_04']; ?></td>
                <td width="12%" align="center"><?=format_tanggal($row['PF_05']); ?></td>
                <td width="12%" align="center" ><?=format_tanggal($row['PF_06']); ?></td>
              </tr>
              <?
              }
              ?>
            </table>
    
    </td>
  </tr>
	
	<?
}

function jabb($h,$no,$NIP)
{
	?>
	<tr> 
    <td bgcolor="CCCCCC"><b>RIWAYAT JABATAN</b></td>
  </tr>
  <tr> 
    <td> 
      
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td width="3%" align="center"><b>NO</b></td>
            <td width="42%" align="center"><b>NAMA JABATAN</b></td>
            <td width="6%" align="center"><b>ESELON</b></td>
            <td width="26%" align="center"><b>NOMOR SK</b></td>
            <td width="11%" align="center"><b>TGL SK</b></td>
            <td width="11%" align="center"><b>TMT JAB</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td width="3%" align="right"><?=$no.'.'; ?></td>
            <td width="42%" ><?=$row["JF_03"]; ?> <?=namaLokasiKerja($row[A_01].$row[A_02].$row[A_03].'00')?></td>
            <td width="6%" align="center"><? if ($row['JF_04']!='99') echo eselon($row["JF_04"]);else echo "-"; ?></td>
            <td width="26%" ><?=$row["JF_05"]; ?></td>
            <td width="11%" align="center"><?=format_tanggal($row['JF_06']); ?></td>
            <td width="11%" align="center"><?=format_tanggal($row['JF_07']); ?></td>
          </tr>
          <?
        }
        ?>
        </table>
     
    </td>
  </tr>
  <?
}
function ttjasa($h,$no,$NIP)
{
	?>
	<tr> 
    <td bgcolor="CCCCCC"><b>RIWAYAT TANDA JASA</b></td>
  </tr>
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA PENGHARGAAN</b></td>
            <td align="center"><b>NOMOR SK</b></td>
            <td align="center"><b>TANGGAL</b></td>
            <td align="center"><b>TAHUN</b></td>
            <td align="center"><b>ASAL </b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr>
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row["JS_03"]; ?></td>
            <td ><?=$row["JS_04"]; ?></td>
            <td align="center"><?=format_tanggal($row['JS_05']); ?></td>
            <td align="center"><?=$row["JS_06"]; ?></td>
            <td ><?=$row["JS_07"]; ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function tugas($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT PENUGASAN KE LUAR NEGERI</b></td>
  </tr>
  <tr> 
    <td> 
      <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
        <tr bgcolor="dddddd"> 
          <td align="center" width="3%"><b>NO</b></td>
          <td align="center"><b>NEGARA</b></td>
          <td align="center"><b>JENIS</b></td>
          <td align="center"><b>PEJABAT YANG MENETAPKAN </b></td>
          <td align="center"><b>NOMOR SK</b></td>
          <td align="center" width="11%"><b>TGL SK </b></td>
          <td align="center" width="11%"><b>MULAI</b></td>
          <td align="center" width="11%"><b>SELESAI</b></td>
        </tr>
        <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
        <tr> 
          <td align="right" width="3%"><?=$no.'.'; ?></td>
          <td ><?=$row["TG_03"]; ?></td>
          <td ><?=$row["TG_04"]; ?></td>
          <td ><?=$row["TG_05"]; ?></td>
          <td ><?=$row["TG_06"]; ?></td>
          <td align="center" width="11%"><?=format_tanggal($row["TG_07"]); ?></td>
          <td align="center" width="11%"><?=format_tanggal($row["TG_08"]); ?></td>
          <td align="center" width="11%"><?=format_tanggal($row["TG_09"]); ?></td>
        </tr>
        <?
        }
        ?>
      </table>
    </td>
  </tr>
  <?
}
function bahasa($h,$no,$NIP)
{
	?>
	
  <tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>PENGUASAAN BAHASA</b></td>
  </tr>
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>JENIS BAHASA</b></td>
            <td align="center"><b>NAMA BAHASA</b></td>
            <td align="center"><b>KEMAMPUAN</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row["BS_03"]; ?></td>
            <td ><?=$row["BS_04"]; ?></td>
            <td ><?=$row["BS_05"]; ?></td>
          </tr>
          <?
	}
	?>
        </table>
      
    </td>
  </tr>
  <?
}
function dikumum($h,$no,$NIP)
{
	?>
	  <tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT PENDIDIKAN UMUM</b></td>
  </tr>
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>TINGKAT</b></td>
            <td align="center"><b>JURUSAN</b></td>
            <td align="center"><b>NAMA SEKOLAH</b></td>
            <td align="center"><b>NO. IJAZAH</b></td>
            <td align="center" width="8%"><b>LULUS</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row["DK_03"]; ?></td>
            <td ><?=$row["DK_04"]; ?></td>
            <td ><?=$row["DK_05"]; ?></td>
            <td ><?=$row[DK_08]?></td>
            <td align="center" width="8%"><?=substr($row["DK_09"],0,4); ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function dikstru($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT DIKLAT STRUKTURAL</b></td>
  </tr>
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA DIKLAT</b></td>
            <td align="center"><b>TEMPAT</b></td>
            <td align="center"><b>PENYELENGGARA</b></td>
            <td align="center" width="11%"><b>MULAI</b></td>
            <td align="center" width="11%"><b>SELESAI</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['LT_03']; ?></td>
            <td ><?=$row['LT_04']; ?></td>
            <td ><?=$row['LT_05']; ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function dikfung($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT DIKLAT FUNGSIONAL</b></td>
  </tr>
  <tr> 
    <td> 
      <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
        <tr bgcolor="dddddd"> 
          <td align="center" width="3%"><b>NO</b></td>
          <td align="center"><b>NAMA DIKLAT</b></td>
          <td align="center"><b>TEMPAT</b></td>
          <td align="center"><b>PENYELENGGARA</b></td>
          <td align="center" width="11%"><b>MULAI</b></td>
          <td align="center" width="11%"><b>SELESAI</b></td>
        </tr>
        <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
        <tr> 
          <td align="right" width="3%"><?=$no.'.'; ?></td>
          <td ><?=$row['LT_03']; ?></td>
          <td ><?=$row['LT_04']; ?></td>
          <td ><?=$row['LT_05']; ?></td>
          <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
          <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
        </tr>
        <?
        }
        ?>
      </table>
    </td>
  </tr>

<?
}
function diktek($h,$no,$NIP)
{
	?>
	
  <tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT DIKLAT TEKNIS</b></td>
  </tr>
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA DIKLAT</b></td>
            <td align="center"><b>TEMPAT</b></td>
            <td align="center"><b>PENYELENGGARA</b></td>
            <td align="center" width="11%"><b>MULAI</b></td>
            <td align="center" width="11%"><b>SELESAI</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['LT_03']; ?></td>
            <td ><?=$row['LT_04']; ?></td>
            <td ><?=$row['LT_05']; ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function tatarnya($h,$no,$NIP)
{
	?>
	
  <tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT PENATARAN</b></td>
  </tr>
  <tr> 
    <td> 
      <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
        <tr bgcolor="dddddd"> 
          <td align="center" width="3%"><b>NO</b></td>
          <td align="center"><b>NAMA PENATARAN</b></td>
          <td align="center"><b>TEMPAT</b></td>
          <td align="center"><b>PENYELENGGARA</b></td>
          <td align="center"><b>JAM</b></td>
          <td align="center" width="11%"><b>MULAI</b></td>
          <td align="center" width="11%"><b>SELESAI</b></td>
        </tr>
        <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['LT_03']; ?></td>
            <td ><?=$row['LT_04']; ?></td>
            <td ><?=$row['LT_05']; ?></td>
            <td align="center"><?=$row['LT_09']; ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
          </tr>
          <?
        }
        ?>
      </table>
    </td>
  </tr>
  <?
}

function seminarnya($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT SEMINAR/LOKAKARYA/SIMPOSIUM</b></td>
  </tr>
  <tr> 
    <td> 
      <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
        <tr bgcolor="dddddd"> 
          <td align="center" width="3%"><b>NO</b></td>
          <td align="center"><b>NAMA SEMINAR/LOKAKARYA/SIMPOSIUM</b></td>
          <td align="center"><b>TEMPAT</b></td>
          <td align="center"><b>PENYELENGGARA</b></td>
          <td align="center"><b>JAM</b></td>
          <td align="center" width="11%"><b>MULAI</b></td>
          <td align="center" width="11%"><b>SELESAI</b></td>
        </tr>
                <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['LT_03']; ?></td>
            <td ><?=$row['LT_04']; ?></td>
            <td ><?=$row['LT_05']; ?></td>
            <td align="center"><?=$row['LT_09']; ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
          
          </tr>
          <?
        }
        ?>
      </table>
    </td>
  </tr>
  <?
}

function kursusnya($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>RIWAYAT KURSUS DI DALAM DAN LUAR NEGERI</b></td>
  </tr>
  
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA KURSUS</b></td>
            <td align="center"><b>TEMPAT</b></td>
            <td align="center"><b>PENYELENGGARA</b></td>
            <td align="center"><b>JAM</b></td>
            <td align="center" width="11%"><b>MULAI</b></td>
            <td align="center" width="11%"><b>SELESAI</b></td>
          </tr>
          <?
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['LT_03']; ?></td>
            <td ><?=$row['LT_04']; ?></td>
            <td ><?=$row['LT_05']; ?></td>
            <td align="center"><?=$row['LT_09']; ?> </td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_07']); ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['LT_08']); ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}
function ayah($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>DATA ORANG TUA KANDUNG</b></td>
  </tr>
  <tr><td>
  <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
  <?
  
  $row=mysql_fetch_array($h);
  ?>
  	<tr bgcolor="#CCCCCC"> 
          <td width="100%" colspan="4"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA AYAH&nbsp;:</b></td>
        </tr>
        <tr> 
          <td  width="3%" align="right">1.</td>
          <td  width="19%">NAMA AYAH</td>
          <td  width="4%" align="center">:</td>
          <td><?=$row['NM_04']; ?></td>
          
        </tr>
   	<tr> 
          <td  width="3%" align="right">2.</td>
          <td  width="19%">TEMPAT/TGL LAHIR</td>
          <td  width="4%" align="center">:</td>
          <td><?=$row['NM_05']."/".format_tanggal($row['NM_06']); ?></td>
          
        </tr>
        <tr> 
          <td  width="3%" align="right">3.</td>
          <td  width="19%">ALAMAT</td>
          <td  width="4%" align="center">:</td>
          <td><?=$row['NM_07']; ?></td>
          
        </tr>
  </table>
  </td></tr>
  <?
}
function ibu($h,$no,$NIP)
{
	?>
  <tr><td>
  <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
  <?

  $row=mysql_fetch_array($h);
  ?>
  	<tr bgcolor="#CCCCCC"> 
          <td width="100%" colspan="4"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA IBU&nbsp;:</b></td>
        </tr>
        <tr> 
          <td  width="3%" align="right">1.</td>
          <td  width="19%">NAMA IBU</td>
          <td  width="4%" align="center">:</td>
          <td><?=$row['NM_04']; ?></td>
          
        </tr>
   	<tr> 
          <td   width="3%" align="right">2.</td>
          <td   width="19%">TEMPAT/TGL LAHIR</td>
          <td   width="4%" align="center">:</td>
          <td><?=$row['NM_05']."/".format_tanggal($row['NM_06']); ?></td>
          
        </tr>
        <tr> 
          <td   width="3%" align="right">3.</td>
          <td   width="19%">ALAMAT</td>
          <td   width="4%" align="center">:</td>
          <td><?=$row['NM_07']; ?></td>
          
        </tr>
  </table>
  </td></tr>
  <?
}

function smistri($h,$no,$NIP)
{
	$xx=mysql_fetch_array(mysql_query("select B_06 from MASTFIP08 where B_02='$NIP' LIMIT 1"));
	$jk=$xx[B_06];
	if ($jk=='1') $jdl='DATA ISTRI'; else $jdl='DATA SUAMI';
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b><?=$jdl?></b></td>
  </tr>
  <tr><td>
  <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
  <?
  
  $row=mysql_fetch_array($h);
  ?>
  	
        <tr> 
          <td width="3%" align="right">1.</td>
          <td width="19%">NAMA</td>
          <td width="4%" align="center">:</td>
          <td><?=$row['KF_04']; ?></td>
              
        </tr> 
   	<tr>  
          <td width="3%" align="right">2.</td>
          <td width="19%">TEMPAT/TGL LAHIR</td>
          <td width="4%" align="center">:</td>
          <td><?=$row['KF_09']."/".format_tanggal($row['KF_05']); ?></td>
              
        </tr> 
        <tr>  
          <td width="3%" align="right">3.</td>
          <td width="19%">TANGGAL MENIKAH</td>
          <td width="4%" align="center">:</td>
          <td><?=format_tanggal($row['KF_06']); ?></td>
              
        </tr> 
        <tr>  
          <td width="2%" align="right">4.</td>
          <td width="19%">TUNJANGAN</td>
          <td width="4%" align="center">:</td>
          <td><? if ($row['KF_07']=='D') echo "DAPAT";else echo "TIDAK DAPAT"; ?></td>
          
        </tr>
  </table>
  </td></tr>
  <?
}

function anak($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>DATA ANAK</b></td>
  </tr>
  
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA ANAK</b></td>
            <td align="center" width="22%"><b>TEMPAT LAHIR</b></td>
            <td align="center" width="11%"><b>TGL LAHIR</b></td>
            <td align="center" width="11%"><b>JNS KEL</b></td>
            <td align="center" width="11%"><b>STATUS</b></td>
            <td align="center" width="11%"><b>TUNJANGAN</b></td>
          </tr>
          <?
          
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['KF_04']; ?></td>
            <td ><?=$row['KF_09']; ?></td>
            <td align="center" width="11%"><?=format_tanggal($row['KF_05']); ?></td>
            <td align="center" width="11%"><?=$row['KF_10']; ?></td>
            <td align="center" width="11%"><? if ($row['KF_08']=='K') echo "KANDUNG";else if ($row['KF_08']=='T') echo "TIRI";else if ($row['KF_08']=='A') echo "ANGKAT"; ?></td>
            <td align="center" width="11%"><? if ($row['KF_07']=='D') echo "DAPAT";else echo "TIDAK DAPAT"; ?></td>
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function profesi($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>PENDIDIKAN PROFESI</b></td>
  </tr>
  
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA PROFESI</b></td>
            <td align="center" width="22%"><b>TAHUN</b></td>
            
          </tr>
          <?
          
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row[PR_03]?></td>
            <td ><?=$row[PR_04]?></td>
            
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}

function tupoksi($h,$no,$NIP)
{
	?>
	<tr bgcolor="#CCCCCC"> 
    <td bgcolor="#CCCCCC"><b>URAIAN RINGKAS PEKERJAAN/TUGAS</b></td>
  </tr>
  
  <tr> 
    <td> 
       
        <table width="99%" border="1" cellspacing="0" cellpadding="1" style="border-collapse: collapse" bordercolor="#111111">
          <tr bgcolor="dddddd"> 
            <td align="center" width="3%"><b>NO</b></td>
            <td align="center"><b>NAMA PEKERJAAN/TUGAS</b></td>
            
          </tr>
          <?
          
        
        while ($row=mysql_fetch_array($h))
        {
        	$no++;
        	?>
          <tr> 
            <td align="right" width="3%"><?=$no.'.'; ?></td>
            <td ><?=$row['TP_03']; ?></td>
            
          </tr>
          <?
        }
        ?>
        </table>
      
    </td>
  </tr>
  <?
}


?>
