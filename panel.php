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
                            <div class="d-flex justify-content-center">
                                <img src="assets/img/empty-box.png" alt="Gambar" width="400" class="img-fluid">
                            </div>
      
                            <h5 class="text-center">Anda belum mempunyai kelas</h5>
    
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-outline-primary btn-user" data-toggle="modal" data-target="#buatKelas">Buat Kelas</button>
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

        <!-- Row gotter end -->
        </div>

    <!-- Main body end -->
    </div>



<?php include("includes/pesanToast.php");?>
<?php 

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