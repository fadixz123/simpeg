<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
if ($what=='delete')
	mysql_query("delete from MASTJAB1 where JF_01='$NIP' and ID='$ID' LIMIT 1") or die (mysql_error());

if ($updjab)
{
	$u=0;
	for ($i=1;$i<=$no;$i++)
	{
		$xtgjf07=$THJF_07[$i]."-".$BLJF_07[$i]."-".$TGJF_07[$i];
		$xtgjf06=$THJF_06[$i]."-".$BLJF_06[$i]."-".$TGJF_06[$i];
		//$a[$i]=$xtgjf07;
		$I_JB=ereg_replace('\'','\"',$JF_03[$i]);
		//$j=mysql_num_rows(mysql_query("select * from MASTJAB1 where JF_01='$NIP' and JF_07='$xtgjf07' LIMIT 1"));
		if ($upd[$i]=='1')
		{
			
			$q  ="insert into MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JF_02='$JF_02ORG[$i]',JF_01='$NIP',JF_03='$I_JB',JF_04='$JF_04[$i]', ";
			$q .="JF_05='$JF_05[$i]',JF_06='$xtgjf06', JF_07='$xtgjf07'";
			mysql_query($q) or die (mysql_error());
		}
		else if ($upd[$i]=='0')
		{
			$q  ="update MASTJAB1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="JF_02='$JF_02ORG[$i]',JF_03='$I_JB',JF_04='$JF_04[$i]', ";
			$q .="JF_05='$JF_05[$i]',JF_06='$xtgjf06', JF_07='$xtgjf07' where JF_01='$NIP' and ";
			$q .="ID='$IDORG[$i]'";// and ";
/*			$q .="JF_03='$JF_03ORG[$i]' and ";
			$q .="JF_04='$JF_04ORG[$i]' and ";
			$q .="JF_05='$JF_05ORG[$i]' and ";
			$q .="JF_06='$JF_06ORG[$i]' and ";
			$q .="JF_07='$JF_07ORG[$i]' ";*/
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;			
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT JABATAN",$NIP);
	/*sort($a);
	$z=0;
	for ($i=1;$i<=$no;$i++)
	{
		$z=$i-1;
		$xtgjf07=$THJF_07[$i]."-".$BLJF_07[$i]."-".$TGJF_07[$i];
		$q="update MASTJAB1 set JF_02='$i' where JF_01='$NIP' and JF_07='$a[$z]'";
		
		mysql_query($q) or die (mysql_error());
	}*/
	
}
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04 from MASTFIP08 where B_02='$NIP' LIMIT 1"));

?>
<script type="text/javascript">
    $(function() {
        $('.dpicker').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function removeMex(el) {
        var parent = el.parentNode.parentNode;
        parent.parentNode.removeChild(parent);
        var jumlah = $('.tr_rows').length;
        var col = 0;
        for (i = 1; i <= jumlah; i++) {
            $('.tr_rows:eq('+col+')').children('td:eq(0)').children('.nomor').val(i);
            col++;
        }
    }
    
    function add_new_row_rjabatan(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
        var str = '<tr class="tr_rows '+((i%2===0)?'odd':'even')+'">'+
                '<td><input type="text" name="JF_02ORG[]" id="no'+(jml+i)+'" value="'+(jml+i)+'" size="2" class="nomor"></td>'+
                '<td><input type="text" name="JF_03[]" id="jabatan'+(jml+i)+'" size="40"> </td>'+
                '<td><input type="hidden" name="ID[]" id="ID'+(jml+i)+'" /><select name="JF_04[]" id="esel'+(jml+i)+'">'+
                    '<option value="">-</option>'+
                    '<option value="12">I.b</option>'+
                    '<option value="21">II.a</option>'+
                    '<option value="22">II.b</option>'+
                    '<option value="31">III.a</option>'+
                    '<option value="32">III.b</option>'+
                    '<option value="41">IV.a</option>'+
                    '<option value="42">IV.b</option>'+
                    '<option value="51">V.a</option>'+
                    '<option value="52">V.b</option>'+
                  '</select></td>'+
                  '<td><input type="text" name="JF_05[]" id="nosk'+(jml+i)+'" value=""></td>'+
                  '<td><input type="text" name="TGJF_06[]" id="tgsk'+(jml+i)+'" class="dpicker"></td>'+
                  '<td><input type="text" name="TGJF_07[]" id="tgtmt'+(jml+i)+'" class="dpicker"></td>'+
                  '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMex(this);"><i class="fa fa-trash-o"></i></button></td>'+
                '</tr>';
            $('#rjabatan tbody').append(str);
            $('.dpicker').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rjabatan() {
        var jml = $('.tr_rows').length;
        var stop = false;
//        if (jml === 0) {
//            dc_validation('#tambah','Pilih jumlah jabatan !');
//            stop = true;
//        }
        for (i = 1; i <= jml; i++) {
            
        }
        if (stop) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=rjabatan',
            data: $('#rjabatan_form').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                if (data.act === 'edit') {
                    message_edit_success();
                } else {
                    message_add_success();
                }
            },
            error: function() {
                hide_ajax_indicator();
            }
        });
    }
    
</script>
<form name="pktform" id="rjabatan_form" method="post">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>" />
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>" />
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>" />
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>" />
<table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rjabatan">
<!--  <tr> 
    <td><strong>I</strong></td>
    <td colspan="6" bgcolor="DDDDDD">&nbsp;<strong>RIWAYAT JABATAN</strong></td>
  </tr>-->
    <thead>
  <tr> 
    <th>No</th>
    <th>Nama Jabatan</th>
    <th>Esel</th>
    <th>No. SK JAB</th>
    <th>TMT SK</th>
    <th>TMT JAB</th>
    <th>&nbsp; </th>
  </tr>
  </thead>
  <tbody>
  <?php
  $no=0;
  $r=mysql_query("select ID,JF_01,JF_02,JF_03,JF_04,JF_05,JF_06,JF_07 from MASTJAB1 where JF_01='$NIP' order by JF_07");
  while ($row=mysql_fetch_array($r))
  {
  	$no++;
  	$JF_03[$no]=$row[JF_03];
  	
  	$JF_05[$no]=$row[JF_05];
  	
  	
  	?>
  <tr valign="top" bgcolor="<?=$warnarow?>"> 
    <input type="hidden" name="upd[]" value="0">
    <input type="hidden" name="IDORG[]" value="<?=$row[ID]?>">
    <input type="hidden" name="JF_03ORG[]" value="<?=$row[JF_03]?>">
    <input type="hidden" name="JF_04ORG[]" value="<?=$row[JF_04]?>">
    <input type="hidden" name="JF_05ORG[]" value="<?=$row[JF_05]?>">
    <input type="hidden" name="JF_06ORG[]" value="<?=$row[JF_06]?>">
    <input type="hidden" name="JF_07ORG[]" value="<?=$row[JF_07]?>">
    <td align="right">
    <input type="text" name="JF_02ORG[]" size="1" value="<?=$row[JF_02]?>" class="inputkecil"></td>
    <td >
    <?php $I_JB=ereg_replace('"','\'',$row[JF_03]); ?>
    <input type="text" name="JF_03[]" size="30" value="<?=$I_JB?>" class="inputkecil"> 
    </td>
    <td >
    <select name="JF_04[]" >
    <option value="99" <?php if ($row[JF_04]=='99') echo "selected"?>>-</option>
    <option value="12" <?php if ($row[JF_04]=='12' || strtoupper($row[JF_04])=='1B') echo "selected"?>>I.a</option>
    <option value="21" <?php if ($row[JF_04]=='21' || strtoupper($row[JF_04])=='2A') echo "selected"?>>II.a</option>
    <option value="22" <?php if ($row[JF_04]=='22' || strtoupper($row[JF_04])=='2B') echo "selected"?>>II.b</option>
    <option value="31" <?php if ($row[JF_04]=='31' || strtoupper($row[JF_04])=='3A') echo "selected"?>>III.a</option>
    <option value="32" <?php if ($row[JF_04]=='32' || strtoupper($row[JF_04])=='3B') echo "selected"?>>III.b</option>
    <option value="41" <?php if ($row[JF_04]=='41' || strtoupper($row[JF_04])=='4A') echo "selected"?>>IV.a</option>
    <option value="42" <?php if ($row[JF_04]=='42' || strtoupper($row[JF_04])=='4B') echo "selected"?>>IV.b</option>
    <option value="51" <?php if ($row[JF_04]=='51' || strtoupper($row[JF_04])=='5A') echo "selected"?>>V.a</option>
    <option value="52" <?php if ($row[JF_04]=='52' || strtoupper($row[JF_04])=='5B') echo "selected"?>>V.b</option>
    </select>
    
    
    
    </td>
    <td> 
    <input type="text" name="JF_05[]" size="40" value="<?=$row[JF_05]?>"> 
    </td>
    <td > 
      <input type="text" name="TGJF_06[]" value="<?=datefmysql($row[JF_06])?>" class="dpicker">
    </td>
    <td> 
        <input type="text" name="TGJF_07[]" value="<?=  datefmysql($row[JF_07])?>" class="dpicker">
    </td>
    <td>
        <button type="button" class="btn btn-default btn-xs" onclick="removeMex(this);"><i class="fa fa-trash-o"></i></button>
    </td>
  </tr>
  </tbody>
  <?php } ?>
  <tfoot>
  <tr> 
    <td colspan="7" bgcolor="DDDDDD">Jumlah Jabatan yang akan ditambahkan : &nbsp;
        <select name="jmltambah" onchange="add_new_row_rjabatan(this.value);" style="width: 100px;">
            <option value="">-</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
          </select>
      <button type="button" class="btn btn-primary" onclick="save_data_rjabatan(); return false;"><i class="fa fa-save"></i> Simpan</button>
    </td>
  </tr>
  </tfoot>
</table>
</form>