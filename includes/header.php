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
</head>



<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-syringe"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dashboard</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if (isset($dashboard_active)) {echo "$dashboard_active"; }?>">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Lainnya
            </div>

            <li class="nav-item <?php if (isset($pertemuan_active)) {echo "$pertemuan_active"; }?>">
                <a class="nav-link" href="pertemuan.php" >
                    <i class="fa-solid fa-book-medical"></i>
                    <span>Riwayat Pertemuan</span>
                </a>
            </li>

                <?php
                	$object->query = "
                    SELECT * FROM pertemuan_vaksinasi 
                    INNER JOIN pengguna 
                    ON pengguna.id_pengguna = pertemuan_vaksinasi.id_pengguna 
                    WHERE pertemuan_vaksinasi.id_pengguna = '".$_SESSION["id_pengguna"]."'
                    ";
                
                    $data_pertemuan = $object->get_result();

                    foreach ($data_pertemuan as $row)
                    {

                        
                        if ($row['id_pengguna'] == $_SESSION["id_pengguna"]) {
                            ?>
                            <li class="nav-item <?php if (isset($tiket_active)) {echo "$tiket_active"; }?>">
                                    <a class="nav-link" href="tiket-vaksinasi.php?id=<?= $row["id_pengguna"];?>" >
                                    <i class="fa-solid fa-ticket"></i>
                                    <span>Riwayat & Tiket Vaksin</span>
                                </a>
                            </li>
                            <?php
                        }else {
                            header("Location:dashboard.php");
                        }


                        
                    }
                ?>
                <li class="nav-item <?php if (isset($profil_active)) {echo "$profil_active"; }?>">
                    <a class="nav-link" href="profil.php" >
                        <i class="fa fa-id-card"></i>
                        <span>Profil</span>
                    </a>
                </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">


                        <div class="topbar-divider d-none d-sm-block"></div>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nama_user; ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?php echo $gambar_user; ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="profile.php">
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

                </nav>
                <!-- End of Topbar -->