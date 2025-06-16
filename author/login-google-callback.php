<?php
    if (isset($_GET['code'])) {
        $client = new Google_Client();
        $client->setClientId(GOOGLE_CLIENT_ID);
        $client->setClientSecret(GOOGLE_CLIENT_SECRET);
        $client->setRedirectUri(GOOGLE_REDIRECT_URI);
        $client->addScope("email");
        $client->addScope("profile");

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);
    
        $oauth2 = new Google_Service_Oauth2($client);
        $userInfo = $oauth2->userinfo->get();
        $email = $userInfo->email;
        $AccessToken = RenderAccessToken();
        
        
        if (get_total("user", "WHERE email = '".$userInfo['email']."'") <= 0) {
            $nickname = $userInfo->name;
            $avatar = $userInfo->picture;
            $password = md5(123456);
            
            $mysql->insert('user', "email,password,avatar,nickname,_accesstoken,ipadress,time", "'$email','$password','$avatar','$nickname','$AccessToken','" . IP . "','" . DATEFULL . "'");
            $User_Arr = GetDataArr("user", "email = '$email'");
            addCoin($User_Arr['id'], 'register');
        }

        $mysql->update("user", "_accesstoken = '$AccessToken', online = 1", "email = '$email'");
        setcookie('author', $AccessToken, time() + (86400 * 30), '/', URL_None_HTTP(), false);
        setcookie('_accesstoken', $AccessToken, time() + (86400 * 30), '/', URL_None_HTTP(), false);
    
        die(header("location:/"));
    }