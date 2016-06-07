<?php
$totalRow=64;
$totalItem=64;
$thisNo=0;
$kosong=0;
$hal=1;
$NIP = $_GET['nip'];
            //  1      2      3        4        5        6         7         8         9        10           11          12        13     14     15       16      17        18 
$h=array( 1=> 'pktt','jabb','ttjasa','tugas','bahasa','dikumum','dikstru','dikfung','diktek','tatarnya','seminarnya','kursusnya','ayah','ibu','smistri','anak');
$t=array( 1=> 'MASTPKT1','MASTJAB1','MSTJASA1','MSTTGAS1','MSTBHSA1','MSTPEND1','MSTSTRU1','MSTFUNG1','MSTTEKN1','MSTPTAR1','MSTSEMI1','MSTKURS1','MSTORTU1','MSTORTU1','MASTKEL1','MASTKEL1');
$f=array( 1=> "where PF_01='$NIP'","where JF_01='$NIP'","where JS_01='$NIP'","where TG_01='$NIP'","where BS_01='$NIP'","where DK_01='$NIP'","where LT_01='$NIP'","where LT_01='$NIP'","where LT_01='$NIP'","where LT_01='$NIP'","where LT_01='$NIP'","where LT_01='$NIP'","where NM_01='$NIP' and NM_02='1'","where NM_01='$NIP' and NM_02='2'","where KF_01='$NIP' and KF_02='1'","where KF_01='$NIP' and KF_02='2'");
$o=array( 1=> "PF_06","JF_02","JS_01","TG_01","BS_01","DK_09","LT_01","LT_01","LT_01","LT_01","LT_01","LT_01","NM_01","NM_01","KF_01","KF_03");

?>

<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="700" id="AutoNumber1">

<?

//the sequence
$xi=1;
$hal=1;
for ($i=1;$i<=16;$i++)
{
	
	$jrec=getJmlBarisTabel($t[$i],$o[$i],$f[$i]);
	//echo $t[$i];
	if ($jrec > 0) {
		//$xno[$xi]=$i;
		$xjrec += $jrec;
		//echo $xjrec;
		switch($i) {
			case 13 : $xjrec +=3;break;
			case 14 : $xjrec +=3;break;
			case 15 : $xjrec +=4;break;
			default : $xjrec +=2;
		}
		
		
			if ($xjrec > $totalRow) {
				switch($i) {
					case 13 : $xK =3;break;
					case 14 : $xK =3;break;
					case 15 : $xK =4;break;
					default : $xK =2;
				}
				$dp=($xjrec-$totalRow)-$xK;
				
				if ($dp < 0) $dp=0;
				$jrec=getJmlBarisTabel($t[$i],$o[$i],$f[$i]);
				
				if ($dp==$jrec) {
					$hal++;
					
				        $q="select * from $t[$i] $f[$i] order by $o[$i]";
				        //echo $q;
					$r=mysql_query($q) or die (mysql_error());
					echo $h[$i]($r,$no,$NIP);
					$xjrec=$jrec+$xK;
					?>
					</table>
					<p STYLE="page-break-after: always"><font face="Arial" size="1">halamana <?=$hal?></font>�</p>
					<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="700" id="AutoNumber1">
					<?
				        
				}
				
				else { 
					$hal++;
					$limit=$jrec-$dp;
					$q="select * from $t[$i] $f[$i] order by $o[$i] limit 0,$limit";
                                        //echo $q;
					$r=mysql_query($q) or die (mysql_error());
					echo $h[$i]($r,$no,$NIP);
					?>
					</table>
					<p STYLE="page-break-after: always" align="center"><font face="Arial" size="1">halaman <?=$hal?></font>�</p>
					<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="700" id="AutoNumber1">
					<?
				        $limit2=$jrec-$limit;
				        if ($limit2 > 0) {
				        $no=$limit;
				        $q="select * from $t[$i] $f[$i] order by $o[$i] limit $limit,$limit2";
                                        //echo $q;
					$r=mysql_query($q) or die (mysql_error());
					echo $h[$i]($r,$no,$NIP);
					}
					$xjrec=$limit2+$xK;
					
					$no=0;
					
					
				}
				
			}
			elseif ($xjrec== $totalRow) { 
				switch($i) {
					case 13 : $xK =4;break;
					case 14 : $xK =3;break;
					case 15 : $xK =4;break;
					default : $xK =2;
				}
				$jrec=getJmlBarisTabel($t[$i],$o[$i],$f[$i]);
                                $limit=$jrec-2;
                                if ($t[$i] === 'MSTORTU1') {
                                    $q="select * from $t[$i] $f[$i] order by $o[$i]";
                                } else {
                                    $q="select * from $t[$i] $f[$i] order by $o[$i] limit 0,$limit";
                                }
				//echo $q;
				$r=mysql_query($q) or die (mysql_error());
				echo $h[$i]($r,$no,$NIP);
				$hal++;
				?>
				</table>
				<p STYLE="page-break-after: always" align="center"><font face="Arial" size="1">halaman <?=$hal?></font>�</p>
				<table border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111" width="700" id="AutoNumber1">
				<?
				$limit2=$jrec-$limit;
				$no=$limit;
				if ($t[$i] === 'MSTORTU1') {
                                    $q="select * from $t[$i] $f[$i] order by $o[$i]";
                                } else {
                                    $q="select * from $t[$i] $f[$i] order by $o[$i] limit 0,$limit";
                                }
				//echo $q;
				$r=mysql_query($q) or die (mysql_error());
				echo $h[$i]($r,$no,$NIP);
				$xjrec=$limit2+$xK;
				$no=0;  
			}
				
			else {
				$q="select * from $t[$i] $f[$i] order by $o[$i]";
				
				$r=mysql_query($q) or die (mysql_error());
				echo $h[$i]($r,$no,$NIP);	
			}
	$xi++;	
	}
}
//for ($i=1;$i<=sizeOf($xno);$i++) echo $t[$xno[$i]]."\n";	
?>	
	
</table>
<?
$space=($totalRow-$xjrec);
$space = $space-2;
for ($i=1;$i<$space;$i++) echo "<font face=\"Arial\" size=\"2\"><br>&nbsp;</font>";
$hal++;
?>
<font face="Arial" size="1">halaman <?=$hal?></font>
