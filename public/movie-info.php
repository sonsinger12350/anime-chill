<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$value[2]) die(header('location:' . URL));
FireWall();
$MovieSlug = sql_escape($value[2]);
if (get_total("movie", "WHERE slug = '$MovieSlug'") < 1) die(header('location:' . URL));
$Movie = GetDataArr("movie", "slug = '$MovieSlug'");
$NumEpisode = ($Movie['ep_hien_tai'] ? $Movie['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$Movie['id']}'"));
$statut = ($Movie['loai_phim'] == 'Phim Lẻ' ? "{$Movie['movie_duration']} Phút" : "$NumEpisode/{$Movie['ep_num']}");
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    
    <title><?= ("{$Movie['name']} {$Movie['seo_title']} VietSub + Thuyết Minh Tiếng Việt") ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes"/>
    <meta name="title" content="<?= ("{$Movie['name']} {$Movie['seo_title']} Vietsub + Thuyết Minh Tiếng Việt") ?>" />
    <meta name="revisit-after" content="1 days" />
    <meta name="description" content="<?= ("Xem Phim {$Movie['name']}, {$Movie['other_name']} {$Movie['seo_title']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV.COM | bilibili | iqiyi | Hoạt hình trung quốc | {$Movie['seo_tap']} | hhkungfu | hhpanda") ?>" />
    <meta name="keywords" content="<?= (Keyword($Movie['keyword']) ? Keyword($Movie['keyword']) : $Movie['name'] ) ?>" />
    <meta itemprop="name" content="<?= ("Xem Phim {$Movie['name']} {$Movie['seo_title']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV | bilibili.tv | iq.com | Hoạt hình trung quốc | Animehay") ?>" />
    <meta name="language" content="Vietnamese, English" />
    <link rel="canonical" href="<?= URL ?>/thong-tin-phim/<?= $Movie['slug'] ?>.html" />
    <link rel="icon" href="<?= $cf['favico'] ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="utf-8">
    <meta property="og:type" content="video.movie" />
    <meta name="csrf-token" content="<?= $_SESSION['csrf-token'] ?>">
    <?php if ($_author_cookie) { ?>
        <meta name="_accesstoken" content="<?= $_COOKIE['_accesstoken'] ?>">
    <?php } ?>

    <meta property="og:title" content="<?= ("{$Movie['name']} {$Movie['seo_title']} Vietsub + Thuyết Minh Tiếng Việt") ?>" />
    <meta property="og:description" content="<?= ("Xem Phim {$Movie['name']}, {$Movie['other_name']} {$Movie['seo_title']} Vietsub + Thuyết Minh Tiếng Việt | HHTQTV.COM | {$Movie['seo_tap']} | hhkungfu | hhpanda") ?>" />
    <meta property="og:image" content="<?= $Movie['image'] ?>" />
    <meta property="og:site_name" content="<?= Webname() ?> | Web Xem Phim Anime - Hoạt Hình Trung Quốc Hay Nhất" />
    <meta property="og:url" content="<?= URL ?>/thong-tin-phim/<?= $Movie['slug'] ?>.html" />
    <meta property="og:locale" content="vi_VN" />
    <meta name="robots" content="index, follow, noodp">
    <meta property="fb:app_id" content="<?= $cf['fb_app_id'] ?>" />
    <link href="<?= URL ?>/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            token: "7f0d599e2adbe5c42eb4231cf5323eab"
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

            <div class="info-movie">
                <div id="modal" class="modal" style="display:none">
                    <div>
                        <div>Đánh giá phim</div>
                        <a href="javascript:$modal.toggleModal()"><span class="material-icons-round margin-0-5">
                                close
                            </span></a>
                    </div>
                    <div>
                        <div class="rated-star flex flex-hozi-center flex-ver-center">
                            <?php
                            for ($i = 1; $i < 11; $i++) {
                                if (json_decode($_COOKIE['vote'], true)[$Movie['id']] >= $i) {
                                    $css = ' class="active"';
                                } else $css = '';
                                echo "<span rate='$i'$css><span class=\"material-icons-round\">star</span></span>";
                            }
                            ?>

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
                <h1 class="heading_movie"><?= $Movie['name'] ?></h1>
                <div class="head ah-frame-bg">
                    <div class="first" style="position: relative;">
                        <img onclick="location.href = '<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= get_data_multi('id', 'episode', "movie_id = '{$Movie['id']}' ORDER BY id DESC") ?>.html'" src="<?= $Movie['image'] ?>" alt="<?= $Movie['name'] ?>" />
                         <div class="view-info episode_latest flex flex-hozi-center fw-700"><span class="material-icons-round" style="padding: 2px 2px;"> visibility </span>
                        <?= number_format($Movie['view']) ?></div> 
                    </div>
                    <div class="last">
                        <div class="list_cate">
                            <div>Thể loại</div>
                            <div>
                                <?php
                                foreach (json_decode($Movie['cate'], true) as $key => $value) {
                                    $CateGory = GetDataArr('category', "id = '{$value['cate_id']}'");
                                    echo '<a href="/the-loai/' . $CateGory['slug'] . '.html">' . $CateGory['name'] . '</a>';
                                }
                                ?>

                            </div>
                        </div>
                        <?php if ($Movie['other_name']) { ?>
                            <div class="name_other">
                                <div>Tên khác</div>
                                <div><?= $Movie['other_name'] ?></div>
                            </div>
                        <?php } ?>
                        <div class="status">
                            <div>Trạng thái</div>
                            <div><?= $Movie['trang_thai'] ?></div>
                        </div>
                        <div class="score">
                            <div>Điểm</div>
                            <div>
                                <?= Voteting($Movie['vote_point'], $Movie['vote_all']) ?> || <?= $Movie['vote_all'] ?> đánh giá </div>
                        </div>
                        <div class="update_time">
                            <div>Phát hành</div>
                            <div><?= $Movie['year'] ?></div>
                        </div>
                        <div class="duration">
                            <div>Thời lượng</div>
                            <div><?= $statut ?></div>
                        </div>
                        <!-- <div class="duration">
                            <div>Lượt Xem</div>
                            <div><?= number_format($Movie['view']) ?></div>
                        </div> -->
                    </div>
                </div>
                <div class="flex ah-frame-bg flex-wrap">
                    <div class="flex flex-wrap flex-1">
                        <a href="<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= get_data_multi('id', 'episode', "movie_id = '{$Movie['id']}' ORDER BY id DESC") ?>.html" class="padding-5-15 fs-1 button-default fw-1 fs-1 flex flex-hozi-center bg-lochinvar" style="background: #d13a34;" title="Xem Ngay"><span style="font-size: 14px;">Xem Ngay</span></a>
                        <a href="https://ktruyen.online" class="padding-1-1 fs-1 button-default fw-1 fs-1 flex flex-hozi-center bg-lochinvar" style="background: #337ab7;" title="Xem Ngay"><span style="font-size: 14px;">Truyện Tranh</span></a>
                    </div>
                </div>
                <div class="flex ah-frame-bg flex-wrap">
                    <div class="flex flex-wrap flex-1">
                        <a href="javascript:void(0)" id="toggle_follow" class="bg-green padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="Theo dõi phim này"><span class="material-icons-round">bookmark_add</span></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(URL . "/thong-tin-phim/{$Movie['slug']}.html") ?>" style="background-color: #2374e1;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="Chia Sẻ Lên Facebook" target="_blank"><span class="material-icons-round">share</span></a>
                        <a href="https://www.facebook.com/hhchina/" style="background-color: #2374e1;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="FanPage Facebook" target="_blank"><span class="material-icons-round">thumb_up</span></a>
                        <a href="https://www.facebook.com/motanime247/" style="background-color: #2374e1;" class="padding-5-15 fs-35 button-default fw-500 fs-15 flex flex-hozi-center" title="FanPage" target="_blank"><span class="material-icons-round">group</span></a>
                    </div>
                    <div class="last">
                        <div id="rated" class="bg-orange padding-1-5 fs-35 button-default fw-500 fs-15 flex flex-hozi-center"><span class="material-icons-round">
                                stars
                            </span></div>
                    </div>
                </div>

                <?php if (get_total('lien_ket', "WHERE movie_id = '{$Movie['id']}'") >= 1) { ?>
                    <div class="bind_movie ah-frame-bg">
                        <div>
                            <h2 class="heading">Phim liên kết</h2>
                        </div>
                        <div class="scroll-bar">
                            <?php
                            $active = 0;
                            $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "lien_ket WHERE movie_id = '{$Movie['id']}' ORDER BY id ASC");
                            while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <a href="<?= $row['url'] ?>" class="<?= ($active = 1 ? "active" : "") ?>"><?= $row['name'] ?></a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="body">
                    <?php if ($NumEpisode >= 1) { ?>
                        <div class="list_episode ah-frame-bg">
                            <div class="heading flex flex-space-auto fw-700">
                                <span>Danh sách tập</span>
                                <span id="newest-ep-is-readed" class="fs-13"></span>
                            </div>
                            <div class="list-item-episode scroll-bar">
                                <?php
                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "episode WHERE movie_id = '{$Movie['id']}' ORDER BY id DESC");
                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <a href="<?= URL ?>/xem-phim/<?= $Movie['slug'] ?>-episode-id-<?= $row['id'] ?>.html" title="<?= $row['ep_name'] ?>">
                                        <span><?= $row['ep_name'] ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
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
                    <div class="desc ah-frame-bg list_episode">
                        <?php if ($Movie['lich_chieu']) {
                    foreach (json_decode($Movie['lich_chieu'], true) as $key => $value) {
                        if ($value['days'] == 8) {
                            $Days .= "Chủ Nhật,";
                        } else {
                            $Days .= "Thứ {$value['days']}, ";
                        }
                    }
                ?>
                    <div class="heading flex flex-hozi-center fw-700 color-white-2">
                            <p  style="font-size: 16px;"><strong>Lịch Chiếu: <span style="color:#FFA500"><?= $Movie['showtimes'] ?> <span style="color:#FFA500"><?= $Days ?>Hàng Tuần</span></strong></p>
                    </div>
                <?php } ?>
                <br>
                        <h2 class="heading" >Fanpage Facebook</h2>
                    <center><div class="fb-page" data-href="https://www.facebook.com/hhchina/" data-tabs="timeline" data-width="500" data-height="70" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/hhchina/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/hhchina/">HHTQTV.COM</a></blockquote></div></center>
                        <br>
                        <div>
                            <h2 class="heading">
                                Nội dung
                            </h2>
                        </div>
                        <div class="list-item-episode scroll-bar">
                            
                            <p><?= un_htmlchars($Movie['content']) ?></p>
                        </div>
                    </div>
                </div>
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
                <?php if ($cf['cmt_on'] == 'true') { ?>
                    <div class="ah-frame-bg">
                        <div class="flex flex-space-auto">
                            <div class="fw-700 fs-16 color-yellow-2 flex flex-hozi-center">
                                <span class="material-icons-round margin-0-5"></span>Bình luận (<?= number_format(get_total('comment', "WHERE movie_id = '{$Movie['id']}'")) ?>)
                            </div>
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
        </div>
        <script type="text/javascript">
            var $modal = new MyModal();
            var $info_data = {
                movie_id: <?= $Movie['id'] ?>,
            }
            $_GET.comment_id = getParam("comment_id") || null;
            <?php if (get_total('history', "WHERE movie_save = '{$Movie['id']}' AND user_id = '{$user['id']}'") >= 1 && $_author_cookie) { ?>
                var $user_followed = true;
            <?php } else { ?>
                var $user_followed = false;
            <?php } ?>
        </script>
        <script type="text/javascript" src="/themes/js_ob/info_movie.js?v=1.7.4"></script>
        <script type="text/javascript" src="/themes/js_ob/comments.js?v=1.7.4"></script>
        <?= PopUnder('pop_under_info') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
        <?php require_once(ROOT_DIR . '/view/footer-movie-info.php'); ?>
    </div>
</body>

</html>