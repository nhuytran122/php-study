<?php 
    // print_r($_SERVER);
    // print_r($_POST);

    // http://localhost:3000/PHP-Basic/08_superglobal.php?name=NhuY&Age=22
    // if(isset($_GET['name'])){
    //     echo $_GET['name'];
    // }

    // $email = htmlspecialchars($_POST['email'] ?? "");
    $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $password = htmlspecialchars($_POST['password'] ?? "");
    echo $email;
    echo $password;
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="
        <?php
            echo htmlspecialchars($_SERVER['PHP_SELF']);?>
    ">
        <h3>Login your account</h3>
        <div>
            <label for="email">Your email: </label>
            <input type="text" name="email" id="">
        </div>
        <div>
            <label for="password">Your password: </label>
            <input type="password" name="password" id="">
        </div>
        <input type="submit" value="Submit" name="submit">
    </form>
</body>

</html>