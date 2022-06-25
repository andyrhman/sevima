<?php 

include("../path.php");
$judul_halaman = "Daftar Pengguna";
$pengguna_active = "active";

include('../app/controllers/Ujianku.php');
include('../app/database/connect.php');
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

                    <!-- DataTables -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">

                                
                                <div class="col">
                                    <form class="form-inline" action="" method="get">
                                        <div onKeyPress="return checkSubmit(event)">
                                            <input class="form-control" style="width: 300px;" type="text" name="cari" value="<?php if(isset($_GET['cari'])){echo $_GET['cari'];}?>" placeholder="Cari Pengguna..." aria-label="Search">
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">


                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat Email</th>
                                            <th>No HP</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status Email Verfikasi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    </tbody>  
                                    <?php 
                                    
                                    $batas = 10;
                                    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;


                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;

                                    $data = mysqli_query($conn,"SELECT * FROM pengguna");
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);

                                    $nomor = $halaman_awal+1;
                                    if (isset($_GET['cari'])) {

                                        $filteredvalues = $_GET['cari'];
                                        $query2 = "SELECT * FROM pengguna WHERE CONCAT(nama_pengguna,nomor_hp,email,nik) LIKE '%$filteredvalues%' ";
                                        $query_run2 = mysqli_query($conn, $query2);


                                        if (mysqli_num_rows($query_run2) > 0) {
                                            foreach($query_run2 as $item){

                                                if($item["status_verifikasi"] == 'Ya')
                                                {
                                                    $status = '<span class="badge badge-success">Ya</span>';
                                                }
                                                else
                                                {
                                                    $status = '<span class="badge badge-danger">Tidak</span>';
                                                }
                                                ?>
                                    
                                                <tr>
                                                    <th><img src="../<?= $item["foto_profil"] ?>" class="img-thumbnail" width="75" /></th>
                                                    <td><?php echo $item['nama_pengguna'];?></td>
                                                    <td><?php echo $item['email'];?></td>
                                                    <td><?php echo $item['nomor_hp'];?></td>
                                                    <td><?php echo $item['jenis_kelamin'];?></td>
                                                    <td><?php echo $status?></td>
                                                    <td align="center">
                                                        <a name="tombol_view" href="pengguna.php?id=<?php echo $item['id_pengguna'];?>" class="btn btn-info btn-circle btn-sm tombol_view" data-toggle="modal" data-target="#liatModal"><i class="fas fa-eye"></i></a>
                                                        <a href="edit-pengguna.php?id=<?php echo $item['id_pengguna'];?>" class="btn btn-warning btn-circle btn-sm tombol_edit"><i class="fas fa-edit"></i></a>
                                                        <button type="button" value="<?= $item['id_pengguna'];?>" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#hapuspenggunaModal"><i class="fas fa-times"></i></button>
                                                    </td>
                                                
                                                    <!-- Modal haous akun -->
                                                    <div class="modal fade" id="hapuspenggunaModal">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">


                                                                    <!-- Modal Header -->
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title"><strong>Peringatan!</strong></h4>
                                                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                                                    </div>
                                                            
                                                                    <div class="modal-body">                                       
                                                                        <p>Apakah anda yakin ingin menghapus pengguna ini?</p>
                                                                    <form action="pengguna.php" method="post">                                   
                                                                        <!-- Modal footer -->
                                                                        <div class="modal-footer">

                                                                            <!-- Ketika tombol dibawah di klik semua data pengguna yang telah diisi di form akan dikirim ke server PHP menggunakan ajax -->
                                                                            <button type="submit" value="<?= $item['id_pengguna'];?>" name="tombol_hapus" class="btn btn-primary btn-user btn-block">Ya, Lanjutkan</button>

                                                                            <button type="button" class="btn btn-outline-primary btn-user btn-block" data-dismiss="modal">Periksa kembali</button>
                                                                            
                                                                        </div>
                                                                    </form>
                                                            </div>
                                                        </div>
                                                    </div>   

                                                </tr>
                                                                    
                                                <?php
                                            }

                                        }
                                        else {
                                            ?>
                                    
                                            <tr>
                                                <td colspan="8">Data tidak ditemukan!</td>
                                            </tr>
                                                                
                                            <?php
                                        }

                                    }  
                                    else
                                    {
                                
            
                                        $query = "SELECT * FROM pengguna ORDER BY id_pengguna DESC LIMIT $halaman_awal, $batas";
                                        $query_run = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                
                                            foreach($query_run as $row)
                                            {
                                                if($row["status_verifikasi"] == 'Ya')
                                                {
                                                    $status = '<span class="badge badge-success">Ya</span>';
                                                }
                                                else
                                                {
                                                    $status = '<span class="badge badge-danger">Tidak</span>';
                                                }
            
                                                ?>
                                            
                                                <tr>
                                                    <th><img src="../<?= $row["foto_profil"] ?>" class="img-thumbnail" width="75" /></th>
                                                    <td><?php echo $row['nama_pengguna'];?></td>
                                                    <td><?php echo $row['email'];?></td>
                                                    <td><?php echo $row['nomor_hp'];?></td>
                                                    <td><?php echo $row['jenis_kelamin'];?></td>
                                                    <td><?php echo $status?></td>
                                                    <td align="center">
                                                        <a name="tombol_view" href="pengguna.php?id=<?php echo $row['id_pengguna'];?>" class="btn btn-info btn-circle btn-sm tombol_view"><i class="fas fa-eye"></i></a>
                                                        <a href="edit-pengguna.php?id=<?php echo $row['id_pengguna'];?>" class="btn btn-warning btn-circle btn-sm tombol_edit"><i class="fas fa-edit"></i></a>
                                                        <form action="pengguna.php" method="post">
                                                            <button type="submit" value="<?= $row['id_pengguna'];?>" name="tombol_hapus" class="btn btn-danger btn-circle btn-sm tombol_hapus"><i class="fas fa-times"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                                                           
                                                <?php
                                                
            
                                            }
            
                                                                        
                                        }
                                    } 

                                    ?>
                                    <tbody>
                                </table>

                                <nav>
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item">
                                            
                                            <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php 
                                        for($x=1;$x<=$total_halaman;$x++){
                                            ?> 
                                            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                            <?php
                                        }
                                        ?>				
                                        <li class="page-item">
                                            <a class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?> aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>



                            </div>
                        </div>
                    </div>
                






                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


    <?php include("../includes/pesanToast.php");?>
    <?php include("footer.php")?>
    <?php

    if (isset($_POST['tombol_hapus'])) {

        $id_user = $_POST['tombol_hapus'];

        $query = "DELETE FROM pengguna WHERE id_pengguna='$id_user' ";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            $_SESSION['pesan'] = "Pengguna dihapus!";
            ?>
            <script>window.location.href="pengguna.php";</script><?php
        }
    }


    ?>
    <!-- Modal -->
    <div id="liatModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="judul_modal">Detail Jadwal Vaksin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <?php
                if(isset($_GET['id'])){
                    ?>
                    <script>$('#liatModal').modal('show');</script>
                    <?php
                    $id_pengguna = $_GET['id'];
                    $detail_pengguna = "SELECT * FROM pengguna WHERE id_pengguna ='$id_pengguna' ";
                    $detail_pengguna_run = mysqli_query($conn, $detail_pengguna);
                    
                    foreach($detail_pengguna_run as $pengguna){
                        if($row["status_verifikasi"] 	== 'Ya')
                        {
                            $status = '<span class="badge badge-success">Ya</span>';
                        }
                        else
                        {
                            $status = '<span class="badge badge-danger">Tidak</span>';
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <img src="../<?= $pengguna['foto_profil'];?>" class="img-fluid img-thumbnail" width="150" />
                                    </td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Nama</th>
                                    <td width="60%"><?= $pengguna['nama_pengguna'];?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Tanggal Lahir</th>
                                    <td width="60%"><?= $pengguna['tanggal_lahir'];?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Jenis Kelamin</th>
                                    <td width="60%"><?= $pengguna['jenis_kelamin'];?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Nomor HP</th>
                                    <td width="60%"><?= $pengguna['nomor_hp'];?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Email</th>
                                    <td width="60%"><?= $pengguna['email'];?></td>
                                </tr>
                                <tr>
                                    <th width="40%" class="text-right">Verifikasi Email</th>
                                    <td width="60%"><?= $status;?></td>
                                </tr>

                            </table>
                        </div>
                        <?php
                    }
                }
                else 
                {
                    ?>
                    <h4>Data tidak ditemukan!</h4>
                    <?php
                }

                ?>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id_tersembunyi_jadwal" id="id_tersembunyi_jadwal" />
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>


    function lihatPassword() {
		var x = document.getElementById("password");
		var x2 = document.getElementById("password2");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}

		if (x2.type === "password") {
			x2.type = "text";
		} else {
			x2.type = "password";
		}
	}

    var date = new Date();
    date.setDate(date.getDate());
    $('#tanggal_lahir').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });

    


    </script>
</body>

</html>