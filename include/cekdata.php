<?
include('include/config.inc');
include('include/fungsi.inc');

$q1="select B_02 from MASTFIP08 where A_01<>'99' and (D_05='' or D_05 is null or D_05='-')";
$r1=mysql_query($q1);

$qg="select B_02 from MASTFIP08 where A_01<>'99' and (F_03='' or F_03 is null or F_03='-')";
$rg=mysql_query($qg);

$qa="select B_02 from MASTFIP08 where A_01<>'99' and (B_07='' or B_07 is null or B_07='-')";
$ra=mysql_query($qa);

$qs="select B_02 from MASTFIP08 where A_01<>'99' and (B_09='' or B_09 is null or B_09='-')";
$rs=mysql_query($qs);

$qt="select B_02 from MASTFIP08 where A_01<>'99' and (B_05='' or B_05='0000-00-00' or B_05 is null)";
$rt=mysql_query($qt);

$qd="select B_02 from MASTFIP08 where A_01<>'99' and (H_1A='' or H_1A='-' or H_1A is null)";
$rd=mysql_query($qd);

$qk="select B_02 from MASTFIP08 where A_01<>'99' and J_01<>'1' and J_01<>'2' and J_01<>'3'";
$rk=mysql_query($qk);
?>
<table>
<tr><td class="componentheading">CEK DATA KOSONG</td></tr>
<tr><td>
<table border="1" width="100%" id="table1" style="border-collapse: collapse" cellspacing="0" cellpadding="0" bordercolor="#000000">
	
	<tr>
		<td width="151">Golongan CPNS</td>
		<td>
		<?
		while ($ro1=mysql_fetch_array($r1)) {
			echo "<a href='index.htm?sid=$sid&do=cari&nip=$ro1[0]&cari=NIP'>"."$ro1[0] "."; ";
		}?>

		</td>
	</tr>






	<tr>
		<td width="151">Golongan Sekarang</td>
		<td>
		<?
		while ($rog=mysql_fetch_array($rg)) {
			echo $rog[0]."; ";
		}?>
		</td>
	</tr>
	<tr>
		<td width="151">Status Kepegawaian</td>
		<td>
		<?
		while ($ros=mysql_fetch_array($rs)) {
			echo $ros[0]."; ";
		}?>
		</td>
	</tr>
	<tr>
		<td width="151">Agama</td>
		<td>
				<?
		while ($roa=mysql_fetch_array($ra)) {
			echo $roa[0]."; ";
		}?>
		</td>
	</tr>
	<tr>
		<td width="151">Tanggal lahir</td>
		<td>
		<?
		while ($rot=mysql_fetch_array($rt)) {
			echo $rot[0]."; ";
		}?>
		</td>
	</tr>
        <tr>
                <td width="151">Pendidikan</td>
                <td>
                <?
                while ($rod=mysql_fetch_array($rd)) {
                        echo $rod[0]."; ";
                }?>
                </td>
        </tr>
        <tr>
                <td width="151">Status Perkawinan</td>
                <td>
                <?
                while ($rok=mysql_fetch_array($rk)) {
                        echo $rok[0]."; ";
                }?>
                </td>
        </tr>
</table>
</td></tr>
</table>