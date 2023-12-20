<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Trang Liên Hệ - {$cf['title']}";
    $description = "Trang Liên Hệ - {$cf['title']}";
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
                    <h3 class="section-title"><span>Thông Tin Liên Hệ</span></h3>
                </div>
            </div>
            <div class="ah-frame-bg">
                <a class="color-white-2 margin-r-5 fs-15" style="display: block;"><span>Gmail: hhchina.tv@gmail.com</span></a><br>
                <?php
                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "lien_he ORDER BY id DESC");
                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {

                ?>
                    <div class="fs-15 flex" style="margin-bottom: 8px;">
                        <div class="color-red-2 margin-r-5" style="display: block;"><?= $row['name'] ?></div>
                        <a style="padding: 0px 5px;word-break: break-all;" href="<?= $row['url'] ?>" class="bg-blue border-default border-radius-5" target="_blank"><?= $row['url'] ?></a>
                    
                    </div>
                <?php } ?>
            </div>
        </div>
        <?= PopUnder('pop_under_home') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>