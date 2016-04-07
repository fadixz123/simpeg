<?php
$levnya="";
if ($_POST['username']) $username=$_POST['username'];else $username=$_GET['username'];

if ($act=='del') {
	$qd="delete from USER where username='$username'";
	$rd=mysql_query($qd) or die(mysql_error());
}

if ($_POST['submit1'] && $_POST['username']!='') {
	$levnya=$_POST['isadmin'];
	$qc="select * from USER where username='$username'";
	$rc=mysql_query($qc) or die(mysql_error());
	$num=mysql_num_rows($rc);

	if ($password_baru!='') {
		if ($password_baru!=$password_baru1) {
			$msg="Password tidak sama.";
		} else {
			if ($num > 0) {
				$qi="update USER set username='$username',nama='$nama',password='$password_baru',level='$levnya' where username='$username_lama'";
			} else {
				$qi="insert into USER set username='$username',nama='$nama',password='$password_baru',level='$levnya'";
			}
			$ri=mysql_query($qi) or die(mysql_error());
			if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
		}
	} else {
		if ($num > 0) {
			$qi="update USER set username='$username',nama='$nama',level='$levnya' where username='$username_lama'";
		} else {
			$qi="insert into USER set username='$username',nama='$nama',level='$levnya'";
		}
		$ri=mysql_query($qi) or die(mysql_error());
		if (mysql_affected_rows() > 0) $msg="Data berhasil dimasukkan";
	}
}

$mylevel=array();

if ($username!='') {
	$q="select * from USER where username='$username'";
	$r=mysql_query($q) or die(mysql_error());
	$ro=mysql_fetch_array($r);
	$mylevel=$ro[level];
}
?>

<script type="text/javascript">
    function load_data_usersystem(page) {
        $('#datamodal_search').modal('hide');
        $.ajax({
            type: 'GET',
            url: 'webmaster/user-list.php?page='+page+'&sid=<?= $_GET['sid'] ?>',
            data: $('#form-search').serialize(),
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                $('#datamodal_add').modal('hide');
                $('#result').html(data);
            }
        });
    }
    
    function save_data_user() {
        if ($('#nip').val() === '') {
            dc_validation('#nip','Nama pegawai tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#nip');
        if ($('#username').val() === '') {
            dc_validation('#username','Username tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#username');
        if (($('#password').val() !== '') && ($('#password-confirm').val() === '')) {
            dc_validation('#password-confirm','Password confirm tidak boleh kosong!'); return false;
        }
        dc_validation_remove('#password-confirm');
        if (($('#password').val() === '') && ($('#password-confirm').val() !== '')) {
            dc_validation('#password','Password tidak boleh kosong!'); return false;
        }
        if ($('#password').val() !== $('#password-confirm').val()) {
            dc_validation('#password-confirm','Password konfirmasi tidak sama!'); return false;
        }
        dc_validation_remove('#password-confirm');
        dc_validation_remove('#password');
        if ($('#group-user').val() === '') {
            dc_validation('#group-user','User group tidak boleh kosong!'); return false;
        }
        dc_validation_remove('group-user');
        $.ajax({
            type: 'POST',
            url: 'biodata/save-data.php?save=usersystem',
            data: $('#usersystem').serialize(),
            dataType: 'json',
            beforeSend: function() {
                show_ajax_indicator();
            },
            success: function(data) {
                hide_ajax_indicator();
                var page = $('li.noblock').html();
                if (page === undefined) {
                    p = 1;
                } else {
                    p = page;
                }
                if (data.status === true) {
                    load_data_usersystem(p);
                    message_add_success();
                }
            }
        });
    }
    
    function reload_data() {
        reset_form();
        load_data_usersystem(1);
    }
    
    function reset_form() {
        $('input[type=text], input[type=hidden], select, textarea').val('');
        $('a .select2-chosen').html('&nbsp;');
    }
    
    function paging(page) {
        load_data_usersystem(page);
    }
    
    function delete_user(id, p){
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
                    url: 'biodata/save-data.php?save=delete_user',
                    data: 'id='+id,
                    cache: false,
                    success: function(data) {
                        load_data_usersystem(p);
                        message_delete_success();
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
    
    function edit_user(detail) {
        var data = detail.split('#');
        $('#datamodal_add').modal('show');
        //$detail = $data['id'].'#'.$data['B_02B'].'#'.$data['username'].'#'.$data['level'];
        $('#id').val(data[0]);
        $('#nip').val(data[1]);
        $('#username').val(data[2]);
        $('#group-user').val(data[3]);
        $('#s2id_nip a .select2-chosen').html(data[1]+' | '+data[4]);
        $('#datamodal_add .title h4').html('Edit Usersystem');
    }
    
    $(function() {
        load_data_usersystem(1);
        $('#form-open-search').click(function() {
            $('#datamodal_search').modal('show');
        });
        $('#tambah').click(function() {
            $('#datamodal_add').modal('show');
            reset_form();
            $('#datamodal_add .title h4').html('Tambah Usersystem');
        });
        $('#nip').select2({
            ajax: {
                url: 'include/autocomplete.php?search=pegawai',
                dataType: 'json',
                quietMillis: 100,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term, //search term
                        page: page, // page number
                        uk: 'all',
                        suk: ''
                    };
                },
                results: function (data, page) {
                    var more = (page * 20) < data.total; // whether or not there are more results available

                    // notice we return the value of more so Select2 knows if more results can be loaded
                    return {results: data.data, more: more};
                }
            },
            formatResult: function(data){
                var markup = data.list;
                return markup;
            }, 
            formatSelection: function(data){
                return data.list;
            }
        });
    });
</script>
<h4 class="title">ADMINISTRASI PENGGUNA (User Administration)</h4>
<ul class="breadcrumb">
    <li><a href="index.php?sid=<?= $_GET['sid'] ?>&do=home"><i class="fa fa-home"></i> Home</a></li>
    <li><a href="#">User System</a></li>
</ul>
<div id="datamodal_add" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Tambah Usersystem</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
		<form method="POST" id="usersystem" action="?sid=<?=$sid?>&do=edituser">
		<input type="hidden" name="username_lama" value="<?=$ro[username]?>">
                <input type="hidden" name="id" id="id" />
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" size="20" class="select2-input" id="nip" value="<?=$ro[nama]?>"></td>
                        </tr>
                        <tr>
                            <td width="20%">Username*</td>
                            <td>:</td>
                            <td width="80%"><input type="text" name="username" id="username" class="form-control" size="20" value="<?=$ro[username]?>"></td>
                        </tr>
                        
                        <tr>
                            <td width="20%">Password</td>
                            <td>:</td>
                            <td><input type="password" name="password_baru" id="password" placeholder="Kosongkan jika tidak ada perubahan" class="form-control" size="20"></td>
                        </tr>
                        <tr>
                            <td width="20%">Ulangi Password</td>
                            <td>:</td>
                            <td><input type="password" name="password_baru1" id="password-confirm" placeholder="Kosongkan jika tidak ada perubahan" class="form-control" size="20"></td>
                        </tr>
                        <tr>
                            <td width="20%">Level</td>
                            <td>:</td>
                            <td>
                                <select name="group_user" id="group-user" class="form-control" id="group"><option value="">Pilih ...</option>
                                <?php 
                                $sql = mysql_query("select * from group_users order by nama");
                                while ($data = mysql_fetch_array($sql)) { ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
		</form>
                        </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="save_data_user(); "><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
    </div>
</div>
<div id="datamodal_search" class="modal fade">
    <div class="modal-dialog" style="width: 600px; height: 100%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="widget-header">
                <div class="title">
                    <h4>Cari Data Usersystem</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="widget-body">
		<form id="form-search" action="?sid=<?=$sid?>&do=edituser">
                    <table width="100%">
                        <tr>
                            <td width="20%">Nama</td>
                            <td>:</td>
                            <td><input type="text" name="nama" size="20" class="form-control"></td>
                        </tr>
                        <tr>
                            <td width="20%">Username*</td>
                            <td>:</td>
                            <td width="80%"><input type="text" name="username" class="form-control" size="20"></td>
                        </tr>
                        <tr>
                            <td width="20%">Level</td>
                            <td>:</td>
                            <td>
                                <select name="group_user" class="form-control" id="group"><option value="">Semua ...</option>
                                <?php 
                                $sql = mysql_query("select * from group_users order by nama");
                                while ($data = mysql_fetch_array($sql)) { ?>
                                    <option value="<?= $data['id'] ?>"><?= $data['nama'] ?></option>
                                <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
		</form>
                        </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-minus-circle"></i> Batal</button>
            <button type="button" class="btn btn-primary" onclick="load_data_usersystem(1); "><i class="fa fa-eye"></i> Cari User</button>
        </div>
    </div>
    </div>
</div>
<div class="form-toolbar">
    <div class="toolbar-left">
        <button id="tambah" class="btn btn-primary" data-target=".bs-modal-lg"><i class="fa fa-plus-circle"></i> Tambah Data</button>
        <button class="btn" data-target=".bs-modal-lg"  id="form-open-search"><i class="fa fa-search"></i> Cari Data</button>
        <button class="btn" data-target=".bs-modal-lg" onclick="reload_data();"><i class="fa fa-refresh"></i> Reload Data</button>
    </div>
</div> 
<div id="result">
    <table width="100%" class="table table-bordered table-stripped table-hover" id="table_data_no">
        <thead>
        <tr>
            <th width="5%">No</th>
            <th width="10%">NIP</th>
            <th width="10%">Username</th>
            <th width="20%">Nama</th>
            <th width="10%">Level</th>
            <th width="67">Password</th>
            <th width="67">&nbsp;</th>
        </tr>
        </thead>
    </table>
</div>
</body>

</html>