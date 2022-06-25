<?php 

include("../path.php");
$judul_halaman = "Buat Kelas";
$kelas_active = "active";

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
<?php include("header.php")?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Kelas</h6>
                                </div>
                                <div class="col" align="right">
                                    <button type="button" name="tambah_kelas" id="tambah_kelas" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tabel_kelas" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Kelas</th>
                                            <th>Kode Kelas</th>
                                            <th>Nama Mapel</th>
                                            <th>Tipe Kelas</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                      

                    <div id="modalKelas" class="modal fade">
                        <div class="modal-dialog">
                            <form method="post" id="form_kelas">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="judul_modal"></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <span id="form_pesan"></span>
                                       
                                        <div class="form-group">
                                            <label>Nama Mata Pelajaran</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                                </div>
                                                
                                                <input type="text" name="nama_mapel" id="nama_mapel" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan nama mata pelajaran.">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Kelas</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-a"></i></span>
                                                </div>
                                                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan nama kelas.">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                                </div>
                                                <textarea class="form-control" name="deskripsi" id="deskripsi" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan deskripsi."> </textarea>
                                            </div>
                                        </div>             
                                        <div class="form-group">
                                            <label>Tipe Kelas</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                                </div>
                                                <select id="tipe_kelas" name="tipe_kelas" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan tipe kelas."/> 
                                                    <option value="">-- Pilih Tipe --</option>
                                                    <option value="Pribadi">Pribadi</option>
                                                    <option value="Publik">Publik</option>
                                                </select>
                                            </div>
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
                                    <h4 class="modal-title" id="judul_modal">Detail Kelas</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body" id="detail_kelas">
                                    
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
    <?php include("footer.php")?>
    <script>
    $(document).ready(function(){

        var dataTable = $('#tabel_kelas').DataTable({
            "processing" : true,
            "serverSide" : true,
            "order" : [],
            "ajax" : {
                url:"kode_kelas.php",
                type:"POST",
                data:{action:'fetch'}
            },
            "columnDefs":[
                {
                    "targets":"_all",
                    "orderable":false,
                },
            ],
        });


        $('#tambah_kelas').click(function(){
            
            $('#form_kelas')[0].reset();

            $('#form_kelas').parsley().reset();

            $('#judul_modal').text('Tambah Kelas');

            $('#action').val('Tambah');

            $('#tombol_submit').val('Tambah');

            $('#modalKelas').modal('show');

            $('#form_pesan').html('');

        });

        $('#form_kelas').parsley();

        $('#form_kelas').on('submit', function(event){
            event.preventDefault();
            if($('#form_kelas').parsley().isValid())
            {		
                $.ajax({
                    url:"kode_kelas.php",
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

            var id_kelas = $(this).data('id');

            $('#form_kelas').parsley().reset();

            $('#form_pesan').html('');

            $.ajax({

                url:"kode_kelas.php",

                method:"POST",

                data:{id_kelas:id_kelas, action:'fetch_single'},

                dataType:'JSON',

                success:function(data)
                {

                    $('#nama_mapel').val(data.nama_mapel);
                    $('#nama_kelas').val(data.nama_kelas);
                    $('#deskripsi').val(data.deskripsi);
                    $('#tipe_kelas').val(data.tipe_kelas);

                    $('#judul_modal').text('Edit Kelas');

                    $('#action').val('Edit');

                    $('#tombol_submit').val('Edit');

                    $('#modalKelas').modal('show');

                    $('#id_tersembunyi').val(id_kelas);

                }

            })

        });

        $(document).on('click', '.status_tombol', function(){
            var id = $(this).data('id');
            var status = $(this).data('status');
            var status_berikutnya = 'Pribadi';
            if(status == 'Pribadi')
            {
                status_berikutnya = 'Publik';
            }
            if(swal({
                title: "Peringatan",
                text: "Apakah anda yakin ingin mengganti status kelas ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((gantistatus) => {
                if (gantistatus) {
                    $.ajax({
                        url:"kode_kelas.php",

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
            var id_kelas = $(this).data('id');

            $.ajax({

                url:"kode_kelas.php",

                method:"POST",

                data:{id_kelas:id_kelas , action:'fetch_single'},

                dataType:'JSON',

                success:function(data)
                {
                    var html = '<div class="table-responsive">';
                    html += '<table class="table">';


                    html += '<tr><th width="40%" class="text-right">Nama Kelas</th><td width="60%">'+data.nama_kelas+'</td></tr>';

                    html += '<tr><th width="40%" class="text-right">Kode Kelas</th><td width="60%">'+data.kode_kelas+'</td></tr>';

                    html += '<tr><th width="40%" class="text-right">Nama Mata Pelajaran</th><td width="60%">'+data.nama_mapel+'</td></tr>';

                    html += '<tr><th width="40%" class="text-right">Deskripsi</th><td width="60%">'+data.deskripsi+'</td></tr>';

                    html += '<tr><th width="40%" class="text-right">Tipe Kelas</th><td width="60%">'+data.tipe_kelas+'</td></tr>';


                    html += '</table></div>';

                    $('#viewModal').modal('show');

                    $('#detail_kelas').html(html);

                }

            })
        });

        $(document).on('click', '.tombol_hapus', function(){

            var id = $(this).data('id');
            if(swal({
                title: "Peringatan",
                text: "Apakah anda yakin ingin menghapus Kelas ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,

            })
            .then((hapusaction) => {
                if (hapusaction) {
                    $.ajax({
                    url:"kode_kelas.php",
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
</body>

</html>