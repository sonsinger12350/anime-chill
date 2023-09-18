<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_author_cookie) die(header("location:/login"));
if (isset($_POST['change_profile'])) {
    $nickname = sql_escape($_POST['nickname']);
    $quote = sql_escape($_POST['quote']);
    $Success = 0;
    if (!$nickname) {
        $Success++;
        $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Vui Lòng Nhập Biệt Danh Của Bạn</div>';
    }
    if (strlen($nickname) < 6) {
        $Success++;
        $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Biệt Danh phải nhiều hơn 6 kí tự</div>';
    }
    if (strlen($quote) > 50) {
        $Success++;
        $Notice .= '<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Châm Ngôn Sống Không Được Quá 50 Ký Tự</div>';
    }
    if ($Success == 0) {
        $mysql->update("user", "nickname = '$nickname',quote = '$quote'", "email = '$useremail'");
        header("Refresh:0");
        $Notice .= '<div class="noti-success flex flex-hozi-center"><span class="material-icons-round margin-0-5">success</span>Cập Nhật Hồ Sơ Thành Công</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Trang Quản Lý Tài Khoản - {$cf['title']}";
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
                <div class="margin-10-0 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 inline-flex height-40 flex-hozi-center">
                        <h3 class="section-title"><span>Hello <?= $user['nickname'] ?> </span></h3>
                    </div>
                    <div>
                        <div class="flex flex-hozi-center flex-ver-right">
                            <span class="fs-19 margin-r-5 fw-500"><?= number_format($user['coins']) ?></span>
                            <img src="/themes/img/coins.png?v=1.1.8" class="w-20">
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <!-- <div class="list-menu-account flex-column bg-black" style="display: inline-block;">
                        <a href="/tai-khoan/ho-so" class="flex flex-hozi-center active"><span class="material-icons-round margin-0-5">
                                account_box
                            </span>
                            <div class='name-menu'>Hồ sơ</div>
                        </a>
                        <a href="/tai-khoan/nap-xu" class="flex flex-hozi-center "><span class="material-icons-round margin-0-5">
                                price_change
                            </span>
                            <div class='name-menu'>Nạp xu</div>
                        </a>
                        <a href="/tai-khoan/lich-su-giao-dich" class="flex flex-hozi-center "><span class="material-icons-round margin-0-5">
                                receipt_long
                            </span>
                            <div class='name-menu'>Lịch sử giao dịch</div>
                        </a>
                        <a href="/tai-khoan/cua-hang" class="flex flex-hozi-center "><span class="material-icons-round margin-0-5">
                                store
                            </span>
                            <div class='name-menu'>Cửa hàng</div>
                        </a>
                    </div> -->
                    <div class="flex-1">
                        <script type="text/javascript" src="/themes/js_ob/croppie.js?v=1.7.4"></script>
                        <link href="/themes/styles/croppie.css?v=1.4.0" rel="stylesheet" />
                        <div id="user-profile">
                            <div id="modal" class="modal">
                                <div>
                                    <div>Tải lên ảnh đại diện</div>
                                    <a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">
                                            close
                                        </span></a>
                                </div>
                                <div class="upload-area">
                                    <form action="/file-upload">
                                        <div class="fallback">
                                            <div id="show-image-upload">
                                            </div>
                                            <input name="file" type="file" id="upload-avatar" class="display-none" accept="image/*" />
                                            <div class="option-avatar">
                                            </div>
                                            <div class="button-default padding-10-20 bg-red color-white" id="select-avatar" onclick="showSelectAvatar()"><span class="material-icons-round margin-0-5">
                                                    cloud_upload
                                                </span> Tải ảnh lên</div>
                                            <div class="fw-500 margin-t-10">Upload ảnh 18+ sẽ bị khoá nick ngay lập tức</div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <form action="" method="post" id="form-user-profile" class="ah-frame-bg border-radius-0">
                                <div class="flex flex-column">
                                    <div class="left flex flex-ver-center">
                                        <div class="avatar flex flex-column flex-hozi-center">
                                            <img src="<?= $user['avatar'] ?>" />
                                            <div class="level-user margin-t-5">
                                                <span style="color:<?= LevelColor($user['level']) ?>">Lv.<?= $user['level'] ?> </span>
                                            </div>
                                            <div class="button-default margin-t-10" onclick="showModal()">
                                                Thay Avatar
                                            </div>
                                        </div>
                                    </div>

                                    <div class="right margin-l-5 flex-1">
                                        <div id="message-line"> <?= $Notice ?></div>
                                        <div class="input-zero">
                                            <div class="label">Biệt danh</div>
                                            <div><input name="nickname" value="<?= $user['nickname'] ?>" type="text" placeholder="Nhập biệt danh của bạn"></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Châm ngôn</div>
                                            <div><input name="quote" value="<?= $user['quote'] ?>" type="text"></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Icon</div>
                                            <div class="NewInput" style="padding-top: 5px;"><?= LevelIcon($user['level'], 18, 18) ?><?= UserIcon($user['id'], 18, 18) ?></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Cảnh Giới</div>
                                            <div class="NewInput" style="padding-top: 5px;"><b style="color:<?= LevelColor($user['level']) ?>"><?= Danh_Hieu($user['level']) ?></b></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Email</div>
                                            <div><input value="<?= $user['email'] ?>" type="email" placeholder="Nhập email của bạn" disabled></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Ngày tham gia</div>
                                            <div><input value="<?= $user['time'] ?>" type="text" placeholder="Ngày Tham Gia" disabled></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Kinh nghiệm</div>
                                            <div><input value="<?= $user['exp'] ?>/<?= ($user['level'] * 30) ?>" type="text" disabled></div>
                                        </div>
                                        <div class="input-zero">
                                            <div class="label">Tiền xu</div>
                                            <div><input name="coins" value="<?= number_format($user['coins']) ?>" type="text" disabled></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-ver-center">
                                    <button type="submit" name="change_profile" value="submit" class="button-default bg-red color-white"><span class="material-icons-round margin-0-5">
                                            save
                                        </span>Lưu</button>
                                </div>
                            </form>
                            <div id="message-line"></div>
                        </div>
                        <script type="text/javascript" src="/themes/js_ob/user.profile.js?v=1.7.4"></script>
                        <style>
                            .upload-area {
                                border: 2px dashed #fff;
                                height: 300px;
                                /* width: 400px; */
                                border-radius: 5px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                flex-direction: column;
                            }
                        </style>
                    </div>
                </div>
                <script type="text/javascript">
                    const $list_menu_account = document.getElementsByClassName("name-menu");
                    if (window.innerWidth < 350) {
                        [...$list_menu_account].forEach(item => {
                            item.style.display = "none";
                        })
                    }
                </script>
            </div>
        </div>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>