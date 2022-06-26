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
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'cek_login')
	{
		if(isset($_SESSION['patient_id']))
		{
			echo 'pertemuan.php';
		}
		else
		{
			echo 'login.php';
		}
	}

	if($_POST['action'] == 'fetch_jadwal')
	{
		$output = array();

        $order_column = array('tempat_vaksin.nama_tempat', 'jenis_vaksin.nama_vaksin', 'jadwal_vaksin.jadwal_tanggal_vaksin', 'jadwal_vaksin.jadwal_hari_vaksin', 'jadwal_vaksin.jadwal_waktu_mulai', 'jadwal_vaksin.jadwal_waktu_berakhir');
        
        $main_query = "
        SELECT * FROM jadwal_vaksin 
        INNER JOIN jenis_vaksin 
        ON jenis_vaksin.id_vaksin = jadwal_vaksin.id_vaksin 
        INNER JOIN tempat_vaksin 
        ON tempat_vaksin.id_tempat = jadwal_vaksin.id_tempat 
        ";

		$search_query = '
		WHERE jadwal_vaksin.jadwal_tanggal_vaksin >= "'.date('Y-m-d').'" 
		AND jadwal_vaksin.status_jadwal = "Aktif" 
		AND jenis_vaksin.status_vaksin = "Tersedia" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( tempat_vaksin.nama_tempat LIKE "%'.$_POST["search"]["value"].'%" ';
            $search_query .= 'OR jenis_vaksin.nama_vaksin LIKE "%'.$_POST["search"]["value"].'%" ';
            $search_query .= 'OR jadwal_vaksin.jadwal_tanggal_vaksin LIKE "%'.$_POST["search"]["value"].'%" ';
            $search_query .= 'OR jadwal_vaksin.jadwal_hari_vaksin LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY jadwal_vaksin.jadwal_tanggal_vaksin ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["nama_tempat"];

			$sub_array[] = $row["nama_vaksin"];

			$sub_array[] = $row["jadwal_tanggal_vaksin"];

			$sub_array[] = $row["jadwal_hari_vaksin"];

			$sub_array[] = $row["jadwal_waktu_mulai"];

			$sub_array[] = $row["jadwal_waktu_berakhir"];

			$sub_array[] = '
			<div align="center">
			<button type="button" name="detail_vaksinasi" class="btn btn-primary btn-sm detail_vaksinasi" data-id_vaksin="'.$row["id_vaksin"].'" data-id_tempat="'.$row["id_tempat"].'" data-id_jadwal_vaksin="'.$row["id_jadwal_vaksin"].'">Terima Vaksin</button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	if($_POST['action'] == 'edit_profile')
	{
		$data = array(
			':password'			=>	$_POST["password"],
			':nama_pertama'		=>	$_POST["nama_pertama"],
			':nama_kedua'		=>	$_POST["nama_kedua"],
			':nik'				=>	$_POST["nik"],
			':tanggal_lahir'	=>	$_POST["tanggal_lahir"],
			':jenis_kelamin'	=>	$_POST["jenis_kelamin"],
			':alamat'			=>	$_POST["alamat"],
			':no_hp'			=>	$_POST["no_hp"],
			':provinsi'			=>	$_POST["provinsi"],
			':kabupaten_kota'	=>	$_POST["kota"],
			':kecamatan'		=>	$_POST["kecamatan"],
			
		);

		$object->query = "
		UPDATE users  
		SET password 	 = :password, 
		firstname 		 = :nama_pertama, 
		lastname 		 = :nama_kedua, 
		nik 			 = :nik, 
		tanggal_lahir 	 = :tanggal_lahir, 
		jenis_kelamin 	 = :jenis_kelamin, 
		alamat 			 = :alamat, 
		nomor_hp 		 = :no_hp, 
		provinsi 		 = :provinsi, 
		kabupaten_kota 	 = :kabupaten_kota, 
		kecamatan 		 = :kecamatan
		WHERE patient_id = '".$_SESSION['patient_id']."'
		";

		$object->execute($data);

		$_SESSION['pesan'] = 'Profil anda berhasil diupdate';

	}

	if($_POST['action'] == 'detail_vaksinasi')
	{

		$object->query = "
		SELECT * FROM pengguna 
		WHERE id_pengguna = '".$_SESSION["id_pengguna"]."'
		";

		$data_pasien = $object->get_result();

		foreach($data_pasien as $row_pasien)
		{
			$html = '
			<h4 class="text-center">Detail Pasien</h4>
			<table class="table">
			';

			$html .= '
			<tr>
				<th width="40%" class="text-right">Nama Pasien</th>
				<td>'.$row_pasien["nama_pengguna"].'</td>
			</tr>
			<tr>
			<th width="40%" class="text-right">NIK</th>
				<td>'.$row_pasien["nik"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">No Telepon</th>
				<td>'.$row_pasien["nomor_hp"].'</td>
			</tr>
			<tr>
				<th width="40%" class="text-right">Alamat</th>
				<td>'.$row_pasien["alamat"].'</td>
			</tr>
			';
		
			$object->query = "
			SELECT * FROM jadwal_vaksin 
			INNER JOIN jenis_vaksin 
			ON jenis_vaksin.id_vaksin = jadwal_vaksin.id_vaksin 
			INNER JOIN tempat_vaksin 
			ON tempat_vaksin.id_tempat = jadwal_vaksin.id_tempat 
			WHERE jadwal_vaksin.id_jadwal_vaksin = '".$_POST["id_jadwal_vaksin"]."'
			";
			
			$data_jadwal_vaksinasi = $object->get_result();

			$data_pasien = $object->get_result();
			$html .= '
			</table>
			<hr />
			<h4 class="text-center">Detail Pertemuan Vaksinasi</h4>
			<table class="table">
			';
			
			foreach($data_jadwal_vaksinasi as $row_jadwal_vaksinasi)
			{
				$html .= '
				<tr>
					<th width="40%" class="text-right">Nama Tempat</th>
					<td>'.$row_jadwal_vaksinasi["nama_tempat"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Vaksin Yang Akan Diterima</th>
					<td><span class="badge badge-primary">'.$row_jadwal_vaksinasi["nama_vaksin"].'</span></td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Tanggal Vaksinasi</th>
					<td>'.$row_jadwal_vaksinasi["jadwal_tanggal_vaksin"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Hari Pertemuan</th>
					<td>'.$row_jadwal_vaksinasi["jadwal_hari_vaksin"].'</td>
				</tr>
				<tr>
					<th width="40%" class="text-right">Waktu Vaksinasi</th>
					<td>'.$row_jadwal_vaksinasi["jadwal_waktu_mulai"].' - '.$row_jadwal_vaksinasi["jadwal_waktu_berakhir"].'</td>
				</tr>
				';
			}
		
			$html .= '
			</table>';
		}
		echo $html;
	}

	if($_POST['action'] == 'terima_vaksin')
	{
		$error = '';
		
		$data = array(
			':id_pengguna'			=>	$_SESSION['id_pengguna'],	
		);

		$object->query = "
		SELECT * FROM pertemuan_vaksinasi 
		WHERE id_pengguna = :id_pengguna 
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '
			<div class="alert alert-danger">Anda sudah memesan pertemuan Vaksinasi, mohon cek tiket anda secara berkala untuk informasi selanjutnya.</div>
			<div class="utama-error" id="pemanggangError" style="display:block;">
				<div class="pemanggang-error">
					<div class="konten-error">
						<div class="ikon-error"><i class="fa-solid fa-xmark"></i></div>
						<div class="detail">
						<span>Error</span>
						<p>Terjadi Kesalahan.</p>
						</div>
					</div>
					<!-- <div class="close-ikon-error"><i class="fa-solid fa-xmark"></i></div> -->
				</div>
			</div>
			';
		
		}
		else
		{

			$appointment_number = $object->Generate_appointment_no();
	
			$data = array(
				':id_pengguna'				=>	$_SESSION['id_pengguna'],
				':id_vaksin'				=>	$_POST['id_vaksin'],
				':id_tempat'				=>	$_POST['id_tempat'],
				':id_jadwal_vaksin'			=>	$_POST['id_jadwal_vaksin'],
				':no_pertemuan'				=>	$appointment_number,
				':status'					=>	'Menunggu',
				':kedatangan_pasien'		=>	'Tidak', 
				':selesai_vaksin'			=>	'Belum', 
				':sudah_vaksin_dosis_1'		=>	'Tidak', 
				':sudah_vaksin_dosis_2'		=>	'Tidak'
			);

			$object->query = "
			INSERT INTO pertemuan_vaksinasi 
			(id_pengguna, id_vaksin, id_tempat, id_jadwal_vaksin, no_pertemuan_vaksinasi, status, kedatangan_pasien, selesai_vaksin, sudah_vaksin_dosis_1, sudah_vaksin_dosis_2) 
			VALUES (:id_pengguna, :id_vaksin, :id_tempat, :id_jadwal_vaksin, :no_pertemuan, :status, :kedatangan_pasien, :selesai_vaksin, :sudah_vaksin_dosis_1, :sudah_vaksin_dosis_2)
			";

			$object->execute($data);

			$_SESSION['pesan'] = 'Pertemuan sedang di proses';
		}




		echo json_encode(['error' => $error]);
		
	}

	if($_POST['action'] == 'fetch_pertemuan')
	{
		$output = array();

		$order_column = array('pertemuan_vaksinasi.no_pertemuan_vaksinasi','pengguna.nama_pengguna', 'jadwal_vaksin.jadwal_tanggal_vaksin', 'tempat_vaksin.nama_tempat', 'jadwal_vaksin.jadwal_hari_vaksin', 'jadwal_vaksin.jadwal_waktu_mulai', 'jadwal_vaksin.jadwal_waktu_berakhir', 'pertemuan_vaksinasi.status');
		
		$main_query = "
		SELECT * FROM pertemuan_vaksinasi  
		INNER JOIN pengguna 
		ON pengguna.id_pengguna = pertemuan_vaksinasi.id_pengguna 
		INNER JOIN jadwal_vaksin 
		ON jadwal_vaksin.id_jadwal_vaksin = pertemuan_vaksinasi.id_jadwal_vaksin 
		INNER JOIN tempat_vaksin 
		ON tempat_vaksin.id_tempat = pertemuan_vaksinasi.id_tempat 
		";

		$search_query = '
		WHERE pertemuan_vaksinasi.id_pengguna = "'.$_SESSION["id_pengguna"].'" 
		';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'AND ( pertemuan_vaksinasi.no_pertemuan_vaksinasi LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR jadwal_vaksin.jadwal_tanggal_vaksin LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tempat_vaksin.nama_tempat LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR jadwal_vaksin.jadwal_hari_vaksin LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR pertemuan_vaksinasi.status LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		
		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY pertemuan_vaksinasi.id_pertemuan ASC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query . $search_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();

			$sub_array[] = $row["no_pertemuan_vaksinasi"];

			$sub_array[] = $row["nama_pengguna"];

			$sub_array[] = $row["jadwal_tanggal_vaksin"];			

			$sub_array[] = $row["nama_tempat"];

			$sub_array[] = $row["jadwal_hari_vaksin"];

			$sub_array[] = $row["jadwal_waktu_mulai"]. ' - ' .$row["jadwal_waktu_berakhir"];
			
			$status = '';

			if($row["status"] == 'Menunggu')
			{
				$status = '<span class="badge badge-warning">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Di proses')
			{
				$status = '<span class="badge badge-primary">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Selesai')
			{
				$status = '<span class="badge badge-success">' . $row["status"] . '</span>';
			}

			if($row["status"] == 'Batal')
			{
				$status = '<span class="badge badge-danger">' . $row["status"] . '</span>';
			}

			$sub_array[] = $status;
			
			if ($row["status"] == 'Batal') {
				$sub_array[] = '<button type="button" name="batalkan_pertemuan" style="display:none;" class="btn btn-danger btn-sm batalkan_pertemuan"><i class="fas fa-times"></i></button>';
			}
			elseif($row["status"] == 'Selesai'){
				$sub_array[] = '<button type="button" name="batalkan_pertemuan" style="display:none;" class="btn btn-danger btn-sm batalkan_pertemuan"><i class="fas fa-times"></i></button>';
			}
			else {
				$sub_array[] = '<button type="button" name="batalkan_pertemuan" class="btn btn-danger btn-sm batalkan_pertemuan" data-id="'.$row["id_pertemuan"].'"><i class="fas fa-times"></i></button>';
			}
			

			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

	if($_POST['action'] == 'batalkan_pertemuan')
	{
		$data = array(
			':status'			=>	'Batal',
			':id_pertemuan'		=>	$_POST['id_pertemuan']
		);
		$object->query = "
		UPDATE pertemuan_vaksinasi 
		SET status = :status 
		WHERE id_pertemuan = :id_pertemuan
		";
		$object->execute($data);
		$_SESSION['pesan'] = 'Pertemuan berhasil dihapus!';
	}
}



?>