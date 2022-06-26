<?php
$judul_halaman = "Dashboard Admin";
$mata_active = "active";

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
                <!-- Begin Page Content -->
                <div class="container-fluid">

    
                    <!-- DataTales -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Buat Mata Pelajaran</h6>
                                </div>
                                <div class="col" align="right">
                                    <button type="button" name="tambah_mapel" id="tambah_mapel" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tabel_mapel" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Waktu Ujian</th>
                                            <th>Token</th>
                                            <th>Status Unggah</th>
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

                    <div id="modalMapel" class="modal fade">
                        <div class="modal-dialog">
                            <form method="post" id="form_mapel">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="judul_modal"></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="form_pesan"></span>
                                        <div class="form-group">
                                            <label>Nama Mata Pelajaran<span class="text-danger">*</span></label>
                                            <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan mata pelajaran."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Ujian<span class="text-danger">*</span></label>
                                            <input type="text" name="waktu_ujian" id="waktu_ujian" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan token ujian."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah Pertanyaan<span class="text-danger">*</span></label>
                                            <input type="text" name="jumlah_pertanyaan" id="jumlah_pertanyaan" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan token ujian."/>
                                        </div>
                                        <div class="form-group">
                                            <label>Token<span class="text-danger">*</span></label>
                                            <input type="text" name="token" id="token" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan token ujian."/>
                                            <small>Token harus berhuruf kecil!</small>
                                        </div>
                                        <div class="form-group">
                                            <label>Status Unggah<span class="text-danger">*</span></label>
                                            <select name="status_unggah" id="status_unggah" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan status ujian."/> 
                                                <option value="">-- Pilih Status --</option>
                                                <option value="1">Ya</option>
                                                <option value="0">Tidak</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id_tersembunyi" id="id_tersembunyi" />
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
                                    <h4 class="modal-title" id="judul_modal">Detail Mata Pelajaran</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" id="detail_mapel">
                                    
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



<?php include("../includes/pesanToast.php");?>
<?php include("footer.php");?>
<script>
$(document).ready(function(){

	var dataTable = $('#tabel_mapel').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"kode_mapel.php",
			type:"POST",
			data:{action:'fetch'}
		},
        language: {
            url: '../vendor/datatables.net/js/dataTables.indo.json'
        },
		"columnDefs":[
			{
				"targets":'_all',
				"orderable":false,
			},
		],
	});


	$('#tambah_mapel').click(function(){
		
		$('#form_mapel')[0].reset();

		$('#form_mapel').parsley().reset();

    	$('#judul_modal').text('Tambah Mata Pelajaran');

    	$('#action').val('Tambah');

    	$('#tombol_submit').val('Tambah');

    	$('#modalMapel').modal('show');

    	$('#form_pesan').html('');

	});

	$('#form_mapel').parsley();

	$('#form_mapel').on('submit', function(event){
		event.preventDefault();
		if($('#form_mapel').parsley().isValid())
		{		
			$.ajax({
				url:"kode_mapel.php",
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

		var id = $(this).data('id');

		$('#form_mapel').parsley().reset();

		$('#form_pesan').html('');

		$.ajax({

	      	url:"kode_mapel.php",

	      	method:"POST",

	      	data:{id:id, action:'fetch_single'},

	      	dataType:'JSON',

	      	success:function(data)
	      	{

	        	$('#nama_mapel').val(data.kategori);
                $('#jumlah_pertanyaan').val(data.jumlah_pertanyaan);
                $('#waktu_ujian').val(data.waktu_ujian);
                $('#token').val(data.token);
                $('#status_unggah').val(data.publish);

	        	$('#judul_modal').text('Edit Mata Pelajaran');

	        	$('#action').val('Edit');

	        	$('#tombol_submit').val('Edit');

	        	$('#modalMapel').modal('show');

	        	$('#id_tersembunyi').val(id);

	      	}

	    })

	});

	$(document).on('click', '.status_tombol', function(){
		var id = $(this).data('id');
    	var status = $(this).data('status');
		var status_berikutnya = '1';
		if(status == '1')
		{
			status_berikutnya = '0';
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
                    url:"kode_mapel.php",

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
        var id = $(this).data('id');

        $.ajax({

            url:"kode_mapel.php",

            method:"POST",

            data:{id:id , action:'fetch_single'},

            dataType:'JSON',

            success:function(data)
            {
                var html = '<div class="table-responsive">';
                html += '<table class="table">';

                html += '<tr><th width="40%" class="text-right">Nama Mapel</th><td width="60%">'+data.kategori+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Jumlah Pertanyaan</th><td width="60%">'+data.jumlah_pertanyaan+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Waktu Ujian</th><td width="60%">'+data.waktu_ujian+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Token Ujian</th><td width="60%">'+data.token+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Status Unggah</th><td width="60%">'+data.publish+'</td></tr>';

                html += '<tr><th width="40%" class="text-right">Dibuat Pada</th><td width="60%">'+data.created_at+'</td></tr>';

                html += '</table></div>';

                $('#viewModal').modal('show');

                $('#detail_mapel').html(html);

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
                url:"kode_mapel.php",
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