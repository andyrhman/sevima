<?php

$judul_halaman = "Ganti Password";

include('app/controllers/Ujianku.php');

$object = new Ujianku;

include("includes/loginHeader.php");
include("path.php");

include(ROOT_PATH . "/app/database/connect.php");
?>

    <div class="container">
        <?php include(ROOT_PATH . "/includes/pesan.php")?>
        <?php include("message.php"); ?>
        <span id="message"></span>
        <!-- Outer Row -->
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        <div class="col-lg-6 d-none d-lg-block"><img src="assets\img\undraw_Forgot_password_re_hxwm.png" width="500" alt=""></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Ganti password</h1>
                                        <p class="mb-4">Pastikan password yang anda masukkan harus memiliki minimal 6 karakter dan 1 nomor digit.</p>
                                    </div>
                                    <form class="user" id="form_gantiPassword" action="<?php echo BASE_URL . '/app/controllers/kode-reset-password.php'; ?>" method="post">

                                        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>">

                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="email" aria-describedby="emailHelp"
                                                placeholder="Masukkan alamat email..." onkeydown="return false;" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];}?>">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_baru" class="form-control form-control-user"
                                                id="password" placeholder="Masukkan password" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan password anda.">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password2" placeholder="Konfirmasi password" required data-parsley-trigger="keyup" data-parsley-equalto="#password" data-parsley-equalto-message="Password tidak sama" data-parsley-required-message="Harus diisi.">
                                        </div>

                                        <div class="form-group"> 
                                            <input type="checkbox" onclick="lihatPassword()"> Tunjukkan Password
                                        </div> 

                                        <button type="submit" name="ganti-password" class="btn btn-primary btn-user btn-block">Ganti Password</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="daftar.php">Buat akun</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Sudah punya akun? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
<?php
include("includes/loginFooter.php");
?>

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

  	$(document).ready(function(){
		$('#form_gantiPassword').parsley();

		$('#form_gantiPassword').on('submit', function(event){

		});


	});


</script>


</body>

</html>