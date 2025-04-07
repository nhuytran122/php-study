<?php
    require_once __DIR__ . '/jwt.php';


    function getUserFromToken() {
        $token = $_COOKIE['token'] ?? '';
        return verifyJWT($token);
    }

    function checkPermission($requiredRole) {
        $user = getUserFromToken();
        if ($user && $user['role'] === $requiredRole) {
            return true;
        }
        return false;
    }
?>