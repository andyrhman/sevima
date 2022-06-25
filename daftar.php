<?php
$judul_halaman = "Registrasi Akun";
include("includes/loginHeader.php");
include("path.php");
include(ROOT_PATH . "/app/database/connect.php");
?>
    <div id="container" class="container">
        <span id="message"></span>
        <div class="row justify-content-center">
            <div class="col-lg-6 d-none d-lg-block"><img class="my-5" style="position: relative; top:40px" src="assets/img/robot-checking-user-profile.png" alt="Logo" width="600"></div>
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h3 class="mb-4 text-primary" style="font-weight:600">Daftar Untuk Masuk</h3>
                            </div>
                            <form class="user" method="post" id="form_daftar">
                               
                                <div class="form-group">
                                    <label>Nama Lengkap<span class="text-danger">*</span> </label> 
                                    <input type="text" class="form-control form-control-user" name="nama_lengkap" id="nama_lengkap" oninput="this.value = this.value.toUpperCase()"
                                        placeholder="Nama Lengkap" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan nama pertama anda.">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir<span class="text-danger">*</span> </label> 
                                    <input type="text" class="form-control form-control-user" name="tanggal_lahir" id="tanggal_lahir" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan tangal lahir anda.">
                                </div>
                                <div class="form-group">
                                    <label>Email<span class="text-danger">*</span> </label> 
                                    <input type="email" class="form-control form-control-user" name="alamat_email" id="email"
                                        placeholder="Alamat email anda" required autofocus data-parsley-type="email" data-parsley-type-message="Email harus valid" data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan email anda." data-parsley-checkemail data-parsley-checkemail-message='Email anda sudah terdaftar' >
                                </div>
                                <label>Password<span class="text-danger">*</span> </label> 
                                <div class="form-group row">
                                    
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password" id="password" class="form-control form-control-user"
                                            placeholder="Password" required  data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan password anda.">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" id="password2" class="form-control form-control-user"
                                            placeholder="Konfirmasi Password" required data-parsley-trigger="keyup" data-parsley-equalto="#password" data-parsley-equalto-message="Password tidak sama" data-parsley-required-message="Harus diisi.">
                                    </div>
                                </div>

                                <div class="form-group"> 
                                    <input type="checkbox" onclick="lihatPassword()"> Tunjukkan Password
                                </div> 

                                <div class="form-group">
                                    <label>Jenis Kelamin<span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan jenis kelamin anda.">
                                            <option></option>
                                            <option>Laki-Laki</option>
                                            <option>Perempuan</option>
                                    </select>
                                </div> 

                                <div class="form-group">
                                    <label>No HP<span class="text-danger">*</span> </label> 
                                    <input type="text" class="form-control form-control-user" name="no_hp" id="no_hp"
                                        placeholder="No telepon yang aktif" required data-parsley-trigger="keyup" data-parsley-required-message="Mohon masukkan No HP anda." 
                                        data-parsley-ceknomorhp data-parsley-ceknomorhp-message='Nomor HP anda sudah terdaftar' 
                                        data-parsley-pattern='^[0-9]+$' data-parsley-pattern-message="Nomor HP harus valid">
                                </div>
                                
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-user btn-block" data-toggle="modal" data-target="#modalDaftar">Daftar</button>
                                </div> <!-- form-group// -->

                                <!-- Modal daftar akun -->
                                <div class="modal fade" id="modalDaftar">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title"><strong>Apakah informasi anda sudah sesuai dan benar?</strong></h4>
                                                <button type="button" class="close" data-dismiss="modal">×</button>
                                            </div>
                                  
                                            <div class="modal-body">                                       
                                                <p>Anda tidak diperkenankan mengubah informasi detil 
                                                 anda setelah ini, apakah anda ingin melanjutkan?</p>
                                                                                   
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <!-- Field value "daftar user" akan digunakan di kode ajax -->
                                                <input type="hidden" name='halaman' value='daftar_user' />
                                                <input type="hidden" name="action" value="daftar_user" />
                                                <!-- Ketika tombol dibawah di klik semua data pengguna yang telah diisi di form akan dikirim ke server PHP menggunakan ajax -->
                                                <button type="submit" id="tombol_daftar_user" class="btn btn-primary btn-user btn-block" value="Register">Ya, Lanjutkan</button>

                                                <button type="button" class="btn btn-outline-primary btn-user btn-block" data-dismiss="modal">Periksa kembali</button>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <hr>

                            <div class="text-center">
                                <a class="small" href="login.html">Sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                        
                    
                </div>
            </div>
        </div>
    </div>


    <div id="preloader" style="display: none; background-color: white;">

        <h1 class="title">Memuat...</h1>
        <div id="loader"></div>
    </div>
<?php
include("includes/loginFooter.php");
?>

<script>
    var date = new Date();
    date.setDate(date.getDate());
    $('#tanggal_lahir').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });

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