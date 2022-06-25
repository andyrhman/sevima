<?php
$judul_halaman = "Daftar Users";

include('../app/controllers/Ujianku.php');
include("../app/database/connect.php");

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


                    <a class="btn btn-circle btn-primary my-2" href="pengguna.php"><i class="fa-solid fa-arrow-left"></i></a>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Pengguna</h1>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="card-body card-block">


                                <?php 
                                
                                //Ambil url dengan metode GET
                                if (isset($_GET['id'])) {
                                    $user_id = $_GET['id'];
                                    $user = "SELECT * FROM pengguna WHERE id_pengguna='$user_id' ";
                                    $user_run = mysqli_query($conn, $user);

                                    foreach($user_run as $user)
                                    {
                                    ?>
                                    <form action="edit-pengguna.php" method="post" id="form_edit">

                                        <input type="hidden" name="id_user" value="<?= $user['id_pengguna'];?>">

                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nama Lengkap</label></div>
                                            <div class="col-12 col-md-9"><input type="text" name="nama_lengkap" value="<?= $user['nama_pengguna']; ?>" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan nama pertama anda."></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                                            <div class="col-12 col-md-9"><input type="email" name="alamat_email" value="<?= $user['email']; ?>"  class="form-control" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-required-message="Masukkan Email anda."><small class="help-block form-text">Email yang diisi harus email aktif.</small></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Password</label></div>
                                            <div class="col-12 col-md-9"><div class="pass_show"><input type="password" name="password" placeholder="Masukkan password baru" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan password anda."></div></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tanggal Lahir</label></div>
                                            <div class="col-12 col-md-9"><input type="date" name="tanggal_lahir" value="<?= $user['tanggal_lahir']; ?>" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan tanggal lahir anda."></div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="select" class=" form-control-label">Jenis Kelamin</label></div>
                                            <div class="col-12 col-md-9">
                                                <select name="jenis_kelamin" id="select" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan jenis kelamin anda.">
                                                    <option><?= $user['jenis_kelamin']; ?></option>
                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                    <option value="Perempuan">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                       
                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Alamat</label></div>
                                            <div class="col-12 col-md-9"><textarea class="form-control" rows="3" name="alamat" required data-parsley-trigger="keyup" data-parsley-required-message="Masukkan kecamatan anda."><?= $user['alamat']; ?></textarea></div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col col-md-3"><label for="select" class=" form-control-label">Status Email Verifikasi</label></div>
                                            <div class="col-12 col-md-9">
                                                <select name="status_verifikasi" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Harus diisi.">
                                                    <option value="1" <?= $user['status_verifikasi'] == "1" ? "selected":''; ?> >Ya</option>
                                                    <option value="0" <?= $user['status_verifikasi'] == "0" ? "selected":''; ?> >Tidak</option>
                                                </select>
                                            </div>
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
                                else{
                                    
                                    ?>
                                        <h4>Data tidak ditemukan</h4>

                                    <?php

                                }
                                
                                
                                ?>


                            </div>
                        </div>
                    </div>

                      
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
<?php include("../includes/pesanToast.php");?>
<?php include("footer.php");?>
<?php
    if(isset($_POST['update_user'])) {


        $id_user        = $_POST['id_user']; 
        $nama_lengkap   = $_POST['nama_lengkap'];
        $alamat_email   = $_POST['alamat_email'];
        $password       = password_hash($_POST['password'], PASSWORD_DEFAULT); 
        $nik            = $_POST['nik'];
        $tanggal_lahir  = $_POST['tanggal_lahir'];
        $jenis_kelamin  = $_POST['jenis_kelamin'];
        $provinsi       = $_POST['provinsi'];
        $kota           = $_POST['kota'];
        $kecamatan      = $_POST['kecamatan'];
        $alamat         = $_POST['alamat'];
        $verify_status  = $_POST['status_verifikasi'];
        //Cek email jika ada
        $cek_email = "SELECT * FROM pengguna WHERE email='$alamat_email' LIMIT 1";
        $cek_email_run = mysqli_query($conn, $cek_email);
    
        if (mysqli_num_rows($cek_email_run) > 0) {
    

            ?>
            <script>window.location.href="edit-pengguna.php?id=<?php echo $id_user;?>";</script>
            <?php

            $_SESSION['pesanError'] = "Email sudah ada!";
    
        }
        else 
        {

            if(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $_POST['password']))
            {
 
                ?>
                <script>window.location.href="edit-pengguna.php?id=<?php echo $id_user;?>";</script>
                <?php
                
                $_SESSION['pesanError'] = "Password harus 6 karakter dan mempunyai 1 nomor digit";
            }
            else {
                $query = "UPDATE pengguna SET nama_pengguna='$nama_lengkap', password='$password', email='$alamat_email', nik='$nik', tanggal_lahir='$tanggal_lahir', provinsi='$provinsi', jenis_kelamin='$jenis_kelamin', alamat='$alamat', kecamatan='$kecamatan', status_verifikasi='$verify_status' WHERE id_pengguna='$id_user' ";
                $query_run = mysqli_query($conn, $query);
        
                if ($query_run) {
                    $_SESSION['pesan'] = "Pengguna berhasil terupdate!";
                    ?>
                    <script>window.location.href="pengguna.php";</script><?php
                }
            }
        }


    
    }
?>
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
				url: "../app/controllers/get_daerah.php",
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
				url: "../app/controllers/get_daerah.php",
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
				url: "../app/controllers/get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_des").html(hasil);
					$("#form_des").show();
				}
			});
		});


	});

</script>
</html>