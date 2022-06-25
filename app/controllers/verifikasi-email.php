<?php 
session_start();
include("../../path.php"); 
include(ROOT_PATH . "/app/database/connect.php");

if (isset($_GET['token'])) {

    $token = $_GET['token']; //Mengambil url token
    $query = "SELECT token_verifikasi, status_verifikasi FROM pengguna WHERE token_verifikasi='$token' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    // Cek jika token ada atau tidak
    if (mysqli_num_rows($query_run) > 0) {
        
        //Mengambil satu tabel dari users
        $row = mysqli_fetch_array($query_run);

        //Cek jika token terverifikasi atau tidak
        if ($row['status_verifikasi'] == "Tidak") {
            
            //Update verify_status menjadi 1
            $token_klik = $row['token_verifikasi'];
            $update_query = "UPDATE pengguna SET status_verifikasi='Ya' WHERE token_verifikasi='$token_klik' LIMIT 1";
            $update_query_run = mysqli_query($conn, $update_query);

            //Jika berhasil pesan muncul
            if ($update_query_run) {
                $_SESSION['message'] = "Akun anda telah terverifikasi!";
                $_SESSION['teks'] = "Anda sudah bisa login";
                $_SESSION['status'] = "success";
                header("Location: ../../login.php");
                exit(0);
            }else {
                $_SESSION['message'] = "Verifikasi gagal";
                $_SESSION['teks'] = "Klik tombol oke untuk keluar";
                $_SESSION['status'] = "error";
                header("Location: ../../login.php");
                exit(0);
            }

        }else {
            $_SESSION['message'] = "Email sudah terverifikasi!";
            $_SESSION['teks'] = "Silahkan login kembali";
            $_SESSION['status'] = "warning";
            header("Location: ../../login.php");
            exit(0);
        }



    }else {
        $_SESSION['message'] = "Token tidak ditemukan";
        $_SESSION['teks'] = "Klik tombol oke untuk keluar";
        $_SESSION['status'] = "error";
        header("Location: ../../login.php");
        exit(0);
    }

}


?>