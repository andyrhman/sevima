<?php

//doctor_action.php

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

if(isset($_POST["action"]))
{

	if($_POST["action"] == 'fetch')
	{
		$order_column = array('nama_kelas', 'kode_kelas', 'nama_mapel', 'tipe_kelas');

		$output = array();

		$main_query = "
		SELECT * FROM kelas ";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE nama_kelas LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR nama_mapel LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR tipe_kelas LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY id_kelas DESC ';
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
			$sub_array[] = $row["nama_kelas"];
			$sub_array[] = $row["kode_kelas"];
			$sub_array[] = $row["nama_mapel"];
			$status = '';
			if($row["tipe_kelas"] == 'Pribadi')
			{
				$status = '<button type="button" class="badge badge-warning status_tombol" data-id="'.$row["id_kelas"].'" data-status="'.$row["tipe_kelas"].'">' . $row["tipe_kelas"] . '</button>';
			}
			else{
				$status = '<button type="button" class="badge badge-success status_tombol" data-id="'.$row["id_kelas"].'" data-status="'.$row["tipe_kelas"].'">' . $row["tipe_kelas"] . '</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="tombol_view" class="btn btn-info btn-circle btn-sm tombol_view" data-id="'.$row["id_kelas"].'"><i class="fas fa-eye"></i></button>
			<button type="button" name="tombol_edit" class="btn btn-warning btn-circle btn-sm tombol_edit" data-id="'.$row["id_kelas"].'"><i class="fas fa-edit"></i></button>
			<button type="button" name="tombol_hapus" class="btn btn-danger btn-circle btn-sm tombol_hapus" data-id="'.$row["id_kelas"].'"><i class="fas fa-times"></i></button>
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
			':nama_mapel'				=>	$object->clean_input($_POST["nama_mapel"]),
			':nama_kelas'				=>	$object->clean_input($_POST["nama_kelas"]),
			':deskripsi'				=>	$object->clean_input($_POST["deskripsi"]),
			':tipe_kelas'				=>	$object->clean_input($_POST["tipe_kelas"]),
			':kode_kelas'				=>	$object->buatRandomString(),
			':waktu_ditambahkan'		=>	$object->now
		);

		$object->query = "
		INSERT INTO kelas 
		(nama_mapel, nama_kelas, deskripsi, kode_kelas, waktu_ditambahkan, tipe_kelas) 
		VALUES (:nama_mapel, :nama_kelas, :deskripsi, :kode_kelas, :waktu_ditambahkan, :tipe_kelas)
		";

		$object->execute($data);

		$_SESSION['pesan'] = "Kelas berhasil ditambah!";


		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM kelas 
		WHERE id_kelas = '".$_POST["id_kelas"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['nama_kelas'] = $row['nama_kelas'];
			$data['kode_kelas'] = $row['kode_kelas'];
			$data['nama_mapel'] = $row['nama_mapel'];
			$data['deskripsi'] 	= $row['deskripsi'];
			$data['tipe_kelas'] = $row['tipe_kelas'];
            if($row["tipe_kelas"] 	== 'Pribadi')
            {
                $data['tipe_kelas'] = '<span class="badge badge-success">Pribadi</span>';
            }
            else
            {
                $data['tipe_kelas'] = '<span class="badge badge-danger">Publik</span>';
            }

		}

		echo json_encode($data);
	}

	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';
		
		$data = array(
			':nama_mapel'				=>	$object->clean_input($_POST["nama_mapel"]),
			':nama_kelas'				=>	$object->clean_input($_POST["nama_kelas"]),
			':deskripsi'				=>	$object->clean_input($_POST["deskripsi"]),
			':tipe_kelas'				=>	$object->clean_input($_POST["tipe_kelas"]),
		);

		$object->query = "
		UPDATE kelas  
		SET nama_mapel 		= :nama_mapel, 
		nama_kelas 			= :nama_kelas, 
		tipe_kelas			= :tipe_kelas, 
		deskripsi 			= :deskripsi 
		WHERE id_kelas 		= '".$_POST['id_tersembunyi']."'
		";

		$object->execute($data);

		$_SESSION['pesan'] = "Kelas berhasil di edit!";


		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}

	if($_POST["action"] == 'ganti_status')
	{

		$data = array(
			':tipe_kelas'		=>	$_POST['status_berikutnya']
		);

		$object->query = "
		UPDATE kelas 
		SET tipe_kelas 	= :tipe_kelas 
		WHERE id_kelas  = '".$_POST["id"]."'
		";

		$object->execute($data);

		$_SESSION['pesan'] = "Status kelas berhasil diganti.";


	}

	if($_POST["action"] == 'hapus')
	{
		$object->query = "
		DELETE FROM kelas 
		WHERE id_kelas = '".$_POST["id"]."'
		";

		$object->execute();

		$_SESSION['pesan'] = "Kelas berhasil dihapus";
	}
}

?>