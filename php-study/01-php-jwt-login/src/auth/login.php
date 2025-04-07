<?php
    require_once(__DIR__ . '/../../config/database.php');
    require_once(__DIR__ . '/jwt.php');

    $email = $password = '';
    $error_email = $error_password = '';
    $failed_login = false;
    $token = '';

    if (isset($_POST['login'])) {
        if (empty($_POST['email'])) {
            $error_email = 'Email is required';
        } else {
            $email = htmlspecialchars($_POST['email']);
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
                    $statement->execute(['email' => $email]);

                    $user = $statement->fetch(PDO::FETCH_ASSOC);

                    if ($user && password_verify($password, $user['password'])) {
                        createJWT($user['id'], $user['full_name'], $user['role']);
                        header('location:./index.php');
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