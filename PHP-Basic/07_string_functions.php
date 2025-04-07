<?php 
    $full_name = 'Nhu Y';
    echo "length: ", strlen($full_name);
    echo strrev($full_name);

    echo strtolower($full_name);
    echo strtoupper($full_name);

    echo str_replace(' ', '-', $full_name);

    if(str_starts_with($full_name, 'Nguyen')){
        echo "Her name starts with Nguyen <br>";
    }

    if(str_ends_with($full_name, 'Y')){
        echo "Her name ends with Y <br>";
    }

    echo "<h1> html string </h1>";

    echo htmlspecialchars("<h1> html string </h1>");

    // echo "<script> alert('This is js code') </script>";

    echo htmlspecialchars("<script> alert('This is js code') </script>");

    printf('<br> %s likes %s', 'Nhu Y', 'Sunrise');

    printf('pi = %f', 3.14);
?>