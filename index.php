<?php

$judul_halaman = "Halaman Utama";

include('app/controllers/Ujianku.php');

$object = new Ujianku;

// if(isset($_SESSION['patient_id']))
// {
// 	header('location:pertemuan.php');
// }

// $object->query = "
// SELECT * FROM jadwal_dokter 
// INNER JOIN dokter 
// ON dokter.id_dokter = jadwal_dokter.id_dokter
// WHERE jadwal_dokter.jadwal_tanggal_dokter >= '".date('Y-m-d')."' 
// AND jadwal_dokter.status_pertemuan = 'Aktif' 
// AND dokter.status_dokter = 'Aktif' 
// ORDER BY jadwal_dokter.jadwal_tanggal_dokter ASC
// ";

// $result = $object->get_result();

?>

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

								<a class="dropdown-item" href="kelas.php">
									<i class="fas fa-sm fa-fw mr-2 fa-tachometer-alt text-gray-400"></i>
									Kelas
								</a>

								<a class="dropdown-item" href="pilih-ujian.php">
									<i class="fas fa-sm fa-fw mr-2 fa-award text-gray-400"></i>
									Quiz
								</a>
								
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


     <!-- Header-->
	 	<header class="bg-white py-5">
			<div class="container px-5">
				<div class="row gx-5 align-items-center justify-content-center">
					<div class="col-lg-8 col-xl-7 col-xxl-6">
						<div class="my-5 text-xl-start" style="color: black;">
							<h1 class="display-5 fw-bolder mb-2">Buat akunmu sekarang</h1>
							<p class="lead fw-normal mb-4">Tingkatkan ilmu pengetahuan dengan</br> mencoba tes ujian di website kami</p>
							<div class="d-grid gap-3 d-sm-flex justify-content-sm-start justify-content-xl-start">
								<a class="btn btn-primary btn-lg px-4 me-sm-3" href="daftar.php">Daftar Sekarang <i class="fa fa-long-arrow-right arrow1" aria-hidden="true"></i></a>	
							</div>
						</div>
					</div>
					<div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="assets/img/professor-teaching-calculation-to-students.png" alt="..." /></div>
				</div>
			</div>
		</header>


		<div class="container text-center">
			<h2 class="text-primary" style="font-weight: 600;">Manfaat belajar online</h2>
			<div class="container px-5 my-5">
				<div class="row gx-5">
					<div class="col-lg-4 mb-5">
						<div class="card h-100 shadow border-0">
							<img class="card-img-top" src="assets/img/blog.png" alt="..." />
							<div class="card-body p-4">
								<a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Dapat Diakses dengan Mudah</h5></a>
								<p class="card-text mb-0">Salah satu keuntungan belajar online di rumah adalah proses pembelajaran bisa diakses dengan mudah hanya dengan menggunakan smartphone, komputer atau laptop yang terhubung dengan jaringan internet.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 mb-5">
						<div class="card h-100 shadow border-0">
							<img class="card-img-top" src="assets/img/message-not-found.png" alt="..." />
							<div class="card-body p-4">
								<a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Waktu Belajar Lebih Fleksibel</h5></a>
								<p class="card-text mb-0">Waktu belajar pada pembelajaran online bisa dilakukan kapan saja karena biasanya akan ada pilihan waktu belajar yang bisa Moms pilih. Dalam satu kali pertemuan, akan dibutuhkan waktu mulai dari 1-3 jam saja. Tentu saja dengan begitu bisa menghemat banyak waktu.</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4 mb-5">
						<div class="card h-100 shadow border-0">
							<img class="card-img-top" src="assets/img/success.png" alt="..." />
							<div class="card-body p-4">
								<a class="text-decoration-none link-dark stretched-link" href="#!"><h5 class="card-title mb-3">Wawasan yang Didapat Lebih Luas</h5></a>
								<p class="card-text mb-0">Ketika belajar online di rumah, wawasan yang didapat anak bisa jauh lebih luas. Hal ini dikarenakan beberapa materi pelajaran pada e-learning masih ada yang belum tersedia di media cetak seperti buku fisik.</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Call to action-->
				<aside class="bg-white bg-gradient rounded-3 p-4 p-sm-5 mt-2">
					<div class="d-flex align-items-center justify-content-center flex-column flex-xl-row text-center text-xl-start">
						<div class="mb-4 mb-xl-0">
							<h2 class="text-primary" style="font-weight: 600;">Mari meningkat kreativitas anak bangsa dengan banyak belajar!</h2>
						</div>
					</div>
				</aside>
			</div>               
		</div>

<?php
include("includes/loginFooter.php");
?>

<script>
  
    function lihatPassword() {
		var x = document.getElementById("password");
		var x2 = document.getElementById("password2");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}

		if (x2.type === "password") {
			x2.type = "text";
		} else {
			x2.type = "password";
		}
	}

    // Mengaktifkan jQuery
	$(document).ready(function(){

        window.ParsleyValidator.addValidator('checkemail', {
            validateString: function(value){
                return $.ajax({
                    url:'user_action.php',
                    method:'post',
                    data:{halaman:'daftar_user', action:'cek_email', alamat_email:value},
                    dataType:"json",
                    async: false,
                    success:function(data)
                    {
                    return true;
                    }
                });
            }
        });

        window.ParsleyValidator.addValidator('ceknomorhp', {
            validateString: function(value){
                return $.ajax({
                    url:'user_action.php',
                    method:'post',
                    data:{halaman:'daftar_user', action:'cek_nomorhp', no_hp:value},
                    dataType:"json",
                    async: false,
                    success:function(data)
                    {
                    return true;
                    }
                });
            }
        });

        // Memvalidasi data form ketika pengguna mengisi data dengan parsley
        $('#form_daftar').parsley();
        // Ketika tombol submit ditekan
        $('#form_daftar').on('submit', function(event){

            event.preventDefault();
            
            // Jika semua form terisi dan tidak ada error 
            if($('#form_daftar').parsley().isValid())
            {
                //Membuat request AJAX
                $.ajax({

                    url:"user_action.php", //mengirimkan request ke file php
                    method:"POST", //menggunakan metode POST untuk mengirim data ke server
                    data:$(this).serialize(), //data yang akan dikirm ke server
                    dataType:'json', //data dikirim akan menggunakan format json
                    beforeSend:function(){

                        $('#modalDaftar').modal('hide');
                        $('#preloader').css('display', 'block');                    
                        $('#tombol_daftar_user').attr('disabled', 'disabled');


                    },
                    //function ini dipanggil jika request berhasil di selesaikan dan akan menerima data dari server
                    success:function(data)
                    {
                        $('#tombol_daftar_user').attr('disabled', false);

                        window.scrollTo(0,0);
                        // Jika berhasil menerima data dari server
                        if(data.error !== '') //Jika data yang diterima mengalami kesalahan
                        {
                            setTimeout(progress_bar_process, 500)
                            $('#message').html(data.error);
                          
                        }
                        // Jika data yang diterima berhasil di terima server 
                        if(data.success != '')  
                        {

                            window.location = "aktivasi.php";

                        }
                    }
                });
            }

        });

        function progress_bar_process()
        {
            $('#preloader').css('display', 'none');
            // $("#password").get(0).scrollIntoView();
            window.scrollTo(0,0);

        }

    });

	function update() {
		var select = document.getElementById('form_prov');
		var option = select.options[select.selectedIndex];

		document.getElementById('value').value = option.value;
		document.getElementById('text').value = option.text;
	}
	update();

	function update_kota() {
		var select = document.getElementById('form_kab');
		var option = select.options[select.selectedIndex];

		document.getElementById('value1').value = option.value;
		document.getElementById('text1').value = option.text;
	}
	update_kota();

	function update_kecamatan() {
		var select = document.getElementById('form_kec');
		var option = select.options[select.selectedIndex];

		document.getElementById('value2').value = option.value;
		document.getElementById('text2').value = option.text;
	}
	update_kecamatan();

	$(document).ready(function(){

		// sembunyikan form kabupaten, kecamatan dan desa
		// $("#form_kab").hide();
		// $("#form_kec").hide();
		// $("#form_des").hide();

		// ambil data kabupaten ketika data memilih provinsi
		$('body').on("change","#form_prov",function(){
			var id = $(this).val();
			var data = "id="+id+"&data=kabupaten";
			$.ajax({
				type: 'POST',
				url: "app/controllers/get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_kab").html(hasil);
					$("#form_kab").show();

				}
			});
		});

		// ambil data kecamatan/kota ketika data memilih kabupaten
		$('body').on("change","#form_kab",function(){
			var id = $(this).val();
			var data = "id="+id+"&data=kecamatan";
			$.ajax({
				type: 'POST',
				url: "app/controllers/get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_kec").html(hasil);
					$("#form_kec").show();
	
				}
			});
		});

		// ambil data desa ketika data memilih kecamatan/kota
		$('body').on("change","#form_kec",function(){
			var id = $(this).val();
			var data = "id="+id+"&data=desa";
			$.ajax({
				type: 'POST',
				url: "app/controllers/get_daerah.php",
				data: data,
				success: function(hasil) {
					$("#form_des").html(hasil);
					$("#form_des").show();
				}
			});
		});


	});

</script>


</body>

</html>