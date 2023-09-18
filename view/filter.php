<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<div id="filter-movie">
    <div class="trigger-buttons flex">
        <div>Thể loại</div>
        <div>Năm</div>
        <div>Loại Phim</div>
        <div>Trạng thái</div>
    </div>
    <div class="condition-filter">
        <div>
            <div class=" fw-500 margin-5-0">Thể loại</div>
            <div class="flex flex-wrap">
                <?php
                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "category ORDER BY id DESC");
                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div filter-value="<?= $row['id'] ?>" title="Thể loại <?= $row['name'] ?>"><?= $row['name'] ?></div>
                <?php } ?>
            </div>
        </div>
        <div>
            <div class="fw-500 margin-5-0">Năm phát hành</div>
            <div class="flex flex-wrap">
                <?php
                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "year ORDER BY id DESC");
                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <div filter-value="<?= $row['year'] ?>"><?= $row['year'] ?></div>
                <?php } ?>
            </div>
        </div>
        <div>
            <div class="fw-500 margin-5-0">Loại Phim</div>
            <div class="flex flex-wrap">
                <div filter-value="1">Phim Lẻ</div>
                <div filter-value="2">Phim Bộ</div>
            </div>
        </div>
        <div>
            <div class="fw-500 margin-5-0">Trạng thái</div>
            <div class="flex flex-wrap">
                <div filter-value="1">Đang Cập Nhật</div>
                <div filter-value="2">Hoàn Thành</div>
            </div>
        </div>
    </div>
    <div id="filter-submit" class="display-none flex-ver-center">
        <div class="button-default padding-10-20 bg-red margin-10-0 flex fw-500 flex-hozi-center">
            <span class="material-icons-round margin-r-5">filter_alt</span>
            <span>Lọc</span>
        </div>
    </div>
</div>
<div id="filtering" class="flex"></div>