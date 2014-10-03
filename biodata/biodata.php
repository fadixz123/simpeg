<?
$sid=md5(date("Y-m-d").date("H:i:s").$REMOTE_ADDR."ItsABeautifulDay");
?>
<table width="96%" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
<form name="biodataAuth" method="post" action="auth.php">    
<input type="hidden" name="sid" value="<?=$sid?>"> 
  <tr>
  <td width="436" colspan="3" class="componentheading">LOGIN BIODATA PNS</td>
  </tr>
  <tr>
  <td width="143">Username(NIP)</td>
  <td width="18" align="center">:</td>
  <td width="275">
  <input type="text" size="20" name="username" ></td>
  </tr>
  <tr>
  <td width="143">Password</td>
  <td width="18" align="center">:</td>
  <td width="275">
  <input type="password" size="20" name="password" ></td>
  </tr>
  <tr>
  <td width="143">&nbsp;</td>
  <td width="18">&nbsp;</td>
  <td width="275">
  <input type="submit" value="MASUK" name="login" class="tombol"></td>
  </tr>
</form>
</table>
