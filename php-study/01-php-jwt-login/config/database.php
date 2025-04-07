<?php
    define('DATABASE_SERVER', 'localhost');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASSWORD', '123456');
    define('DATABASE_NAME', 'learning_management');
    $connection = null;

    try{
        $connection = new PDO(
            "mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME,
            DATABASE_USER,
            DATABASE_PASSWORD
        );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException  $e){
        echo "Connection failed: " . $e->getMessage();
        $connection = null;
    }

?>