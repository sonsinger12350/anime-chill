<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
FireWall();
$Slug_Cate = sql_escape($value[2]);
if (get_total("category", "WHERE slug = '$Slug_Cate'") < 1) die(header('location:' . URL));
$cate = GetDataArr("category", "slug = '$Slug_Cate'");
$SeoTitle = ($cate['title'] ? $cate['title'] : "Thể Loại {$cate['title']} - {$cf['title']}");
$SeoDescription = ($cate['description'] ? $cate['description'] : "Thể Loại {$cf['title']} - {$cf['description']}");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = $SeoTitle;
    $description = $SeoDescription;
    require_once(ROOT_DIR . '/view/head.php');
    ?>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div id="filter-page">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Thể Loại : <?= $cate['name'] ?></span></h3>
                    </div>
                </div>
                <?php require_once(ROOT_DIR . '/view/filter.php'); ?>
                <div class="movies-list">
                    <?php
                    $NumPage = GetParam('p') ? GetParam('p') : 1;
                    $PAGE = CheckPages('movie', "WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"{$cate['id']}\"%'", 30, $NumPage);
                    if ($PAGE['total'] >= 1) {
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"{$cate['id']}\"%' ORDER BY id DESC LIMIT {$PAGE['start']},30");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                            if ($row['loai_phim'] == 'Phim Lẻ') {
                                $statut = "{$row['movie_duration']} Phút";
                            } else {
                                $statut = "$NumEpisode/{$row['ep_num']}";
                            }
                    ?>
                            <div class="movie-item" id="movie-id-<?= $row['id'] ?>">
                                <a href="<?= URL ?>/info/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
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
                <?= view_pages($PAGE['total'], 30, $NumPage, URL . "/the-loai/$Slug_Cate.html?p=") ?>
                <script>
                    const $data_filter_raw = JSON.parse("[[<?= $cate['id'] ?>],[],[],[]]");
                </script>
                <script type="text/javascript" src="<?= URL ?>/themes/js_ob/filter.js?v=1.7.4"></script>
            </div>
            <div id="ah_toast"></div>
        </div>
        <?= PopUnder('pop_under_home') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>