<?php 

include("../path.php");
$judul_halaman = "Hasil Quiz";
$hasil_active = "active";

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
<?php include("header.php")?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTables -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">

                                
                                <div class="col">
                                    <form class="form-inline" action="" method="get">
                                        <div onKeyPress="return checkSubmit(event)">
                                            <input class="form-control" style="width: 300px;" type="text" name="cari" value="<?php if(isset($_GET['cari'])){echo $_GET['cari'];}?>" placeholder="Cari Pengguna..." aria-label="Search">
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">


                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Total Pertanyaan</th>
                                            <th>Jawaban Salah</th>
                                            <th>Jawaban Benar</th>
                                            <th>Tanggal Ujian</th>
                                        </tr>
                                    </thead>
                                    </tbody>  
                                    <?php 
                                    
                                    $batas = 10;
                                    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
                                    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;


                                    $previous = $halaman - 1;
                                    $next = $halaman + 1;

                                    $data = mysqli_query($conn,"SELECT * FROM hasil_quiz ");
                                    $jumlah_data = mysqli_num_rows($data);
                                    $total_halaman = ceil($jumlah_data / $batas);

                                    $nomor = $halaman_awal+1;
                                    if (isset($_GET['cari'])) {

                                        $filteredvalues = $_GET['cari'];
                                        $query2 = "SELECT * FROM hasil_quiz WHERE CONCAT(nama_pengguna,tipe_quiz) LIKE '%$filteredvalues%' ";
                                        $query_run2 = mysqli_query($conn, $query2);


                                        if (mysqli_num_rows($query_run2) > 0) {
                                            foreach($query_run2 as $item){

                                                ?>
                                    
                                                <tr>
                                                    <td><?php echo strtoupper($item["nama_pengguna"])?></td>
                                                    <td><?php echo $item["tipe_quiz"]?></td>
                                                    <td><?php echo $item["total_pertanyaan"]?></td>
                                                    <td><?php echo $item["jawaban_salah"]?></td>
                                                    <td><?php echo $item["jawaban_benar"]?></td>
                                                    <td><?php echo $item["waktu_ujian"]?></td>

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
                                
            
                                        $query = "SELECT * FROM hasil_quiz ORDER BY id DESC LIMIT $halaman_awal, $batas";
                                        $query_run = mysqli_query($conn, $query);

                                        if (mysqli_num_rows($query_run) > 0) {
                                
                                            foreach($query_run as $row)
                                            {
            
                                                ?>
                                            
                                                <tr>
                                                    <td><?php echo strtoupper($row["nama_pengguna"])?></td>
                                                    <td><?php echo $row["tipe_quiz"]?></td>
                                                    <td><?php echo $row["total_pertanyaan"]?></td>
                                                    <td><?php echo $row["jawaban_salah"]?></td>
                                                    <td><?php echo $row["jawaban_benar"]?></td>
                                                    <td><?php echo $row["waktu_ujian"]?></td>

                                                </tr>

                                                                                           
                                                <?php
                                                
            
                                            }
            
                                                                        
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


    <?php include("../includes/pesanToast.php");?>
    <?php include("footer.php")?>

    <script>



    </script>
</body>

</html>