<?php
$judul_halaman = "Profil Anda";
$profil_active = "active";
$profil_text = "text-white";

include("app/database/connect.php");
include('app/controllers/Ujianku.php');

$object = new Ujianku;

if(!$object->pengguna_login())
{
    header("location:".$object->base_url."login.php");
}

$object->query = "
SELECT * FROM pengguna 
WHERE id_pengguna = '".$_SESSION["id_pengguna"]."'
";

$hasilData = $object->get_result();

?>
<?php include("includes/header.php");?>
            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-body">

                    <?php 
                            
                    //Ambil url dengan metode GET
                    if (isset($_GET['id'])) {
                    ?>            
                    <a class="btn btn-circle btn-primary my-2" href="profil.php"><i class="fa-solid fa-arrow-left"></i></a>
                    <div class="card-body card-block">

                    <?php
                            


                    $id_pengguna = $_GET['id'];
                    $pengguna = "SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna' ";
                    $pengguna_run = mysqli_query($conn, $pengguna);

                    foreach($pengguna_run as $pengguna)
                    {
                    ?>

                    <form action="profil.php" method="post" id="form_edit">

                        <input type="hidden" name="id_pengguna" value="<?= $pengguna['id_pengguna'];?>">

                        <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama Lengkap</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="nama_pengguna" id="nama_pengguna" oninput="this.value = this.value.toUpperCase()" value="<?= $pengguna['nama_pengguna']; ?>" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan nama anda."></div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Lahir</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="tanggal_lahir" id="tanggal_lahir" value="<?= $pengguna['tanggal_lahir']; ?>" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan tanggal lahir anda."></div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                            <div class="col-12 col-md-9"><input type="email" name="alamat_email" onkeydown="return false;" value="<?= $pengguna['email']; ?>"  class="form-control" required autofocus data-parsley-type="email" data-parsley-type-message="Email harus valid" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda."></div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">No HP</label></div>
                            <div class="col-12 col-md-9"><input type="text" name="no_hp" value="<?= $pengguna['nomor_hp']; ?>" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan no HP anda."></div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="select" class=" form-control-label">Jenis Kelamin</label></div>
                            <div class="col-12 col-md-9">
                                <select name="jenis_kelamin" id="select" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan jenis kelamin anda.">
                                    <option><?= $pengguna['jenis_kelamin']; ?></option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="select" class=" form-control-label">Provinsi</label></div>
                            <div class="col-12 col-md-9">
                                <select id="form_prov" onChange="update()" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan provinsi anda.">
                                    <option><?= $pengguna['provinsi']; ?></option>
                                <?php 
                                    $daerah = mysqli_query($conn,"SELECT kode,nama FROM wilayah_2020 WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
                                    while($d = mysqli_fetch_array($daerah)){
                                        ?>
                                        <option value="<?php echo $d['kode']; ?>"><?php echo $d['nama']; ?></option>
                                        <?php 
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="select" class=" form-control-label">Kabupaten/Kota</label></div>
                            <div class="col-12 col-md-9">
                                <select id="form_kab" onChange="update_kota()" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan kabupaten/kota anda.">
                                    <option><?= $pengguna['kabupaten_kota']; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col col-md-3"><label for="select" class=" form-control-label">Kecamatan</label></div>
                            <div class="col-12 col-md-9">
                                <select id="form_kec" onChange="update_kecamatan()" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan kecamatan anda.">
                                    <option><?= $pengguna['kecamatan']; ?></option>
                                </select>
                            </div>
                        </div>


                        <input type="hidden" id="value">
                        <input type="hidden" id="text" name="provinsi">

                        <input type="hidden" id="value1">
                        <input type="hidden" id="text1" name="kota" >

                        <input type="hidden" id="value2">
                        <input type="hidden" id="text2" name="kecamatan" >

                        <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Alamat</label></div>
                            <div class="col-12 col-md-9"><textarea class="form-control" rows="3" name="alamat" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan alamat anda."><?= $pengguna['alamat']; ?></textarea></div>
                        </div>
                    
                        </div>
                        <div class="card-footer">
                            <button type="submit" name="update_user" class="btn btn-primary btn-sm">
                                <i class="fa fa-dot-circle-o"></i> Update
                            </button>
                        </div>

                    </form>
                    <?php
                    }
                
                }
                else 
                {
                ?>
                    <div class="my-4">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pengguna</h6>
                    </div>

                    <?php
                    if (isset($_SESSION['gambarError'])) {
                    ?>
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            <span class="badge badge-pill badge-danger">Error</span>
                            <?= $_SESSION['gambarError'];?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php
                        unset($_SESSION['gambarError']);
                    
                    }   
                    
                    ?>

                    <?php
                    foreach($hasilData as $pengguna){
                        if($pengguna["status_verifikasi"] == 'Ya')
                        {
                            $status = '<span class="badge badge-success">Ya</span>';
                        }
                        else
                        {
                            $status = '<span class="badge badge-danger">Tidak</span>';
                        }
                    ?>
                    
                        <div class="row">
                            <div class="col-sm-12" align="right">
                                <a class="btn btn-outline-info " href="profil.php?id=<?php echo $pengguna['id_pengguna'];?>"><i class="fa-solid fa-pen-to-square"></i> Perbarui Profil</a>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Lengkap</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['nama_pengguna'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-6 text-secondary">
                            <?= $pengguna['email'];?>
                        </div>
                        <div class="col-sm-3 text-secondary" align="right" data-toggle="modal" data-target="#tombolEmail" >
                            <i class="fa-solid fa-pen-to-square" data-toggle="tooltip" data-placement="top" title="Ganti Email"></i>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Tanggal Lahir</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['tanggal_lahir'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Provinsi</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['provinsi'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Kabupaten/Kota</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['kabupaten_kota'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Kecamatan</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['kecamatan'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jenis Kelamin</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['jenis_kelamin'];?>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Status Verifikasi Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $status ?>
                        </div>
                        </div>
                        <hr>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?= $pengguna['alamat'];?>
                        </div>
                        </div>
                        <hr>
                

                    <?php                    
                }
                ?>

                <?php
                    }               
                ?>


                    </div>
                </div>

            </div> 




            <!-- Modal-->
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

            <!-- Modal-->
            <div class="modal fade" id="tombolEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Alamat Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form method="post" action="profil.php" id="form_email">
                            <div class="modal-body">


                            <?php 
                            $pengguna_email = "SELECT * FROM pengguna WHERE id_pengguna='".$_SESSION['id_pengguna']."' ";
                            $pengguna_email_run = mysqli_query($conn, $pengguna_email);
                            foreach ($pengguna_email_run as $email) {
                                ?>
                                <div class="form-group">
                                    <label>Email Anda</label> 
                                    <input type="email" class="form-control form-control-user" name="alamat_email" id="email" value="<?= $email['email'];?>"
                                        placeholder="Alamat email anda" required autofocus data-parsley-type="email" data-parsley-type-message="Email harus valid" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda." data-parsley-checkemail data-parsley-checkemail-message='Email anda sudah terdaftar' >
                                </div>  
                                <?php
                            }
                            ?>

                            </div>
                            <div class="modal-footer">
                            <button type="submit" name="update_email" class="btn btn-primary btn-user btn-block">Oke</button>
                            <button type="button" class="btn btn-outline-danger btn-user btn-block" data-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 


        <!-- Row gotter end -->
        </div>

    <!-- Main body end -->
    </div>

<?php include("includes/pesanToast.php");?>
<?php include("includes/footer.php");?>
<?php
  if(isset($_POST['update_user'])) {
    //Ambil data user melalui post
    $id_pengguna        = $_POST['id_pengguna']; 
    $nama_pengguna      = $_POST['nama_pengguna'];
    //$email_pengguna     = $_POST['alamat_email'];
    $nik                = $_POST['nik'];
    $tanggal_lahir      = $_POST['tanggal_lahir'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $nomor_hp           = $_POST['no_hp'];
    $provinsi           = $_POST['provinsi'];
    $kota               = $_POST['kota'];
    $kecamatan          = $_POST['kecamatan'];
    $alamat             = $_POST['alamat'];

    $query = "UPDATE pengguna SET 
    nama_pengguna        ='$nama_pengguna', 
    nik                 ='$nik', 
    tanggal_lahir       ='$tanggal_lahir', 
    provinsi            ='$provinsi', 
    jenis_kelamin       ='$jenis_kelamin', 
    alamat              ='$alamat', 
    kabupaten_kota      ='$kota', 
    kecamatan           ='$kecamatan'
    WHERE id_pengguna   ='$id_pengguna' ";     
    $query_run = mysqli_query($conn, $query);
    
    if($query_run)
    { 
        $_SESSION['pesan'] = "Profil anda berhasil terupdate!";
        ?>
        <script>window.location.href="profil.php";</script>
        <?php

    }
    
  
  }

  if (isset($_POST['update_foto'])) {

    $nama_gambar    = $_FILES['foto_pengguna']['name'];
    $ukuran_gambar  = $_FILES['foto_pengguna']['size'];
    $tmp_gambar     = $_FILES['foto_pengguna']['tmp_name'];
    $error_gambar   = $_FILES['foto_pengguna']['error'];

    if ($error_gambar === 0) {
      // Jika ukuran gambar melebihi 2MB
      if ($ukuran_gambar > 2000000) {

        ?>
        <script>window.location.href="profil.php";</script>
        <?php
        $_SESSION['gambarError'] = "Ukuran gambar melebihi 2MB!";
        
      }
      //Jika ukuran gambar tidak melebihi 2MB
      else 
      {

        // Berguna mengembalikan informasi path file
        $image_extension = pathinfo($nama_gambar, PATHINFO_EXTENSION);
        // Mengganti nama gambar menjadi= random
        $filename = time() . '.' . $image_extension;

        //Membuat nama gambar menjadi huruf kecil
        $image_extension_lc = strtolower($image_extension);
        //Eksitensi yang diizikan untuk diupload
        $exs_diizinkan = array("jpg", "jpeg", "png");

        $destinasi = 'assets/img/' . $filename;

        //Jika eksitensi gambar termasuk jpg, jpeg, png
        if (in_array($image_extension_lc, $exs_diizinkan)) {
          
          $query = "UPDATE pengguna SET foto_profil='$destinasi' WHERE id_pengguna='".$_SESSION["id_pengguna"]."'";
          $query_run = mysqli_query($conn, $query);

          if ($query_run) {
            move_uploaded_file($tmp_gambar, $destinasi);
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
          $_SESSION['gambarError'] = "Tipe file yang diizinkan adalah jpg, jpeg dan png";
        }


      }
    }
    else 
    {
      ?>
      <script>window.location.href="profil.php";</script>
      <?php
      $_SESSION['gambarError'] = "Terjadi kesalahan mohon coba lagi";
    }


  }

  if (isset($_POST['update_email'])) {
    //Mengambil email dari input
    $emailAnda = $_POST['alamat_email'];

    //Cek email jika sama di database
    $cek_email = "SELECT * FROM pengguna WHERE email='$emailAnda' LIMIT 1";
    $cek_email_run = mysqli_query($conn, $cek_email);

    if (mysqli_num_rows($cek_email_run) > 0) {
        $_SESSION['pesanError'] = "Email sudah terdaftar";
    }
    else
    {
        $query = "UPDATE pengguna SET email='$emailAnda' WHERE id_pengguna = '".$_SESSION['id_pengguna']."' ";
        $query_run = mysqli_query($conn, $query);
        if ($query_run) 
        {
            $_SESSION['pesan'] = "Email berhasil terupdate!";
            ?>
            <script>window.location.href="profil.php";</script>
            <?php
        }
    }

  }
?>
<script>

    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })

    var date = new Date();
    date.setDate(date.getDate());
    $('#tanggal_lahir').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });

    $(document).ready(function(){
        $('#form_edit').parsley();

        $('#form_edit').on('submit', function(event){

        });

        $('#form_email').parsley();

        $('#form_email').on('submit', function(event){

        });
    });

    function update() {
        var select = document.getElementById('form_prov');
        var option = select.options[select.selectedIndex];

        document.getElementById('value').value = option.value;
        document.getElementById('text').value = option.text;
    }
    update();

    function update_kota() {
        var select = document.getElementById('form_kab');
        var option = select.options[select.selectedIndex];

        document.getElementById('value1').value = option.value;
        document.getElementById('text1').value = option.text;
    }
    update_kota();

    function update_kecamatan() {
        var select = document.getElementById('form_kec');
        var option = select.options[select.selectedIndex];

        document.getElementById('value2').value = option.value;
        document.getElementById('text2').value = option.text;
    }
    update_kecamatan();

    $(document).ready(function(){

        // sembunyikan form kabupaten, kecamatan dan desa
        // $("#form_kab").hide();
        // $("#form_kec").hide();
        // $("#form_des").hide();

        // ambil data kabupaten ketika data memilih provinsi
        $('body').on("change","#form_prov",function(){
        var id = $(this).val();
        var data = "id="+id+"&data=kabupaten";
        $.ajax({
            type: 'POST',
            url: "app/controllers/get_daerah.php",
            data: data,
            success: function(hasil) {
            $("#form_kab").html(hasil);
            $("#form_kab").show();

            }
        });
        });

        // ambil data kecamatan/kota ketika data memilih kabupaten
        $('body').on("change","#form_kab",function(){
        var id = $(this).val();
        var data = "id="+id+"&data=kecamatan";
        $.ajax({
            type: 'POST',
            url: "app/controllers/get_daerah.php",
            data: data,
            success: function(hasil) {
            $("#form_kec").html(hasil);
            $("#form_kec").show();

            }
        });
        });

        // ambil data desa ketika data memilih kecamatan/kota
        $('body').on("change","#form_kec",function(){
        var id = $(this).val();
        var data = "id="+id+"&data=desa";
        $.ajax({
            type: 'POST',
            url: "app/controllers/get_daerah.php",
            data: data,
            success: function(hasil) {
            $("#form_des").html(hasil);
            $("#form_des").show();
            }
        });
        });


    });
</script>
</body>

</html>