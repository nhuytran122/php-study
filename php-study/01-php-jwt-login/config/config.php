<?php 
    $secretKey = 'ggdfgdfjopgejoggjflnxnbklxnblkvcnfsgisfjgkf56484f6d';
    define('JWT_SECRET', $secretKey); 
    define('JWT_ALGORITHM', 'HS256'); 
    define('TOKEN_EXPIRY', 3600);

    define('URL_GG_CALLBACK', 'http://localhost:3000/php-study/01-php-jwt-login/src/auth/google_callback.php');
?>