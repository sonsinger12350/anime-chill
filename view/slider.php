<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
if ($cf['slider'] == 'true') {
?>

        <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
            <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                Phim Đề Cử
            </div>
        </div>
        <div class="owl-carousel owl-theme">
            <?php
            $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND de_cu = 'true' ORDER BY timestap DESC");
            while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                if ($row['loai_phim'] == 'Phim Lẻ') {
                    $statut = "{$row['movie_duration']} Phút";
                } else {
                    $statut = "$NumEpisode/{$row['ep_num']}";
                }
            ?>
                <div>
                    <a href="<?= URL ?>/info/<?= $row['slug'] ?>.html">
                        <div><img src="<?= $row['image'] ?>" alt="Phim <?= $row['name'] ?>" /></div>
                        <div class="name"><?= $row['name'] ?></div>
                        <div class="episode_latest">
                            <?= $statut ?> </div>
                    </a>
                    <?= ShowFollow($row['id']) ?>
                </div>
            <?php } ?>

    </div>
<?php } ?>