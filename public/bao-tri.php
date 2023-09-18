<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if ($cf['baotri'] == 'false' && !$_SESSION['admin']) die(header("location: /"));
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Bảo Trì Nâng Cấp</title>
    <link rel="canonical" href="<?= URL ?>" />
    <link rel="icon" href="<?= $cf['favico'] ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?= URL ?>/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
    <link rel="stylesheet" href="/games/index.css">
    <script src="/games/index.js"></script>


</head>

<body class="scroll-bar">

    <div id="ah_wrapper">
        <div class="ah_content">
            <div class="margin-10-0 align-center">
                <img src="/themes/img/Xl3c.gif" style="width: 100px;height: 100px">
            </div>
            <div class="margin-10-0 flex flex-ver-center">
                <h3 class="section-title" style="text-align: center;">
                    <span>Website Hiện Đang Trong Quá Trình Bảo Trì Để Nhằm Nâng Cấp Dịch Vụ Vui Lòng Quay Lại Sau ít Phút , Xin Cám Ơn Bạn Đã Ủng Hộ Website Chúng Tôi
                </h3>
            </div>

            <iframe style="border-radius: 25px;box-shadow: 0 0 20px #eee;" type="text/html" width="100%" height="450" src="https://www.youtube.com/embed/9quTDU0MiM4?controls=0&autoplay=1&origin=<?= URL ?>&fs=0&showinfo=0&loop=1&rel=0" frameborder="0" allow="autoplay" allowfullscreen></iframe>
            <div class="margin-10-0 bg-brown flex flex-space-auto" style="border-radius: 5px;">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex flex-hozi-center">
                    <h3 class="section-title"><span>Nếu Có Thắc Mắc Hãy Liên Hệ Với Chúng Tôi?</span></h3>
                </div>
            </div>
            <div class="ah-frame-bg">
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
    </div>
</body>

</html>