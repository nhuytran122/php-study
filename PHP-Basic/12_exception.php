<?php 
    function divide($a, $b){
        if(!$b){
            throw new Exception("Cannot divide by 0");
        }
        return $a / $b;
    }

    // echo divide(5, 0);
    try{
        echo divide(10, 2);
        echo divide(10, 0);
        echo "no errors";
    }
    catch (Exception $e){
        echo "Caught exeption " .$e -> getMessage() . "\n";
    }
    finally{
        echo "Finally come here...";
    }
    echo "Program runs here...";
?>