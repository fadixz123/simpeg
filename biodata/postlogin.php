<?
include("../include/config.inc");
include("../include/fungsi.inc");
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);

	if ($cekYT=='YA') {
		$qAdd="insert into MASTFIP1 set B_02='$NIP'";
		mysql_query($qAdd) or die(mysql_error());
	}
	else if ($cekYT=='TIDAK') $NIP='';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>:: e-PersonalSystem ::</TITLE>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT LANGUAGE="javascript" SRC="edit.js"></SCRIPT>
</HEAD>
<BODY BGCOLOR=#FFFFFF LEFTMARGIN=0 TOPMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0
onLoad="
<?
if (strlen($NIP)==0) echo "cekNIP.NIP.focus()";
?>">
<TABLE WIDTH=800 BORDER=0 CELLPADDING=0 CELLSPACING=0>
<!------------- input NIP ------------>
<?
if (strlen($NIP)==0) {
	?>
	<tr>
	<td width="800" height="1"></td>
	</tr>
	<tr>
	  <td align="center" valign="top" class="componentheading">
	     <table width="100%" cellpadding="0" cellspacing="0" border="0">
	     <form name="cekNIP" method="post" action="postlogin.php?sid=<?=$sid?>&do=awal">
	     <tr bgcolor="#006600" class="sectiontableheader" height="30">
	       <td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masukkan NIP
	       </td>
	       <td width="1%">:
	       </td>
	       <td width="59%">
	       <input type="text" name="NIP" maxlength="9" width="20" >
	       <input name="cariNIP" type="submit" value="CARI NIP">
	       </td>
	       <td width="20%" align="center"><a href="logout.php?sid=<?=$sid?>">Keluar</a>
	       </td>
	     </tr>
	     </form>
	     </table>	
	  </td>
	</tr>
<!------------------------------------>

<!------------ NIP have inputted --------------->	
	<?
}
else if (strlen($NIP)!=0) {
	
	$q="select B_02,B_03A,B_03,B_03B from MASTFIP1 where B_02='$NIP' LIMIT 1";
	$r=mysql_query($q) or die(mysql_error());
	if (mysql_num_rows($r)==0) {
		
		?>
		<tr>
		<td height="1" class="componentheading"></td>
		</tr>
		<form name="cekNIPAgain" method="post" action="postlogin.php?sid=<?=$sid?>&do=cari">
		<input type="hidden" name="NIP" value="<?=$NIP?>">
		<tr bgcolor="#86B0B3" height="30">
		<td height="30" bgcolor="#006600" class="sectiontableheader">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIP Belum ADA, akan ditambah?
		<input type="submit" name="cekYT" value="YA">
		<input type="submit" name="cekYT" value="TIDAK">
		</td>
		</tr>
		</form>
		<tr>
		<td>&nbsp;</td>
		</tr>
	<?
	}
	else if(mysql_num_rows($r)==1) {
		$sid2=md5(date("H:i:s").date("Y-m-d"));
		$row=mysql_fetch_array($r);
		?>
		<tr>
		<td height="1"></td>
		</tr>
		<tr>
	  	  <td align="center" valign="top">
	     	  <table width="100%" cellpadding="0" cellspacing="0" border="0">
	     	    <tr height="15">
	     	      <td valign="top" class="sectiontableheader">
	     	      	  | 
	     	          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=awal&NIP=<?=$NIP?>">Awal</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=lokid&NIP=<?=$NIP?>">Lokasi&amp;Identitas</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=cpnspns&NIP=<?=$NIP?>">CPNS&PNS</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=pkt&NIP=<?=$NIP?>">Pkt&amp;Gaji</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=jab&NIP=<?=$NIP?>">JabAkhir</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=dik&NIP=<?=$NIP?>">DikAkhir</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=ortu&NIP=<?=$NIP?>">Ortu</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=smistri&NIP=<?=$NIP?>">Suami/Istri</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=anak&NIP=<?=$NIP?>">Anak</a>
                          | 
                          <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=pupns&NIP=<?=$NIP?>"">PUPNS</a>
                          | 
                          <a href="logout.php?sid=<?=$sid?>&sid2=<?=$sid2?>&NIP=<?=$NIP?>">
                          KELUAR!</a>
                      </td>
                      </tr>
                      <tr height="25">
                      <td valign="top" class="sectiontableheader">
                          |
                             Riwayat &nbsp;
                           <select size="1" name="do"  onChange="window.location='postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do='+this.value+'&NIP=<?=$NIP?>'">
                              <option value="">Pilih Riwayat</option>
                              <option value="rpk" <? if ($page=='rpk') echo "selected"?>>RIWAYAT PANGKAT</option>
  	    		               <option value="rjb"  <? if ($page=='rjb') echo "selected"?>>RIWAYAT JABATAN</option>
  	    		               <option value="rtj"  <? if ($page=='rtj') echo "selected"?>>RIWAYAT TANDA JASA</option>
  	    		               <option value="rtg"  <? if ($page=='rtg') echo "selected"?>>RIWAYAT TUGAS KE LUAR NEGERI</option>
  			                   <option value="bhs"  <? if ($page=='bhs') echo "selected"?>>PENGUASAAN BAHASA</option>
  			                   <option value="rdu"  <? if ($page=='rdu') echo "selected"?>>RIWAYAT PENDIDIKAN UMUM</option>
  			                   <option value="rst"  <? if ($page=='rst') echo "selected"?>>RIWAYAT DIKLAT STRUKTURAL</option>
  			                   <option value="rfu"  <? if ($page=='rfu') echo "selected"?>>RIWAYAT DIKLAT FUNGSIONAL</option>
  			                   <option value="rdt"  <? if ($page=='rdt') echo "selected"?>>RIWAYAT DIKLAT TEKNIS</option>
  			                   <option value="rpt"  <? if ($page=='rpt') echo "selected"?>>RIWAYAT PENATARAN</option>
  			                   <option value="rsm"  <? if ($page=='rsm') echo "selected"?>>RIWAYAT SEMI/LOKA/SIMP</option>
  			                   <option value="rku"  <? if ($page=='rku') echo "selected"?>>RIWAYAT
  			                   KURSUS DI DLM & LUAR NEGERI</option>
                             </select>
                        | 
                        <a href="postlogin.php?sid=<?=$sid?>&sid2=<?=$sid2?>&do=pupns&NIP=">NIP Lain</a>
                        
	     	      </td>
	     	    </tr>
	     	  </table>
	     	  </td>
	     	</tr>
	     	<tr>
		<td height="1"></td>
		</tr>
		<tr bgColor="#999999" height="20">
		<td height="20" bgcolor="#CCCCCC" class="sectiontableheader" >| NIP : 
		  <?=$NIP?> 
		  | 
		  <?=namaPNS($row[B_03A],stripslashes($row[B_03]),$row[B_03B])?> 
		  |</td>
		</tr>
		<tr>
		  <td valign="top" align="center">
		  <?
			switch ($page)
			{
				case "awal" 	: include ("awal.inc");break;
				case "lokid"	: include ("lokid.inc");break;
				case "cpnspns"	: include ("cpnspns.inc");break;
				case "pkt"	: include ("pktgaji.inc");break;
				case "dik"	: include ("dik.inc");break;
				case "jab"	: include ("jabatan.inc");break;
				case "rpk"	: include ("rpkt.inc");break;
				case "rjb"	: include ("rjab.inc");break;
				case "rtj"	: include ("rtj.inc");break;
				case "rtg"	: include ("rln.inc");break;
				case "bhs"	: include ("bahasa.inc");break;
				case "rdu"	: include ("rdikum.inc");break;
				case "rst"	: include ("rdikstru.inc");break;
				case "rfu" 	: include ("rdikfung.inc");break;
				case "rdt" 	: include ("rdiktekn.inc");break;
				case "rpt" 	: include ("rtatar.inc");break;
				case "rsm" 	: include ("rsemi.inc");break;
				case "rku" 	: include ("rkursus.inc");break;
				case "ortu"	: include ("ortu.inc");break;
				case "smistri"	: include ("smistri.inc");break;
				case "anak"	: include ("anak.inc");break;
				case "pupns"	: include ("pupns.inc");break;
				
			}
		  ?>	
		  </td>
		</tr>
		<?
	}
}
?>
<!------------------------------------>

<!------------ footer ---------------->
<!------------------------------------>
</table>
</body>
</html>
<?
mysql_close();
}
else {
	mysql_close();	
	header("Location:index.htm");
}
?>
