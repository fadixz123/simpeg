<?

echo "&nbsp;HASIL PENCARIAN";
if ($namacari !='')
{
	if ($ukcari=='all')
	$q="select * from MASTFIP1 where B_03 LIKE '%$namacari%' order by F_03 DESC,I_05,I_06 DESC";
	else
	$q="select * from MASTFIP1 where B_03 LIKE '%$namacari%' and A_01='$ukcari' order by F_03 DESC,I_05,I_06 DESC";
	$r=mysql_query($q) or die (mysql_error());
	?>
		<table width="100%" border="0" cellspacing="1" cellpadding="1">
	        <tr align="center" bgcolor="#FFCC33"> 
	          <td width="17%"><strong>NIP</strong></td>
	          <td width="41%"><strong>NAMA</strong></td>
	          <td width="42%"><strong>UNIT KERJA<br>JABATAN</strong></td>
	        </tr>
	<?
	$no=0;
	while ($row=mysql_fetch_array($r))
	{
		$no++;
		
		$q2="select NM from TABLOK where substring(KD,1,2)='$row[A_01]' LIMIT 1";
		
		$oo=mysql_fetch_array(mysql_query($q2));
		
	?>
	        <tr bgcolor="<? if (($no % 2)==0) echo "#CCCCCC"; else echo "#DDDDDD";?>">
	          <td valign="top"><a href="?do=home&act=caripns&nipcari=<?=$row[B_02]?>"><?=$row[B_02]?></a></td>
	          <td valign="top"><?=print_nama($row[B_03A],$row[B_03],$row[B_03B]);?></td>
	          <td valign="top"><?=$oo[NM]?><br><?=$row[I_JB]?></td>
	        </tr>
	<?
	}
	?>

      		</table>
<?
}
?>