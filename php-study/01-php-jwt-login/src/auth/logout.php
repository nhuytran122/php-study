<?php
    require '../../config/config.php';
    setcookie("token", "", time() - TOKEN_EXPIRY, "/", "", true, true);

    header("Location: ../../view/login.php");
    exit();
?>