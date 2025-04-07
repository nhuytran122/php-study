<?php
    require_once('../config/database.php');
    require_once('../config/config.php');
    require_once('../src/auth/jwt.php');
    require_once('../src/auth/login.php');
    require_once '../src/auth/verify.php'; 

    $user = getUserFromToken();
    if ($user !== false) {
        header('Location: ./index.php');
    }

    // use Google\Client;
    $credentialsPath = '../config/credentials.json';

    if (!file_exists($credentialsPath)) {
        die('File credentials.json không tồn tại tại: ' . $credentialsPath);
    }
    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath); 
    $client->setRedirectUri(URL_GG_CALLBACK);
    $client->addScope('email');
    $client->addScope('profile');
    $authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <form action="" method="POST">
        <div class="mb-3">
            <input type="email" class="form-control <?php echo $error_email ? 'is-invalid' : ''; ?>" name="email"
                placeholder="Enter your email ?" value="<?php echo htmlspecialchars($email); ?>">
            <p class="text-danger">
                <?php echo $error_email; ?>
            </p>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control <?php echo $error_password ? 'is-invalid' : ''; ?>"
                name="password" placeholder="Enter your password" value="<?php echo htmlspecialchars($password); ?>">
            <p class="text-danger">
                <?php echo $error_password; ?>
            </p>
        </div>
        <div class="mb-3">
            <?php
            if ($failed_login) {
                echo '<p class="text-danger">Invalid email or password. Please try again.</p>';
            }
            ?>
            <input type="submit" class="btn btn-primary" name="login" value="login">
        </div>
    </form>
    <a href="<?php echo htmlspecialchars($authUrl); ?>">Login with Google</a>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
</script>

</html>