<?php
    require_once '../src/auth/verify.php'; 
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>

<body>
    <h1>Welcome
        <b>
            <?php 
                $user = getUserFromToken();
                if ($user === false) {
                    echo 'Guest';
                } else {
                    echo $user['username']; 
                }
            ?>
            <?php 
        if ($user !== false) {
            echo '<a href="../src/auth/logout.php" class="btn btn-danger">Logout</a>';
        }
        ?>
        </b>
    </h1>
</body>

</html>