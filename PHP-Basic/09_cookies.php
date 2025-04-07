<?php 
    setcookie('name', 'Nhu Y', time() + 24 * 3600);
    
    if(isset($_COOKIE['name'])){
        echo $_COOKIE['name'];
    }
    // Xóa cookies - unset cookie
    setcookie('name', '', time() - 24 * 3600);
?>