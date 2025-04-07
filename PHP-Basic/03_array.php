<?php
$some_numbers = [2, 6, 9, 8];
$fruits = ['apple', 'melon', 'pineapple'];

// print_r($fruits);
// echo $fruits[2];

$colors = [
    3 => 'red',
    5 => 'blue',
    7 => 'green'
];
// echo $colors[7];

$hex_colors = [
    'red' => 'FF0000',
    'green' => '00FF00'
];
// echo $hex_colors['green'];

$person = [
    'full_name' => 'Nhu Y',
    'age' => 22,
    'email' => 'nhuytran@gmail.com'
];
// echo $person['email'];

$persons =  [
    [
        'full_name' => 'Nhu Y',
        'age' => 22,
        'email' => 'nhuytran@gmail.com'
    ],
    [
        'full_name' => 'Hoang Minh',
        'age' => 22,
        'email' => 'hminh@gmail.com'
    ]

];

echo $persons[1]['full_name'];
// var_dump(json_decode($persons));

?>