<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_POST) die(HTMLMethodNot(503));
if (!$_POST['MovieID']) die(HTMLMethodNot(503));
if (!$_POST['EpisodeID']) die(HTMLMethodNot(503));
HeaderApplication();

$MovieID = sql_escape($_POST['MovieID']);
$EpisodeID = sql_escape($_POST['EpisodeID']);
if (get_total("movie", "WHERE id = '$MovieID'") < 1) die(JsonMessage(401, "Phim này Không Tồn Tại Trên Hệ Thông"));
if (get_total("episode", "WHERE id = '$EpisodeID'") < 1) die(JsonMessage(401, "Tập này Không Tồn Tại Trên Hệ Thông"));
$Ep = GetDataArr("episode", " id = '$EpisodeID'");
$Movie = GetDataArr("movie", " id = '$MovieID'");
if (URL . "/watch/{$Movie['slug']}-episode-id-$EpisodeID.html" != $referer)  die(JsonMessage(401, "Bạn Đang Truy Cập Trái Phép Website Của Chúng Tôi"));
$cache_key = $Movie['slug'] . "_$EpisodeID";
if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
$PlayerData = array();
$PlayerData['code'] = 200;
$PlayerData['info'] = [
    "Movie_Title" => $Movie['name'],
    "Movie_Vote" => "{$Movie['vote_point']}/{$Movie['vote_all']}",
    "Movie_Year" => $Movie['year'],
];
foreach (json_decode($Ep['server'], true) as $key => $value) {
    if ($value['server_link']) {
        $PlayerData["src_" . ServerName($value['server_name'])] = Khoangtrang(urldecode($value['server_link']));
    }
}
$InstanceCache->set($cache_key, json_encode($PlayerData), $cf['time_cache'] * 3600);
die(json_encode($PlayerData));
