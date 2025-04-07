<?php
$age = 30;
    if($age >= 18){
        echo " >= 18";
    }
    else{
        echo " <18";
    }

    $date_time = date("F");
    // echo $date_time;

    $hours = date("H");
    // echo $hours;
    // if($hours < 12){
    //     echo "Good morning";
    // }
    // else if($hours >= 12 && $hours <= 17){
    //     echo "Good afternoon";
    // }
    // else{
    //     echo "Good evening";
    // }

    $comments = ['ABC', 'DEF', 'GHI'];
    // if(empty($comments)){
    //     echo "There are no comments";
    // }

    // if(!empty($comments)){
    //     echo "There are some comments";
    // }

    echo !empty($comments) ? "Some comments" : "No comments";

    // $first_comment = !empty($comments) ? $comments[0] : 'No comments';
    
    // $first_comment = $comments[0] ?? 'No comments';
    // echo $first_comment;

    $favorite_color = 'aqua';
    switch($favorite_color){
        case 'red':
            echo 'You choose RED';
            break;
        case 'blue':
            echo 'You choose BLUE';
            break;
        default:
            echo 'Not RED, BLUE';
    }
?>