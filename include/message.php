<h4 class="title">MESSAGE</h4>
<script type="text/javascript">
    $(function() {
        load_message();
        $('#reload').click(function() {
            load_message();
        });
    });
    function load_message() {
        $.ajax({
            type: 'GET',
            url: 'include/load-data.php?data=message',
            data: 'nip=<?= $_GET['id'] ?>',
            dataType: 'json',
            success: function(data) {
                $('.isi_message').empty();
                $.each(data.data, function(i, v) {
                    var foto = v.foto;
                    if (v.foto === '' && v.B_06 === '1') {
                        foto = 'default-l.png';
                    }
                    if (v.foto === '' && v.B_06 === '2') {
                        foto = 'default-p.png';
                    }
                    var str = '<tr valign=top class="spaceunder"><td width="10%"><img src="Foto/'+foto+'" width="50px" height="50px" /></td><td><small><b>'+v.nama+'</b></small><br/>'+v.message+' <p style="font-size: 10px; margin-top: 12px;"> '+datetimefmysql(v.waktu)+' </p></td></tr>';
                    $('.isi_message').append(str);
                });
            }
        });
    }
    
    function save_reply() {
        if ($('#isi').val() !== '') {
            $.ajax({
                type: 'POST',
                url: 'include/save-data.php?save=message',
                data: $('#form_message').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    show_ajax_indicator();
                },
                success: function(data) {
                    if (data.status === true) {
                        load_message();
                        $('#isi').val('');
                    }
                },
                complete: function() {
                    hide_ajax_indicator();
                }
            });
        }
    }
</script>
<div id="result">
    <?php 
    mysql_query("update tb_message_detail set status_baca = 'Sudah' where nip_pengirim = '".$_GET['id']."' and nip_penerima = '".$_SESSION['nip']."'");
    $sql1 = mysql_query("select `B_02B` as nip1, CONCAT_WS(' ',B_03, B_03B) as nama from mastfip08 where B_02 = '".$_SESSION['nip']."'");
    $row1 = mysql_fetch_array($sql1);
    
    $sql = mysql_query("select `B_02B` as nip2, CONCAT_WS(' ',B_03, B_03B) as nama from mastfip08 where B_02 = '".$_GET['id']."'");
    $row = mysql_fetch_array($sql);
    ?>
    <p>to: <button class="btn btn-danger btn-xs"><i class="fa fa-user"></i> <?= $row['nama'] ?></button></p>
    <div class="isi_message">
        <table width="100%">
            
        </table>
    </div>
    <form id="form_message">
        <input type="hidden" name="nip1" id='nip1' value="<?= $row1['nip1'] ?>" />
        <input type="hidden" name="nip2" id='nip2' value="<?= $row['nip2'] ?>" />
        <div class='wrapper-message'>
            <textarea id="isi" name="message" style="outline: none; width: 100%; height: 100px; border: none; border-bottom: 1px solid #ccc; margin-bottom: 3px;"></textarea>
            <button type="button" onclick="save_reply();" class="btn btn-primary" style="margin-left: 2px;"><i class="fa fa-reply"></i> Reply</button>
            <button type="button" id='reload' class="btn btn-default" style="margin-right: 2px; float: right; "><i class="fa fa-refresh"></i> Reload Message</button>
        </div>
    </form>
</div>