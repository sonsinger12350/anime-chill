<?php
    if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
    if (isset($_author_cookie)) die(header("location:/"));
    if (isset($_POST['action_login'])) {
        $email = sql_escape($_POST['email']);
        $password = md5(sql_escape($_POST['password']));
        $Success = false;
        if (!$email || !$password) {
            $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Bạn Không Được Để Trống Email Hoặc Password</div>';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span> Địa Chỉ Email Không Hợp Lệ</div>';
        }
        if (get_total("user", "WHERE email = '$email' AND password = '$password'") >= 1) {
            $Success = true;
        } else {
            $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Địa Chỉ Email Hoặc Mật Khẩu Không Đúng</div>';
        }
        switch ($Success) {
            case true:
                $AccessToken = RenderAccessToken();
                setcookie('author', $AccessToken, time() + (86400 * 30), '/', URL_None_HTTP(), false);
                setcookie('_accesstoken', $AccessToken, time() + (86400 * 30), '/', URL_None_HTTP(), false);
                $mysql->update("user", "_accesstoken = '$AccessToken', online = 1", "email = '$email'");
                $user = GetDataArr('user', "_accesstoken = '$AccessToken'");
                // Đồng bộ lịch sử xem phim khi đăng nhập
                syncHistoryOnLogin($user['id']);
                die(header("location:/"));
                break;
        }
    }

    // $client = new Google_Client();
    // $client->setClientId(GOOGLE_CLIENT_ID);
    // $client->setClientSecret(GOOGLE_CLIENT_SECRET);
    // $client->setRedirectUri(GOOGLE_REDIRECT_URI);
    // $client->addScope("email");
    // $client->addScope("profile");
    // $authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Đăng Nhập Tài Khoản Thành Viên- {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
    <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <style>
        .login-google {
            display: flex;
            align-items: center;
            background-color: #4285f4;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
        }

        .login-google p {
            margin: 1px;
            padding: 7px;
            border-radius: 3px;
            background: #fff;
        }

        .login-google span {
            margin: 0 24px 0 12px;
            padding: 9px 0;
            font-size: 16px;
            margin-left: 30px;
        }
    </style>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div class="login-page">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Đăng Nhập Thành Viên</span></h3>
                    </div>
                </div>
                <div class="ah-form flex flex-column flex-hozi-center ah-frame-bg">
                    <div id="message-line"> <?= $Notice ?></div>
                    <p>Mật khẩu mặc định khi lần đầu đăng nhập bằng google là: <span style="color: #ffa400">123456</span></p>
                    <form action="/login" method="POST">
                        <div>
                            <label>Email</label>
                            <input type="email" placeholder="Nhập email của bạn" value="" name="email">
                        </div>
                        <div>
                            <label>Mật khẩu</label>
                            <input type="password" placeholder="Nhập mật khẩu của bạn" name="password">
                        </div>
                        <div class="flex flex-hozi-center flex-column">
                            <div class="flex flex-hozi-center">
                                <button type="submit" class="button-default color-white bg-red" name="action_login" value="submit">Đăng nhập</button>
                                <?php if ($cf['sign_up'] >= 1) { ?>
                                    <b style="padding: 10px;">Hoặc</b>
                                    <a href="/dang-ky" class="button-default bg-green margin-5-0 padding-10-20">Đăng ký</a>
                                <?php } ?>
                            </div>
                        </div>
                        <center>
                            <a href="<?= $authUrl ?>" class="login-google">
                                <p class="mb-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#4285F4" d="M20.64 12.2045c0-.6381-.0573-1.2518-.1636-1.8409H12v3.4814h4.8436c-.2086 1.125-.8427 2.0782-1.7959 2.7164v2.2581h2.9087c1.7018-1.5668 2.6836-3.874 2.6836-6.615z"></path><path fill="#34A853" d="M12 21c2.43 0 4.4673-.806 5.9564-2.1805l-2.9087-2.2581c-.8059.54-1.8368.859-3.0477.859-2.344 0-4.3282-1.5831-5.036-3.7104H3.9574v2.3318C5.4382 18.9832 8.4818 21 12 21z"></path><path fill="#FBBC05" d="M6.964 13.71c-.18-.54-.2822-1.1168-.2822-1.71s.1023-1.17.2823-1.71V7.9582H3.9573A8.9965 8.9965 0 0 0 3 12c0 1.4523.3477 2.8268.9573 4.0418L6.964 13.71z"></path><path fill="#EA4335" d="M12 6.5795c1.3214 0 2.5077.4541 3.4405 1.346l2.5813-2.5814C16.4632 3.8918 14.426 3 12 3 8.4818 3 5.4382 5.0168 3.9573 7.9582L6.964 10.29C7.6718 8.1627 9.6559 6.5795 12 6.5795z"></path></svg>		
                                </p>
                                <span>Đăng nhập bằng <b>Google</b></span>
                            </a>
                        </center>
                        <div class="alert-deposit mb-3">
									<i class="fa-solid fa-circle-info"></i> Nếu bạn quên mật khẩu và muốn lấy lại, vui lòng liên hệ với admin qua Fanpage!
								</div>
                        <div class="flex flex-wrap flex-1">
                                <a href="https://www.messenger.com/t/hhchina/" class="padding-1-1 fs-1 button-default fw-1 fs-1 flex flex-hozi-center bg-lochinvar" style="background: #337ab7;" title="quên mật khẩu"><span style="font-size: 14px;">Quên mật khẩu!</span></a>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>