<?php

include('../../app/controllers/Ujianku.php');
include('../../app/database/connect.php');
$object = new Ujianku;

$total_que = 0;

$object->query = "SELECT * FROM pertanyaan WHERE kategori='$_SESSION[kategori_quiz]'";
$object->execute();

$total_que = $object->row_count();
echo $total_que;