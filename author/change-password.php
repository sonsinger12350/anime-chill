<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_author_cookie) die(header("location:/login"));
if (isset($_POST['action_send'])) {
    $new_password = md5(sql_escape($_POST['new_password']));
    $re_new_password = md5(sql_escape($_POST['re_new_password']));
    $Success = 0;
    if ($new_password != $re_new_password) {
        $Success++;
        $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Hai Mật Khẩu Không Khớp Nhau</div>';
    }
    if (strlen($_POST['new_password']) < 6) {
        $Success++;
        $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Mật khẩu đặt phải nhiều hơn 6 kí tự</div>';
    }
    switch ($Success) {
        case 0:
            $mysql->update("user", "password = '$new_password'", "email = '$useremail'");
            $Notice .= '<div class="noti-success flex flex-hozi-center"><span class="material-icons-round margin-0-5">success</span>Thay Đổi Mật Khẩu Thành Công</div>';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Thay Đổi Mật Khẩu Tài Khoản - {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div class="ah_follows">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Đổi Mật Khẩu Tài Khoản</span></h3>
                    </div>
                </div>
                <div class="ah-form flex flex-column flex-hozi-center ah-frame-bg">
                    <form action="" method="POST">
                        <div>
                            <label>Mật khẩu mới</label>
                            <input type="password" placeholder="Nhập mật khẩu mới" name="new_password">
                        </div>
                        <div>
                            <label>Nhập lại mật khẩu mới</label>
                            <input type="password" placeholder="Nhập lại mật khẩu mới" name="re_new_password">
                        </div>
                        <div id="message-line"> <?= $Notice ?></div>
                        <div>
                            <button type="submit" name="action_send" class="button-default color-white bg-red" value="submit">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>