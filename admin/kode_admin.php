<?php

//doctor_action.php

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

if(isset($_POST["action"]))
{

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('nama_admin', 'master_admin');

		$output = array();

		$main_query = "
		SELECT * FROM admin ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE email_admin LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR nama_admin LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR master_admin LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR nomor_kontak LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY id_admin DESC ';
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

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = '<img src="'.$row["foto_profil_admin"].'" class="img-thumbnail" width="75" />';
			$sub_array[] = $row["email_admin"];
			$sub_array[] = $row["password_admin"];
			$sub_array[] = $row["nama_admin"];
			$sub_array[] = $row["nomor_kontak"];
			$status = '';
			if($row["master_admin"] == 'Ya')
			{
				$status = '<button type="button" class="badge badge-success status_tombol" data-id="'.$row["id_admin"].'" data-status="'.$row["master_admin"].'">' . $row["master_admin"] . '</button>';
			}
			else{
				$status = '<button type="button" class="badge badge-danger status_tombol" data-id="'.$row["id_admin"].'" data-status="'.$row["master_admin"].'">' . $row["master_admin"] . '</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="tombol_view" class="btn btn-info btn-circle btn-sm tombol_view" data-id="'.$row["id_admin"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="tombol_edit" class="btn btn-warning btn-circle btn-sm tombol_edit" data-id="'.$row["id_admin"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="tombol_hapus" class="btn btn-danger btn-circle btn-sm tombol_hapus" data-id="'.$row["id_admin"].'"><i class="fas fa-times"></i></button>
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

	if($_POST["action"] == 'Tambah')
	{

		$error = '';

		$success = '';

		$data = array(
			':email_admin'	=>	$_POST["email_admin"]
		);

		$object->query = "
		SELECT * FROM admin 
		WHERE email_admin = :email_admin
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email Sudah ada!</div>';
		}
		else
		{
			$foto_profil_admin = '';
			if($_FILES['foto_profil']['name'] != '')
			{
				$format_file = array("jpg", "png");

	    		$exs_file = pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($exs_file, $format_file))
			    {
			        $error = "<div class='alert alert-danger'>Gambar harus menggunakan format .jpg, .png</div>";
			    }
			    else if (($_FILES["foto_profil"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>Ukuran file lebih dari 2MB</div>";
			    }
			    else
			    {
			    	$nama_baru = rand() . '.' . $exs_file;

					$destinasi = 'images/' . $nama_baru;

					move_uploaded_file($_FILES['foto_profil']['tmp_name'], $destinasi);

					$foto_profil_admin = $destinasi;
			    }
			}
			else
			{
				$foto_profil_admin = '';

				$nama = $_POST["nama_admin"][0];
                $tempat = "img/". time() . ".png";
				$gambar = imagecreate(200, 200);
				$merah = rand(0, 255);
				$hijau = rand(0, 255);
				$biru = rand(0, 255);
			    imagecolorallocate($gambar, 230, 230, 230);  
			    $warnateks = imagecolorallocate($gambar, $merah, $hijau, $biru);
			    imagettftext($gambar, 100, 0, 55, 150, $warnateks, '../font/arial.ttf', $nama);
			    imagepng($gambar, $tempat);
			    imagedestroy($gambar);
			    $foto_profil_admin = $tempat;

			}

			if($error == '')
			{
				$data = array(
					':email_admin'				=>	$object->clean_input($_POST["email_admin"]),
					':password_admin'			=>	$_POST["password_admin"],
					':nama_admin'				=>	$object->clean_input($_POST["nama_admin"]),
					':tanggal_lahir'			=>	$object->clean_input($_POST["tanggal_lahir"]),
					':no_hp'					=>	$object->clean_input($_POST["no_hp"]),
					':alamat_admin'				=>	$object->clean_input($_POST["alamat_admin"]),
					':foto_profil_admin'		=>	$foto_profil_admin,
					':master_admin'				=>	'Tidak',
					':waktu_ditambahkan'		=>	$object->now
				);

				$object->query = "
				INSERT INTO admin 
				(email_admin, password_admin, nama_admin, tanggal_lahir, nomor_kontak, alamat_admin, foto_profil_admin, master_admin, waktu_ditambahkan) 
				VALUES (:email_admin, :password_admin, :nama_admin, :tanggal_lahir, :no_hp, :alamat_admin, :foto_profil_admin, :master_admin, :waktu_ditambahkan)
				";

				$object->execute($data);

				$_SESSION['pesan'] = "Pengguna admin berhasil ditambah!";
			}
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM admin 
		WHERE id_admin = '".$_POST["id_admin"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['email_admin'] = $row['email_admin'];
			$data['password_admin'] = $row['password_admin'];
			$data['nama_admin'] = $row['nama_admin'];
			$data['foto_profil'] = $row['foto_profil_admin'];
			$data['no_hp'] = $row['nomor_kontak'];
			$data['alamat_admin'] = $row['alamat_admin'];
			$data['tanggal_lahir'] = $row['tanggal_lahir'];

		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':email_admin'	=>	$_POST["email_admin"],
			':id_admin'		=>	$_POST['hidden_id']
		);

		$object->query = "
		SELECT * FROM admin 
		WHERE email_admin = :email_admin 
		AND id_admin != :id_admin
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Email sudah ada!</div>';
		}
		else
		{
			$foto_profil_admin = '';
			if($_FILES['foto_profil']['name'] != '')
			{
				$format_file = array("jpg", "png");

	    		$exs_file = pathinfo($_FILES["foto_profil"]["name"], PATHINFO_EXTENSION);

	    		if(!in_array($exs_file, $format_file))
			    {
			        $error = "<div class='alert alert-danger'>Gambar harus menggunakan format .jpg, .png</div>";
			    }
			    else if (($_FILES["foto_profil"]["size"] > 2000000))
			    {
			       $error = "<div class='alert alert-danger'>Ukuran file lebih dari 2MB</div>";
			    }
			    else
			    {
			    	$nama_baru = rand() . '.' . $exs_file;

					$destinasi = 'images/' . $nama_baru;

					move_uploaded_file($_FILES['foto_profil']['tmp_name'], $destinasi);

					$foto_profil_admin = $destinasi;
			    }
			}
			else
			{
				$foto_profil_admin = '';

				$nama = $_POST["hidden_foto_profil"];

			    $foto_profil_admin = $nama;

			}

			if($error == '')
			{
				$data = array(
					':email_admin'				=>	$object->clean_input($_POST["email_admin"]),
					':password_admin'			=>	$_POST["password_admin"],
					':nama_admin'				=>	$object->clean_input($_POST["nama_admin"]),
					':tanggal_lahir'			=>	$object->clean_input($_POST["tanggal_lahir"]),
					':no_hp'					=>	$object->clean_input($_POST["no_hp"]),
					':alamat_admin'				=>	$object->clean_input($_POST["alamat_admin"]),
					':foto_profil_admin'		=>	$foto_profil_admin,
				);

				$object->query = "
				UPDATE admin  
				SET email_admin 	= :email_admin, 
				password_admin 		= :password_admin, 
				nama_admin			= :nama_admin, 
				tanggal_lahir 		= :tanggal_lahir, 
				nomor_kontak 		= :no_hp, 
				alamat_admin 		= :alamat_admin, 
				foto_profil_admin 	= :foto_profil_admin 
				WHERE id_admin 		= '".$_POST['hidden_id']."'
				";

				$object->execute($data);

				$_SESSION['pesan'] = "Pengguna admin berhasil di edit!";
			}			
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'ganti_status')
	{
        $object->query = "
        SELECT * FROM admin 
        WHERE id_admin = '".$_SESSION['admin_id']."'
        ";

        $user_result = $object->get_result();
        foreach($user_result as $row)
        {
            if ($row['master_admin'] == 'Ya') {
				$data = array(
					':master_admin'		=>	$_POST['status_berikutnya']
				);
		
				$object->query = "
				UPDATE admin 
				SET master_admin = :master_admin 
				WHERE id_admin  = '".$_POST["id"]."'
				";
		
				$object->execute($data);
		
				$_SESSION['pesan'] = "Status admin berhasil diganti.";
			}
			else{
				$_SESSION['pesanError'] = "Anda bukan master admin";
			}
		}

	}

	if($_POST["action"] == 'hapus')
	{
		$object->query = "
		DELETE FROM admin 
		WHERE id_admin = '".$_POST["id"]."'
		";

		$object->execute();

		$_SESSION['pesan'] = "Admin berhasil dihapus.";
	}
}

?>