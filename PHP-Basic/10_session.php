<?php 
    session_start();
    if(isset($_POST['submit'])){
        $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
        $password = htmlspecialchars($_POST['password'] ?? "");
        if($email == 'nhuytran@gmail.com' && $password == '123'){
            $_SESSION['email'] = $email;
            header('Location: 10_dashboard.php');
        }
        else{
            echo "Incorrect email/password";
        }
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Login your account</h1>
    <form method="POST" action="
        <?php
            echo htmlspecialchars($_SERVER['PHP_SELF']);?>
    ">
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