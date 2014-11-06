<?
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
if (!$uk) $uk='all';
?>
<h4 class="title">REKAP DATA PNS</h4>
<table width="100%">
  
  <tr>
    <td width="15%">Unit Kerja:</td>
    <td><select name="uk" class="form-control" style="width: 300px;" onchange="window.location='index.htm?do=rekap&sid=<?=$sid?>&uk='+this.value+'&what=<?=$what?>'">
    <option value="all" <?= $uk=='all' ? "selected" : ""?>>Semua Unit Kerja</option>
    <?
    $lsuk=listUnitKerja();
    foreach($lsuk as $key=>$value) {
    ?>
    <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?=$value[1]?></option>
    <? } ?>
	</select></td>
  </tr>
  <tr>
    <td width="288">Rekap Berdasarkan:</td>
    <td width="464"><select name="select" class="form-control" style="width: 300px;" onchange="window.location='index.htm?do=rekap&sid=<?=$sid?>&uk=<?=$uk?>&what='+this.value+''">
    <option>Pilih</option>
    <option value="1" <? if ($what=="1") echo "selected"; ?>>Golongan</option>
    <option value="2" <? if ($what=="2") echo "selected"; ?>>Pendidikan Struktural</option>
    <option value="3" <? if ($what=="3") echo "selected"; ?>>Pendidikan Umum</option>
    <option value="4" <? if ($what=="4") echo "selected"; ?>>Eselon</option>
    <option value="5" <? if ($what=="5") echo "selected"; ?>>Agama</option>
    <option value="6" <? if ($what=="6") echo "selected"; ?>>Jenis Kelamin</option>
    <option value="7" <? if ($what=="7") echo "selected"; ?>>Usia</option>
    <option value="8" <? if ($what=="8") echo "selected"; ?>>Status Perkawinan</option>
    </select></td>
  </tr>
  <tr>
  <td colspan="3">
  <?
  if ($what!="" && $uk!="") {
  switch ($what) {
	  case 1: include("pangkat.php");break;
	  case 2: include("struktural.php");break;
	  case 3: include("pendidikan.php");break;
	  case 4: include("eselon.php");break;
	  case 5: include("agama.php");break;
	  case 6: include("jeniskelamin.php");break;
	  case 7: include("usia.php");break;
	  case 8: include("status.php");break;
	  }
  }
  ?>
  </td>
  </tr>
  </table>
<?
mysql_close();
?>