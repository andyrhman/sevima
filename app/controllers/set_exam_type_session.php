<?php

include('../../app/controllers/Ujianku.php');
include('../../app/database/connect.php');

$object = new Ujianku;

$kategori_quiz = $_GET["kategori_quiz"];
$_SESSION["kategori_quiz"] = $kategori_quiz;

$object->query = "SELECT * FROM kategori_quiz WHERE kategori='$kategori_quiz'";
$object->execute();

$hasilQuery = $object->get_result();

foreach ($hasilQuery as $row) {
    $_SESSION["exam_time"] = $row["waktu_ujian"];
}


date_default_timezone_set('Asia/Makassar');
$tanggal = date("Y-m-d H:i:s");

$_SESSION["end_time"] = date("Y-m-d H:i:s", strtotime($tanggal . "+$_SESSION[exam_time] minutes"));
$_SESSION["exam_start"] = "yes";


