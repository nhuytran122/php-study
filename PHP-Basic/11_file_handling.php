<?php 
    $file_path = "./11_fruits.txt";
    if(file_exists($file_path)){
        // echo readfile($file_path); // + dung lượng file
        
        $file_handle = fopen($file_path, 'r');
        $file_content = fread($file_handle, filesize(($file_path)));

        
        echo $file_content;
    }
    else{
        // K tồn tại -> tạo file mới
        $file_handle = fopen($file_path, 'w'); //open for write
        // PHP.EOL: xuống dòng
        $file_content = 'banana' .PHP_EOL. 'mango' .PHP_EOL. 'grape';
        fwrite($file_handle, $file_content);
    }
    fclose($file_handle);
?>