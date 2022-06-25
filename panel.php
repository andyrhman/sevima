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
<style>

.kard:hover {
    border: 1px solid #1a1aff;
    -webkit-transform: translateY(-10px);
    transform: translateY(-10px);
    cursor: pointer;
}

.kartu:hover {
  opacity: 0.6;
}

</style>
            <div class="col-lg-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <?php
                            if (isset($_SESSION['kodeError'])) {
                            ?>
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    <span class="badge badge-pill badge-danger">Error</span>
                                    <?= $_SESSION['kodeError'];?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php
                                unset($_SESSION['kodeError']);
                            
                            }   

                            
                            ?>
                            
                            
                        <?php

                        $object->query = "SELECT * FROM kelas_pengguna 
                        INNER JOIN kelas 
                        ON kelas.id_kelas = kelas_pengguna.id_kelas 
                        INNER JOIN pengguna 
                        ON pengguna.id_pengguna = kelas_pengguna.id_pengguna 
                        WHERE kelas_pengguna.id_pengguna = '".$_SESSION['id_pengguna']."' 
                        ";

                        $object->execute();

                        $ambilData = $object->get_result();

                        if ($object->row_count() > 0) {

                            foreach ($ambilData as $kelas) {

                                ?>

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                                        <div class="card kard shadow" style="border: 1px solid #b3b3ff;">
                                            <img src="https://drive.google.com/uc?export=view&id=1aj_vT5zjJlkdEQ_VcCsdnvpVBi-Fjwyb" class="kartu" alt="...">
                                            <div class="card-body">
                                                <a style="font-size: 24px;" href="kelas.php?kelas=<?= $kelas['id_kelas']?>"><?= $kelas['nama_kelas']?></a>
                                                <p class="card-text"><?= $kelas['deskripsi']?></p>
                                            </div>
                                            <div class="card-body card-p">
                                                <div class="row">
                                                    <div class="col col-xs-4 ">
                                                        <i class="far fa-comments"></i> 456
                                                    </div>
                                                    <div class="col col-xs-4 ">
                                                        <i class="far fa-heart"></i> 2.4k
                                                    </div>
                                                    <div class="col col-xs-4">
                                                        <i class="fas fa-share"></i> 99
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

        
                                </div>
                                <?php
                            }
                        }
                        else
                        {
                            
                            ?>
                                <?php 
                                    $object->query = "SELECT * FROM kelas  
                                    WHERE id_pembuat = '".$_SESSION['id_pengguna']."' 
                                    ";
            
                                    $object->execute();
            
                                    $dataPembuat = $object->get_result();

                                    foreach ($dataPembuat as $data) {
                                        if ($data['id_pembuat'] == $_SESSION['id_pengguna']) {
                                            ?>
                                            <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                                <span class="badge badge-pill badge-success">Berhasil</span>
                                                Kode Kelas Anda <strong><?= $data['kode_kelas']?></strong> Anda sekarang bisa menekan tombol <strong>Gabung Kelas</strong>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php
                                        }
                                    }

                                
                                ?>

                            <div class="d-flex justify-content-center">
                                <img src="assets/img/empty-box.png" alt="Gambar" width="400" class="img-fluid">
                            </div>
      
                            <h5 class="text-center">Anda belum mempunyai kelas</h5>
    
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-outline-primary btn-user" data-toggle="modal" data-target="#buatKelas">Buat Kelas</button>
                                <button type="button" class="btn btn-primary btn-user" data-toggle="modal" data-target="#gabungKelas">Gabung ke Kelas</button>
                            </div>
                            <?php
                        }


                        ?>

                

                </div>
            </div>

            </div>
            
            <div id="gabungKelas" class="modal fade">
                <div class="modal-dialog">
                    <form action="" method="post" id="form_pertemuan">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Gabung ke Kelas</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Kode Kelas</label>
                                    <div>                             
                                        <input type="text" name="kode_kelas" id="kode_kelas" class="form-control" required>
                                        <small>Mintalah kode kelas kepada pengajar, lalu masukkan kode di sini.</small>
                                    </div>
                                    

                                </div>
                
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="gabung_kelas" id="gabung_kelas" class="btn btn-success btn-user">Gabung</button>                           
                                <button type="button" class="btn btn-defaul btn-user" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="buatKelas" class="modal fade">
                <div class="modal-dialog">
                    <form action="" method="post" id="form_pertemuan">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="modal_title">Gabung ke Kelas</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <label>Nama Mata Pelajaran</label>                            
                                    <input type="text" name="nama_mapel" id="nama_mapel" placeholder="Masukkan Mata Pelajaran" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan nama mata pelajaran.">

                                </div>
                                <div class="form-group">
                                    <label>Nama Kelas</label>
                                    <input type="text" name="nama_kelas" id="nama_kelas" placeholder="Masukkan Nama Kelas" class="form-control" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan nama kelas.">
 
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" placeholder="Masukkan Deskripsi" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan deskripsi."> </textarea>

                                </div>             
                                <div class="form-group">
                                    <label>Tipe Kelas</label>

                                    <select id="tipe_kelas" name="tipe_kelas" class="form-control" placeholder="Masukkan Tipe Kelas" required  data-parsley-trigger="keyup" data-parsley-required-message="Masukkan tipe kelas."/> 
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="Pribadi">Pribadi</option>
                                        <option value="Publik">Publik</option>
                                    </select>

                                </div>  
                    
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="buat_kelas" id="buat_kelas" class="btn btn-success btn-user">Buat</button>                           
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

if (isset($_POST['buat_kelas'])) {

    $data = array(
        ':nama_mapel'				=>	$object->clean_input($_POST["nama_mapel"]),
        ':id_pembuat'				=>	$object->clean_input($_SESSION['id_pengguna']),
        ':nama_kelas'				=>	$object->clean_input($_POST["nama_kelas"]),
        ':deskripsi'				=>	$object->clean_input($_POST["deskripsi"]),
        ':tipe_kelas'				=>	$object->clean_input($_POST["tipe_kelas"]),
        ':kode_kelas'				=>	$object->buatRandomString(),
        ':waktu_ditambahkan'		=>	$object->now
    );

    $object->query = "
    INSERT INTO kelas 
    (nama_mapel, nama_kelas, deskripsi, kode_kelas, waktu_ditambahkan, tipe_kelas, id_pembuat) 
    VALUES (:nama_mapel, :nama_kelas, :deskripsi, :kode_kelas, :waktu_ditambahkan, :tipe_kelas, :id_pembuat)
    ";

    $object->execute($data);

    $_SESSION['pesan'] = "Kelas berhasil dibuat!";

    ?>
    <script>
        window.location.href = "panel.php";
    </script>
    <?php

}

if (isset($_POST['gabung_kelas'])) {

    $object->query = "SELECT * FROM kelas WHERE kode_kelas ='$_POST[kode_kelas]' LIMIT 1";
    
    $object->execute();

    if ($object->row_count() > 0) {

        $hasilData = $object->statement_result();

        foreach ($hasilData as $hasil) {

            $object->query = "SELECT * from kelas_pengguna WHERE id_pengguna = '".$_SESSION['id_pengguna']."' LIMIT 1";
            $object->execute();

            if ($object->row_count() > 0) {

                $_SESSION['pesanError'] = "Anda sudah terdaftar di kelas ini";
                ?>
                <script>
                    window.location.href = "panel.php";
                </script>
                <?php

            }
            else {
                $object->query = "INSERT INTO kelas_pengguna (id_kelas, id_pengguna) VALUES ('$hasil[id_kelas]','".$_SESSION['id_pengguna']."') ";

                $object->execute();
                $_SESSION['pesan'] = "Berhasil bergabung";
                ?>
                <script>
                    window.location.href = "panel.php";
                </script>
                <?php
            }

        }

    }else{
        $_SESSION['kodeError'] = "Kode tidak ditemukan";
        ?>
        <script>
            window.location.href = "panel.php";
        </script>
        <?php
    }

}

include("includes/footer.php");

?>
<script>



</script>
</body>

</html>