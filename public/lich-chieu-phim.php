<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
$NumPage = GetParam('p') ? GetParam('p') : 1;
$days = GetParam('day') ? GetParam('day') : 2;
if ($days == 8) {
    $NameDay = "Chủ Nhật";
} else $NameDay = "Thứ $days";
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Lịch Chiếu Phim Anmime - Hoạt Hình Trung Quốc";
    $description =  "Xem Lịch Chiếu Phim Anmime - Hoạt Hình Trung Quốc Hàng Tuần";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <div id="filter-page">
<div class="ah-frame-bg">
<center><p style="background-color: #404040; font-family: Comfortaa, sans-serif; font-weight: 900; margin: 0px;"></p><p style="background-color: #404040; margin: 0px;"><span style="background-color: transparent; text-align: left;"><span style="color: white; font-family: Comfortaa; font-size: medium;"><b style="color: #ff00fe; font-size: 14px;">• </b><b>Lưu Ý: Lịch chiếu phim bên dưới chỉ mang tính chất tương đối, phim có chiếu trên web hay không phụ thuộc vào nhóm dịch, có thể chỉ sau vài giờ hoặc vài ngày thậm chí vài năm nếu phim đó không ai dịch, mong các bạn không phàn nàn và thắc mắc.!</b></span></span></p><p style="background-color: #404040; margin: 0px;"><span style="background-color: transparent; text-align: left;"><span style="color: white; font-family: Comfortaa; font-size: medium;"><b></b></span></span></p></center></div>
            <div class="ah-frame-bg">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 2 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 3 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 4 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 5 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 6 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Thứ <?= $days = 7 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
    </div>
    
<!-- --------------------------------------------------------- -->
    
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        
        <div class="ah_content">
            <div class="ah-frame-bg">
            <div id="filter-page">
                <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <span>Lịch Chiếu Chủ Nhật <?= $days=8 ?> <!-- Trang <?= $NumPage ?> --></span>
                    </div>
                </div>
                <div class="movies-list">
                    <?php
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                    <div class="episode-latest"> <span><?= $statut ?></span></div>
                                    <div>
                                        <img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" />
                                    </div>
                                    <div class="score">
                                        <span style="display: flex;">
                                            <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                            <?= Voteting($row['vote_point'], $row['vote_all']) ?>
                                        </span>
                                    </div>
                                    <div class="name-movie">
                                        <?= $row['name'] ?>
                                    </div>
                                </a>
                            </div>
                    <?php }
                    } ?>
                </div>
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/lich-chieu.html?day=$days&p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
            <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
        </div>
    </div>
</body>

</html>