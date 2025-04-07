<?php
    require_once '../../vendor/autoload.php';
    require_once '../../config/database.php';
    require_once './jwt.php';
    require_once(__DIR__ . '/../repository/UserRepository.php');
    require_once __DIR__ . '/../helper/GoogleClientHelper.php';

    use Google\Client;
    use Google\Service\Oauth2;

    $credentialsPath = '../../config/credentials.json';

    if (!file_exists($credentialsPath)) {
        die('File credentials.json không tồn tại tại: ' . $credentialsPath);
    }

    if(isset($_GET['code'])) {
        $client = GoogleClientHelper::createClient();
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']); 
        $client->setAccessToken($token);
        
        $oauth2Service = new Oauth2($client);
        $userInfo = $oauth2Service->userinfo->get(); 
        
        $email = $userInfo->getEmail();
        $fullName = $userInfo->givenName . ' ' . $userInfo->familyName;

        $userRepository = new UserRepository($connection);
        $user = $userRepository->findByEmail($email);
        if (!$user){
            $userId = $userRepository->create($email, $fullName);
        }   
        else{
            $userId = $user['id'];
            $fullName = $user['full_name'];
            $role = $user['role'];
        }
        createJWT($userId, $fullName, $role);
        header('Location: ../../view/index.php');
        exit();
    }
    else{
        header('Location: ../../view/login.php');
        exit();
    }
?>