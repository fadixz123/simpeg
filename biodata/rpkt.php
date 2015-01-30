<?php
include('../include/config.inc');
include('../include/fungsi.inc');
mysql_connect($server,$user,$pass);
mysql_select_db($db);
$NIP = $_GET['nip'];
$x=mysql_fetch_array(mysql_query("select A_01,A_02,A_03,A_04,F_03 from MASTFIP08 where B_02='$NIP' LIMIT 1"));
$myF_03=$x[F_03];

if ($what=='delete')
{
	$q="delete from MASTPKT1 where PF_02='$PF_02' and ID='$ID' LIMIT 1";
	mysql_query($q) or die (mysql_error());
}

if ($updpk)
{
	for ($i=3;$i<=$no;$i++)
	{
		$a1[$i][0]=$PF_03[$i];
		$a1[$i][1]=$i;
		$a2[$i][0]=$PF_03[$i];
		$a2[$i][1]=$i;
	}
	sort($a2);
	$u=0;
	for ($i=0;$i<count($a2);$i++)
	{
		$xno=$a2[$i][1];
		$xpk=$a2[$i][0];
		$xtsk="$THSK[$xno]-$BLSK[$xno]-$TGSK[$xno]";
		$xmsk="$THTMT[$xno]-$BLTMT[$xno]-$TGTMT[$xno]";
		$q="select * from MASTPKT1 where PF_01='$NIP' and PF_03='$xpk' and PF_05='$PF_05ORG[$xno]' and PF_06='$PF_06ORG[$xno]' LIMIT 1";
		if (mysql_num_rows(mysql_query($q))==0)
		{
			$q  ="insert into MASTPKT1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="PF_01='$NIP',PF_02='$xno',PF_03='$xpk',PF_04='$PF_04[$xno]',PF_05='$xtsk',PF_06='$xmsk'";
			mysql_query($q) or die (mysql_error());
		}
		else
		{
			$q  ="update MASTPKT1 set A_01='$A_01',A_02='$A_02',A_03='$A_03',A_04='$A_04', ";
			$q .="PF_02='$xno', PF_04='$PF_04[$xno]',PF_05='$xtsk',PF_06='$xmsk' where PF_01='$NIP' and  PF_03='$xpk' and ";
			$q .="PF_05='$PF_05ORG[$xno]' and PF_06='$PF_06ORG[$xno]'";
			mysql_query($q) or die (mysql_error());
		}
		if (mysql_affected_rows() > 0) $u++;
		// update MASTFIP08 untuk pkt terakhir;
		mysql_query("update MASTFIP08 set F_02='$xtsk', F_TMT='$xmsk' where B_02='$NIP' and F_03='$xpk'");		
	}
	if ($u > 0) lethistory($sid,"UPDATE RIWAYAT PANGKAT",$NIP);
		
}
?>
<script type="text/javascript">
    $(function() {
        $('.dpicker').datepicker({
            format: 'dd/mm/yyyy'
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
    
    function removeMe(el, id) {
        bootbox.dialog({
              message: "Anda yakin akan menghapus data ini?",
              title: "Hapus Data",
              buttons: {
                batal: {
                  label: '<i class="fa fa-refresh"></i> Batal',
                  className: "btn-default",
                  callback: function() {

                  }
                },
                hapus: {
                  label: '<i class="fa fa-trash-o"></i>  Hapus',
                  className: "btn-primary",
                  callback: function() {
                    $.ajax({
                        url: 'biodata/save-data.php?save=delete_rpangkat',
                        data: 'id='+id,
                        cache: false,
                        dataType : 'json',
                        success: function(data) {
                            var parent = el.parentNode.parentNode;
                            parent.parentNode.removeChild(parent);
                            var jumlah = $('.tr_rows').length;
                            var col = 0;
                            for (i = 1; i <= jumlah; i++) {
                                $('.tr_rows:eq('+col+')').children('td:eq(0)').html(i);
                                col++;
                            }
                        },
                        error: function(e){
                             message_delete_failed();
                        }
                    });
                  }
                }
              }
            });
        
    }
    
    function add_new_pangkat(val) {
        var jml = $('.tr_rows').length;
        for (i = 1; i <= val; i++) {
            var str = '<tr class="tr_rows '+((i%2===0)?'odd':'even')+'">'+
                    '<td align="center">'+(jml+i)+'</td>'+
                    '<td><input type="hidden" name="ID[]" id="ID'+i+'" /><select name="PF_03[]" >'+
                        '<option value="">-</option>'+
                        '<option value="11">I/a</option>'+
                        '<option value="12">I/b</option>'+
                        '<option value="13">I/c</option>'+
                        '<option value="14">I/d</option>'+
                        '<option value="21">II/a</option>'+
                        '<option value="22">II/b</option>'+
                        '<option value="23">II/c</option>'+
                        '<option value="24">II/d</option>'+
                        '<option value="31">III/a</option>'+
                        '<option value="32">III/b</option>'+
                        '<option value="33">III/c</option>'+
                        '<option value="34">III/d</option>'+
                        '<option value="41">IV/a</option>'+
                        '<option value="42">IV/b</option>'+
                        '<option value="43">IV/c</option>'+
                        '<option value="44">IV/d</option>'+
                        '<option value="45">IV/e</option>'+
                      '</select></td>'+
                      '<td><input type="text" name="PF_04[]" id="PF_04'+i+'" size="40" /></td>'+
                      '<td><input type="text" name="TGSK[]" id="TGSK'+i+'" size="10" class="dpicker" /></td>'+
                      '<td><input type="text" name="TGTMT[]" id="TGTMT'+i+'" size="10" class="dpicker" /></td>'+
                      '<td><button type="button" class="btn btn-default btn-xs" onclick="removeMe(this);"><i class="fa fa-trash-o"></i></button></td>'+
                    '</tr>';
            $('#rpangkat tbody').append(str);
            $('.dpicker').datepicker({
                format: 'dd/mm/yyyy'
            }).on('changeDate', function(){
                $(this).datepicker('hide');
            });
        }
    }
    
    function save_data_rpangkat() {
        var jml = $('.tr_rows').length;
        var stop = false;
        if (jml === 0) {
            dc_validation('#tambah','Pilih jumlah pangkat !');
            stop = true;
        }
        for (i = 1; i <= jml; i++) {
            
        }
        if (stop) {
            return false;
        }
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=rpangkat',
            data: $('#rpangkat_form').serialize(),
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
<form name="pktform" id="rpangkat_form" action="index.htm?sid=<?=$sid?>&sid2=<?=$sid2?>&do=biodata&page=rpk&NIP=<?=$NIP?>" method="post">
    <input type="hidden" name="NIP" value="<?= $NIP ?>" />
    <input type="hidden" name="A_01" value="<?=$x[A_01]?>">
    <input type="hidden" name="A_02" value="<?=$x[A_02]?>">
    <input type="hidden" name="A_03" value="<?=$x[A_03]?>">
    <input type="hidden" name="A_04" value="<?=$x[A_04]?>">
    
    <table width="100%" class="table table-condensed table-bordered table-hover no-margin" id="rpangkat">
        <thead>
    <!--    <tr>
          <th>H</th>
          <th>RIWAYAT KEPANGKATAN</th>
        </tr>-->
        <tr> 
          <th width="5%">No</th>
          <th width="15%" class="left">PKT/GOL</th>
          <th width="15%" class="left">NO SK</th>
          <th width="10%" class="left">TGL SK</th>
          <th width="10%" class="left">TMT PKT</th>
          <th width="5%">&nbsp; </th>
        </tr>
        </thead>
        <tbody>
        <?php
                $query="select * from MASTPKT1 where PF_01='$NIP' order by PF_03,PF_06,PF_02";
                $result=mysql_query($query) or die (mysql_error());
                $no=0;
                while ($row=mysql_fetch_array($result))
                {
                    $no++;
                    $PF_02[$no]=$row["PF_02"];
                    $PF_03[$no]=$row["PF_03"];
                    $query1="delete from MASTPKT1 where PF_01='$NIP' and PF_02='$PF_02[$no]' LIMIT 1";
                    $delquery=base64_encode($query1);

                ?>
        <tr class="tr_rows <?= ($no%2===1)?'even':'odd' ?>"> 
          <td align="center"><?=$no; ?></td>
          <td>
          <?php
          if ($no>2)
          {
            ?>
            <input type="hidden" name="ID[]" value="<?=$row["ID"]; ?>"> 
            <select name="PF_03[]" >
              <option value="">-</option>
              <option value="11" <?php if ($row["PF_03"]=="11") echo "selected"; ?>>I/a</option>
              <option value="12" <?php if ($row["PF_03"]=="12") echo "selected"; ?>>I/b</option>
              <option value="13" <?php if ($row["PF_03"]=="13") echo "selected"; ?>>I/c</option>
              <option value="14" <?php if ($row["PF_03"]=="14") echo "selected"; ?>>I/d</option>
              <option value="21" <?php if ($row["PF_03"]=="21") echo "selected"; ?>>II/a</option>
              <option value="22" <?php if ($row["PF_03"]=="22") echo "selected"; ?>>II/b</option>
              <option value="23" <?php if ($row["PF_03"]=="23") echo "selected"; ?>>II/c</option>
              <option value="24" <?php if ($row["PF_03"]=="24") echo "selected"; ?>>II/d</option>
              <option value="31" <?php if ($row["PF_03"]=="31") echo "selected"; ?>>III/a</option>
              <option value="32" <?php if ($row["PF_03"]=="32") echo "selected"; ?>>III/b</option>
              <option value="33" <?php if ($row["PF_03"]=="33") echo "selected"; ?>>III/c</option>
              <option value="34" <?php if ($row["PF_03"]=="34") echo "selected"; ?>>III/d</option>
              <option value="41" <?php if ($row["PF_03"]=="41") echo "selected"; ?>>IV/a</option>
              <option value="42" <?php if ($row["PF_03"]=="42") echo "selected"; ?>>IV/b</option>
              <option value="43" <?php if ($row["PF_03"]=="43") echo "selected"; ?>>IV/c</option>
              <option value="44" <?php if ($row["PF_03"]=="44") echo "selected"; ?>>IV/d</option>
              <option value="45" <?php if ($row["PF_03"]=="45") echo "selected"; ?>>IV/e</option>
            </select> 
          <?php
            }
            else
            {
                    echo "&nbsp;&nbsp;".pktH($row[PF_03])."";
            }
            ?>      
          </td>
          <td height="20" width="139"> 
          <?php if ($no>2) { ?>
          <input type="text" name="PF_04[]" size="30" value="<?=$row["PF_04"]; ?>"> 
            <? } 
            else { echo "".$row[PF_04].""; }
            ?>
          </td>
          <td height="20" width="150"> 
          <?
          if ($no>2)
          {
            ?>
          <input type="text" name="TGSK[]" class="dpicker" value="<?=datefmysql($row["PF_05"],8,2); ?>">
          <?
            }
            else echo "&nbsp;".datefmysql($row[PF_05])."";
          ?>


          </td>
          <td height="20" width="150"> 
          <?
          if ($no>2)
          {
            ?>
          <input type="text" name="TGTMT[]" class="dpicker" size="5" value="<?=datefmysql($row["PF_06"],8,2); ?>">
          <?
            }
            else echo "&nbsp;".datefmysql($row[PF_06])."";
          ?>

          </td>
          <td height="20" width="50" valign="top">
            <? 
            if ($row[PF_03]==$myF_03) echo "-";
            else if ($no>2) { ?> <button type="button" class="btn btn-default btn-xs" onclick="removeMe(this, '<?= $row['ID'] ?>');"><i class="fa fa-trash-o"></i></button>
            <? } ?>
          </td>
        </tr>

        <?
                }
                ?>
        </tbody>
        <tfoot>
        <tr valign="top" bgcolor="#DDDDDD"> 
            <td height="20" colspan="6"> Jumlah Pangkat yang akan ditambahkan:
                <select name="TAMBAH" id="tambah" style="width: 100px;" onChange="add_new_pangkat(this.value);">
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
            </select> <input type="hidden" name="no" id="no" value="<? echo $no; ?>"> 
            <button type="button" class="btn btn-primary" onclick="save_data_rpangkat(); return false;"><i class="fa fa-save"></i> Simpan</button>
          </td>
        </tr>
        <tr valign="top" bgcolor="#CCCCCC"> 
          <td height="20" colspan="2">
          Perhatian :  
          </td>
          <td colspan="4">
            No 1 dan 2 <i>otomatis</i> terisi dari pangkat CPNS dan PNS pertama kali
          </td>
        </tr>
        <tr valign="top" bgcolor="#CCCCCC"> 
          <td height="20" colspan="2">&nbsp;

          </td>
          <td colspan="4">
            Nomor akan diurutkan sesuai pangkat
          </td>
        </tr>
        <tr valign="top" bgcolor="#CCCCCC"> 
          <td height="20" colspan="2">&nbsp;

          </td>
          <td colspan="4">
            Pangkat Terakhir diupdate dari Menu Pangkat & Gaji (bertanda *)
          </td>
        </tr>
        </tfoot>
    </table>
</form>