<?php
    require_once '../../vendor/autoload.php';
    require_once '../../config/database.php';
    require_once './jwt.php';
    require_once '../../config/config.php';

    use Google\Client;
    use Google\Service\Oauth2;

    $credentialsPath = '../../config/credentials.json';

    if (!file_exists($credentialsPath)) {
        die('File credentials.json không tồn tại tại: ' . $credentialsPath);
    }

    $client = new Google_Client();
    $client->setAuthConfig($credentialsPath); 
    $client->setRedirectUri(URL_GG_CALLBACK);
    $client->addScope('email');
    $client->addScope('profile');

    if(isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']); 
        $client->setAccessToken($token);
        
        $oauth2Service = new Oauth2($client);
        $userInfo = $oauth2Service->userinfo->get(); 
        
        $email = $userInfo->getEmail();
        $fullName = $userInfo->givenName . ' ' . $userInfo->familyName;

        $sql = "SELECT * FROM users WHERE email = :email";
        if ($connection != null) {
            try {
                /** @var PDO|null $connection */
                $statement = $connection->prepare($sql);
                $statement->execute(['email' => $email]);

                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if (!$user){
                    $sql_insert = "INSERT INTO users(email, full_name) VALUES (:email, :full_name)";
                    $stm = $connection->prepare($sql_insert);
                    $stm->execute(['email' => $email, 'full_name' => $fullName]);
                    $userId = $connection->lastInsertId();
                    $role = 'USER';
                }   
                else{
                    $userId = $user['id'];
                    $fullName = $user['full_name'];
                    $role = $user['role'];
                }
                createJWT($userId, $fullName, $role);
                header('Location: ../../view/index.php');
                exit();
            } catch (PDOException $e) {
                echo "Database error: " . $e->getMessage();
            }
        } else {
            echo "No database connection.";
        }
    }
    else{
        header('Location: ../../view/login.php');
        exit();
    }
?>