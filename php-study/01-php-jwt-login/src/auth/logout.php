<?php
    require_once '../../config/config.php';
    require_once '../../vendor/autoload.php';
    
    $client = new Google_Client();
    $client->setAuthConfig('../../config/credentials.json');
    $client->revokeToken(); 
    setcookie("token", "", time() - TOKEN_EXPIRY, "/", "", true, true);

    header("Location: ../../view/login.php");
    exit();
?>