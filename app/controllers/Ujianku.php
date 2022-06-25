<?php

//Appointment.php

class Ujianku
{
	// Mendefenisikan variabel
	public $base_url = 'http://localhost/pendidikankita/';
	public $connect;
	public $query;
	public $statement;
	public $now;

	// Membuat function yang akan menjadi object baru dari class
	public function __construct()
	{
		// Membuat koneksi antara PHP dan database server
		$this->connect = new PDO("mysql:host=localhost;dbname=pendidikankita", "root", "");

		date_default_timezone_set('Asia/Makassar');

		session_start();

		$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
	}

	function buatRandomString($length = 5) {
		$characters = 'ABCDEFGHIJKLMOPQRSTUVWXTZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function buatToken($length = 5) {
		$characters = 'abcdefghiklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	// Menjalankan query
	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);

		if($data)
		{
			$this->statement->execute($data); // $this->statement akan menjalankan query 
		}
		else
		{
			$this->statement->execute();
		}		
	}

	// Fungsi ini berguna meilhat berapa row yang mempengaruhi
	function row_count()
	{
		// Fungsi akan berulang kali digunakan untuk membuat sistem
		return $this->statement->rowCount();
	}
	// Fungsi ini berguna meilhat berapa row yang mempengaruhi
	function total_row()
	{
		$this->execute();
		return $this->statement->rowCount();
		// Fungsi akan berulang kali digunakan untuk membuat sistem
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function aktivasi()
	{
		if(isset($_SESSION['pengguna']))
		{
			return true;
		}
		return false;
	}

	function pengguna_login()
	{
		if(isset($_SESSION['id_pengguna']))
		{
			return true;
		}
		return false;
	}


	function is_login()
	{
		if(isset($_SESSION['admin_id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['user_type']))
		{
			if($_SESSION["user_type"] == 'Master')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}

	function total_admin()
	{
		$this->query = "
		SELECT * FROM admin  
		";
		$this->execute();
		return $this->row_count();
	}

	function total_kelas()
	{
		$this->query = "
		SELECT * FROM kelas  
		";
		$this->execute();
		return $this->row_count();
	}

	function total_pengguna_registrasi()
	{
		$this->query = "
		SELECT * FROM pengguna  
		";
		$this->execute();
		return $this->row_count();
	}



}


?>