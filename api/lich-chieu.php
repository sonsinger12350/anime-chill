<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
HeaderApplication();
if (!$_POST) die(HTMLMethodNot(503));

if (!$_POST['days']) die(JsonMessage(401, "Error Post Paramter"));
$days = sql_escape($_POST['days']);
if ($days > 8) die(JsonMessage(502, "Không Hợp Lệ"));
if ($days < 8) {
    $NameLich = "Thứ $days";
} else $NameLich = "Chủ Nhật";
$CheckLich = get_total("movie", "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'");
if ($CheckLich < 1) die(JsonMessage(404, '<div class="flex flex-space-auto " style="position: relative;width: 100%;">
                                            <img src="/themes/img/tumblr_mgvrr0Zr7L1rjfb9zo1_500.gif" width="150" height="150">
                                            <h2 style="bottom: 1px;position:absolute;">Hiện <span style="color: red;">' . $NameLich . '</span> Không Có Phim Nào</h2>
                                        </div>'));
$P = CheckPages('movie', "WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%'", 15, 1);
if (is_mobile()) {
    $Limit = 16;
    $cache_key = "cache.Mobile_LichChieu_$days";
} else {
    $Limit = 15;
    $cache_key = "cache.PC_LichChieu_$days";
}

if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND lich_chieu LIKE '%\"days\":\"$days\"%' ORDER BY timestap DESC LIMIT {$P['start']},$Limit");
while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
    if ($row['loai_phim'] == 'Phim Lẻ') {
        $statut = "{$row['movie_duration']} Phút";
    } else $statut = "$NumEpisode/{$row['ep_num']}";

    $HTML_LichChieu .= '<div class="movie-item" id="movie-id-3300">
                            <a href="' . URL . '/thong-tin-phim/' . $row['slug'] . '.html" title="' . $row['name'] . '">
                                <div class="episode-latest"> <span>' . $statut . '</span></div>
                                <div>
                                    <img src="' . $row['image'] . '" alt="Phim ' . $row['name'] . '" />
                                </div>
                                <div class="score">
                                <span style="display: flex;">
                                        <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                    ' . Voteting($row['vote_point'], $row['vote_all']) . '
                                    </span>
                                </div>
                                <div class="name-movie">
                                    ' . $row['name'] . '
                                </div>
                            </a>
                            ' . ShowFollow($row['id']) . '
                        </div>';
}
$HTML_LichChieu .= "<div style=\"display:block;\">" . view_pages($P['total'], 15, 1, URL . "/lich-chieu.html?day=$days&p=") . "</div>";
$InstanceCache->set($cache_key, JsonMessage(200, $HTML_LichChieu), $cf['time_cache'] * 3600);
die(JsonMessage(200, $HTML_LichChieu));
