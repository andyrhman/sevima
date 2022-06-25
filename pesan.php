<?php

if (isset($_SESSION['login_status'])) {
    ?>
    <div class="sufee-alert alert with-close <?= $_SESSION['colour'];?> alert-dismissible fade show">
        <span class="badge badge-pill badge-warning"><i class="fa-solid fa-exclamation"></i></span>
        <?= $_SESSION['login_status']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['login_status']);
  
}

if (isset($_SESSION['login_status2'])) {
    ?>
    <div class="sufee-alert alert with-close <?= $_SESSION['colour2'];?> alert-dismissible fade show">
        <span class="badge badge-pill badge-warning"><i class="fa-solid fa-exclamation"></i></span>
        <?= $_SESSION['login_status2']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['login_status2']);
  
}

if (isset($_SESSION['passError'])) {
?>
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger">Error</span>
        <?= $_SESSION['passError'];?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php
    unset($_SESSION['passError']);

}    

?>