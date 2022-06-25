<?php

//login_action.php

include('../app/controllers/Ujianku.php');

$object = new Ujianku;

if(isset($_POST["email_admin"]))
{
	sleep(1);
	$error = '';
	$url = '';
	$data = array(
		':email_admin'	=>	$_POST["email_admin"]
	);

	$object->query = "
		SELECT * FROM admin
		WHERE email_admin = :email_admin
	";

	$object->execute($data);

	$total_row = $object->row_count();


	if($object->row_count() == 0)
	{
		$error = '<div class="alert alert-danger">Alamat email salah</div>';
	}
	else
	{
		//$result = $statement->fetchAll();

		$result = $object->statement_result();

		foreach($result as $row)
		{
			if($row["status_admin"] == 'Tidak Aktif')
			{
				$error = '<div class="alert alert-danger">Akun anda tidak aktif, mohon kontak admin.</div>';
			}
			else
			{
				if($_POST["password_admin"] == $row["password_admin"])
				{
					$_SESSION['admin_id'] = $row['id_admin'];
					$_SESSION['type'] = 'Admin';
					$url = $object->base_url . 'admin/dashboard.php';
				}
				else
				{
					$error = '<div class="alert alert-danger">Password Salah</div>';
				}
			}

		}
	}



	$output = array(
		'error'		=>	$error,
		'url'		=>	$url
	);

	echo json_encode($output);
}

?>