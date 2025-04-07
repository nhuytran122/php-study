<?php 
    session_start();
    session_destroy();
    header('Location: 10_session.php');
?>