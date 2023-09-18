<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
HeaderApplication();
if (!$_POST) die(HTMLMethodNot(503));
$genre_id = (int)$_POST['genre_id'];
if (!$genre_id) die(HTMLMethodNot(503));
if (get_total('category', "WHERE id = '$genre_id'") < 1) die(json_encode(["result" => "Thể loại không tồn tại", "status" => "failed"]));
if (get_total('movie', "WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"$genre_id\"%'") < 1) die(json_encode(["result" => "Thể loại này chưa có phim nào được đề cử", "status" => "failed"]));
$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"$genre_id\"%' ORDER BY timestap DESC LIMIT 10");
while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $episode_number = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
    $statut = ($row['loai_phim'] == 'Phim Lẻ' ? "{$row['movie_duration']} Phút" : "$episode_number/{$row['ep_num']}");
    $html .= '<div class="movie-item" id="movie-id-' . $row['id'] . '">
                <a href="' . URL . '/thong-tin-phim/' . $row['slug'] . '.html" title="' . $row['name'] . '">
                    <div class="episode-latest" style="background-color: rgba(183,28,28,.9);
                    color: #fff;
                    text-shadow: 0 0 2px rgb(0 0 0 / 30%);
                    font-weight: 900;
                    border-radius: 16px;"> <span>' . $statut . '</span></div>
                    <div>
                        <img src="' . $row['image'] . '" alt="Phim ' . $row['name'] . '" />
                    </div>
                    <div class="score" style="background: rgba(0,0,0,.65);color: #f5ec42;border-radius: 15px;">
                    <span style="display: flex;">
                                        <i class="material-icons-round" style="padding: 0px 2px; font-size: 13px;">star</i>
                                        ' . Voteting($row['vote_point'], $row['vote_all']) . '
                                        </span>
                    </div>
                    <div class="name-movie" style="color:#fffdfd;">
                        ' . $row['name'] . '
                    </div>
                </a>
                ' . ShowFollow($row['id']) . '
            </div>';
}
die(json_encode(["result" => $html, "genre" => get_data_multi('slug', 'category', "id = '$genre_id'"), "status" => "success"]));
