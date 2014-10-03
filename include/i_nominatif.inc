            <?
		if ($unitkerja !='')
		{
		$tahun=date("Y");
		$thskr=$tahun-56;
		$tglok=$thskr."-".date("m")."-".date("d");
		if ($gol1=='') $gol1='11';
		if ($gol2=='') $gol2='45';
		$aEs=array(1=>'1A','1B','2A','2B','3A','3B','4A','4B','5A');
		$aNama=array(1=>'IA','IB','IIA','IIB','IIIA','IIIB','IVA','IVB','VA');
		$aGol=array(1=>'11','12','13','14','21','22','23','24','31','32','33','34','41','42','43','44','45');
		$aNama=array(1=>'I/a','I/b','I/c','I/d','II/a','II/b','II/c','II/d','III/a','III/b','III/c','III/d','IV/a','IV/b','IV/c','IV/d','IV/e');
		
		//----------- processing nominatif here ------
		
		if ($unitkerja=='xx')
		$query="select A_01,B_02, B_03A, B_03, B_03B, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2. "' and substring(B_05,1,4) >= $thskr order by F_03 DESC,F_02 ASC, F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC";
		else
		$query="select A_01,B_02, B_03A, B_03, B_03B, F_03, F_02, F_04, H_4A, H_1A, H_02, B_05, I_JB, I_06 from MASTFIP1 where A_01 ='".substr($unitkerja,0,2)."' and F_03 >= '" . $gol1. "' and F_03 <= '" . $gol2. "' and substring(B_05,1,4) >= $thskr order by F_03 DESC,F_02 ASC, F_04 DESC, H_4A ASC, H_1A DESC, H_02 ASC, B_05 ASC";
echo $query;
		?>
<table border="0" cellpadding="2" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber5">
      <tr>
        <td width="100%" valign="top">
	<table border="1" cellpadding="2" style="border-collapse: collapse; border-style: dotted; border-width: 1" bordercolor="#111111" width="100%" height="300" bgcolor="#FFEEBF">
          <tr><td align="center" >HASIL :</td></tr>
          <tr>
            <td width="100%" valign="top" align="center" height="100%" bgcolor="#FFFFFF">
		
		<table border="1" style="border-collapse: collapse" bordercolor="#111111" width="568" id="AutoNumber1">
		  <tr>
		    <td width="31" align="center" bgcolor="#DDDDDD"><b>NO</b></td>
		    <td width="80" align="center" bgcolor="#DDDDDD"><b>NIP</b></td>
		    <td width="177" align="center" bgcolor="#DDDDDD"><b>NAMA</b></td>
		    <td width="177" align="center" bgcolor="#DDDDDD"><b>TGL LAHIR</b></td>
		    <td width="182" align="center" bgcolor="#DDDDDD"><b>JABATAN</b></td>
		    <td width="45" align="center" bgcolor="#DDDDDD"><b>ESEL</b></td>
		    <td width="46" align="center" bgcolor="#DDDDDD"><b>G/R</b></td>
		  </tr>
		  <?
		  $no=0;
		  $r=mysql_query($query) or die (mysql_error());
		  while ($row=mysql_fetch_array($r))
		  {
		  	$no++;
		  	?>
		  <tr class="td2">
		    <td valign="top" class="td2" width="31" align="right"><?=$no?></td>
		    <td valign="top" class="td2" width="80" align="center"><?=$row[B_02]?></td>
		    <td valign="top" class="td2" width="177"><?=print_nama($row[B_03A],$row[B_03],$row[B_03B])?></td>
		    <td valign="top" class="td2" width="177"><?=$row[B_05]?></td>
		    <td valign="top" class="td2" width="182"><?=$row[I_JB]?></td>
		    <td valign="top" class="td2" width="45" align="center"><?=eselon2($row[I_06])?></td>
		    <td valign="top" class="td2" width="46" align="center"><?=pktH($row[F_03])?></td>
		  </tr>
		  	<?
		  }
		  ?>
		</table>
		<?
		}
		?>
          </td>
          </tr>
        </table>
        </td>
        
    </table>
