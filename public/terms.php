<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "{$cf['title']} - Trang Điều Khoản Và Dịch Vụ";
    $description =  "Trang Điều Khoản Và Dịch Vụ - {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div class="margin-10-0 bg-brown flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    <h3 class="section-title"><span>Điều Khoản Và Dịch Vụ</span></h3>
                </div>
            </div>
            <div class="ah-frame-bg" style="padding: 15px 15px;">
                <?= un_htmlchars($cf['terms']) ?>
            </div>
        </div>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>