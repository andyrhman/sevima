<?php 

include("../path.php");
$judul_halaman = "LOGIN ADMIN";

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

// if($object->is_login())
// {
//     header("location:".$object->base_url."admin/dashboard.php");
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Tataran">

    <title><?php if (isset($judul_halaman)) {echo "$judul_halaman"; }?></title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="../vendor/font-awesome/css/all.min.css"/>

    <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    

    <!-- DataTables -->
    <link rel="stylesheet" href="../vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
    
    <!-- Datepicker -->
    <link rel="stylesheet" href="../vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />

    <!-- Timepicker -->
    <link rel="stylesheet" href="../vendor/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">

    <!-- SB admin theme -->
    <link rel="stylesheet" href="../assets/css/sb-admin-2.min.css">

    <link rel="stylesheet" href="../assets/css/pass-show.css">

    <!-- Ajax -->
    <script src="../vendor/popperjs/popper.min.js"></script>
    <link rel="stylesheet" href="../assets/css/parsley.css" />
    <link rel="stylesheet" href="../assets/css/loader.css" />
    <link rel="stylesheet" href="../assets/css/onichan.css">

</head>

<body>


    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block my-5"><img src="img\undraw_donut_love_kau1.png" width="500" alt=""></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 animate-charcter mb-4">Login Admin <i class="fa-solid fa-key"></i></h1>
                                    </div>
                                    <span id="error"></span>
                                    <form class="user" id="form_login" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email_admin" class="form-control form-control-user"
                                                id="email_admin" aria-describedby="emailHelp"
                                                placeholder="Masukkan email anda..." required autofocus data-parsley-type="email" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda.">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_admin" class="form-control form-control-user"
                                                id="password_admin" placeholder="Password" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan password anda.">
                                        </div>

                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->

                                        <div class="form-group">
                                            <input type="submit" name="tombol_login" id="tombol_login" class="btn btn-primary btn-user btn-block warna-warni" value="Login">
                                        </div>

                                        <hr>
    
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/FlexStart/assets/js/main.js"></script>

    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Datatables -->
    <script src="../vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Datepicker -->
    <script src="../vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

    <!-- TimePicker -->
    <script src="../vendor/moment/min/moment.min.js"></script>
    <script src="../vendor/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- SweetAlertJS -->
    <script src="../assets/js/sweetalert.min.js"></script> 

    <!-- parsley -->
    <script src="../vendor/parsleyjs/dist/parsley.js"></script>


<script>

$(document).ready(function(){

    $('#form_login').parsley();

    $('#form_login').on('submit', function(event){

        event.preventDefault();
        
        if($('#form_login').parsley().isValid())
        {       
            $.ajax({
                url:"login_action.php",
                method:"POST",
                data:$(this).serialize(),
                dataType:'json',
                beforeSend:function()
                {
                    $('#tombol_login').attr('disabled', 'disabled');
                    $('#tombol_login').val('memuat...');
                },
                success:function(data)
                {                   
                    $('#tombol_login').attr('disabled', false);
                    if(data.error != '')
                    {
                        $('#error').html(data.error);
                        $('#tombol_login').val('Login');
                    }
                    else
                    {
                        window.location.href = data.url;
                    }
                }
            })
        }
    });

});

</script>
</body>

</html>