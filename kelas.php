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
.bg-cover {
    background-position: center;
    background-repeat: no-repeat;
    background-size: 1280px 720px;
}
</style>
            <div class="col-lg-9">
                <div class="card mb-3">
                    <div class="card-body">
  

                    <header class="bg-cover py-5" style="background-image: url(assets/img/online-courses.png); background-color:#bad7f5;">
                        <div class="container px-5">
                            <div class="row gx-5 mt-5">
                                <div class="col-lg-8 col-xl-7 col-xxl-6">
                                    <div class="my-5 text-xl-start">
                                        <h1 class="display-5 fw-bolder text-white mb-2" style="font-weight: bold;">A Bootstrap 5 template for modern businesses</h1>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </header>

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

include("includes/footer.php");

?>
<script>



</script>
</body>

</html>