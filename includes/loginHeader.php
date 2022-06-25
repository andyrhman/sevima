<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if (isset($judul_halaman)) {echo "$judul_halaman"; }?></title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css"/>

    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Jquery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
    
    <!-- Datepicker -->
    <link rel="stylesheet" href="vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />

    <!-- Timepicker -->
    <link rel="stylesheet" href="vendor/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css">

    <!-- SB admin theme -->
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">

    <link rel="stylesheet" href="assets/css/pass-show.css">

    <!-- Ajax -->
    <script src="vendor/popperjs/popper.min.js"></script>
    <link rel="stylesheet" href="assets/css/parsley.css" />
    <link rel="stylesheet" href="assets/css/loader.css" />
    <link rel="stylesheet" href="assets/css/toastSukses.css" />
    <link rel="stylesheet" href="assets/css/toastError.css" />
    <link rel="stylesheet" href="assets/css/imgHover.css" />
</head>



<body id="page-top">
<div class="container-fluid">

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        
        <div class="sidebar-brand-icon">
            <a class="navbar-brand" href="index.php" style="color:#50a1f2; font-weight: 600; font-size: 30px;">
            <img src="assets/img/school.png" width="40" class="d-inline-block align-top" alt="" loading="lazy">
            PendidikanKita</a>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <?php
                if (!isset($_SESSION['id_pengguna'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login / Register</a>
                    </li>

                    <?php
                }else {
                    
                    $object->query = "
                    SELECT * FROM pengguna 
                    WHERE id_pengguna = '".$_SESSION['id_pengguna']."'
                    ";

                    $user_result = $object->get_result();
                    
                    foreach($user_result as $row)
                    {
                        $nama_user = $row['nama_pengguna'];
                        $gambar_user = $row['foto_profil'];
                    }

                    ?>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-regular fa-user" style="color: #50a1f2;"></i>                    
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nama_user; ?></span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">

                            <a class="dropdown-item" href="profil.php">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <?php
                
                }
                ?>



            </ul>
        </div>
    </div>
</nav>

