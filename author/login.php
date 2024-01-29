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
            plusCoinFirstTime($user['id'], 'first_login');
            die(header("location:/"));
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Đăng Nhập Tài Khoản Thành Viên- {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>