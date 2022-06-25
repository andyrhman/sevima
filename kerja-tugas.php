<?php
$judul_halaman = "Dashboard";
$kelas_active = "active";
$kelas_text = "text-white";

include('app/controllers/Ujianku.php');

$object = new Ujianku;

if(!$object->pengguna_login())
{
    header("location:".$object->base_url."login.php");
}

?>
<?php include("includes/header.php");?>

            <div class="col-lg-9">
                <div class="card mb-3">
                    <div class="card-body">
  

                    <form action="" method="post" id="form_pertemuan" enctype="multipart/form-data">

                        <?php
                            if (isset($_GET['KerjaTugas'])) {
                                $idTugas = $_GET['KerjaTugas'];
        
                                $object->query = "SELECT * FROM tugas WHERE id_tugas = $idTugas";
                                $hasilTugas = $object->get_result();
        
                                foreach ($hasilTugas as $rowTugas) {
                                    ?>
                                    <script>$('#kerjaTugas').modal('show');</script>

                                    <h4><?= $rowTugas['judul_tugas']?></h4>
                                    <small>Tanggal & waktu berahkir <?= $rowTugas['tanggal_tugas_berakhir']?></small>
                                    <small><?= $rowTugas['jadwal_berakhir_tugas']?></small>
                                    <div><?= $rowTugas['deskripsi_tugas']?></div>
                                    <div>
                                        <img src="<?= $rowTugas['file_tugas']?>" alt="" width="400">
                                    </div>


                                    <div class="form-group">
                                        <label>Masukkan jawaban anda</label>
                                        <div>                             
                                            <textarea class="form-control" name="jawaban_teks" id="jawaban_teks" placeholder="Masukkan jawaban"></textarea>
                                        </div>
                                        
                                    </div>

                                    <div class="form-group">
                                        <label>Lampirkan</label>
                                        <div>                             
                                            <input type="file" name="jawaban_file" id="jawaban_file" class="form-control">
                                        </div>
                                        

                                    </div>

                    
                                    


                                    <?php
                                }

                            }
                            ?>

                                    

                            <button type="submit" name="serahkan_tugas" id="serahkan_tugas" class="btn btn-success btn-user">Serahkan Tugas</button>                           
                                    
                                
                        </div>
                    </form>

                    
                </div>
            </div>


  

        <!-- Row gotter end -->
        </div>

    <!-- Main body end -->
    </div>



<?php include("includes/pesanToast.php");?>
<?php 
if (isset($_POST['serahkan_tugas'])) {

    $fnm4 = $_FILES["jawaban_file"]["name"];
    $destinasi = "assets/img/" . $tm . $fnm4;
    move_uploaded_file($_FILES["jawaban_file"]["tmp_name"], $destinasi);

    $data = array(
        ':jawaban_teks'				=>	$object->clean_input($_POST["jawaban_teks"]),
        ':jawaban_file'			    =>	$destinasi,
        ':id_pengguna'		        =>	$object->clean_input($_SESSION['id_pengguna']),
        ':id_tugas'		            =>	$idTugas,
        ':id_kelas'		            =>	$idKelasPengguna,
    );

    $object->query = "
    INSERT INTO tugas_pengguna  
    (jawaban_teks, jawaban_file, id_pengguna, id_tugas, id_kelas) 
    VALUES (:jawaban_teks, :jawaban_file, :id_pengguna, :id_tugas, :id_kelas)
    ";

    $object->execute($data);

    $_SESSION['pesan'] = "Tugas berhasil di serahkan!";

    ?>
    <script>
        window.location.href = "panel.php";
    </script>
    <?php
}

include("includes/footer.php");

?>
<script>



</script>
</body>

</html>