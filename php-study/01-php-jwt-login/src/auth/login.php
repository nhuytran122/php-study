<?php
    require_once(__DIR__ . '/../../config/database.php');
    require_once(__DIR__ . '/jwt.php');
    require_once(__DIR__ . '../../repository/UserRepository.php');

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
            $userRepository = new UserRepository($connection);
            $user = $userRepository->findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $token = createJWT($user['id'], $user['full_name'], $user['role']);
                echo json_encode(['token' => $token]);
                // header('location:./index.php');
                exit(); 
            } else {
                $failed_login = true;
            }
        }
    } 
    
?>