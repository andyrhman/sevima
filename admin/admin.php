<?php
$judul_halaman = "Dashboard Admin";

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin/login.php");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}

?>

<?php include("header.php");?>
<?php
$object->query = "
SELECT * FROM admin 
WHERE id_admin = '".$_SESSION['admin_id']."'
";

$user_result = $object->get_result();

foreach($user_result as $row)
{
    if ($row['master_admin'] == 'Ya') {
    ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Admin</h1>
                    </div>

    
                    <!-- DataTales -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar admin</h6>
                                </div>
                                <div class="col" align="right">
                                    <button type="button" name="tambah_admin" id="tambah_admin" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tabel_admin" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Gambar</th>
                                            <th>Alamat Email</th>
                                            <th>Password</th>
                                            <th>Nama Admin</th>
                                            <th>No HP</th>
                                            <th>Master Admin</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                      

                    <!-- Content Row -->

                    <div class="row">

 
                    </div>

                    <div id="modalAdmin" class="modal fade">
                        <div class="modal-dialog">
                            <form method="post" id="form_admin">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="judul_modal"></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="form_pesan"></span>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="text" name="email_admin" id="email_admin" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Password <span class="text-danger">*</span></label>
                                                    <input type="password" name="password_admin" id="password_admin" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Nama Admin <span class="text-danger">*</span></label>
                                                    <input type="text" name="nama_admin" id="nama_admin" class="form-control" required data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>No HP<span class="text-danger">*</span></label>
                                                    <input type="text" name="no_hp" id="no_hp" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Alamat</label>
                                                    <input type="text" name="alamat_admin" id="alamat_admin" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Tanggal Lahir</label>
                                                    <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required  data-parsley-trigger="keyup" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Foto Profil<span class="text-danger">*</span></label>
                                            <br />
                                            <input type="file" name="foto_profil" id="foto_profil"/>
                                            <div id="unggah_gambar"></div>
                                            <input type="hidden" name="hidden_foto_profil" id="hidden_foto_profil" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                        <input type="hidden" name="action" id="action" value="Tambah" />
                                        <input type="submit" name="submit" id="tombol_submit" class="btn btn-success" value="Tambah" />
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="viewModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="judul_modal">Detail Admin</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" id="detail_admin">
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    <?php

    }
    else{
        $_SESSION['pesanError'] = "Anda tidak diizinkan!";
        ?>
        <script>window.location.href="dashboard.php";</script>
        <?php
        
    }
}
?>



<?php include("../includes/pesanToast.php");?>
<?php include("footer.php");?>
<script>
$(document).ready(function(){

	var dataTable = $('#tabel_admin').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"kode_admin.php",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[5, 6],
				"orderable":false,
			},
		],
	});

    $('#tanggal_lahir').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

	$('#tambah_admin').click(function(){
		
		$('#form_admin')[0].reset();

		$('#form_admin').parsley().reset();

    	$('#judul_modal').text('Tambah Admin');

    	$('#action').val('Tambah');

    	$('#tombol_submit').val('Tambah');

    	$('#modalAdmin').modal('show');

    	$('#form_pesan').html('');

	});

	$('#form_admin').parsley();

	$('#form_admin').on('submit', function(event){
		event.preventDefault();
		if($('#form_admin').parsley().isValid())
		{		
			$.ajax({
				url:"kode_admin.php",
				method:"POST",
				data: new FormData(this),
				dataType:'json',
                contentType: false,
                cache: false,
                processData:false,
				beforeSend:function()
				{
					$('#tombol_submit').attr('disabled', 'disabled');
					$('#tombol_submit').val('memuat...');
				},
				success:function(data)
				{
					$('#tombol_submit').attr('disabled', false);
					if(data.error != '')
					{
						$('#form_pesan').html(data.error);
						$('#tombol_submit').val('Tambah');
					}
					else
					{
                        location.reload();
					}
				}
			})
		}
	});

	$(document).on('click', '.tombol_edit', function(){

		var id_admin = $(this).data('id');

		$('#form_admin').parsley().reset();

		$('#form_pesan').html('');

		$.ajax({

	      	url:"kode_admin.php",

	      	method:"POST",

	      	data:{id_admin:id_admin, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#email_admin').val(data.email_admin);
                $('#email_admin').val(data.email_admin);
                $('#password_admin').val(data.password_admin);
                $('#nama_admin').val(data.nama_admin);
                $('#unggah_gambar').html('<img src="'+data.foto_profil+'" class="img-fluid img-thumbnail" width="150" />')
                $('#hidden_foto_profil').val(data.foto_profil);
                $('#no_hp').val(data.no_hp);
                $('#alamat_admin').val(data.alamat_admin);
                $('#tanggal_lahir').val(data.tanggal_lahir);

	        	$('#judul_modal').text('Edit Dokter');

	        	$('#action').val('Edit');

	        	$('#tombol_submit').val('Edit');

	        	$('#modalAdmin').modal('show');

	        	$('#hidden_id').val(id_admin);

	      	}

	    })

	});

	$(document).on('click', '.status_tombol', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var status_berikutnya = 'Ya';
		if(status == 'Ya')
		{
			status_berikutnya = 'Tidak';
		}
        if(swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin mengganti status pengguna ini?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((gantistatus) => {
            if (gantistatus) {
                $.ajax({
                    url:"kode_admin.php",

                    method:"POST",

                    data:{id:id, action:'ganti_status', status:status, status_berikutnya:status_berikutnya},

                    success:function(data)
                    {

                        location.reload();

                    }
            })
            } else {
                swal.close();
            }
        }));

	});

    $(document).on('click', '.tombol_view', function(){
        var id_admin = $(this).data('id');

        $.ajax({

            url:"kode_admin.php",

            method:"POST",

            data:{id_admin:id_admin , action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><td colspan="2" class="text-center"><img src="'+data.foto_profil+'" class="img-fluid img-thumbnail" width="150" /></td></tr>';

                html += '<tr><th width="40%" class="text-right">Email</th><td width="60%">'+data.email_admin+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Password</th><td width="60%">'+data.password_admin+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Nama Admin</th><td width="60%">'+data.nama_admin+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">No Telepon</th><td width="60%">'+data.no_hp+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Alamat Admin</th><td width="60%">'+data.alamat_admin+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Tanggal Lahir</th><td width="60%">'+data.tanggal_lahir+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#detail_admin').html(html);

            }

        })
    });

	$(document).on('click', '.tombol_hapus', function(){

    	var id = $(this).data('id');
        if(swal({
            title: "Peringatan",
            text: "Apakah anda yakin ingin menghapus pengguna ini?",
            icon: "warning",
            buttons: true,
            dangerMode: true,

        })
        .then((hapusaction) => {
            if (hapusaction) {
                $.ajax({
                url:"kode_admin.php",
                method:"POST",
                data:{id:id, action:'hapus'},
                success:function(data)
                {
                    location.reload();
                }
            })
            } else {
                swal.close();
            }
        }));


  	});



});
</script>
</html>