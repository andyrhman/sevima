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

function resend_email($email, $verify_token){
    
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
    $mail->FromName = 'UjianKita';
    $mail->AddAddress($email);
    $mail->WordWrap = 50;
    $mail->IsHTML(true);
    $mail->Subject = 'Kode verifikasi untuk Email UjianKita';

    $message_body = '

        <table width="100%">
            <!-- LOGO -->
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
                                <h1>Kode Verifikasi Login</h1> 
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
                                <p style="margin: 0;">Akun anda telah terdaftar di website UjianKita. Silahkan verifikasi akun anda dengan mengklik tombol di bawah ini.</p>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" align="center">
                                <a href="http://localhost/ujiankita/app/controllers/verifikasi-email.php?token='.$verify_token.'">Klik Aku</a>
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
    //echo 'Pesan berhasil terkirim';

}


if(isset($_POST['kirim-kode'])) 
{    
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = "SELECT * FROM pengguna WHERE email='$email' LIMIT 1";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {

        $row = mysqli_fetch_array($query_run);
        if ($row['status_verifikasi'] == "Tidak") {

            $email = $row['email'];
            $verify_token = $row['token_verifikasi'];

            resend_email($email, $verify_token);

            $_SESSION['message'] = "Email verifikasi telah terkirim!";
            $_SESSION['teks'] = "Silahkan cek email anda";
            $_SESSION['status'] = "success";
            header("Location: ../../login.php");
            exit(0);
        }
        else {
            $_SESSION['login_status'] = "Email sudah terverifikasi, silahkan login";
            $_SESSION['colour'] = "alert-warning";
            header("Location: ../../login.php");
            exit(0); 
        }



    }
    else{
        $_SESSION['message'] = "Email anda tidak terdaftar!";
        $_SESSION['teks'] = "Anda memasukkan email yang salah";
        $_SESSION['status'] = "error";
        header("Location: ../../login.php");
        exit(0); 
    }

}

?>