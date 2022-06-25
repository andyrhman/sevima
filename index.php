<?php

$judul_halaman = "Halaman Utama";

// include('app/controllers/Vaksinku.php');

// $object = new Vaksinku;

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

<?php include("includes/header2.php");?>

    <div class="container">
        <h1>Index.php</h1>
    </div>

<?php
include("includes/footer2.php");
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