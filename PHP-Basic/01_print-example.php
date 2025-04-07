<?php
    echo "Hello world";
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>
        <?php
            // Có thể concat 
            echo "pi = ", 3.14, ', x = ', 3;
            
            print "Hello world";

            print_r(['Nhu Y', 'Minh', 'Khanh', 'Hoang']);

            // Hiển thị cả dữ liệu lẫn kiểu dữ liệu
            var_dump(false);

            var_export("Hello");
        ?>
    </p>

    <h1>
        <?= 'This is me'; ?>
    </h1>
</body>

</html>