<?php
include('include/config.inc');
include('include/fungsi.inc');
$link=mysql_connect($server,$user,$pass);
mysql_select_db($db);
$hasupt=false;

$qcu="select distinct A_02 from TABLOKB08 where A_01='$uk' and A_02<>'99'";
$rcu=mysql_query($qcu) or die(mysql_error());
if (mysql_num_rows($rcu)>1) $hasupt=true;
?>
<script type="text/javascript">
    $(function() {
        $('.showhide').hide();
        $('#tampilkan').click(function() {
            var uk  = $('#uk').val();
            var upt = $('#upt').val();
            var wWidth = $(window).width();
            var dWidth = wWidth * 1;
            var wHeight= $(window).height();
            var dHeight= wHeight * 1;
            var x = screen.width/2 - dWidth/2;
            var y = screen.height/2 - dHeight/2;
            window.open('include/struktur_org.original.php?sid=<?=$_GET['sid']?>&uk='+uk+'&upt='+upt+'','pop','width='+dWidth+', height='+dHeight+', left='+x+',top='+y);
        });
    });
    
    function cek_hasupt(value) {
        if (value !== '') {
            $.ajax({
                url: 'include/autocomplete.php?search=hasupt',
                data: 'uk='+value,
                dataType: 'json',
                success: function(data) {
                    if (data.hasupt === true) {
                        $('.showhide').show();
                        $('#upt').empty();
                        var stri = '<option value="00">INDUK</option>';
                        $('#upt').html(stri);
                        $.each(data.data, function(i, v) {
                            var str = '<option value="'+v.A_02+'">'+v.NALOK+'</option>';
                            $('#upt').append(str);
                        });
                    } else {
                        $('#upt').empty();
                        $('.showhide').hide();
                    }
                }
            });
        } else {
            $('#upt').empty();
            $('.showhide').hide();
        }
    }
</script>
<h4 class="title">STRUKTUR ORGANISASI PNS</h4>
<form name="form1" action="?sid=<?=$sid?>&do=struktur" method="post">
<table width="100%">
  
  <tr>
  <td width="15%">Unit Kerja:</td>
  <td>
      <select name="uk" id="uk" class="form-control" onchange="cek_hasupt(this.value);" style="width: 300px;">
          <option value="">Pilih Unit Kerja ...</option>
        <?php
        $lsuk=listUnitKerja();
        foreach($lsuk as $key=>$value) { ?>
            <option value="<?=$value[0]?>" <?= $value[0]==$uk ? "selected" : ""?>><?= ucwords(strtolower($value[1]))?></option>
        <? } ?>
        </select>
  </td>
  </tr>
    <tr class="showhide">
    <td>Induk/UPT:</td>
    <td>
        <select name="upt" id="upt" class="form-control" style="width: 300px;">
            
        </select>
    </td>
    </tr>
        <!--<input type="hidden" name="upt" value="00">-->
  <tr>
  <td width="76">&nbsp;</td>
  <td width="339">
      <button type="button" class="btn btn-primary" id="tampilkan"><i class="fa fa-eye"></i> Tampilkan</button>
  </td>
  </tr>
  <tr>
  <td width="436" colspan="3">&nbsp;</td>
  </tr>
  </table>
</form>
