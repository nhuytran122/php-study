<?php 
    $y = 20;
    function sayHello($name){
        global $y;
        // echo "$y";
        // echo "Hello $name";
    }

    function sum($a=0, $b=0){
        return $a + $b;
    }

    sayHello('Nhu Y');
    // echo sum(5, 8);

    $multiply = function($a, $b){
        return $a * $b;
    };
    // echo $multiply(3, 4);

    $substract = fn($a, $b) => $a - $b;
    // echo $substract(6, 2);

    $names = ['Nhu Y', 'Minh', 'Hoang', 'Khanh'];
    // echo 'Number of items: ' .count($names);

    // var_dump((in_array('Hoang', $names)));

    // Chèn cuối
    array_push($names, 'Khoa', 'Quynh');

    // Chèn đầu
    array_unshift($names, 'Khai');

    // xÓA CUỐI
    array_pop($names);
    // print_r($names);

    // Xóa đầu
    array_shift($names);
    // print_r($names);

    // Xoá phần tử + không đánh lại stt
    // unset($names[3]);
    // print_r($names);

    // Chia nhỏ arr ra
    $chunked_array = array_chunk($names, 3);
    // print_r($chunked_array);

    $arr_one = [1, 3, 5];
    $arr_two = [2, 4, 6];

    $merged_arr = array_merge($arr_one, $arr_two);
    // print_r($merged_arr);

    // spread operator
    $arr_three = [...$merged_arr]; // clone an arr
    $merged_arr[0] = 111;
    // print_r($arr_three);

    $arr_four = [...$arr_one, ...$arr_two];
    // print_r($arr_four);

    // Combine two arrs
    $a = ['name', 'age', 'email'];
    $b = ['Hoang', 22, 'hoang@gmail.com'];
    $c = array_combine($a, $b);
    
    // print_r(array_keys($c));
    // print_r(array_values($c));

    // Đảo keys vs values
    // print_r(array_flip($c));

    $numbers = range(0, 10);
    print_r($numbers);

    // Ánh xạ arr, độ rộng giống, giá trị khác
    $squared_numbers = array_map(function($each_number){
        return $each_number * $each_number;
    }, $numbers);
    print_r($squared_numbers);

    //c2:
    // $squared_numbers = array_map(fn($each_number) =>
    //     $each_number * $each_number
    // , $numbers);
    // print_r($squared_numbers);

    // filter arr
    $filtered_numbers = array_filter(
        $numbers, fn($each_number) => $each_number % 2 == 0);
    print_r($filtered_numbers);
    

?>