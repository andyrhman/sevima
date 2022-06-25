
<?php 
session_start();
include("path.php");
// include(ROOT_PATH . "/app/helpers/validateUsers.php");
$judul_halaman = "Aktivasi";

?>

<?php include("includes/loginHeader.php"); ?>

<div class="container">

<?php include(ROOT_PATH . "/includes/pesan.php")?>
<div class="card bg-light">
    <div class="card-body mx-auto">

        
        <h2 class="card-title mt-3 text-center">Selamat akun anda telah terdaftar di website kami!</h2>

        <div class="text-center">
            <img src="assets\img\mail-draw.png" class="img-fluid" alt="mail" width="400px">
        </div>


        
        <div>
            <p class="text-center"><strong>Jika anda tidak menerima email untuk kode verifikasi silahkan cek spam email anda.</strong></p>
            <p>Silahkan cek email anda untuk kode verifikasi login. Jika anda tidak menerima <br>kode verifikasi anda bisa menekan tombol kirim ulang email dibawah.</p>
            <a href="login.php" class="btn btn-outline-primary btn-block">Log in <i class="fa-solid fa-arrow-right-long"></i></a>
            <button type="submit" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal">Kirim ulang email</button>          
        </div>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Kirim ulang kode verifikasi</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>

                    <!-- Modal body -->
                    <form action="<?php echo BASE_URL . "app/controllers/resend-email-code.php"; ?>" method="post" id="form_aktivasi">
                        <div class="modal-body">

                        <div class="text-center">
                            <img src="assets\img\mail-box.png" class="img-fluid" alt="Login">
                        </div>

                            <?php include("pesan.php"); ?>
                            <label class="sr-only">Email</label> 
                            <p class="text-muted font-italic">Kami akan mengirimkan anda email, pastikan email <br>yang anda masukkan merupakan email yang aktif.</p>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1"
                                required autofocus data-parsley-type="email" data-parsley-type-message="Email harus valid" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda.">
                            </div>
                            
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" name="kirim-kode" class="btn btn-primary" >Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div> <!-- card.// -->

</div> 
<!--container end.//-->
<script>
    $(document).ready(function(){
		$('#form_aktivasi').parsley();

		$('#form_aktivasi').on('submit', function(event){

		});


	});
</script>
</body>
</html>