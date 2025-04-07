<?php
    for($i = 5; $i <= 10; $i++){
        echo "i = $i <br>";
    }

    $i = 0;
    while($i < 20){
        echo "$i <br>";
        $i++;
    }

    $i = 31;
    do{
        echo "$i <br>";
        $i++;
    } while($i < 30);

    $fruits = ['apple', 'orange', 'lemon'];
    for($i = 0; $i < count($fruits); $i++){
        echo "$fruits[$i] <br>";
    }
    foreach ($fruits as $fruit){
        echo "$fruit <br>";
    }

    foreach ($fruits as $index => $fruit){
        echo "$index -  $fruit <br>";
    }

    $person = [
        'full_name' => 'Nhu Y',
        'age' => 18,
        'email' => 'nhuytran@gmail.com'
    ];
    foreach ($person as $key => $value) {
        echo "$key : $value <br>";
    }

    
?>