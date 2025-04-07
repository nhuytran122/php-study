<?php 
    session_start();
    if(isset($_SESSION['email'])){
        echo "Welcome to Dashboard Page";
        echo "<br>Email: " . $_SESSION['email'];
        echo "<a href='/PHP-Basic/10_logout.php'> Logout </a>";
    }
    else{
        echo "Welcome guest to dashboard";
        echo "<a href='/PHP-Basic/10_session.php'> Back to login </a>";
    }
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1>This is dashboard</h1>
</body>

</html>