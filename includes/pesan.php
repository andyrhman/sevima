<?php if(isset($_SESSION['message'])): ?>
    <script src="assets/js/sweetalert.min.js"></script> 
    <script>
        swal({
            title: "<?php echo $_SESSION['message'];?>",
            text: "<?php echo $_SESSION['teks'];?>",
            icon: "<?php echo $_SESSION['status'];?>",
            button: "Oke",
        });
    </script>
    <?php unset($_SESSION['message'])?>
<?php endif;?>

