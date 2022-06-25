<?php
$judul_halaman = "Profil Anda";
$profil_active = "active";
include("../path.php"); 

include(ROOT_PATH . "/app/database/connect.php");
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

$object->query = "
SELECT * FROM admin
WHERE id_admin = '".$_SESSION["admin_id"]."'
";

$result = $object->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<?php include("header.php");?>
<style>
.container {
  position: relative;
  width: 50%;
}

.image {
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.container:hover .image {
  opacity: 0.3;
}

.container:hover .middle {
  opacity: 1;
}

</style>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                  
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Profil Anda</h1>
                    </div>


                    <div class="content mt-3">
                    <?php
                    if (isset($_SESSION['pesanError'])) {
                        ?>
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Error</span>
                            <?= $_SESSION['pesanError'];?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        unset($_SESSION['pesanError']);
                        
                    }   
                    
                    ?>
                    <?php
                      foreach ($result as $user) {
                        if($row["master_admin"] == 'Ya')
                        {
                            $status = '<span class="badge badge-success">Ya</span>';
                        }
                        else
                        {
                            $status = '<span class="badge badge-danger">Tidak</span>';
                        }
                    ?>
                    <?php
                    if (isset($_GET['id'])) {
                    ?>
                    <a class="btn btn-circle btn-primary my-2" href="profil.php"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="row gutters-sm">
                        <div class="col-md-4 mb-3">
                            <div class="card">

                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="container">
                                            <img src="<?= $user['foto_profil_admin']?>" alt="Admin" class="rounded-circle image" width="150" data-toggle="modal" data-target="#tombolGambar">
                                            <div class="middle">
                                                <div data-toggle="modal" data-target="#tombolGambar"><i class="fa-solid fa-pen-to-square"></i></div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h4><?= $user['nama_admin']?></h4>
                                            <p class="text-secondary my-2"><?= $user['email_admin']?></p>
                                            <p class="text-muted font-size-sm"><?= $user['alamat_admin']?></p>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-8">
                            <div class="card mb-3">
                              
                                <div class="card-body">
                                    <?php
                                    if (isset($_SESSION['pesanError'])) {
                                        ?>
                                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                            <span class="badge badge-pill badge-danger">Error</span>
                                            <?= $_SESSION['pesanError'];?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php
                                        unset($_SESSION['pesanError']);
                                        
                                        }   
                                    
                                    ?>

                                    <br>
                                    <form action="profil.php" method="post" id="form_edit">

                                    <input type="hidden" name="id_admin" value="<?= $user['id_admin'];?>">

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nama Lengkap</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="nama_admin" value="<?= $user['nama_admin'];?>" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan nama anda.">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="email" class="form-control" name="email_admin" value="<?= $user['email_admin'];?>" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda.">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Password Baru</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                        <div class="pass_show">
                                            <input type="password" class="form-control" name="password_admin" placeholder="Masukkan password baru anda" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan password anda.">
                                        </div>  
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">No Telepon</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="nomor_kontak" value="<?= $user['nomor_kontak'];?>" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan no telepon anda.">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Tanggal Lahir</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $user['tanggal_lahir'];?>" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan tanggal lahir anda.">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Alamat</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" class="form-control" name="alamat_admin" value="<?= $user['alamat_admin'];?>" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan alamat anda.">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12" align="right">
                                            <button type="submit" name="update_admin" class="btn btn-primary"><i class="fa-solid fa-circle-check"></i> Update</button>
                                        </div>
                                    </div>
                                    <hr>
                                    </form>
                                </div>
                            </div>
                        </div>              
                        <?php
                        }
                        else {
                        ?>
                        <div class="row gutters-sm">
                          <div class="col-md-4 mb-3">
                              <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="container">
                                            <img src="<?= $user['foto_profil_admin']?>" alt="Admin" class="rounded-circle image" width="150" data-toggle="modal" data-target="#tombolGambar">
                                            <div class="middle">
                                                <div data-toggle="modal" data-target="#tombolGambar"><i class="fa-solid fa-pen-to-square"></i></div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h4><?= $user['nama_admin']?></h4>
                                            <p class="text-secondary my-2"><?= $user['email_admin']?></p>
                                            <p class="text-muted font-size-sm"><?= $user['alamat_admin']?></p>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12" align="right">
                                            <a class="btn btn-info " href="profil.php?id=<?= $user['id_admin'];?>"><i class="fa-solid fa-gear"></i> Edit</a>
                                        </div>
                                    </div>
                
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nama Lengkap</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $user['nama_admin']?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $user['email_admin']?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">No Telepon</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $user['nomor_kontak']?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Tanggal Lahir</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $user['tanggal_lahir']?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Alamat</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <?= $user['alamat_admin']?>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Master Admin</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <span class="badge badge-success"><?= $status?></span>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    }
                    ?>
                    </div>

                </div>
                <!-- /.container-fluid -->

                <div class="modal fade" id="tombolGambar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih gambar baru</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="profil.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <input type="file" name="foto_pengguna"/>  
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="update_foto" class="btn btn-primary">Oke</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 

            </div>
            <!-- End of Main Content -->
<?php include("../includes/pesanToast.php");?>
<?php include("footer.php");?>
<?php
if (isset($_POST['update_admin'])) {

  //Mengambil data form dengan metode POST
  $id_admin       = $_POST['id_admin'];
  $nama_admin     = $_POST['nama_admin'];
  $email_admin    = $_POST['email_admin'];
  $password_admin = $_POST['password_admin'];
  $nomor_kontak   = $_POST['nomor_kontak'];
  $tanggal_lahir  = $_POST['tanggal_lahir'];
  $alamat_admin   = $_POST['alamat_admin'];


  //Cek email jika ada
  $cek_email = "SELECT * FROM admin WHERE email_admin='$email_admin' LIMIT 1";
  $cek_email_run = mysqli_query($conn, $cek_email);

  if (mysqli_num_rows($cek_email_run) > 0) {

    foreach($cek_email_run as $item){
      ?>
      <script>window.location.href="profil.php?id=<?php echo $id_admin;?>";</script>
      <?php
    }

    $_SESSION['pesanError'] = "Email sudah ada!";
  }
  else{
    //Memberi perintah SQL
    $query = "UPDATE admin SET 
    nama_admin      ='$nama_admin', 
    email_admin     ='$email_admin', 
    password_admin  ='$password_admin', 
    tanggal_lahir   ='$tanggal_lahir', 
    nomor_kontak    ='$nomor_kontak', 
    alamat_admin    ='$alamat_admin'
    WHERE id_admin  ='$id_admin'";

    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
      $_SESSION['pesan'] = "Profil anda berhasil terupdate!";
      ?>
      <script>window.location.href="profil.php";</script>
      <?php
    }

  }




}

if (isset($_POST['update_foto'])) {
  
  $nama_foto    = $_FILES['foto_pengguna']['name'];
  $tmp_foto     = $_FILES['foto_pengguna']['tmp_name'];
  $ukuran_foto  = $_FILES['foto_pengguna']['size'];
  $error_gambar = $_FILES['foto_pengguna']['error'];

  if ($error_gambar === 0) {
    if ($ukuran_foto > 2000000) {    

      $_SESSION['pesanError'] = "Ukuran file melebihi 2MB";

      ?>
      <script>window.location.href="profil.php";</script>
      <?php

    }else {
      // Berguna mengembalikan informasi path file
      $image_extension = pathinfo($nama_foto, PATHINFO_EXTENSION);
      // Mengganti nama gambar menjadi= random
      $filename = time() . '.' . $image_extension;

      //Membuat nama gambar menjadi huruf kecil
      $image_extension_lc = strtolower($image_extension);
      //Eksitensi yang diizikan untuk diupload
      $exs_diizinkan = array("jpg", "jpeg", "png");

      $destinasi = 'img/' . $filename;

      //Jika eksitensi gambar termasuk jpg, jpeg, png
      if (in_array($image_extension_lc, $exs_diizinkan)) {
        
        $query = "UPDATE admin SET foto_profil_admin='$destinasi' WHERE id_admin='".$_SESSION["admin_id"]."'";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
          move_uploaded_file($tmp_foto, $destinasi);
          ?>
          <script>window.location.href="profil.php";</script>
          <?php
          $_SESSION['pesan'] = "Gambar berhasil diubah!";
        }

      }
      //Jika eksitensi gambar tidak termasuk jpg, jpeg, png
      else 
      {
        ?>
        <script>window.location.href="profil.php";</script>
        <?php
        $_SESSION['pesanError'] = "Tipe file yang diizinkan adalah jpg, jpeg dan png";
      }
    }


  }


}


?>


</body>
<script>
    $(document).ready(function(){
      $('.pass_show').append('<i class="fa-solid fa-eye ptxt"></i>');  
    });
      

    $(document).on('click','.pass_show .ptxt', function(){ 

      $(this).text($(this).text() == "" ? "" : ""); 

      $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); 

    });  


    $(document).ready(function(){
      $('#form_edit').parsley();

      $('#form_edit').on('submit', function(event){

      });


    });

    $('#tanggal_lahir').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });
</script>
</html>