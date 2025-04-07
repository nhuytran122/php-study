<?php
require_once('../config/database.php');
require_once('../src/auth/jwt.php');

$user_name = $password = '';
$error_email = $error_password = '';
$failed_login = false;

if (isset($_POST['login'])) {
    if (empty($_POST['email'])) {
        $error_email = 'Email is required';
    } else {
        $user_name = htmlspecialchars($_POST['email']);
    }

    if (empty($_POST['password'])) {
        $error_password = 'Password is required';
    } else {
        $password = htmlspecialchars($_POST['password']);
    }

    if (empty($error_email) && empty($error_password)) {
        $sql = "SELECT * FROM users WHERE email = :email";
        if ($connection != null) {
            try {
                /** @var PDO|null $connection */
                $statement = $connection->prepare($sql);
                $statement->execute(['email' => $user_name]);

                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    createJWT($user['id'], $user['full_name'], 'USER');
                    header('location:index.php');
                    exit(); 
                } else {
                    $failed_login = true;
                }
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            echo "No database connection.";
        }
    }
}
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
                placeholder="Enter your email ?" value="<?php echo htmlspecialchars($user_name); ?>">
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
</script>

</html>