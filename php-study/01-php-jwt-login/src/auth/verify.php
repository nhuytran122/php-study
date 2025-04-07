<?php
    require_once __DIR__ . '/jwt.php';


    function getUserFromToken() {
        $token = $_COOKIE['token'] ?? '';
        return verifyJWT($token);
    }
?>