<?php
session_start();

include("../../path.php");
include(ROOT_PATH . "/app/database/connect.php");

//PHP MAILER DEPENDECIES
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';

function password_reset($get_email, $token){

    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.mail.yahoo.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'mailerbotfortest@yahoo.com';
    $mail->Password = 'bjysjvtsllitcgdo';
    $mail->From = 'mailerbotfortest@yahoo.com';
    $mail->FromName = 'PendidikanKita';
    $mail->AddAddress($get_email);
    $mail->WordWrap = 50;
    $mail->IsHTML(true);
    $mail->Subject = 'Permintaan reset password dari website PendidikanKita';

    $message_body = '

    <table width="100%">
    
        <tr>
            <td bgcolor="#45bded" align="center">
                <table width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#45bded" align="center">
                <tablewidth="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" >
                            <h1>LINK RESET PASSWORD</h1> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <p style="margin: 0;">Anda telah meminta untuk reset password anda di website PendidikanKita. Silahkan klik link dibawah ini untuk reset paswword anda.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="center">
                            <a href="http://localhost/pendidikankita/ganti-password.php?token='.$token.'&email='.$get_email.'">Klik Aku</a>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <p style="margin: 0;">Jika anda punya pertanyaan, silahkan kirim balasan&mdash;ke email ini, kami bersedia untuk membantu.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <p style="margin: 0;">Salam hormat,<br>Andy Rahman</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    ';
    $mail->Body = $message_body;
    $mail-> send();

}

if (isset($_POST['reset-password'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $token = md5(rand());

    $cek_email = "SELECT email FROM pengguna WHERE email='$email' LIMIT 1";
    $cek_email_run = mysqli_query($conn, $cek_email);

    //Cek email
    if (mysqli_num_rows($cek_email_run) > 0) {
        // Jika email ada
        $row = mysqli_fetch_array($cek_email_run);

        $get_email = $row['email'];

        $update_token = "UPDATE pengguna SET token_verifikasi='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($conn, $update_token);

        if ($update_token_run) {
            
            password_reset($get_email, $token);

            $_SESSION['message'] = "Password reset telah terkirim di email anda";
            $_SESSION['teks'] = "Silahkan cek email anda";
            $_SESSION['status'] = "success";
            header("Location: ../../login.php");
            exit(0);
            
        }
        else {
            $_SESSION['login_status'] = "Terjadi kesalahan, silahkan coba lagi";
            $_SESSION['colour'] = "alert-warning";
            header("Location: ../../login.php");
            exit(0);
        }
        
        
    
    //Email tidak ada
    }else {
        $_SESSION['login_status'] = "Email tidak ditemukan";
        $_SESSION['colour'] = "alert-danger";
        header("Location: ../../login.php");
        exit(0);
    }

}


if (isset($_POST['ganti-password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_baru = mysqli_real_escape_string($conn, $_POST['password_baru']);

    $token = mysqli_real_escape_string($conn, $_POST['password_token']);

    //Jika token ditemukan
    if (!empty($token)) {

        // Cek jika token valid atau tidak

        $cek_token = "SELECT token_verifikasi FROM pengguna WHERE token_verifikasi='$token' LIMIT 1";
        $cek_token_run = mysqli_query($conn, $cek_token);

        //Jika token ada
        if (mysqli_num_rows($cek_token_run) > 0) {
            
            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $_POST['password_baru']))
            {
                $_SESSION['login_status'] = "Password harus minimal 6 karakter dan mempunyai 1 nomor digit!";
                $_SESSION['colour'] = "alert-danger";
                header("Location: ../../ganti-password.php?token=$token&email=$email");
                exit(0);
            
            } else {

                $encpass = password_hash($password_baru, PASSWORD_DEFAULT);
                // Update password
                $update_password = "UPDATE pengguna SET password='$encpass' WHERE token_verifikasi='$token' LIMIT 1";
                $update_password_run = mysqli_query($conn, $update_password);

                if ($update_password_run) {
                    //Update token 
                    $token_baru = md5(rand())."Tataran";
                    $update_token_baru = "UPDATE pengguna SET token_verifikasi='$token_baru' WHERE token_verifikasi='$token' LIMIT 1";
                    $update_token_baru_run = mysqli_query($conn, $update_token_baru);

                    $_SESSION['message'] = "Password sukses terupdate!";
                    $_SESSION['teks'] = "Sekarang anda bisa login";
                    $_SESSION['status'] = "success";
                    header("Location: ../../login.php");
                    exit(0);
                }
                else {
                    $_SESSION['message'] = "Password tidak terupdate!";
                    $_SESSION['teks'] = "Ada kesalahan terjadi";
                    $_SESSION['status'] = "error";
                    header("Location: ../../login.php");
                    exit(0);
                }


            }

        }
        else //Jika token tidak ada
        {
            $_SESSION['login_status'] = "Token tidak valid!";
            $_SESSION['colour'] = "alert-danger";
            header("Location: ../../ganti-password.php?token=$token&email=$email");
            exit(0);
        }

    }
    else {
        $_SESSION['login_status'] = "Token tidak ditemukan!";
        $_SESSION['colour'] = "alert-danger";
        header("Location: ../../login.php");
        exit(0);
    }



}



?>