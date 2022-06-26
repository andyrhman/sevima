<?php
$judul_halaman = "Hasil Terakhir";

include('app/controllers/Ujianku.php');
include('app/database/connect.php');
$object = new Ujianku;

if(!$object->pengguna_login())
{
    header("location:".$object->base_url."login.php");
}
?>

<?php include("includes/header.php");?>

            <div class="col-lg-9">

                <h4 class="text-center">Hasil Terakhir Ujian anda</h4>

                <div class="card mb-3">
                    <div class="card-body">
                    <?php
                        $count = 0;
                        $res = mysqli_query($conn, "SELECT * FROM hasil_quiz WHERE nama_pengguna = '$_SESSION[nama_pengguna]' ORDER BY id DESC");
                        $count = mysqli_num_rows($res);

                        if ($count == 0) {
                            ?>
                            <div class="my-5">
                                
                                <h2 class="text-center">Hasil terakhir belum ada...</h2>
                                <div class="d-flex justify-content-center">
                                    <img src="assets/img/empty-box.png" width="400" class="img-fluid" alt="Error 404">
                                </div>
                                
                            </div>
                            <?php

                        } else {
                                        
                            ?>

                            <div class="card bg-primary text-white" style="border-radius: 25px; padding: 5px; background: linear-gradient(90deg,#4481e3, #27DBB1);">
                                <div class="card-body">
                                <?php while ($row = mysqli_fetch_array($res)):?>
                                    <div class="row pb-3">
                                        <div class="col-md-6 batas-garis">
                                            <div>Nama Quiz</div>
                                            <div style="font-style:italic;"><?php echo $row["tipe_quiz"]?></div>
                                        </div>
                                        <div class="col-md-6 batas-garis">
                                            <div>Tanggal Dikerjakan</div>
                                            <div style="font-style:italic;"><?php echo $row['waktu_ujian']?></div>
                                        </div>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-6 batas-garis">
                                            <div>Jawaban Benar</div>
                                            <div style="font-style:italic;"><?php echo $row['jawaban_benar']?></div>
                                        </div>
                                        <div class="col-md-6 batas-garis">
                                            <div style="font-style:italic;"><?php echo $row['total_pertanyaan']?> Soal</div>
                                        </div>
                                    </div>
                                    
                                <?php endwhile;?>
                                </div>


                            </div>

                            <?php
                                


                                
                            

                        }

                    ?>



                    </div>
                </div>
            </div>
            

        <!-- Row gotter end -->
        </div>

    <!-- Main body end -->
    </div>

<?php include("includes/footer.php");?>

</body>

</html>

