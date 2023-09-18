<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_author_cookie) die(header("location:/login"));
if (!$_SESSION['viewer']) {
    $mysql->update("config", "view = view + 1", "id = 1");
    $_SESSION['viewer'] = "True";
}
if (!$value[2]) die(header("location: /thong-bao"));
$Notice_ID = sql_escape($value[2]);
if (get_total("notice", "WHERE id = '$Notice_ID'") < 1) die(header("location: /thong-bao"));
$notice = GetDataArr("notice", "id = '$Notice_ID'");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
        
            <div id="message-page">
                <div class="ah-frame-bg">
                    <div class="title border-style-1 color-red-2 fw-500 fs-21">
                        Tin nhắn từ hệ thống
                    </div>
                    <div class="content border-style-1"><?= $notice['content'] ?></div>
                    <div class="time fs-12 flex flex-hozi-center">
                        <span class="material-icons-round margin-0-5">
                            schedule
                        </span><?= RemainTime($notice['timestap']) ?>
                    </div>
                </div>
            </div>

        </div>


        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>