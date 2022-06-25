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
            <a class="navbar-brand" href="panel.php" style="color:#50a1f2; font-weight: 600; font-size: 30px;">
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
                }
                ?>

                <?php 
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
            </ul>
        </div>
    </div>
</nav>

<!-- Side Navigattion -->
<div class="row gutters-sm">

    <div class="col-lg-3 mb-3">
        <?php
        $object->query = "
        SELECT * FROM pengguna 
        WHERE id_pengguna = '".$_SESSION["id_pengguna"]."'
        ";
        
        $hasil = $object->get_result();
        
        foreach ($hasil as $pengguna) {
            ?>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        
                    <div class="kontainer">
                        <img src="<?= $pengguna['foto_profil']?>" alt="Foto Profil" class="rounded-circle image" width="150" data-toggle="modal" data-target="#tombolGambar">
                        <div class="middle">
                            <div data-toggle="modal" data-target="#tombolGambar"><i class="fa-solid fa-pen-to-square"></i></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h4><?= $pengguna['nama_pengguna'];?></h4>
                        <p class="text-secondary mb-1"><?= $pengguna['email'];?></p>
                        <p class="text-muted font-size-sm"><?= $pengguna['alamat'];?></p>                                     
                    </div>
                    </div>
                </div>
            </div>                    
            <?php
        }

        ?>


        <!--  -->
        <div class="card mt-3">
            <ul class="list-group list-group-flush navbar-nav">
            <li class="nav-item list-group-item d-flex justify-content-between align-items-center flex-wrap <?php if (isset($kelas_active)) {echo "$kelas_active"; }?>">
                <a class="mb-0 nav-link <?php if (isset($kelas_text)) {echo "$kelas_text"; }?>" href="panel.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>                          
                    <span class="ml-3">Kelas</span>
                </a>
            </li>

            <li class="nav-item list-group-item d-flex justify-content-between align-items-center flex-wrap <?php if (isset($tugas_active)) {echo "$tugas_active"; }?>">
                <a class="mb-0 nav-link <?php if (isset($tugas_text)) {echo "$tugas_text"; }?>" href="tugas.php">
                    <i class="fa-solid fa-book-medical"></i>                         
                    <span class="ml-3">Tugas</span>
                </a>
            </li>

            <li class="nav-item list-group-item d-flex justify-content-between align-items-center flex-wrap <?php if (isset($quiz_active)) {echo "$quiz_active"; }?>">
                <a class="mb-0 nav-link <?php if (isset($quiz_text)) {echo "$quiz_text"; }?>" href="pilih-ujian.php">
                    <i class="fa-solid fa-award"></i>                          
                    <span class="ml-3">Quiz</span>
                </a>
            </li>
            
            <li class="nav-item list-group-item d-flex justify-content-between align-items-center flex-wrap <?php if (isset($profil_active)) {echo "$profil_active"; }?>">
                <a class="mb-0 nav-link <?php if (isset($profil_text)) {echo "$profil_text"; }?>" href="profil.php">
                    <i class="fa fa-id-card"></i>                          
                    <span class="ml-3">Profil</span>
                </a>
            </li>
            </ul>
        </div>
    </div>