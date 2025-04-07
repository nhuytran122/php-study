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
                    if (checkPermission('ADMIN')) {
                        echo '<p>You are an ADMIN. You can manage the system.</p>';
                        echo '<a href="#">Manage Users</a><br>';
                    } else {
                        echo '<p>You are a USER. You can view content.</p>';
                        echo '<a href="#">View Content</a><br>';
                    }
                    echo '<a href="../src/auth/logout.php">Logout</a>';
                } else {
                    echo '<a href="../view/login.php">Login</a>';
                }
            ?>
        </b>
    </h1>
</body>

</html>