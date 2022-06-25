<?php

//action.php

include('app/controllers/Ujianku.php');

// Membuat objek class Appointment untuk digunakan nanti
$object = new Ujianku;

//PHP MAILER DEPENDECIES
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Jika tombol ditekan maka akan menjalankan kode dibawah
if(isset($_POST["halaman"]))
{
    if ($_POST['halaman'] == 'daftar_user') {

		if($_POST['action'] == 'cek_email')
		{
			$object->query = "
			SELECT * FROM pengguna 
			WHERE email = '".trim($_POST["alamat_email"])."'
			";

			$total_row = $object->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

		if($_POST['action'] == 'cek_nomorhp')
		{
			$object->query = "
			SELECT * FROM pengguna 
			WHERE nomor_hp = '".trim($_POST["no_hp"])."'
			";

			$total_row = $object->total_row();

			if($total_row == 0)
			{
				$output = array(
					'success'		=>	true
				);
				echo json_encode($output);
			}
		}

        // Jika tombol action di halaman daftar
        if($_POST['action'] == 'daftar_user')
        {
            $error = '';

            $success = '';

            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $_POST['password']))
            {
                $error = '			
                <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">
                    <span class="badge badge-pill badge-warning"><i class="fa-solid fa-exclamation"></i></span>
                    Password harus 6 karakter dan mempunyai 1 nomor digit.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
            else
            {
                $foto_profil = '';

                $nama = $_POST["nama_lengkap"][0];
                $tempat = "assets/img/". time() . ".png";
                $gambar = imagecreate(200, 200);
                $merah = rand(0, 255);
                $hijau = rand(0, 255);
                $biru = rand(0, 255);
                imagecolorallocate($gambar, 230, 230, 230);  
                $warnateks = imagecolorallocate($gambar, $merah, $hijau, $biru);
                imagettftext($gambar, 100, 0, 55, 150, $warnateks, 'font/arial.ttf', $nama);
                imagepng($gambar, $tempat);
                imagedestroy($gambar);
                $foto_profil = $tempat;

                $email = $_POST['alamat_email'];
                $verify_token = md5(rand());
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
                $data = array(
                    ':email'				=>	$object->clean_input($_POST["alamat_email"]),
                    ':password'				=>	$password,
                    ':nama_lengkap'			=>	$object->clean_input($_POST["nama_lengkap"]),
                    ':tanggal_lahir'		=>	$object->clean_input($_POST["tanggal_lahir"]),
                    ':jenis_kelamin'		=>	$object->clean_input($_POST["jenis_kelamin"]),
                    ':foto_profil'			=>	$foto_profil,
                    ':nomor_hp'				=>	$object->clean_input($_POST["no_hp"]),
                    ':dibuat_pada'			=>	$object->now,
                    ':token_verifikasi'		=>	$verify_token,
                    ':status_verifikasi'    => 'Tidak'
                );
    
                $object->query = "
                INSERT INTO pengguna (email, password, nama_pengguna, tanggal_lahir, jenis_kelamin, foto_profil, nomor_hp, dibuat_pada, token_verifikasi, status_verifikasi) 
                VALUES (:email, :password, :nama_lengkap, :tanggal_lahir, :jenis_kelamin, :foto_profil, :nomor_hp, :dibuat_pada, :token_verifikasi, :status_verifikasi)
                ";
    
                $object->execute($data);
    
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
    
                if($mail->Send())
                {
                    $success = '<div class="alert alert-success">Please Check Your Email for email Verification</div>';
                }
                else
                {
                    $error = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle fa-fw"></i>' . $mail->ErrorInfo . '</div>';
                }
            }

            $output = array(
                'error'		=>	$error,
                'success'	=>	$success
            );
            // Mengirim data ke AJAX menggunakan format json
            echo json_encode($output);
        }

    }

	if($_POST["action"] == 'cek_login')
	{
		if(isset($_SESSION['id_pengguna']))
		{
			echo 'pertemuan.php';
		}
		else
		{
			echo 'login.php';
		}
	}

    if ($_POST['halaman'] == 'login_user') {

        if($_POST['action'] == 'login_user')
        { 
            $error = '';
    
            $data = array(
                ':email'	=>	$_POST["alamat_email"]
            );
    
            $object->query = "
            SELECT * FROM pengguna 
            WHERE email = :email
            ";
    
            $object->execute($data);
            
            if($object->row_count() > 0)
            {
    
                $result = $object->statement_result();
    
                foreach($result as $row)
                {
                    if($row["status_verifikasi"] == 'Ya')
                    {
                        // Memeriksa password yang pengguna isi sama dengan password yang ada di database
                        if(password_verify($_POST["password"] ,$row["password"]))
                        {                               
                            $_SESSION['id_pengguna'] = $row['id_pengguna'];
                            $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
                            // Jika pengguna mengisi centang form ingat saya maka sistem akan mengingat pengguna tidak perlu isi form lagi
                            if (!empty($_POST['ingat-saya'])) {
                                setcookie ("email_pengguna",$_POST["alamat_email"],time()+ (10 * 365 * 24 * 60 * 60));  
                                setcookie ("password_pengguna",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
                            } 
                            else  
                            {  
                                if(isset($_COOKIE["email_pengguna"]))   
                                {  
                                    setcookie ("email_pengguna","");  

                                }  

                                if(isset($_COOKIE["password_pengguna"]))   
                                {  
                                    setcookie ("password_pengguna","");  

                                }  
                            } 
 
                        }
                        else
                        {
                            $error = '    
                            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                <span class="badge badge-pill badge-danger"><i class="fa-solid fa-exclamation"></i></span>
                                Password atau email salah.
                            </div>'
                            ;

                        }
                    }
                    else
                    {
                        $error = '
                        <div class="sufee-alert alert with-close alert-warning alert-dismissible fade show">
                            <span class="badge badge-pill badge-warning"><i class="fa-solid fa-exclamation"></i></span>
                            Email belum di verifikasi! Jika email belum terkirim 
                            <a class="text-primary" href="#" type="button" data-toggle="modal" data-target="#kirimEmail">Kirim ulang kode verifikasi</a>
                        </div>'
                        ;
                    }
                }
            }
            else
            {
                $error = '
                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                    <span class="badge badge-pill badge-danger">Error</span>
                    Password atau email salah.
                </div>'
                ;
            }
    
            $output = array(
                'error'		=>	$error
            );
    
            echo json_encode($output);
    
        }
    }

};
?>