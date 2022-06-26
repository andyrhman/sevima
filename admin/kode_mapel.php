<?php

//doctor_action.php

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

if(isset($_POST["action"]))
{

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('kategori', 'waktu_ujian', 'publish', 'token');

		$output = array();

		$main_query = "
		SELECT * FROM kategori_quiz ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE kategori LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR token LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY id DESC ';
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
			$sub_array[] = $row["kategori"];
			$sub_array[] = $row["waktu_ujian"] . ' Menit';
			$sub_array[] = $row["token"];
			$status = '';
			if($row["publish"] == '1')
			{
				$status = '<button type="button" class="badge badge-success status_tombol" data-id="'.$row["id"].'" data-status="'.$row["publish"].'">Ya</button>';
			}
			else{
				$status = '<button type="button" class="badge badge-danger status_tombol" data-id="'.$row["id"].'" data-status="'.$row["publish"].'">Tidak</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="tombol_view" class="btn btn-info btn-circle btn-sm tombol_view" data-id="'.$row["id"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="tombol_edit" class="btn btn-warning btn-circle btn-sm tombol_edit" data-id="'.$row["id"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="tombol_hapus" class="btn btn-danger btn-circle btn-sm tombol_hapus" data-id="'.$row["id"].'"><i class="fas fa-times"></i></button>
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
			':jumlah_pertanyaan'		=>	$object->clean_input($_POST["jumlah_pertanyaan"]),
            ':nama_mapel'				=>	$object->clean_input($_POST["nama_mapel"]),
            ':waktu_ujian'				=>	$object->clean_input($_POST["waktu_ujian"]),
            ':token'			        =>	$object->clean_input($_POST["token"]),
            ':status_unggah'			=>	$object->clean_input($_POST["status_unggah"]),
            ':waktu_ditambahkan'		=>	$object->now
        );

        $object->query = "
        INSERT INTO kategori_quiz 
        (kategori, waktu_ujian, publish, token, created_at, jumlah_pertanyaan) 
        VALUES (:nama_mapel, :waktu_ujian, :status_unggah, :token, :waktu_ditambahkan, :jumlah_pertanyaan)
        ";

        $object->execute($data);

        $_SESSION['pesan'] = "Mata Pelajaran berhasil ditambah!";


		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM kategori_quiz 
		WHERE id = '".$_POST["id"]."'
		";

		$hasil = $object->get_result();

		$data = array();

		foreach($hasil as $row)
		{
			$data['kategori'] 		= $row['kategori'];
			$data['jumlah_pertanyaan'] 	= $row['jumlah_pertanyaan'];
			$data['waktu_ujian'] 	= $row['waktu_ujian'];
			$data['token'] 			= $row['token'];
			$data['created_at'] 	= $row['created_at'];
			if($row["publish"] 	== '1')
            {
                $data['publish'] = '<span class="badge badge-success">Ya</span>';
            }
            else
            {
                $data['publish'] = '<span class="badge badge-danger">Tidak</span>';
            }
		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';
		
        $data = array(
			':jumlah_pertanyaan'		=>	$object->clean_input($_POST["jumlah_pertanyaan"]),
            ':nama_mapel'				=>	$object->clean_input($_POST["nama_mapel"]),
            ':waktu_ujian'				=>	$object->clean_input($_POST["waktu_ujian"]),
            ':token'			        =>	$object->clean_input($_POST["token"]),
            ':status_unggah'			=>	$object->clean_input($_POST["status_unggah"]),
        );

        $object->query = "UPDATE kategori_quiz 
		SET kategori = :nama_mapel,
		waktu_ujian = :waktu_ujian,
		jumlah_pertanyaan = :jumlah_pertanyaan,
		publish = :status_unggah,
		token = :token 
		WHERE id = '".$_POST['id_tersembunyi']."'
        ";

        $object->execute($data);

		$_SESSION['pesan'] = "Mata pelajaran erhasil di edit!";


		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'ganti_status')
	{
		$data = array(
			':status_ujian'		=>	$_POST['status_berikutnya']
		);

		$object->query = "
		UPDATE kategori_quiz 
		SET publish = :status_ujian 
		WHERE id  = '".$_POST["id"]."'
		";

		$object->execute($data);

		$_SESSION['pesan'] = "Berhasil merubah status";

	}

	if($_POST["action"] == 'hapus')
	{
		$object->query = "
		DELETE FROM kategori_quiz 
		WHERE id = '".$_POST["id"]."'
		";

		$object->execute();

		$_SESSION['pesan'] = "Berhasil dihapus.";
	}
}

?>