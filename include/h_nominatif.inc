
<table border="0" cellspacing="0" cellpading="0" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber4">

          <tr>
            <td width="100%" colspan="3" bgcolor="#E2E7F3">NOMINATIF PNS</td>
          </tr>
          <?
          if ($gol1=='') $gol1='11';
          ?>
          
          <tr>
            <td width="24%">GOLONGAN</td>
            <td width="5%" align="center">:</td>
            <td width="71%">Antara&nbsp;
            <select name="gol1" class="button2" onChange="window.location='?do=nominatif&sid=<?=$sid?>&sid2=<?=$myid?>&gol1='+this.value+''">
            <option value="45" <? if ($gol1=='45') echo "selected"; ?>>IV/e</option>
            <option value="44" <? if ($gol1=='44') echo "selected"; ?>>IV/d</option>
            <option value="43" <? if ($gol1=='43') echo "selected"; ?>>IV/c</option>
            <option value="42" <? if ($gol1=='42') echo "selected"; ?>>IV/b</option>
            <option value="41" <? if ($gol1=='41') echo "selected"; ?>>IV/a</option>
            <option value="34" <? if ($gol1=='34') echo "selected"; ?>>III/d</option>
            <option value="33" <? if ($gol1=='33') echo "selected"; ?>>III/c</option>
            <option value="32" <? if ($gol1=='32') echo "selected"; ?>>III/b</option>
            <option value="31" <? if ($gol1=='31') echo "selected"; ?>>III/a</option>
            <option value="24" <? if ($gol1=='24') echo "selected"; ?>>II/d</option>
            <option value="23" <? if ($gol1=='23') echo "selected"; ?>>II/c</option>
            <option value="22" <? if ($gol1=='22') echo "selected"; ?>>II/b</option>
            <option value="21" <? if ($gol1=='21') echo "selected"; ?>>II/a</option>
            <option value="14" <? if ($gol1=='14') echo "selected"; ?>>I/d</option>
            <option value="13" <? if ($gol1=='13') echo "selected"; ?>>I/c</option>
            <option value="12" <? if ($gol1=='12') echo "selected"; ?>>I/b</option>
            <option value="11" <? if ($gol1=='11') echo "selected"; ?>>I/a</option>
            </select> s/d 
            <select name="gol2" class="button2" onChange="window.location='?do=nominatif&sid=<?=$sid?>&sid2=<?=$myid?>&gol1=<?=$gol1?>&gol2='+this.value+''">
            <option value="45" <? if ($gol2=='45') echo "selected"; ?>>IV/e</option>
            <option value="44" <? if ($gol2=='44') echo "selected"; ?>>IV/d</option>
            <option value="43" <? if ($gol2=='43') echo "selected"; ?>>IV/c</option>
            <option value="42" <? if ($gol2=='42') echo "selected"; ?>>IV/b</option>
            <option value="41" <? if ($gol2=='41') echo "selected"; ?>>IV/a</option>
            <option value="34" <? if ($gol2=='34') echo "selected"; ?>>III/d</option>
            <option value="33" <? if ($gol2=='33') echo "selected"; ?>>III/c</option>
            <option value="32" <? if ($gol2=='32') echo "selected"; ?>>III/b</option>
            <option value="31" <? if ($gol2=='31') echo "selected"; ?>>III/a</option>
            <option value="24" <? if ($gol2=='24') echo "selected"; ?>>II/d</option>
            <option value="23" <? if ($gol2=='23') echo "selected"; ?>>II/c</option>
            <option value="22" <? if ($gol2=='22') echo "selected"; ?>>II/b</option>
            <option value="21" <? if ($gol2=='21') echo "selected"; ?>>II/a</option>
            <option value="14" <? if ($gol2=='14') echo "selected"; ?>>I/d</option>
            <option value="13" <? if ($gol2=='13') echo "selected"; ?>>I/c</option>
            <option value="12" <? if ($gol2=='12') echo "selected"; ?>>I/b</option>
            <option value="11" <? if ($gol2=='11') echo "selected"; ?>>I/a</option>
            </select> </td>
          </tr>
          <tr>
            <td width="24%">UNIT KERJA</td>
            <td width="5%" align="center">:</td>
            <td width="71%"><select name="unitkerja" class="button2" onChange="window.location='?do=nominatif&gol1=<?=$gol1?>&gol2=<?=$gol2?>&unitkerja='+this.value+''">
            <option value="">PILIH UNIT KERJA</option>
            <option value="xx" <? if ($unitkerja=='xx') echo "selected"?>>SEMUA UNIT KERJA</option>
            <?
            $q="select KD,NM from TABLOK order by KD";
            $r=mysql_query($q) or die (mysql_error());
            while ($row=mysql_fetch_array($r))
            {
            	?>
            	<option value="<?=$row[KD]?>" <? if ($unitkerja==$row[KD]) echo "selected"?>><?=$row[NM]?></option>
            	<?
            }
            ?>
            </select></td>
          </tr>
          <tr>
            <td colspan="2" bgcolor="#E2E7F3">&nbsp;</td>
            <td bgcolor="#E2E7F3">&nbsp;</td>
          </tr>
          </form>
        </table>