<?php


include('../../app/controllers/Ujianku.php');
include('../../app/database/connect.php');
$object = new Ujianku;
$no_pertanyaan = "";
$pertanyaan = "";
$opt1 = "";
$opt2 = "";
$opt3 = "";
$opt4 = "";
$jawaban = "";
$count = 0;
$ans = "";

$queno = $_GET["questionno"];

// Untuk menyimpan jawaban
if (isset($_SESSION["jawaban"][$queno])) 
{
    $ans = $_SESSION["jawaban"][$queno];
}

$object->query = "SELECT * FROM pertanyaan WHERE kategori='$_SESSION[kategori_quiz]' && no_pertanyaan=$_GET[questionno]";
$object->execute();
$count = $object->row_count();

$hasilQuery = $object->get_result();

if ($count == 0) 
{
    echo "selesai"; 
} 
else {

    foreach ($hasilQuery as $row) {
        $no_pertanyaan = $row["no_pertanyaan"];
        $pertanyaan = $row["pertanyaan"];
        $opt1 = $row["opt1"];
        $opt2 = $row["opt2"];
        $opt3 = $row["opt3"];
        $opt4 = $row["opt4"];
    }

    ?>

    <br>

    <div class="question bg-white p-3 border-bottom" >
        <div class="d-flex flex-row align-items-center question-title">
            <h3 class="text-danger"><?php echo $no_pertanyaan?>)&nbsp;</h3>
            <div>
                <h5 class="mt-1 ml-2"><?php echo $pertanyaan;?></h5>
            </div>
        </div>
        <div class="ans ml-2">
            <label class="radio"> 
                <input type="radio" name="r1" id="r1" value="<?php echo $opt1; ?>" onclick="radioclick(this.value,<?php echo $no_pertanyaan; ?>)" 
            
            <?php 
                if ($ans == $opt1) {
                    echo "checked";
                }
            
            ?>>
            </label>
            <?php 
                if (strpos($opt1, 'images/') != false) {
                   
                    ?>
                    <img src="admin/<?php echo $opt1?>" class="my-3" alt="" height="80" width="80">
                   
                    <?php

                } else {
                    echo $opt1;
                }
                
            ?>
        </div>
        <div class="ans ml-2">
            <label class="radio"> 
                <input type="radio" name="r1" id="r1" value="<?php echo $opt2; ?>" onclick="radioclick(this.value,<?php echo $no_pertanyaan; ?>)" 
            
            <?php 
                if ($ans == $opt2) {
                    echo "checked";
                }
            
            ?>>
            </label>
            <?php 
                if (strpos($opt2, 'images/') != false) {
                   
                    ?>
                        <img src="admin/<?php echo $opt2?>" class="my-3" alt="" height="80" width="80">
                    <?php

                } else {
                    echo $opt2;
                }
                
            ?>
        </div>
        <div class="ans ml-2">
            <label class="radio"> 
                <input type="radio" name="r1" id="r1" value="<?php echo $opt3; ?>" onclick="radioclick(this.value,<?php echo $no_pertanyaan; ?>)"
            
            <?php 
                if ($ans == $opt3) {
                    echo "checked";
                }
            
            ?>>
            </label>
            <?php 
                if (strpos($opt3, 'images/') != false) {
                   
                    ?>
                        <img src="admin/<?php echo $opt3?>" class="my-3" alt="" height="80" width="80">
                    <?php

                } else {
                    echo $opt3;
                }
                
            ?>
        </div>
        <div class="ans ml-2">
            <label class="radio"> 
                <input type="radio" name="r1" id="r1" value="<?php echo $opt4; ?>" onclick="radioclick(this.value,<?php echo $no_pertanyaan; ?>)"
            
            <?php 
                if ($ans == $opt4) {
                    echo "checked";
                }
            
            ?>>
            </label>
            <?php 
                if (strpos($opt4, 'images/') != false) {
                   
                    ?>
                        <img src="admin/<?php echo $opt4?>" class="my-3" alt="" height="80" width="80">
                    <?php

                } else {
                    echo $opt4;
                }
                
            ?>
        </div>

    </div>
    <?php

}

?>
