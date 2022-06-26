<?php
$judul_halaman = "Hasil Ujian";

include('app/controllers/Ujianku.php');
include('app/database/connect.php');
$object = new Ujianku;

if(!$object->pengguna_login())
{
    header("location:".$object->base_url."login.php");
}

$date = date("Y-m-d H:i:s");
$_SESSION["end_time"] = date("Y-m-d H-i-s", strtotime($date . " + $_SESSION[exam_time] minutes"));
unset($_SESSION['tipe']);
?>
<?php include("includes/header.php");?>
            <div class="col-lg-9">

                <h4 class="text-center">Hasil Ujian anda</h4>

                <div class="card mb-3">
                    <div class="card-body">
                    
                    <?php
                        $benar = 0;
                        $salah = 0;

                        if (isset($_SESSION["jawaban"])) 
                        {
                            for ($i=1; $i <= sizeof($_SESSION["jawaban"]); $i++) { 
                                $jawaban = "";

                                $object->query = "SELECT * FROM pertanyaan WHERE kategori='$_SESSION[kategori_quiz]' && no_pertanyaan= $i";
                                $object->execute();
                                
                                $hasilQuery = $object->get_result();

                                foreach ($hasilQuery as $row) {
                                    $jawaban = $row["jawaban"];
                                }


                                if (isset($_SESSION["jawaban"][$i])) {
                                if ($jawaban == $_SESSION["jawaban"][$i]) {
                                    $benar = $benar + 1;
                                }else 
                                {
                                    $salah = $salah + 1 ;
                                }
                                }else 
                                {
                                    $salah = $salah + 1;
                                }
                            }
                        }

                        $count = 0;

                        $object->query = "SELECT * FROM pertanyaan WHERE kategori='$_SESSION[kategori_quiz]'";
                        $object->execute();
                        
                        $count = $object->row_count();

                        $salah = $count - $benar;
                        ?>
                        <div class="container-fluid">

                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                            <i class="fas fa-pencil-alt text-info fa-3x me-4"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4>Total pertanyaan</h4>
                                        
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0"><?php echo $count ?></h2>
                                    </div>
                                    </div>
                                </div>
                            </div>
                                       
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                        <i class="far fa-check-circle text-success fa-3x me-4"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4>Jawaban Benar</h4>
                                        
                                        </div>
                                        
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0"><?php echo $benar ?></h2>
                                    </div>
                                    </div>
                                </div>
                            </div>
                                                              
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between p-md-1">
                                    <div class="d-flex flex-row">
                                        <div class="align-self-center">
                                        <i class="far fa-times-circle text-danger fa-3x me-4"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4>Jawaban Salah</h4>                                          
                                        </div>
                                    </div>
                                    <div class="align-self-center">
                                        <h2 class="h1 mb-0"><?php echo $salah ?></h2>
                                    </div>
                                    </div>
                                </div>
                            </div>
                             
                        </div>
                        <?php
                    ?>



                    </div>
                </div>
            </div>


        <!-- Row gotter end -->
        </div>

    <!-- Main body end -->
    </div>



    
<?php 

if (isset($_SESSION["exam_start"])) {
    $date = date("Y-m-d");
    mysqli_query($conn, "INSERT INTO hasil_quiz(id, nama_pengguna, tipe_quiz, total_pertanyaan, jawaban_benar, jawaban_salah, waktu_ujian) VALUES(NULL, '$_SESSION[nama_pengguna]', '$_SESSION[kategori_quiz]', '$count', '$benar', '$salah', '$date')");
}

if (isset($_SESSION["exam_start"])) {
    unset($_SESSION["exam_start"])

    ?>
        <script type="text/javascript">
           
           window.location.href = window.location.href;
            
        </script>

    <?php

}

?>


<?php include("includes/footer.php");?>

</body>

</html>
