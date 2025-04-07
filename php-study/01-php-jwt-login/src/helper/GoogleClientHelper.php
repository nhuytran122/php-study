<?php
require_once __DIR__ . '/../../vendor/autoload.php'; 

class GoogleClientHelper {
    public static function createClient() {
        $client = new Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../config/credentials.json'); 
        $client->setRedirectUri(URL_GG_CALLBACK);
        $client->addScope('email');
        $client->addScope('profile');
        return $client;
    }
}