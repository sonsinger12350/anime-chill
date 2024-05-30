<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
$MovieSlug = sql_escape($value[2]);
$EpisodeID = sql_escape($value[3]);
FireWall();
if (get_total("movie", "WHERE slug = '$MovieSlug'") < 1) die(header('location:' . URL));
if (get_total("episode", "WHERE id = '$EpisodeID'") < 1) die(header('location:' . URL . "/thong-tin-phim/$MovieSlug.html"));
$Movie = GetDataArr("movie", "slug = '$MovieSlug'");
$Ep = GetDataArr("episode", " id = '$EpisodeID'");
$mysql->update("movie", "view = view + 1, view_day = view_day + 1, view_week = view_week + 1, view_month = view_month + 1, view_year = view_year + 1", "id = '{$Movie['id']}'");
$statut = ($Movie['loai_phim'] == 'Phim Lẻ' ? "{$Movie['movie_duration']} Phút" : "$NumEpisode/{$Movie['ep_num']}");

$ep_num_plus = ($Ep['ep_num'] + 1);
$ep_num = ($Ep['ep_num'] - 1);
if (get_total('episode', "WHERE movie_id = '{$Movie['id']}' AND ep_num = '$ep_num_plus'") >= 1) {
    $EpNext = GetDataArr('episode', "movie_id = '{$Movie['id']}' AND ep_num = '$ep_num_plus'");
    $JsNextEpisode = 'window.location.href = "' . URL . '/xem-phim/' . $Movie['slug'] . '-episode-id-' . $EpNext['id'] . '.html";';
} else $JsNextEpisode = 'Toast({
    message: "Không có tập tiếp theo",
    type: "error"
});
final_ep = true;';

if (get_total('episode', "WHERE movie_id = '{$Movie['id']}' AND ep_num = '$ep_num'") >= 1) {
    $EpNext = GetDataArr('episode', "movie_id = '{$Movie['id']}' AND ep_num = '$ep_num'");
    $JsOldEpisode = 'window.location.href = "' . URL . '/xem-phim/' . $Movie['slug'] . '-episode-id-' . $EpNext['id'] . '.html";';
} else $JsOldEpisode = 'Toast({
    message: "Không có tập trước",
    type: "error"
});
final_ep = true;';

$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "episode WHERE movie_id = '{$Movie['id']}' ORDER BY id DESC");
while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $Active = ($row['id'] == $EpisodeID ? 'active' : '');
    // List Episode
    $ListEpisode .= ' <a href="' . URL . '/xem-phim/' . $Movie['slug'] . '-episode-id-' . $row['id'] . '.html" title="' . $row['ep_name'] . '" ' . $Active . '><span>' . $row['ep_name'] . '</span></a>';
}

$listServer = [];
$arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");

while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
    $listServer[$row['id']] = $row['server_name'];
    if ($row['server_player'] == 'player') {
        $SupportServer .= "{$row['server_name']},";
    }
}

if (isset($_POST['send_error'])) {
    $note = sql_escape($_POST['note']);
    if ($note && $EpisodeID && $Movie['id']) {
        if (get_total("report", "WHERE movie_id = '{$Movie['id']}' AND episode_id = '$EpisodeID'") < 1) {
            $mysql->insert("report", "movie_id,episode_id,content", "'{$Movie['id']}','$EpisodeID','$note'");
        }
    }
}
if (isset($_author_cookie)) {
    $day = date('d');
    if (get_total('user_movie', "WHERE movie_id = '{$Movie['id']}' AND user_id = '{$user['id']}' AND day = '$day'") < 1) {
        $mysql->update('user', "exp = exp + 3", "id = '{$user['id']}'");
        $mysql->insert('notice', 'user_id,content,timestap,time', "'{$user['id']}','Bạn Được Cộng 3xp Khi Xem \"{$Movie['name']}\"','" . time() . "','" . DATE . "'");
        $mysql->insert('user_movie', "movie_id,user_id,day", "'{$Movie['id']}','{$user['id']}','$day'");
    }
}
$VastPlayer = (get_total('ads', "WHERE position_name = 'vast_mp4' AND type = 'true'") >= 1 ? "'" . URL . "/player-ads.xml'" : '');
if ($cf['tvc_on'] == 'true') $tvc = URL . "/tvcb?url=";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= ("Xem Phim {$Movie['name']} Tập {$Ep['ep_name']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV.COM | bilibili | iqiyi") ?></title>
    <meta name="description" content="<?= ("Xem Phim {$Movie['name']} Tập {$Ep['ep_name']}, {$Movie['other_name']} Tập {$Ep['ep_name']} Vietsub + Thuyết Minh Tiếng Việt | Episode {$Ep['ep_name']} | HHTQTV.COM") ?>" />
    <meta name="keywords" content="<?= (Keyword($Movie['keyword']) ? Keyword($Movie['keyword']) : $Movie['name']) ?>" />
    <meta itemprop="name" content="<?= ("Xem Phim {$Movie['name']} Tập {$Ep['ep_name']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV.COM") ?>" />
    <meta name="language" content="Vietnamese, English" />
    <meta name="revisit-after" content="1 days" />
     
    <link rel="canonical" href="<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= $EpisodeID ?>.html" />
    <link rel="icon" href="<?= $cf['favico'] ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf-token'] ?>">
    <?php if ($_author_cookie) { ?>
        <meta name="_accesstoken" content="<?= $_COOKIE['_accesstoken'] ?>">
    <?php } ?>
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= ("Xem Phim {$Movie['name']} Tập {$Ep['ep_name']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV.COM") ?>" />
    <meta property="og:description" content="<?= ("Xem Phim {$Movie['name']} Tập {$Ep['ep_name']}, {$Movie['other_name']} Tập {$Ep['ep_name']} Vietsub + Thuyết Minh Tiếng Việt | Episode {$Ep['ep_name']} | HHTQTV.COM") ?>" />
    <meta property="og:image" content="<?= $Movie['image'] ?>" />
    <meta property="og:site_name" content="<?= Webname() ?>" />
    <meta property="og:url" content="<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= $EpisodeID ?>.html" />
    <meta property="og:locale" content="vi_VN" />
    <meta name="robots" content="index, follow, noodp">
    <meta property="fb:app_id" content="<?= $cf['fb_app_id'] ?>" />
    <link href="<?= URL ?>/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script type="text/javascript" src="<?= URL ?>/themes/js/jwplayer.js?v=1.0.8"></script>
    <script type="text/javascript">
        jwplayer.key = "ITWMv7t88JGzI0xPwW8I0+LveiXX9SWbfdmt0ArUSyc=";
    </script>
    <?= un_htmlchars($cf['googletagmanager']) ?>
    <script type="text/javascript">
        const $user = {
            "id": "<?= $user['id'] ?>",
            "avatar": "<?= $user['avatar'] ?>",
            "nickname": "<?= $user['nickname'] ?>",
            "email": "<?= $user['email'] ?>",
            "joined_time": "<?= $user['time'] ?>",
            "coins": "<?= $user['coins'] ?>",
            "exp": "<?= $user['exp'] ?>",
            "is_active": "1",
            "banned": "<?= $user['banned'] ?>",
            "quote": "<?= $user['quote'] ?>",
            "vip_expired": "<?= $user['vip'] ?>",
            "is_vip": "<?= $user['vip'] ?>"
        };
        const $elem = new Object();
        const $_GET = new Object();
        var $dt = {
            code_emoji: null,
            token: "<?= $_SESSION['csrf-token'] ?>"
        }
        Object.freeze($user);
    </script>
    <script type="text/javascript">
        var isMB = false;
        (function(a, b) {
            if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) isMB = true;
        })(navigator.userAgent || navigator.vendor || window.opera, '<?= URL ?>');
    </script>
    <style>
        body {
            background: url(<?= ($cf['background'] ? $cf['background'] : "https://i.imgur.com/ISitmiU.jpg") ?>) fixed center;
        }
    </style>
    <script type="text/javascript" src="<?= URL ?>/themes/js_ob/object.js?v=1.7.4"></script>
    <script type="text/javascript" src="<?= URL ?>/themes/js_ob/class.js?v=1.7.4"></script>
    <script type="text/javascript" src="<?= URL ?>/themes/js_ob/function.js?v=1.7.4"></script>
    <script>
        var arfAsync = arfAsync || [];
    </script>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">

            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>

            <div class="watching-movie">
                <div id="intro-vip" class="display-none">
                    <div>Chức Năng Này Đang Được Phát Triển</div>
                    <!-- <div>
                        - Quảng cáo có thể làm bạn khó chịu nhưng tiền thu được từ quảng cáo chúng tôi duy trì trả lương cho nhóm dịch, đội ngũ, chi phí vận hành vậy nên không có cách nào khác.
                    </div>
                    <div>
                        - Vì vậy nếu bạn muốn những lợi ích ưu tiên và xoá quảng cáo được cài đặt trên website (trừ quảng cáo ở server hydrax, chủ server đó cài nên không thể xoá) Vậy thì hãy mở chức năng VIP giá học sinh.
                    </div>
                    <div class="flex flex-ver-center flex-hozi-center flex-column">
                        <div class="color-yellow fw-500 margin-5-0 fs-15">Giá chỉ 19.999 VNĐ / Tháng</div>
                        <a href="/tai-khoan/cua-hang" class="button-default flex flex-hozi-center fw-700 bg-blue fs-15">
                            <span class="material-icons-round ">
                                lock_open
                            </span>Mở ngay</a>
                    </div> -->
                </div>
                <div id="settings-while-watching" class="display-none">
                    <div class="flex flex-ver-center flex-hozi-center flex-column align-center">
                        <div class="fs-17 fw-500 color-yellow">
                            Chỉ áp dụng cho server <?= $SupportServer ?>
                        </div>
                        <div class="padding-5 fw-500">Tự động chuyển tập mới ở mốc thời gian :</div>
                        <label class="switch">
                            <input type="checkbox" class="auto-open-next-ep" onchange="aoneEvent(event)"><span class="slider round"></span></label>
                        <div class="padding-5">
                            <div class="aone-on display-none flex-hozi-center">
                                <input name="aone-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneMin(event)" type="number" />
                                <b class="fs-19 margin-0-5">:</b>
                                <input name="aone-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="aoneSec(event)" type="number" />
                            </div>
                        </div>

                        <div class="padding-5 fw-500">Tự động Bỏ Qua Openning :</div>
                        <label class="switch">
                            <input type="checkbox" class="skip-op" onchange="skipOpEvent(event)"><span class="slider round"></span></label>
                        <div class="padding-5">
                            <div class="turn-on-skip-op display-none flex-hozi-center">
                                <input name="skip-op-min" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpMin(event)" type="number" />
                                <b class="fs-19 margin-0-5">:</b>
                                <input name="skip-op-sec" class="bg-black color-white align-center w-50 padding-5" value="0" onchange="skipOpSec(event)" type="number" />
                            </div>
                        </div>

                        <div class="padding-5 fw-500">Tự động bật chế độ Night(<b class="color-red-2">VIP</b>)</div>
                        <div>
                            <label class="switch"><input type="checkbox" class="auto-turn-on-night-mode" onchange="atonmEvent(event)"><span class="slider round"></span></label>
                        </div>
                        <div class="padding-5 fw-500">Tự động phóng to khi ấn nút Play</div>
                        <div>
                            <label class="switch"><input type="checkbox" class="auto-full-screen" onchange="afsEvent(event)"><span class="slider round"></span></label>
                        </div>
                    </div>
                </div>
<!-- 
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4942643338675496"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4942643338675496"
     data-ad-slot="3049302767"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
-->
                <div class="ah-frame-bg fw-700 margin-10-0 bg-black">
                    <a href="<?= URL ?>/thong-tin-phim/<?= $MovieSlug ?>.html" class="fs-16 flex flex-hozi-center color-yellow border-style-1"><span class="material-icons-round margin-0-5">
                            movie
                        </span><?= $Movie['name'] ?></a>
                    <div class="flex flex-space-auto">
                        <span>Đang Xem Tập <?= $Ep['ep_name'] ?></span>
                        <span>Đăng <?= RemainTime($Movie['timestap']) ?></span>
                    </div>
                </div>
                <div class="control-bar flex flex-space-between bg-cod-gray">
                    <div class="bg-black flex flex-hozi-center fw-500 fs-17 padding-0-10 height-50 border-l-b-t">
                        <div class="margin-10-0 bg-brown flex flex-space-auto">
                            <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                                Tập <?= $Ep['ep_name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="bg-black flex flex-hozi-center fs-17 padding-0-10 height-50 border-r-b-t">
                        <a href="javascript:void(0);" title="Theo dõi phim này" id="toggle_follow" class="button-default padding-5 bg-primary fs-21" title="Theo Dõi">
                            <span class="material-icons-round material-icons-menu">bookmark_add</span>
                        </a>
                        <a href="<?= URL ?>/thong-tin-phim/<?= $MovieSlug ?>.html" class="button-default padding-5 bg-brown fs-21" title="Thông tin phim"><span class="material-icons-round">
                                info
                            </span>
                        </a>
                        <button id="report_error" class="button-default padding-5 bg-red fs-21 color-white"><span class="material-icons-round">
                                report_problem
                            </span>
                        </button>
                    </div>
                </div>
                <form action="<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= $EpisodeID ?>.html" method="POST" name="episode_error" id="episode_error">
                    <input type="text" style="width: 200px;border-radius: 8px;" name="note" placeholder="Điền Lý Do Lỗi Bạn Gặp Phải">
                    <input type="text" style="display: none;" name="movie_id" value="<?= $Movie['id'] ?>">
                    <input type="text" style="display: none;" name="Episode_id" value="<?= $EpisodeID ?>">
                    <input type="submit" style="border-radius: 8px;" name="send_error" value="Gửi">
                </form>
                <div class="ah-frame-bg">
                    <div>
                        <center><p><span><b style="color: orange;">+ Nếu bị ( lag/mờ/không xem được ) hãy ấn vào nút (</b><span style="color: #54b784;">Op</span></span><b style="color: orange; text-align: left;"> | </b><span style="text-align: left;"><span style="color: #54b784;">Arc</span><b style="color: orange;"> |</b><span style="color: #54b784;">.....</span></span><b style="color: orange; text-align: left;">) Bên Dưới để chuyển đổi server.</b></p></center>
                       </div>
                </div>
                <div id="list_sv" class="flex flex-ver-center margin-10" style="flex-wrap: wrap;">
                    <?php
                        $Defult = 0;
                        $movieServer = (!empty($Ep['server']) && $Ep['server'] != 'null') ? array_column(json_decode($Ep['server'], true), 'server_link', 'server_name') : [];

                        foreach ($listServer as $server) {
                            if (!empty($movieServer[$server])) {
                                $Defult++;
                                if ($Defult == 1) {
                                    $ServerDF = "startStreaming('" . ServerName($server) . "', 1)";
                                    echo '<a href="javascript:void(0)" class="button-default bg-green" id="sv_' . ServerName($server) . '" name="' . ServerName($server) . '">' . $server . '</a>';
                                } else {
                                    echo '<a href="javascript:void(0)" class="button-default" id="sv_' . ServerName($server) . '" name="' . ServerName($server) . '">' . $server . '</a>';
                                }
                            }
                        }
                    ?>
                </div>
                <div id="video-player">
                    <div class="loading" style="text-align: center;margin-bottom: 15px;">
                        <div><img src="<?= URL ?>/themes/img/5Q0v.gif" alt="" width="100px" height="100px;"></div>
                        <b>Đang Tải Player Vui Lòng Chờ</b>
                    </div>
                </div>
                <script type="text/javascript">
                    var $info_play_video = {
                        vast: [<?= $VastPlayer ?>],
                    }
                    var $list_sv = document.getElementById("list_sv");
                    var final_ep, next_ep_act = false;
                    var aone_time, aone_event, skip_op, skip_op_time = 0;
                    if ($user.is_vip == 1) {
                        $info_play_video.vast = null;
                    }

                    function convertHMS(value) {
                        const sec = parseInt(value, 10); // convert value to number if it's string
                        let hours = Math.floor(sec / 3600); // get hours
                        let minutes = Math.floor((sec - (hours * 3600)) / 60); // get minutes
                        let seconds = sec - (hours * 3600) - (minutes * 60); //  get seconds
                        // add 0 if value < 10; Example: 2 => 02
                        if (hours < 10) {
                            hours = "0" + hours;
                        }
                        if (minutes < 10) {
                            minutes = "0" + minutes;
                        }
                        if (seconds < 10) {
                            seconds = "0" + seconds;
                        }
                        return hours + ':' + minutes + ':' + seconds; // Return is HH : MM : SS
                    }

                    function setAoneTime() {
                        aone_event = $cookie.getItem("aone_event") || 0;
                        var aone_min = parseInt($cookie.getItem("aone_min")) || 0;
                        var aone_sec = parseInt($cookie.getItem("aone_sec")) || 0;
                        if (aone_event) {
                            aone_time = aone_min * 60 + aone_sec;
                        }
                        return aone_time;
                    }

                    function setSkipOpTime() {
                        skip_op = $cookie.getItem("skip_op") || 0;
                        var skip_op_min = parseInt($cookie.getItem("skip_op_min")) || 0;
                        var skip_op_sec = parseInt($cookie.getItem("skip_op_sec")) || 0;
                        if (skip_op)
                            skip_op_time = skip_op_min * 60 + skip_op_sec;
                        return skip_op_time;

                    }

                    function initSkip() {
                        let get_aone_time = setAoneTime();
                        let get_skip_op_time = setSkipOpTime();
                        // console.log(get_aone_time,get_skip_op_time);
                        if (get_aone_time <= get_skip_op_time) {
                            alert("Cài thời gian chuyển tập mới phải hơn thời gian bỏ qua OP");
                            aone_time = 0;
                        }
                    }
                    initSkip();
                    var skip_ads = null;

                    function loadVideo(s, aa, seek, w, load_hls = false) {
                        var jp = jwplayer("video-player");
                        jp.setup({
                            //sources: s,
                            file: s,
                            width: w,
                            height: "100%",
                            aspectratio: "16:9",
                            playbackRateControls: [0.75, 1, 1.25, 1.5, 2, 2.5],
                            autostart: true,
                            volume: 100,
                            advertising: {
                                client: 'vast',
                                admessage: 'Quảng cáo còn XX giây.',
                                skipoffset: 5,
                                skiptext: 'Bỏ qua quảng cáo',
                                skipmessage: 'Bỏ qua sau xxs',
                                tag: aa,
                            },

                        })

                        function forwardTenSecond() {
                            jp.seek(jp.getPosition() + 10);
                        }
                        jp.addButton("<?= URL ?>/themes/img/next_episode.png?v=1.1.8", "Tập tiếp theo", nextEpisode, "next-episode");
                        jp.addButton("<?= URL ?>/themes/img/forward_10s.png?v=1.1.8", "Tua tiếp 10s", forwardTenSecond, "forward-10s");

                        if (seek != 0) {
                            jp.seek(seek)
                        }
                        jp.on('time', function(e) {
                            $cookie.setItem('resumevideodata', Math.floor(e.position) + ':' + jp.getDuration(), 82000, window.location.pathname);
                            if (aone_event && aone_time) {
                                if (e.position > aone_time && !final_ep && !next_ep_act) {
                                    nextEpisode();
                                    next_ep_act = true;
                                }
                            }
                        });
                        jp.on('adImpression', function() {
                            var jw_controls = getElem("video-player");
                            skip_ads = document.createElement("div");
                            skip_ads.textContent = "Bỏ qua quảng cáo";
                            skip_ads.style.position = "absolute";
                            skip_ads.style.right = "5px";
                            skip_ads.style.top = "5px";
                            skip_ads.style.background = "#000";
                            skip_ads.style.color = "#fff";
                            skip_ads.style.padding = "10px";
                            skip_ads.style.zIndex = 1;
                            skip_ads.addEventListener("click", function() {
                                skip_ads.remove();
                                jwplayer().skipAd();
                            })
                            execDelay(function() {
                                jw_controls.insertAdjacentElement("afterbegin", skip_ads);
                            }, 5000)
                        })
                        jp.on('firstFrame', function() {
                            // skip_ads.remove();
                            var cookieData = $cookie.getItem('resumevideodata');
                            if (cookieData) {
                                var resumeAt = cookieData.split(':')[0],
                                    videoDur = cookieData.split(':')[1];
                                if (parseInt(resumeAt) < parseInt(videoDur)) {
                                    Swal.fire({
                                        title: 'Thông báo',
                                        html: 'Lần trước bạn đã xem tới <font color="red">' + convertHMS(resumeAt) + "</font><br/>Bạn Có muốn xem tiếp ?",
                                        showCancelButton: true,
                                        preConfirm: () => {
                                            (resumeAt == 0) ? resumeAt = 1: "";
                                            jp.seek(resumeAt);
                                        }
                                    })

                                } else if (cookieData && !(parseInt(resumeAt) < parseInt(videoDur))) {}
                            }
                            if ($cookie.getItem("afs_on")) {
                                execDelay(function() {
                                    jp.setFullscreen(true)
                                }, 2000);
                            }
                        });
                        jp.on('ready', function() {
                            if ($cookie.getItem("atonm_on")) {
                                getElem("toggle-light").click();
                            }
                        })
                        jp.on("seek", function(e) {
                            seek = e.offset;
                        })

                        return jp;
                    }

                    function nextEpisode() {
                        <?= $JsNextEpisode ?>
                    }

                    function oldEpisode() {
                        <?= $JsOldEpisode ?>
                    }
                    (async () => {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });
                        var LoadPlayerServer = (async () => {
                            return new Promise((resolve, reject) => {
                                $.ajax({
                                    type: "POST",
                                    url: '/server/ajax/player',
                                    data: {
                                        MovieID: <?= $Movie['id'] ?>,
                                        EpisodeID: <?= $Ep['id'] ?>
                                    },
                                    success: function(ResponsePlayer) {
                                        resolve(ResponsePlayer);
                                    }
                                });
                            });
                        });
                        var PlayerServer = await LoadPlayerServer();
                        var startStreaming = (async (name_server, first_server = null) => {
                            var _video_player = document.getElementById("video-player");
                            var load_video;
                            if (PlayerServer.code != 200) {
                                $('#video-player').html(`<div style="text-align: center;margin-bottom: 15px;"><img src="/themes/img/error.png" width="100" height="100"><div>${PlayerServer.message}</div></div>`);
                                return
                            }
                            switch (name_server) {
                                <?php
                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");
                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                    if ($row['server_player'] == 'player') {
                                        echo '
                                case \'' . ServerName($row['server_name']) . '\':
                                    var SourceVideo = {
                                        "file": PlayerServer.src_' . ServerName($row['server_name']) . ',
                                    }
                                    load_video = loadVideo(PlayerServer.src_' . ServerName($row['server_name']) . ', $info_play_video.vast, skip_op_time, \'100%\');
                                    break;';
                                    } else {
                                        echo '
                                case \'' . ServerName($row['server_name']) . '\':
                                    _video_player.innerHTML = `<div style="position: relative;padding-bottom: 57.25%"><iframe style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;overflow:hidden;" frameborder="0" src="' . $tvc . '${PlayerServer.src_' . ServerName($row['server_name']) . '}" frameborder="0" scrolling="0" allowfullscreen></iframe></div>`;
                                    break;';
                                    }
                                ?>
                                <?php } ?>
                                default:
                                    break;
                            }
                            first_server == null && $cookie.setItem('server_watching', name_server, 86400);
                            $(`#sv_${name_server}`).addClass("bg-green");
                        });
                        <?= $ServerDF ?>

                        list_sv.childNodes.forEach(item => {
                            item.addEventListener("click", function(e) {
                                list_sv.querySelector(".bg-green").classList.remove("bg-green");
                                this.classList.add("bg-green");
                                startStreaming(this.getAttribute("name"));
                            })
                        });
                    })();
                </script>
                <div class="flex flex-ver-center margin-10">
                    <div class="button-default flex flex-hozi-center fw-700 bg-blue" id="toggle-light">
                        <span class="material-icons-round ">
                            nightlight
                        </span>Night
                    </div>
                    <div class="button-default flex flex-hozi-center bg-red">
                        </span><span><a href="https://www.messenger.com/t/hhchina/"</span>
                        </span> Báo lỗi
                    </div>
                    <div>
                        <a href="javascript:oldEpisode();" class="button-default padding-5-20 flex flex-hozi-center fw-700"> <span class="material-icons-round ">
                                arrow_back_ios
                            </span>Trước</a>
                    </div>
                    <div>
                        <a href="javascript:nextEpisode();" class="button-default padding-5-20 flex flex-hozi-center fw-700">Tiếp<span class="material-icons-round ">
                                arrow_forward_ios
                            </span></a>
                    </div>

                </div>
<!--
<div id="top-banner-pc" style="text-align: center;">
<zone id="kyl30cr3"></zone>
<a onclick="updateClickAds(134);HideCatfish(this);" href="https://www.i9bet198.com/Register?a=22778" target="_blank">
<img src="https://lh3.googleusercontent.com/pw/ABLVV87n-1J3wB8Cg5YTJFY9EeY9qq0C0zNO19-wVy-JWrFZ1dvAIvomJXo9XcBqRv9EEJI3l1z8JWYvCy-0H8Qd8vMroaCW09Iqa24sjk2bbjaIvyVk1zM=w2400" width="95%"></a></div>
-->
                <div class="ah-frame-bg">
                    <div>
                        <center><p><span><b style="color: orange;"></b></span><span style="text-align: left;"><b><span style="color: orange;">Server ( </span><span style="color: #65bea2;">Dl</span><span style="color: orange;"> | </span></b></span><b style="text-align: left;"><span style="color: #65bea2;">Hx</span></b><span style="text-align: left;"><b><span style="color: orange;">&nbsp;) Khi click xem sẽ bị nhảy quảng cáo của bên cung cấp Server, nhấn tắt bỏ và tiếp tục xem phim nhé!</span></b></span></p></center>
                       </div>
                </div>
                <div id="PlayerAds" style="text-align: center;"></div>
                <?php if ($Movie['lich_chieu']) {
                    foreach (json_decode($Movie['lich_chieu'], true) as $key => $value) {
                        if ($value['days'] == 8) {
                            $Days .= "Chủ Nhật,";
                        } else {
                            $Days .= "Thứ {$value['days']},";
                        }
                    }
                ?>
                    <div class="ah-frame-bg">
                        <div class="flex flex-hozi-center fw-700 color-white-2">
                            <span class="material-icons-round margin-0-5">
                                note
                            </span><p style="font-size: 16px;"><strong>Lịch Chiếu: <span style="color:#FFA500"><?= $Movie['showtimes'] ?> <span style="color:#FFA500"><?= $Days ?> Hàng Tuần</span></strong></p>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($Movie['keyword']) { ?>
                    <div class=" bind_movie">
                        <div>
                            <?php
                            $active = 0;
                            foreach (json_decode($Movie['keyword'], true) as $key => $value) {
                                if ($value['name']) {
                            ?>
                                    <a class="ah_key_seo" href="<?= $value['url'] ?>" class="<?= ($active = 1 ? "active" : "") ?>"><?= $value['name'] ?></a>
                            <?php }
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="list_episode ah-frame-bg" id="list-episode">
                    <div class="heading flex flex-space-auto fw-700">
                        <span>Danh sách tập</span>
                        <span id="newest-ep-is-readed" class="fs-13"></span>
                    </div>
                    <div class="list-item-episode scroll-bar">
                        <?= $ListEpisode ?>
                    </div>
                </div>
                <?php if ($cf['cmt_on'] == 'true') { ?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4942643338675496"
     crossorigin="anonymous"></script>
<!-- ads#1 -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4942643338675496"
     data-ad-slot="5238948808"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
                    <div class="ah-frame-bg">
                        <div class="flex flex-space-auto">
                            <div class="fw-700 fs-16 color-yellow-2 flex flex-hozi-center"><span class="material-icons-round margin-0-5">
                                    comment
                                </span>Bình luận (<?= number_format(get_total('comment', "WHERE movie_id = '{$Movie['id']}'")) ?>)</div>
                            <div id="refresh-comments" class="cursor-pointer"><span class="material-icons-round fs-35">refresh</span></div>
                        </div>
                        <?php if (!$_author_cookie) { ?>
                            <div class="flex flex-ver-center fw-500">
                                <a href="/login" class="button-default bg-red">
                                    Đăng nhập để bình luận
                                </a>
                            </div>
                        <?php } ?>
                        <script type="text/javascript" src="/themes/js_ob/fgEmojiPicker.js?v=1.7.4"></script>
                        <div id="frame-comment">
                        </div>
                        <div id="comments" class="margin-t-10" style="width: 100%;overflow: hidden;">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <script type="text/javascript">
                var $info_data = {
                    movie_id: <?= $Movie['id'] ?>,
                    id: <?= $Ep['id'] ?>,
                    no_ep: "<?= $Ep['ep_name'] ?>"
                }
                $_GET.comment_id = getParam("comment_id") || null;
                <?php if (get_total('history', "WHERE movie_save = '{$Movie['id']}' AND user_id = '{$user['id']}'") >= 1 && $_author_cookie) { ?>
                    var $user_followed = true;
                <?php } else { ?>
                    var $user_followed = false;
                <?php } ?>
            </script>
            <script type="text/javascript" src="/themes/js_ob/comments.js?v=1.7.4"></script>
            <div class="opacity">
                <h3>Phim <?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> HD</h3>
                <h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> Thuyet minh</h3>
                <h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> vietsub</h3>
                <h3>Xem <?= $Movie['name'] ?> <?= $Ep['ep_name'] ?> hd vietsub</h3>
                <h3><?= $Movie['name'] ?> <?= $Ep['ep_name'] ?></h3>
            </div>

            <script type="text/javascript">
                CheckButton();
                $('#toggle_follow').on('click', function(e) {
                    var Follow_store = localStorage.getItem("data_follow");
                    let data_follow_store = Follow_store ? JSON.parse(Follow_store) : [];
                    var index_this_movie = data_follow_store.indexOf($info_data.movie_id);
                    var movie_id = $info_data.movie_id
                    if (index_this_movie !== -1) {
                        data_follow_store.splice(index_this_movie, 1);
                        Toast({
                            message: "Xoá Theo Dõi Thành Công!",
                            type: "error"
                        });
                        $('#toggle_follow').html(`<span class="material-icons-round material-icons-menu">bookmark_add</span>`);
                        $('#toggle_follow').css("background-color", "");
                        localStorage.setItem("data_follow", JSON.stringify(data_follow_store));
                    } else {
                        var data = JSON.parse(Follow_store);
                        try {
                            data.push(movie_id);
                            localStorage.setItem("data_follow", JSON.stringify(data));
                        } catch (error) {
                            localStorage.setItem("data_follow", JSON.stringify([movie_id]));
                        }
                        $('#toggle_follow').html(`<span class="material-icons-round">bookmark_remove</span>`);
                        $('#toggle_follow').css("background-color", "rgb(125, 72, 72)");
                        localStorage.removeItem('async_follow');
                        Toast({
                            message: "Thêm Vào Theo Dõi Thành Công",
                            type: "success"
                        });
                    }
                });

                function CheckButton() {
                    try {
                        var Follow_store = localStorage.getItem("data_follow");
                        let data_follow_store = Follow_store ? JSON.parse(Follow_store) : [];
                        var index_this_movie = data_follow_store.indexOf($info_data.movie_id);
                        var movie_id = $info_data.movie_id
                        if (index_this_movie !== -1) {
                            $('#toggle_follow').html(`<span class="material-icons-round">bookmark_remove</span>`);
                            $('#toggle_follow').css("background-color", "rgb(125, 72, 72)");
                        }
                    } catch (error) {
                        console.log(error);
                    }
                }
            </script>
        </div>
        <?= PopUnder('pop_under_watch') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
        <?php require_once(ROOT_DIR . '/view/footer-movie-watch.php'); ?>
        <script type="text/javascript" src="<?= URL ?>/themes/js_ob/watching.js?v=1.7.4"></script>
    </div>
</body>

</html>