<?php

//logout.php

session_start();

session_destroy();
unset($_COOKIE['email_pengguna']);
unset($_COOKIE['password_pengguna']);
setcookie ("email_pengguna","", time() - 1);
setcookie ("password_pengguna","", time() - 1); 
header("location:login.php");

?>