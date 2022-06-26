<?php
$judul_halaman = "Dashboard Admin";
$pertanyaan_active = "active";

include('../app/controllers/Ujianku.php');
include('../app/database/connect.php');
$object = new Ujianku;

if(!$object->is_login())
{
    header("location:".$object->base_url."admin/login.php");
}

if($_SESSION['type'] != 'Admin')
{
    header("location:".$object->base_url."");
}


?>

<?php include("header.php");?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTables -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">

                                
                                <div class="col">
                                    <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran</h6>
                                </div>
                                <!-- Topbar Search -->
                                
                                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" action="" method="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" name="cari" value="<?php if(isset($_GET['cari'])){echo $_GET['cari'];}?>"  placeholder="Cari..."
                                            aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">


                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama Mapel</th>
                                            <th>Waktu Ujian</th>
                                            <th>Token</th>
                                            <th>Status Unggah</th>
                                            <th>Buat Soal</th>
                                            <th>Lihat Soal</th>
                                        </tr>
                                    </thead>
                                    </tbody>  
                                    <?php 
                                    
                                    $batas = 10;
                                    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;


                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;

                                    $object->query = "SELECT * FROM kategori_quiz ORDER BY id DESC LIMIT $halaman_awal, $batas
                                    ";
                                    
                                    $object->execute();
                                                                       
                                    $jumlah_data = $object->row_count();

                                    $total_halaman = ceil($jumlah_data / $batas);

                                    $nomor = $halaman_awal+1;
                                    if (isset($_GET['cari'])) {

                                        $filteredvalues = $_GET['cari'];

                                        $object->query = "SELECT * FROM kategori_quiz WHERE CONCAT(kategori,token) LIKE '%$filteredvalues%' 
                                        ";

                                        $object->execute();

                                        $hasil = $object->get_result();   

                                        if ($object->row_count() > 0) {
                                            foreach($hasil as $item){

                                                if($item["publish"] == '1')
                                                {
                                                    $status = '<span class="badge badge-success">Ya</span>';
                                                }
                                                else
                                                {
                                                    $status = '<span class="badge badge-danger">Tidak</span>';
                                                }
                                                ?>
                                    
                                                <tr>
                                                    
                                                    <td><?php echo $item['kategori'];?></td>
                                                    <td><?php echo $item['waktu_ujian'];?> Menit</td>
                                                    <td><?php echo $item['token'];?></td>
                                                    <td><?php echo $status?></td>
                                                    <td align="center">
                                                        <a name="tambah-soal" href="buat-soal.php?idTeks=<?php echo $item['id'];?>" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-pen-clip"></i></a>
                                                        <a name="tambah-soal" href="buat-soal.php?idGambar=<?php echo $item['id'];?>" class="btn btn-primary btn-circle btn-sm"><i class="fa-solid fa-image"></i></a>
                                                    </td>
                                                    <td align="center">
                                                        <a name="view-soal" href="buat-soal.php?idTeks=<?php echo $item['id'];?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-eye"></i></a>                                                      
                                                    </td>
                                            

                                                </tr>
                                                                    
                                                <?php
                                            }

                                        }
                                        else {
                                            ?>
                                    
                                            <tr>
                                                <td colspan="8">Data tidak ditemukan!</td>
                                            </tr>
                                                                
                                            <?php
                                        }

                                    }  
                                    else
                                    {
                                
                                        $object->query = "SELECT * FROM kategori_quiz ORDER BY id DESC LIMIT $halaman_awal, $batas
                                        ";
                                        
                                        $hasil = $object->get_result();                             
                                        foreach($hasil as $row)
                                        {
                                            if($row["publish"] == '1')
                                            {
                                                $status = '<span class="badge badge-success">Ya</span>';
                                            }
                                            else
                                            {
                                                $status = '<span class="badge badge-danger">Tidak</span>';
                                            }
                                            ?>
                                
                                            <tr>
                                                
                                                <td><?php echo $row['kategori'];?></td>
                                                <td><?php echo $row['waktu_ujian'];?> Menit</td>
                                                <td><?php echo $row['token'];?></td>
                                                <td><?php echo $status?></td>
                                                <td align="center">
                                                    <a name="tambah-soal" href="buat-soal.php?idTeks=<?php echo $row['id'];?>" class="btn btn-success btn-circle btn-sm"><i class="fa-solid fa-pen-clip"></i></a>
                                                    <a name="tambah-soal" href="buat-soal.php?idGambar=<?php echo $row['id'];?>" class="btn btn-primary btn-circle btn-sm"><i class="fa-solid fa-image"></i></a>
                                                </td>
                                                <td align="center">
                                                    <a name="view-soal" href="buat-soal.php?id=<?php echo $row['id'];?>" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-eye"></i></a>                                                      
                                                </td>
                                        

                                            </tr>

                                                                                        
                                            <?php
                                            
        
                                        }
            
                                                                        
                                        
                                    } 

                                    ?>
                                    <tbody>
                                </table>

                                <nav>
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item">
                                            
                                            <a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                        <?php 
                                        for($x=1;$x<=$total_halaman;$x++){
                                            ?> 
                                            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                                            <?php
                                        }
                                        ?>				
                                        <li class="page-item">
                                            <a class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?> aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>



                            </div>
                        </div>
                    </div>
                




                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->



<?php include("footer.php");?>
    <!-- Modal untuk pertanyaan berbentuk Teks -->
    <div id="liatModalTeks" class="modal fade">
        <div class="modal-dialog modal-xl">                    
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Buat Pertanyaan Ujian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <?php
                    if(isset($_GET['idTeks'])){
                        ?>
                        <script>$('#liatModalTeks').modal('show');</script>


                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <textarea class="form-control" name="pertanyaan" id="pertanyaan" required> </textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-a"></i></span>
                                    </div>
                                    <input type="text" name="opsiA" id="opsiA" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                    </div>
                                    <input type="text" name="opsiB" id="opsiB" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-c"></i></span>
                                    </div>
                                    <input type="text" name="opsiC" id="opsiC" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 4</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-d"></i></span>
                                    </div>
                                    <input type="text" name="opsiD" id="opsiD" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <input type="text" name="jawaban" id="jawaban" class="form-control" required>
                                </div>
                            </div>                        
                        
                        <?php

                    }
                    else 
                    {
                        ?>
                        <h4>Data tidak ditemukan!</h4>
                        <?php
                    }

                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submitTeks" class="btn btn-success btn-user btn-block">Submit</button>
                        <button type="button" class="btn btn-danger btn-user btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk pertanyaan berbentuk Gambar -->
    <div id="liatModalGambar" class="modal fade">
        <div class="modal-dialog modal-xl">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Buat Pertanyaan Ujian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <?php
                    if(isset($_GET['idGambar'])){
                        ?>
                        <script>$('#liatModalGambar').modal('show');</script>


                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <textarea class="form-control" name="fpertanyaan" id="fpertanyaan" required> </textarea>                              
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-a"></i></span>
                                    </div>
                                    <input type="file" name="fopsiA" id="fopsiA" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                    </div>
                                    <input type="file" name="fopsiB" id="fopsiB" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-c"></i></span>
                                    </div>
                                    <input type="file" name="fopsiC" id="fopsiC" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 4</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-d"></i></span>
                                    </div>
                                    <input type="file" name="fopsiD" id="fopsiD" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <input type="file" name="fjawaban" id="fjawaban" class="form-control" required>
                                </div>
                            </div>
                            
                        </form>
                        <?php

                    }
                    else 
                    {
                        ?>
                        <h4>Data tidak ditemukan!</h4>
                        <?php
                    }

                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submitGambar" class="btn btn-success btn-user btn-block">Submit</button>
                        <button type="button" class="btn btn-danger btn-user btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Lihat Pertanyaan -->
    <div id="liatSoal" class="modal fade">
        <div class="modal-dialog modal-xl">
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Lihat Pertanyaan</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                    <?php
                    if(isset($_GET['id'])){
                        $idLiatSoal = $_GET['id'];
                        ?>
                        <script>$('#liatSoal').modal('show');</script>

                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Opsi 1</th>
                                    <th>Opsi 2</th>
                                    <th>Opsi 3</th>
                                    <th>Opsi 4</th>
                                    <th>Jawaban</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            </tbody>  
                            
                            <?php                        
                                $idView = $_GET['id'];
                                $teks = '';
                                $object->query = "SELECT * FROM kategori_quiz WHERE id=$idView";
                                $TeksView = $object->get_result();
                                foreach ($TeksView as $asdTeks) {
                                    $teks = $asdTeks["kategori"];
                                }

                                $object->query = "SELECT * FROM pertanyaan WHERE kategori='$teks' ORDER BY no_pertanyaan ASC";
                                $object->execute();

                                $viewPertanyaan = $object->get_result();

                                foreach($viewPertanyaan as $row)
                                {
                                
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $row["no_pertanyaan"]; ?></th>
                                        <td><?php echo $row["pertanyaan"]; ?></td>
                                        <td><?php 

                                            if (strpos($row["opt1"], "opt_images/") !== false) {
                                                ?>
                                                    <img src="<?php echo $row["opt1"];?>" height="50" width="50" alt="gambar">
                                                <?php
                                            } else {
                                                echo $row["opt1"];
                                            }
                                        
                                        ?></td>

                                        <td><?php 

                                        if (strpos($row["opt2"], "opt_images/") !== false) {
                                            ?>
                                                <img src="<?php echo $row["opt2"];?>" height="50" width="50" alt="gambar">
                                            <?php
                                        } else {
                                            echo $row["opt2"];
                                        }

                                        ?></td>

                                        <td><?php 

                                        if (strpos($row["opt3"], "opt_images/") !== false) {
                                            ?>
                                                <img src="<?php echo $row["opt3"];?>" height="50" width="50" alt="gambar">
                                            <?php
                                        } else {
                                            echo $row["opt3"];
                                        }

                                        ?></td>

                                        <td><?php 

                                        if (strpos($row["opt4"], "opt_images/") !== false) {
                                            ?>
                                                <img src="<?php echo $row["opt4"];?>" height="50" width="50" alt="gambar">
                                            <?php
                                        } else {
                                            echo $row["opt4"];
                                        }

                                        ?></td>

                                        <td><?php 

                                        if (strpos($row["jawaban"], "opt_images/") !== false) {
                                            ?>
                                                <img src="<?php echo $row["jawaban"];?>" height="50" width="50" alt="gambar">
                                            <?php
                                        } else {
                                            echo $row["jawaban"];
                                        }

                                        ?></td>
                                        
                                        <td align="center"><?php 

                                        if (strpos($row["opt4"], "opt_images/") !== false) {
                                            ?>
                                                <a href="buat-soal.php?idPertanyaanGambar=<?php echo $row["id"]; ?>&idKategori=<?php echo $idLiatSoal?>" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a> 
                                            <?php
                                        } else {
                                            ?>
                                            <a href="buat-soal.php?idPertanyaanTeks=<?php echo $row["id"]; ?>&idKategori=<?php echo $idLiatSoal?>" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-edit"></i></a>
                                            <?php
                                        }

                                        ?></td>
                                        <td align="center">
                                            <form action="buat-soal.php" method="post">
                                                <button type="submit" value="<?= $row['id'];?>" name="hapusPertanyaan" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-times"></i></button>                                           
                                            </form>
                                        </td>

                                    </tr>
                                
                                <?php
                            }
                            ?>

                            <tbody>
                        </table>
                           
                        <?php

                    }
                    else 
                    {
                        ?>
                        <h4>Data tidak ditemukan!</h4>
                        <?php
                    }

                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Edit pertanyaan berbentuk Teks -->
    <div id="EditModalTeks" class="modal fade">
        <div class="modal-dialog modal-xl">                    
            <form action="" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Edit Pertanyaan Ujian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    <?php
                    if(isset($_GET['idPertanyaanTeks'],$_GET['idKategori'])){
                        $idPertanyaanTeks = $_GET['idPertanyaanTeks'];
                        $idKategori = $_GET['idKategori'];

                        $object->query = "SELECT * FROM pertanyaan WHERE id = $idPertanyaanTeks";
                        $hasilPertanyaan = $object->get_result();

                        foreach ($hasilPertanyaan as $soal) {
                            ?>
                            <script>$('#EditModalTeks').modal('show');</script>
                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <textarea class="form-control" name="pertanyaan" id="pertanyaan" required><?= $soal["pertanyaan"];?></textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-a"></i></span>
                                    </div>
                                    <input type="text" name="opsiA" id="opsiA" value="<?= $soal["opt1"];?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                    </div>
                                    <input type="text" name="opsiB" id="opsiB" value="<?= $soal["opt2"];?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-c"></i></span>
                                    </div>
                                    <input type="text" name="opsiC" id="opsiC" value="<?= $soal["opt3"];?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 4</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-d"></i></span>
                                    </div>
                                    <input type="text" name="opsiD" id="opsiD" value="<?= $soal["opt4"];?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <input type="text" name="jawaban" id="jawaban" value="<?= $soal["jawaban"];?>" class="form-control" required>
                                </div>
                            </div>                                                    
                            <?php
                        }

                    }
                    else 
                    {
                        ?>
                        <h4>Data tidak ditemukan2222!</h4>
                        <?php
                    }

                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="updateTeks" class="btn btn-success btn-user btn-block">Submit</button>
                        <button type="button" class="btn btn-danger btn-user btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal untuk Edit pertanyaan berbentuk Gambar -->
    <div id="EditModalGambar" class="modal fade">
        <div class="modal-dialog modal-xl">                    
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judul_modal">Edit Pertanyaan Ujian</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                    <?php
                    if(isset($_GET['idPertanyaanGambar'],$_GET['idKategori'])){
                        $idPertanyaanGambar = $_GET['idPertanyaanGambar'];
                        $idKategori = $_GET['idKategori'];

                        $object->query = "SELECT * FROM pertanyaan WHERE id = $idPertanyaanGambar";
                        $hasilPertanyaan = $object->get_result();

                        foreach ($hasilPertanyaan as $soal) {
                            ?>
                            <script>$('#EditModalGambar').modal('show');</script>
                            <div class="form-group">
                                <label>Pertanyaan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <textarea class="form-control" name="pertanyaan" id="pertanyaan" required><?= $soal["pertanyaan"];?></textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pilihan 1</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-a"></i></span>
                                    </div>
                                    <div><img src="<?php echo $soal['opt1']?>" alt="gambar" width="120"></div> <br>
                                    
                                </div>
                                <input type="file" name="fopsiA" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pilihan 2</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-b"></i></span>
                                    </div>
                                    <div><img src="<?php echo $soal['opt2']?>" alt="gambar" width="120"></div> <br>
                                    
                                </div>
                                <input type="file" name="fopsiB" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pilihan 3</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-c"></i></span>
                                    </div>
                                    <div><img src="<?php echo $soal['opt3']?>" alt="gambar" width="120"></div> <br>
                                    
                                </div>
                                <input type="file" name="fopsiC" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Pilihan 4</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-d"></i></span>
                                    </div>
                                    <div><img src="<?php echo $soal['opt4']?>" alt="gambar" width="120"></div> <br>
                                    
                                </div>
                                <input type="file" name="fopsiD" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jawaban</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-book"></i></span>
                                    </div>
                                    <div><img src="<?php echo $soal['jawaban']?>" alt="gambar" width="120"></div> <br>
                                    
                                </div>
                                <input type="file" name="fjawaban" class="form-control">
                            </div>                                                    
                            <?php
                        }

                    }
                    else 
                    {
                        ?>
                        <h4>Data tidak ditemukan!</h4>
                        <?php
                    }

                    ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="updateGambar" class="btn btn-success btn-user btn-block">Submit</button>
                        <button type="button" class="btn btn-danger btn-user btn-block" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php include("../includes/pesan.php");?>
<?php

if (isset($_POST['hapusPertanyaan'])) {

    $hapusPertanyaan = $_POST['hapusPertanyaan'];

    $object->query = "DELETE FROM pertanyaan WHERE id ='$hapusPertanyaan' ";

    $object->execute();

    $_SESSION["message"] = 'Berhasil';
    $_SESSION["teks"] = 'Pertanyaan berhasil dihapus';
    $_SESSION["status"] = 'success';
    ?>
        <script>window.location.href=window.location.href;</script>
    <?php
    
}

if (isset($_POST['submitTeks'])) { 
    $idTeks = $_GET['idTeks'];
    $teks = '';
    $object->query = "SELECT * FROM kategori_quiz WHERE id=$idTeks";
    $Teksid = $object->get_result();
    foreach ($Teksid as $asdTeks) {
        $teks = $asdTeks["kategori"];
    }

    $loop = 0;

    if ($object->row_count() == 0) {
        $_SESSION["pesan"] = 'Ini pesan';

    }
    else
    {
        $object->query = "SELECT * FROM pertanyaan WHERE kategori='$teks' ORDER BY id ASC";

        $hasil = $object->get_result();
        foreach ($hasil as $fgh) {
            $loop = $loop+1;
            $object->query = "UPDATE pertanyaan SET no_pertanyaan='$loop' WHERE id=$fgh[id]";
            $object->execute();
        }
    }

    $loop = $loop+1;

    $object->query = "INSERT INTO pertanyaan VALUES (NULL, '$loop', '$_POST[pertanyaan]', '$_POST[opsiA]', '$_POST[opsiB]', '$_POST[opsiC]', '$_POST[opsiD]', '$_POST[jawaban]', '$teks')";

    $object->execute();
    $_SESSION["message"] = 'Berhasil';
    $_SESSION["teks"] = 'Pertanyaan berhasil ditambah';
    $_SESSION["status"] = 'success';
    ?>
    <script type="text/javascript">
        window.location.href = window.location.href;
    </script>
    <?php
}

if (isset($_POST['submitGambar'])) { 
    $idTeks = $_GET['idGambar'];
    $teks = '';
    $object->query = "SELECT * FROM kategori_quiz WHERE id=$idTeks";
    $Teksid = $object->get_result();
    foreach ($Teksid as $asdTeks) {
        $teks = $asdTeks["kategori"];
    }

    $loop = 0;

    if ($object->row_count() == 0) {
        $_SESSION["message"] = 'Ini pesan';
        $_SESSION["teks"] = 'Ini pesan';
        $_SESSION["status"] = 'success';

    }
    else
    {
        $object->query = "SELECT * FROM pertanyaan WHERE kategori='$teks' ORDER BY id ASC";

        $hasil = $object->get_result();
        foreach ($hasil as $fgh) {
            $loop = $loop+1;
            $object->query = "UPDATE pertanyaan SET no_pertanyaan='$loop' WHERE id=$fgh[id]";
            $object->execute();
        }
    }

    $loop = $loop+1;

    $tm = time();

    $fnm1 = $_FILES["fopsiA"]["name"];
    $dst1 = "./opt_images/" . $tm . $fnm1;
    $opsiGambarA = "opt_images/" . $tm . $fnm1;
    move_uploaded_file($_FILES["fopsiA"]["tmp_name"], $dst1);

    $fnm2 = $_FILES["fopsiB"]["name"];
    $dst2 = "./opt_images/" . $tm . $fnm2;
    $opsiGambarB = "opt_images/" . $tm . $fnm2;
    move_uploaded_file($_FILES["fopsiB"]["tmp_name"], $dst2);

    $fnm3 = $_FILES["fopsiC"]["name"];
    $dst3 = "./opt_images/" . $tm . $fnm3;
    $opsiGambarC = "opt_images/" . $tm . $fnm3;
    move_uploaded_file($_FILES["fopsiC"]["tmp_name"], $dst3);

    $fnm4 = $_FILES["fopsiD"]["name"];
    $dst4 = "./opt_images/" . $tm . $fnm4;
    $opsiGambarD = "opt_images/" . $tm . $fnm4;
    move_uploaded_file($_FILES["fopsiD"]["tmp_name"], $dst4);

    $fnm5 = $_FILES["fjawaban"]["name"];
    $dst5 = "./opt_images/" . $tm . $fnm5;
    $opsiGambarJawaban = "opt_images/" . $tm . $fnm5;
    move_uploaded_file($_FILES["fjawaban"]["tmp_name"], $dst5);

    $object->query = "INSERT INTO pertanyaan VALUES (NULL, '$loop', '$_POST[fpertanyaan]', '$opsiGambarA', '$opsiGambarB', '$opsiGambarC', '$opsiGambarD', '$opsiGambarJawaban', '$teks')";

    $object->execute();
    $_SESSION["message"] = 'Berhasil';
    $_SESSION["teks"] = 'Pertanyaan berhasil ditambah';
    $_SESSION["status"] = 'success';
    ?>
    <script type="text/javascript">
        window.location.href = window.location.href;
    </script>
    <?php
}

if (isset($_POST['updateTeks'])) { 

    $pertanyaan  = $_POST['pertanyaan'];
    $opsiA      = $_POST['opsiA'];
    $opsiB      = $_POST['opsiB'];
    $opsiC      = $_POST['opsiC'];
    $opsiD      = $_POST['opsiD'];
    $jawaban    = $_POST['jawaban'];

    $object->query = "UPDATE pertanyaan SET 
    pertanyaan = '$pertanyaan',
    opt1 = '$opsiA',
    opt2 = '$opsiB',
    opt3 = '$opsiC',
    opt4 = '$opsiD',
    jawaban = '$jawaban' 
    WHERE id = $idPertanyaanTeks";

    $object->execute();

    $_SESSION["message"] = 'Berhasil';
    $_SESSION["teks"] = 'Pertanyaan berhasil diupdate';
    $_SESSION["status"] = 'success';
    ?>
    <script type="text/javascript">
        window.location.href = "buat-soal.php";
    </script>
    <?php
}

if (isset($_POST['updateGambar'])) { 

    $fpertanyaan = $_POST["pertanyaan"];
    $opsiGambarA = $_FILES["fopsiA"]["name"];
    $opsiGambarB = $_FILES["fopsiB"]["name"];
    $opsiGambarC = $_FILES["fopsiC"]["name"];
    $opsiGambarD = $_FILES["fopsiD"]["name"];
    $fjawaban    = $_FILES["fjawaban"]["name"];

    $tm = time();

    if ($opsiGambarA!="") {

        $dst1 = "./opt_images/" . $tm . $opt1;
        $dst_db1 = "opt_images/" . $tm . $opt1;
        move_uploaded_file($_FILES["fopsiA"] ["tmp_name"], $dst1);
    
        $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan', opt1='$dst_db1' WHERE id = $idPertanyaanGambar";
        $object->execute();
    }

    if ($opsiGambarB!="") {

        $dst2 = "./opt_images/" . $tm . $opt2;
        $dst_db2 = "opt_images/" . $tm . $opt2;
        move_uploaded_file($_FILES["fopsiB"] ["tmp_name"], $dst2);
    
        $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan', opt2='$dst_db2' WHERE id = $idPertanyaanGambar";
        $object->execute();

    }

    if ($opsiGambarC!="") {

        $dst3 = "./opt_images/" . $tm . $opt3;
        $dst_db3 = "opt_images/" . $tm . $opt3;
        move_uploaded_file($_FILES["fopsiC"] ["tmp_name"], $dst3);
    
        $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan', opt3='$dst_db3' WHERE id = $idPertanyaanGambar";
        $object->execute();

    }

    if ($opsiGambarD!="") {

        $dst4 = "./opt_images/" . $tm . $opt4;
        $dst_db4 = "opt_images/" . $tm . $opt4;
        move_uploaded_file($_FILES["fopsiD"] ["tmp_name"], $dst4);
    
        $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan', opt4='$dst_db4' WHERE id = $idPertanyaanGambar";
        $object->execute();

    }

    if ($fjawaban!="") {

        $dst5 = "./opt_images/" . $tm . $jawaban;
        $dst_db5 = "opt_images/" . $tm . $jawaban;
        move_uploaded_file($_FILES["fjawaban"] ["tmp_name"], $dst5);
    
        $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan', jawaban='$dst_db5' WHERE id = $idPertanyaanGambar";
        $object->execute();

    }

    $object->query = "UPDATE pertanyaan SET pertanyaan = '$fpertanyaan' WHERE id = $idPertanyaanGambar";
    $object->execute();

    $_SESSION["message"] = 'Berhasil';
    $_SESSION["teks"] = 'Pertanyaan berhasil diupdate';
    $_SESSION["status"] = 'success';
    ?>
    <script type="text/javascript">
        window.location.href = "buat-soal.php";
    </script>
    <?php
}
?>

</body>
</html>