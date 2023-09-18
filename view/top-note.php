<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<div class="ah-frame-bg"><?= un_htmlchars($cf['top_note']) ?></div>
<?php if (get_total('user', "WHERE level >= '{$cf['level_notice']}'")) { ?>
    <div class="ah-frame-bg">
        <div class="bg-red padding-5-10 border-default border-radius-5" style="float: left;padding: 0px 5px;font-size: 15px;">Xin Chúc Mừng</div>
        <div class="flex">
            <marquee <?php if (is_mobile()) { ?>scrolldelay="165" <?php } ?>  behavior="scroll"> 
                <?php
                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "user WHERE level >= '{$cf['level_notice']}' ORDER BY RAND() LIMIT {$cf['top_chucmung']}");
                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <span class="fw-700" style="padding: 0px 10px;color:<?= LevelColor($row['level']) ?>;"><?= LevelIcon($row['level'], 15, 15) ?> <?= $row['nickname'] ?> Đã Thăng Cấp Lên Level <?= number_format($row['level']) ?></span>
                <?php } ?>
            </marquee>
        </div>
    </div>
<?php } ?>
<div id="top-banner-pc">
    <zone id="kyl30cr3"></zone>
</div>
<div id="top-banner-mb">
    <zone id="kyl3axj2"></zone>
</div>