<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function createJWT($userId, $username, $role) {
    $issuedAt = time();
    $payload = [
        'iat' => $issuedAt,  
        'nbf' => $issuedAt,         
        'exp' => $issuedAt + TOKEN_EXPIRY, 
        'data' => array(
            'user_id' => $userId,
            'username' => $username,
            'role' => $role
        )
    ];
    
    $token = JWT::encode($payload, JWT_SECRET, JWT_ALGORITHM);
    setcookie("token", $token, time() + 3600, "/", "", true, true);
}

function verifyJWT($token) {
    try {
        if ($token != '') {
            $decoded = JWT::decode($token, new Key(JWT_SECRET, JWT_ALGORITHM));
            return (array) $decoded->data;         
        }
    } catch (Exception $e) {
        error_log($e->getMessage());  // Ghi lại lỗi vào log
        return false;
    }
    return false;
}

?>