
  <TR valign="top"> 
    <TD colspan="4">
      <table width="638" border="0" cellspacing="0" cellpadding="0">
        <tr valign="top"> 
          <td rowspan="4" width="126"> 
<? include ("tgluhui.php"); ?>
          </td>
          <td width="509" align="right"><b><font face="Tahoma" size="2">Portal 
            Kepegawaian Propinsi Jawa Tengah&nbsp;</b></td>
        </tr>
        <tr> 
          <td width="509" align="right"><b></b></td>
        </tr>
        <tr> 
          <td align="right" width="509"><img src="images/submenustruktur.gif" width="125" height="50"></td>
        </tr>
        <tr> 
        <form name="struktur" action="?&sid=<? echo $sid; ?>&do=struktur" method="post">
          <td width="509" align="right" valign="bottom" height="28" style="border-bottom-style: none; border-bottom-width: medium"><font face="Tahoma" size="1"><b><font size="2">
            &nbsp;Unit Kerja 
            <select name="unitkerja" class="button1" onChange="ganti(this,'unitkerja','?&sid=&do=struktur')">
            <option value="">--Pilih--</option>
            <?
            $q="select * from TABLOK where substring(kd,1,2) != '99' order by kd";
            $r=mysql_db_query("bkd",$q) or die (mysql_error());
            while ($row=mysql_fetch_array($r))
            {
            	?>
            	<option value="<?=substr($row['kd'],0,2)?>" <? if (substr($row['kd'],0,2)==$unitkerja) echo "selected"?> ><?=$row[nm]?></option>
            	<?
            }
            ?>
            </select>
            &nbsp; 
            <?
            $myfile="struktur/".$unitkerja.".php";
            if (!file_exists($myfile)) $unitkerja='belum';
	    
            ?>
            <input type="button" name="Submit" value="Tampilkan" class="button1" onClick="javascript:window.open('<? echo "/include/struktur_org.original.php?uker='+this.struktur.unitkerja.value+'"; ?>','pop','dependent=yes,resizable=yes,scrollbars=yes,menubar=yes,maximize=yes')">
<!--            <input type="button" name="Submit" value="Tampilkan" class="button1" onClick="javascript:window.open('<? echo "/struktur/".$unitkerja.".php"; ?>','pop','dependent=yes,resizable=yes,scrollbars=yes,menubar=yes,maximize=yes')">-->
            </b></td>
        </form>
        </tr>
        <tr valign="top"> 
          <td colspan="2">&nbsp; </td>
        </tr>
      </table>
    </TD>
  </TR>
  <TR>
    <TD colspan="4" height="1"><img src="images/titik_putih.gif" border="0" width="100%" height="1"></TD>
  </TR>
  <? include("footer.inc"); ?>
