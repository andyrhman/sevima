<?php

$judul_halaman = "Login Akun";

include('app/controllers/Ujianku.php');

$object = new Ujianku;

include("includes/loginHeader.php");
include("path.php");

include(ROOT_PATH . "/app/database/connect.php");


?>

    <div class="container">
        <?php include(ROOT_PATH . "/includes/pesan.php")?>
        <span id="message"></span>
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-12">

                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block"><img src="assets\img\undraw_Referral_re_0aji.png" width="600" alt=""></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                        <?php include(ROOT_PATH . "/pesan.php")?>
                                    </div>
                                    <?php

                                    ?>
                                    <form class="user" id="form_login" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                name="alamat_email" id="alamat_email" aria-describedby="emailHelp"
                                                placeholder="Masukkan email anda..." value="<?php if(isset($_COOKIE["email_pengguna"])) { echo $_COOKIE["email_pengguna"]; } ?>"
                                                required autofocus data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda.">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password" id="password" placeholder="Password" value="<?php if(isset($_COOKIE["password_pengguna"])) { echo $_COOKIE["password_pengguna"];} ?>"
                                                required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan password anda.">
                                        </div>

                                        <div class="form-group row">
                                            <div class="custom-control custom-checkbox small col-sm-6">
                                                <input type="checkbox" class="custom-control-input" name="ingat-saya" id="customCheck" <?php if(isset($_COOKIE["email_pengguna"])) { ?> checked <?php } ?>>
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>

                                            <div class="col-sm-6 mb-3 mb-sm-0" align="right">
                                                <a class="small" href="#" type="button" data-toggle="modal" data-target="#lupaPassword">Lupa password?</a>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <input type="hidden" name="halaman" value="login_user" />
                                            <input type="hidden" name="action" value="login_user" />
                                            <input type="submit" name="tombol_login" id="patient_login_button" class="btn btn-primary btn-user btn-block" value="Login" />
                                        </div>

                                        <hr>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="daftar.php">Daftar Vaksinasi</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
    <?php include("includes/pesanToast.php"); ?>

    <div class="modal fade" id="lupaPassword">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Reset Password</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal body -->
                <form action="<?php echo BASE_URL . '/app/controllers/kode-reset-password.php'; ?>" method="post">
                    <div class="modal-body">

                    <div class="text-center">
                        <img src="assets\img\forgot-password.png" class="img-fluid" alt="Login">
                    </div>

                        
                        <label class="sr-only">Email</label> 
                        <p class="text-muted font-italic">Kami akan mengirimkan anda email, pastikan email <br>yang anda masukkan merupakan email yang aktif.</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Username" aria-describedby="basic-addon1" required>
                        </div>
                        
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" name="reset-password" class="btn btn-primary" >Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kirimEmail">
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

                        <?php include("message.php"); ?>
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
    <div id="preloader" style="display: none;">
        <div id="loader"></div>
    </div>
<?php
include("includes/loginFooter.php");
?>

<script>
  
  $(document).ready(function(){

    $('#form_login').parsley();

    $('#form_login').on('submit', function(event){

        event.preventDefault();

        if($('#form_login').parsley().isValid())
        {
            $.ajax({

                url:"user_action.php",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function()
                {
                    $('#tombol_login').attr('disabled', 'disabled');
                },
                success:function(data)
                {
                    $('#tombol_login').attr('disabled', false);

                    if(data.error != '')
                    {
                        $('#message').html(data.error);
                        setTimeout(()=>{ //hide the toast notification automatically after 5 seconds
                            $('#pemanggangError').css('display', 'none');
                        }, 4000);
                    }
                    else
                    {
                        window.location.href="panel.php";
                    }
                }
            });
        }

    });

    });

</script>


</body>

</html>