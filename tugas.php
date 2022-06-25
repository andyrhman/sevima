<?php
$judul_halaman = "Dashboard";
$tugas_active = "active";
$tugas_text = "text-white";

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
  
                        <?php 
                            $object->query = "SELECT * FROM kelas  
                            WHERE id_pembuat = '".$_SESSION['id_pengguna']."' LIMIT 1
                            ";
    
                            $object->execute();
    
                            $dataPembuat = $object->get_result();

                            foreach ($dataPembuat as $data) {
                                $idKelas    = $data['id_kelas'];
                                $idPembuat  = $data['id_pembuat'];

                                if ($data['id_pembuat'] == $_SESSION['id_pengguna']) {
                                    ?>
                                    <div>
                                        <button class="btn btn-primary btn-user" data-toggle="modal" data-target="#buatTugas">Buat Tugas</button>
                                    </div>
                                    <?php
                                }
                            }


                        
                        ?>
                        <div class="table-responsive">


                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Judul Tugas</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Berakhir</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Untuk pembuat kelas -->
                                    <?php
                                    $object->query = "SELECT * FROM tugas WHERE id_pembuat = '".$_SESSION['id_pengguna']."'";
                                    
                                    $object->execute();

                                    $dataTugas = $object->get_result();

                                    foreach ($dataTugas as $tugas) {
                                        $judulTugas     = $tugas['judul_tugas'];
                                        $TglMulai       = $tugas['tanggal_tugas_mulai'];
                                        $TglBerakhir    = $tugas['tanggal_tugas_berakhir'];
                                        $waktuMulai     = $tugas['jadwal_mulai_tugas'];
                                        $waktuBerakhir  = $tugas['jadwal_berakhir_tugas'];
                                        $DescTugas      = $tugas['deskripsi_tugas'];
                                        $fileTugas      = $tugas['file_tugas'];
                                        ?>
                                        <tr>
                                            <td><?php echo $tugas['judul_tugas'];?></td>
                                            <td><?php echo $tugas['tanggal_tugas_mulai'];?></td>
                                            <td><?php echo $tugas['tanggal_tugas_berakhir'];?></td>
                                            <td><?php echo $tugas['jadwal_mulai_tugas'];?></td>
                                            <td><?php echo $tugas['jadwal_berakhir_tugas'];?></td>
                                            <td align="center">
                                                
                                                <a href="tugas.php?EditTugas=<?php echo $tugas['id_tugas'];?>" class="btn btn-warning btn-circle btn-sm tombol_edit"><i class="fas fa-edit"></i></a>
                                                
                                                <form action="tugas.php" method="post">
                                                    <button type="submit" value="<?= $tugas['id_tugas'];?>" name="hapusTugas" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-times"></i></button>                                           
                                                </form>
                                            
                                            </td>      
                                        </tr>                                       
                                        <?php
                                    }
                                    ?>
                                    <!-- Untuk pengguna biasa -->
                                    <?php

                                    $object->query = "SELECT * FROM kelas_pengguna WHERE id_pengguna = '".$_SESSION['id_pengguna']."'";
                                    
                                    $object->execute();

                                    $dataPengguna = $object->get_result();

                                    foreach ($dataPengguna as $penggunaData) {
                                        $idKelasPengguna = $penggunaData['id_kelas'];
                                    }
                                  
                                    $object->query = "SELECT * FROM tugas WHERE id_kelas = '$idKelasPengguna'";
                                    
                                    $object->execute();

                                    $dataTugas = $object->get_result();

                                    foreach ($dataTugas as $tugas) {
                                        $judulTugas     = $tugas['judul_tugas'];
                                        $TglMulai       = $tugas['tanggal_tugas_mulai'];
                                        $TglBerakhir    = $tugas['tanggal_tugas_berakhir'];
                                        $waktuMulai     = $tugas['jadwal_mulai_tugas'];
                                        $waktuBerakhir  = $tugas['jadwal_berakhir_tugas'];
                                        $DescTugas      = $tugas['deskripsi_tugas'];
                                        $fileTugas      = $tugas['file_tugas'];
                                        ?>
                                        <tr>
                                            <td><?php echo $tugas['judul_tugas'];?></td>
                                            <td><?php echo $tugas['tanggal_tugas_mulai'];?></td>
                                            <td><?php echo $tugas['tanggal_tugas_berakhir'];?></td>
                                            <td><?php echo $tugas['jadwal_mulai_tugas'];?></td>
                                            <td><?php echo $tugas['jadwal_berakhir_tugas'];?></td>
                                            <td align="center">
                                                
                                                <a href="tugas.php?KerjaTugas=<?php echo $tugas['id_tugas'];?>" class="btn btn-info btn-circle btn-sm tombol_edit"><i class="fas fa-edit"></i></a>
                                            
                                            </td>      
                                        </tr>                                       
                                        <?php
                                    }
                                    ?>

                                    
                                </tbody>  
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            

            <div id="kerjaTugas" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <form action="" method="post" id="form_pertemuan" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Buat Tugas</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                            <?php
                                if (isset($_GET['KerjaTugas'])) {
                                    $idTugas = $_GET['KerjaTugas'];
            
                                    $object->query = "SELECT * FROM tugas WHERE id_tugas = $idTugas";
                                    $hasilTugas = $object->get_result();
            
                                    foreach ($hasilTugas as $rowTugas) {
                                        ?>
                                        <script>$('#kerjaTugas').modal('show');</script>

                                        <h4><?= $rowTugas['judul_tugas']?></h4>
                                        <small><?= $rowTugas['tanggal_tugas_berakhir']?></small>
                                        <small><?= $rowTugas['jadwal_berakhir_tugas']?></small>
                                        <div><?= $rowTugas['deskripsi_tugas']?></div>
                                        <div>
                                            <img src="<?= $rowTugas['file_tugas']?>" alt="" width="400">
                                        </div>


                                        <div class="form-group">
                                            <label>Masukkan jawaban anda</label>
                                            <div>                             
                                                <textarea class="form-control" name="deskripsi_tugas" id="deskripsi_tugas" placeholder="Masukkan jawaban"></textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label>Lampirkan</label>
                                            <div>                             
                                                <input type="file" name="file_tugas" id="file_tugas" class="form-control">
                                            </div>
                                            

                                        </div>

                        
                                          

      
                                        <?php
                                    }

                                }
                                ?>
 
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="serahkan_tugas" id="serahkan_tugas" class="btn btn-success btn-user">Buat Tugas</button>                           
                                <button type="button" class="btn btn-defaul btn-user" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="buatTugas" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <form action="" method="post" id="form_pertemuan" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Buat Tugas</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Judul Tugas</label>
                                            <div>                             
                                                <input type="text" name="judul_tugas" id="judul_tugas" class="form-control" required>
                                            </div>
                                        
                                        </div>

                                        <div class="form-group">
                                            <label>Deskripsi Tugas</label>
                                            <div>                             
                                                <textarea class="form-control" name="deskripsi_tugas" id="deskripsi_tugas" placeholder="Masukkan Deskripsi" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan deskripsi."> </textarea>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">
                                            <label>Lampirkan</label>
                                            <div>                             
                                                <input type="file" name="file_tugas" id="file_tugas" class="form-control">
                                            </div>
                                            

                                        </div>

                
                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Jadwal Tugas Mulai</label>
       
                                            <input type="text" name="tanggal_tugas_mulai" id="tanggal_tugas_mulai" class="form-control" required data-parsley-required-message="Input harus diisi." />

                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Mulai</label>
     
                                            <input type="text" name="jadwal_mulai_tugas" id="jadwal_mulai_tugas" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#jadwal_waktu_mulai" required data-parsley-required-message="Input harus diisi." onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />

                                        </div>
                                        <div class="form-group">
                                            <label>Jadwal Tugas Berakhir</label>

                                            <input type="text" name="tanggal_tugas_berakhir" id="tanggal_tugas_berakhir" class="form-control" required data-parsley-required-message="Input harus diisi." />

                                        </div>
                                        <div class="form-group">
                                            <label>Waktu Berakhir</label>

                                            <input type="text" name="jadwal_berakhir_tugas" id="jadwal_berakhir_tugas" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#jadwal_waktu_berakhir" required data-parsley-required-message="Input harus diisi." onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />

                                        </div>  

                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="buat_tugas" id="buat_tugas" class="btn btn-success btn-user">Buat Tugas</button>                           
                                <button type="button" class="btn btn-defaul btn-user" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="editTugas" class="modal fade">
                <div class="modal-dialog modal-xl">
                    <form action="" method="post" id="form_pertemuan" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Edit Tugas</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <?php
                                if (isset($_GET['EditTugas'])) {
                                    $idTugas = $_GET['EditTugas'];
            
                                    $object->query = "SELECT * FROM tugas WHERE id_tugas = $idTugas";
                                    $hasilTugas = $object->get_result();
            
                                    foreach ($hasilTugas as $rowTugas) {
                                        ?>
                                        <script>$('#editTugas').modal('show');</script>

                                        <div class="row">
                                    
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Judul Tugas</label>
                                                    <div>                             
                                                        <input type="text" value="<?= $rowTugas['judul_tugas']?>" name="judul_tugas" id="judul_tugas" class="form-control" required>
                                                    </div>
                                                
                                                </div>

                                                <div class="form-group">
                                                    <label>Deskripsi Tugas</label>
                                                    <div>                             
                                                        <textarea class="form-control" name="deskripsi_tugas" id="deskripsi_tugas" placeholder="Masukkan Deskripsi" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan deskripsi."><?= $rowTugas['deskripsi_tugas']?></textarea>
                                                    </div>
                                                    
                                                </div>

                                                <div class="form-group">
                                                    <label>Lampirkan</label>
                                                    <div>                             
                                                        <input type="file" value="<?= $rowTugas['file_tugas']?>" name="file_tugas" id="file_tugas" class="form-control">
                                                    </div>
                                                    

                                                </div>

                        
                                            </div>

                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <label>Jadwal Tugas Mulai</label>
            
                                                    <input type="text" value="<?= $rowTugas['tanggal_tugas_mulai']?>" name="tanggal_tugas_mulai" id="tanggal_tugas_mulai" class="form-control" required data-parsley-required-message="Input harus diisi." />

                                                </div>
                                                <div class="form-group">
                                                    <label>Waktu Mulai</label>
            
                                                    <input type="text" value="<?= $rowTugas['jadwal_mulai_tugas']?>" name="jadwal_mulai_tugas" id="jadwal_mulai_tugas" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#jadwal_waktu_mulai" required data-parsley-required-message="Input harus diisi." onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />

                                                </div>
                                                <div class="form-group">
                                                    <label>Jadwal Tugas Berakhir</label>

                                                    <input type="text" value="<?= $rowTugas['tanggal_tugas_berakhir']?>" name="tanggal_tugas_berakhir" id="tanggal_tugas_berakhir" class="form-control" required data-parsley-required-message="Input harus diisi." />

                                                </div>
                                                <div class="form-group">
                                                    <label>Waktu Berakhir</label>

                                                    <input type="text" value="<?= $rowTugas['jadwal_berakhir_tugas']?>" name="jadwal_berakhir_tugas" id="jadwal_berakhir_tugas" class="form-control datetimepicker-input" data-toggle="datetimepicker" data-target="#jadwal_waktu_berakhir" required data-parsley-required-message="Input harus diisi." onkeydown="return false" onpaste="return false;" ondrop="return false;" autocomplete="off" />

                                                </div>  

                                            </div>
                                        </div>
                                        <?php
                                    }

                                }
                                ?>
 
                                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="edit_tugas" id="edit_tugas" class="btn btn-success btn-user">Edit</button>                           
                                <button type="button" class="btn btn-defaul btn-user" data-dismiss="modal">Tutup</button>
                            </div>
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

if (isset($_POST['hapusTugas'])) {

    $hapusPertanyaan = $_POST['hapusTugas'];

    $object->query = "DELETE FROM tugas WHERE id_tugas ='$hapusPertanyaan' ";

    $object->execute();

    $_SESSION['pesan'] = "Tugas berhasil di hapus!";
    ?>
        <script>window.location.href=window.location.href;</script>
    <?php
    
}

if (isset($_POST['edit_tugas'])) {


    $fnm4 = $_FILES["file_tugas"]["name"];
    $destinasi = "assets/img/" . $tm . $fnm4;
    move_uploaded_file($_FILES["file_tugas"]["tmp_name"], $destinasi);

    $data = array(
        ':judul_tugas'				=>	$object->clean_input($_POST["judul_tugas"]),
        ':deskripsi_tugas'			=>	$object->clean_input($_POST["deskripsi_tugas"]),
        ':file_tugas'				=>	$destinasi,
        ':tanggal_tugas_mulai'		=>	$object->clean_input($_POST["tanggal_tugas_mulai"]),
        ':jadwal_mulai_tugas'		=>	$object->clean_input($_POST["jadwal_mulai_tugas"]),
        ':tanggal_tugas_berakhir'	=>	$object->clean_input($_POST["tanggal_tugas_berakhir"]),
        ':jadwal_berakhir_tugas'	=>	$object->clean_input($_POST["jadwal_berakhir_tugas"]),
    );

    $object->query = "UPDATE tugas SET 
    judul_tugas             = :judul_tugas,
    deskripsi_tugas         = :deskripsi_tugas,
    file_tugas              = :file_tugas,
    tanggal_tugas_mulai     = :tanggal_tugas_mulai,
    jadwal_mulai_tugas      = :jadwal_mulai_tugas,
    tanggal_tugas_berakhir  = :tanggal_tugas_berakhir,
    jadwal_berakhir_tugas   = :jadwal_berakhir_tugas 
    WHERE id_tugas = $idTugas";

    $object->execute($data);

    $_SESSION['pesan'] = "Tugas berhasil di edit!";

    ?>
    <script>
        window.location.href = "tugas.php";
    </script>
    <?php
}

if (isset($_POST['buat_tugas'])) {


    $fnm4 = $_FILES["file_tugas"]["name"];
    $destinasi = "assets/img/" . $tm . $fnm4;
    move_uploaded_file($_FILES["file_tugas"]["tmp_name"], $destinasi);

    $data = array(
        ':id_kelas'				    =>	$idKelas,
        ':id_pembuat'				=>	$idPembuat,
        ':judul_tugas'				=>	$object->clean_input($_POST["judul_tugas"]),
        ':deskripsi_tugas'			=>	$object->clean_input($_POST["deskripsi_tugas"]),
        ':file_tugas'				=>	$destinasi,
        ':tanggal_tugas_mulai'		=>	$object->clean_input($_POST["tanggal_tugas_mulai"]),
        ':jadwal_mulai_tugas'		=>	$object->clean_input($_POST["jadwal_mulai_tugas"]),
        ':tanggal_tugas_berakhir'	=>	$object->clean_input($_POST["tanggal_tugas_berakhir"]),
        ':jadwal_berakhir_tugas'	=>	$object->clean_input($_POST["jadwal_berakhir_tugas"]),
    );

    $object->query = "
    INSERT INTO tugas 
    (id_kelas, id_pembuat, judul_tugas, deskripsi_tugas, file_tugas, tanggal_tugas_mulai, jadwal_mulai_tugas, tanggal_tugas_berakhir, jadwal_berakhir_tugas) 
    VALUES (:id_kelas, :id_pembuat, :judul_tugas, :deskripsi_tugas, :file_tugas, :tanggal_tugas_mulai, :jadwal_mulai_tugas, :tanggal_tugas_berakhir, :jadwal_berakhir_tugas)
    ";

    $object->execute($data);

    $_SESSION['pesan'] = "Tugas berhasil dibuat!";

    ?>
    <script>
        window.location.href = "tugas.php";
    </script>
    <?php
}

include("includes/footer.php");

?>
<script>
    var date = new Date();
    date.setDate(date.getDate());

    $('#tanggal_tugas_mulai').datepicker({
        startDate: date,
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });

    $('#tanggal_tugas_berakhir').datepicker({
        startDate: date,
        format: "yyyy-mm-dd",
        autoclose: true,
        language: 'id'
    });

    $('#jadwal_berakhir_tugas').datetimepicker({
        format: 'HH:mm'
    });

    $('#jadwal_mulai_tugas').datetimepicker({
        useCurrent: false,
        format: 'HH:mm'
    });


</script>
</body>

</html>