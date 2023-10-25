<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['viewer']) {
    $mysql->update("config", "view = view + 1", "id = 1");
    $_SESSION['viewer'] = "True";
}
FireWall();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta name="monetag" content="331fec14ce6632a316191c40d16db114">
    <?php
    $description =  $cf['description'];
    require_once(ROOT_DIR . '/view/head.php');
    ?>
    <script>
        $config = {
            boxchat_load: <?= $cf['on_load_boxchat'] ?>
        }
    </script>
    <script type="text/javascript" src="/themes/js_ob/home.js?v=1.7.4"></script>
</head>
<script src="https://www.vipads.live/vn/078C7391-A135-105-34-43993C0F2E09.blpha"></script>

<body class="scroll-bar animethemes">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <center>
                <p style="background-color: #404040; font-family: Comfortaa, sans-serif; font-weight: 900; margin: 0px;"><span style="text-align: left;"><span style="font-family: Comfortaa;"><span new="" roman="" style="color: black; font-size: 14px;" times=""><span style="color: #ff00fe;"><b><br /></b></span></span></span></span></p>
                <p style="background-color: #404040; font-family: Comfortaa, sans-serif; font-weight: 900; margin: 0px;"><span style="text-align: left;"><span style="font-family: Comfortaa;"><span new="" roman="" style="color: black; font-size: 14px;" times=""><span style="color: #ff00fe;"><b>•</b></span></span><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="color: white; font-size: 14px;"> </span></span></b></span></span><span style="background-color: transparent; text-align: left;"><span style="font-family: Comfortaa;"><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="font-size: medium;"><span><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="color: white;">Hãy luôn truy cập web bằng tên miền </span><span><a href="https://hhchina.net" rel="noopener" style="background-color: transparent; box-sizing: border-box; font-family: Comfortaa, sans-serif; font-size: medium; text-decoration-line: none;" target="_blank"><span style="color: #ffa400; font-size: medium;">hhchina.net</span></a> <span style="color: white;">để khi bị chặn sẽ được chuyển hướng tới tên miền mới</span></span></span></b></span></span></span></b></span></span></p>
                <p style="background-color: #404040; margin: 0px;"><span face="Comfortaa, sans-serif" style="font-weight: 900; text-align: left;"><span style="font-family: Comfortaa;"><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="font-size: medium;"><span><span new="" roman="" style="color: black; font-size: 14px;" times=""><span style="color: #ff00fe;"><b>•</b></span></span><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="color: white; font-size: 14px;"> </span></span></b></span></span></span></b></span></span><span style="background-color: transparent; text-align: left;"><span style="color: white; font-family: Comfortaa; font-size: medium;"><b>Do thiếu hút kinh phí nên quảng cáo có thể gây khó chịu, rất mong các bạn thông cảm!</b></span></span></p>
                <p style="background-color: #404040; margin: 0px;"><span style="background-color: transparent; text-align: left;"><span style="color: white; font-family: Comfortaa; font-size: medium;"><span face="Comfortaa, sans-serif" style="color: black; font-size: medium; font-weight: 900;"><span style="font-family: Comfortaa;"><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="font-size: medium;"><span><span new="" roman="" style="color: black; font-size: 14px;" times=""><span style="color: #ff00fe;"><b>•</b></span></span><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="color: white; font-size: 14px;"></span></span></b></span></span></span></b></span></span><span face="Comfortaa, sans-serif" style="background-color: transparent; color: black; font-size: medium; font-weight: 900;"><span style="font-family: Comfortaa;"><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="font-size: medium;"><span style="color: white;">Theo </span></span></span></b></span></span><span face="Comfortaa, sans-serif" style="background-color: transparent; color: black; font-size: medium; font-weight: 900;"><span style="font-family: Comfortaa;"><b -webkit-center="" new="" roman="" text-align:="" times=""><span lang="VI" style="line-height: 17.12px;"><span style="font-size: medium;"><span style="color: white;">dõi Fanpage nhận lịch chiếu phim tại </span></span></span></b></span></span><a href="https://www.facebook.com/motanime247/" rel="noopener" style="background-color: transparent; box-sizing: border-box; font-family: Comfortaa, sans-serif; font-size: medium; font-weight: 900; text-decoration-line: none;" target="_blank"><span style="color: #ff00fe; font-size: medium;">[....Đây....]</span></a></span></span></p>
            </center>
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <?php require_once(ROOT_DIR . '/view/slider.php'); ?>
            <!--            
                       <div class="ah-frame-bg">
                        
                        <div>
                            <p><strong></strong></p>
                            <center><p><strong><span style="color:#FFA500">Ủng hộ chúng mình 1 ly trà đá bằng cách Click vào quảng cáo phía dưới nhé!</span></strong></p></center>
                            <br>
                            <script src="https://www.vipads.live/vn/c-107-25.js"></script>
                            <p></p>
                        </div>
                    </div>
-->
            <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    Mới cập nhật
                </div>
                <div class="margin-r-5 fw-500">
                    <a href="/the-loai/anime.html" class="bg-red padding-5-10 border-default border-radius-5"><?= get_data_multi('name', "category", "id = '1'") ?></a>
                    <a href="/the-loai/cn-animation.html" class="bg-blue padding-5-10 border-default border-radius-5"><?= get_data_multi('name', "category", "id = '18'") ?></a>

                </div>
            </div>
            <div class="movies-list ah-frame-bg">
                <?php
                $PAGE = CheckPages('movie', "WHERE public = 'true'", 30, 1);
                if ($PAGE['total'] >= 1) {
                    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' ORDER BY timestap DESC LIMIT {$PAGE['start']},30");
                    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                        if ($row['loai_phim'] == 'Phim Lẻ') {
                            $statut = "{$row['movie_duration']} Phút";
                        } else $statut = "$NumEpisode/{$row['ep_num']}";

                ?>
                        <div class="movie-item" id="movie-id-3300">
                            <a href="<?= URL ?>/thong-tin-phim/<?= $row['slug'] ?>.html" title="<?= $row['name'] ?>">
                                <div class="episode-latest">
                                    <span>
                                        <?= $statut ?>
                                    </span>
                                </div>
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
                            <?= ShowFollow($row['id']) ?>
                        </div>
                <?php }
                } ?>
            </div>
            <?= view_pages($PAGE['total'], 30, 1, URL . "/phim-moi-cap-nhap.html?p=") ?>

            <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    Lịch Chiếu Phim
                </div>
            </div>
            <div class="bg-black w-100-percent flex-column">
                <div class="tab-lichchieu flex-1" style="border: 1px solid #ffffff;">
                    <?php
                    for ($i = 2; $i < 9; $i++) {
                        $NameLich = ($i < 8 ? "Thứ $i" : "Chủ Nhật");
                        echo '<a href="javascript:LoadLichChieu(' . $i . ');" class="lichchieu" id="thu-' . $i . '">
                                    <div class="item-label">' . $NameLich . '</div>
                                </a>';
                    }
                    ?>
                </div>
            </div>
            <div class="movies-list ah-frame-bg" id="LichChieuPhim"></div>

            <div class="margin-10-0 bg-gray-2 flex flex-space-auto">
                <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                    Đề Cử
                </div>
            </div>
            <style>
                .active {
                    box-shadow: 0 0 5px #eee;
                }

                .nominations-change {
                    background-color: #242525;
                    margin-right: 5px;
                    border: 1px solid #645e5e;
                    display: inline-block;
                    margin-bottom: 5px;
                }
            </style>
            <div class="flex-1" style="margin-bottom: 10px;">
                <?php
                $genre_id = 0;
                $genre_slug = '';
                foreach (json_decode($cf['nominations_category'], true) as $k => $v) {
                    $name = get_data_multi('name', 'category', "id = '{$v['id']}'");
                    if ($k == 0) {
                        $genre_id = $v['id'];
                        $genre_slug = get_data_multi('slug', 'category', "id = '{$v['id']}'");
                    }
                    echo '<a href="javascript:void(0);" data-id="' . $v['id'] . '" class="nominations-change padding-5-10 border-radius-5 ' . ($k == 0 ? 'active' : '') . '">' . $name . '</a>';
                }
                ?>
            </div>
            <div class="movies-list ah-frame-bg" id="nominations_movie">
                <?php
                if (get_total('movie', "WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"$genre_id\"%'") >= 1) {
                    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND cate LIKE '%\"cate_id\":\"$genre_id\"%' ORDER BY timestap DESC LIMIT 10");
                    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
                        $statut = ($row['loai_phim'] == 'Phim Lẻ' ? "{$row['movie_duration']} Phút" : "$NumEpisode/{$row['ep_num']}");
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
                                <div class="name-movie" style="color:#fffdfd;">
                                    <?= $row['name'] ?>
                                </div>
                            </a>
                            <?= ShowFollow($row['id']) ?>
                        </div>
                <?php }
                } else ''; ?>
            </div>
            <div>
                <style>
                    .viewall {
                        position: relative;
                        margin: 0 0 10px 0;
                        text-align: center;
                        display: block;
                        text-transform: uppercase;
                        font-size: 18px;
                        padding: 5px;
                        background: #404040;
                    }
                </style>
                <a class="viewall" href="<?= URL ?>/the-loai-de-cu/<?= $genre_slug ?>.html">Xem Thêm....</a>
            </div>
            <script type="text/javascript">
                $('.nominations-change').click(function() {
                    var _this = $(this);
                    if (_this.hasClass('active')) {
                        return;
                    }
                    $('.nominations-change').removeClass('active');
                    _this.addClass('active');
                    var genre_id = _this.attr('data-id'),
                        nominations_movie = $('#nominations_movie');
                    nominations_movie.html(`<h4>Đang tải....</h4>`);
                    $.post('/server/ajax/phim-de-cu', {
                        genre_id
                    }).done(function(data) {
                        if (data.status != 'success') {
                            nominations_movie.html(`<h4 style="color: red;">${data.result}</h4>`);
                            return;
                        }
                        $('.viewall').attr('href', `<?= URL ?>/the-loai-de-cu/${data.genre}.html`);
                        nominations_movie.html(data.result);
                    });
                });
            </script>
            <?php if ($cf['cmt_on'] == 'true') { ?>
                <style>
                    .my-rank-profile {
                        max-width: 100%;
                        word-break: break-all;
                        background-color: #333333;
                        border-radius: 15px;


                    }
                </style>
                <div class="margin-10-0 bg-black flex flex-space-auto" style="border-radius: 15px;height: 40px;">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex flex-hozi-center">
                        <button type="button" name="boxchat" onclick="btn_load_home(this,'LoadComment','Boxchat');" class="padding-5-10 btn-grad">BoxChat (<?= number_format(get_total('comment', "WHERE movie_id = 'all'")) ?>)</button>
                    </div>
                    <div class="margin-r-5 fw-500">
                        <button type="button" name="top" onclick="btn_load_home(this,'top_bxh','TOP');" class="padding-5-10 btn-grad">TOP</button>
                        <button type="button" name="huong_dan" onclick="btn_load_home(this,'huong_dan','Hướng Dẫn');" class="padding-5-10 btn-grad">Hướng Dẫn</button>
                    </div>
                </div>
                <style>
                    /* css test  */
                    .chat_div {
                        width: 70%;
                    }

                    .desc {
                        display: flex;
                    }
                </style>
                <div class="desc ah-frame-bg">
                    <ul class="chat_div " style="display: block;list-style: none outside none;height: 200px" id="HomeChatList">
                        <div class="home-status">Không Có Comment Nào</div>
                    </ul>
                    <ul style="display: block;list-style: none outside none;height: 440px;overflow: auto;" id="HomeListTop">
                        <!-- // test html  -->
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top1.png">
                                    <div class="top-rank">#TOP 1</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=test12345" width="100" height="100" alt="test12345">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">test12345</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 3</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top2.png">
                                    <div class="top-rank">#TOP 2</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=thinhbo" width="100" height="100" alt="thinhbo">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">thinhbo</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 2</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top3.png">
                                    <div class="top-rank">#TOP 3</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=peterng" width="100" height="100" alt="peterng">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">peterng</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 1</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top3.png">
                                    <div class="top-rank">#TOP 3</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=peterng" width="100" height="100" alt="peterng">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">peterng</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 1</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top3.png">
                                    <div class="top-rank">#TOP 3</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=peterng" width="100" height="100" alt="peterng">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">peterng</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 1</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <li class="home-rank">
                            <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                                <div class="stt-rank">
                                    <img src="/themes/img/top3.png">
                                    <div class="top-rank">#TOP 3</div>
                                </div>
                                <div class="image-container-rank">
                                    <img class="image-rank-home" src="https://ui-avatars.com/api/?background=random&amp;name=peterng" width="100" height="100" alt="peterng">
                                    <span class="rank-level">Lv 1</span>
                                    <span class="level-icon-rank" data-tooltip="Thối Thể">
                                        <img style="border-radius: 5px;" src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEin1mIUksb6MkOMIMnd5OXRh45lfuo709-III7RIonwXtOSdp7GrKVqgqgyrWzSymBYoLpV7pvGBp9Ulx36007Y32YmOOIsupeGtdO12gfyBrKuLBKLpEJkjJKopCCC4DzaZ6I5bemITmc5l2P3d95jKYNxNFT3MI9ba9oY3ca0jW0-FYugc4hOSoii/s2000/nha" width="20" height="20" alt="Thối Thể">
                                    </span>
                                </div>
                                <div class="rank-info">
                                    <span class="rank-text" style="color: #c86432;">peterng</span>
                                    <span class="rank-text" style="color: #c86432;">Exp : 1</span>
                                    <span class="rank-text" style="color: #c86432;">Cảnh Giới : Thối Thể</span>
                                    <span class="rank-text" style="color: #c86432;">Icon : </span>
                                </div>
                            </div>
                        </li>
                        <!-- // end-test html  -->
                    </ul>
                </div>
                <?php
                if ($_author_cookie) {
                    $cache_key = "cache.BangXepHangProfile_" . $user['id'];
                    if (!$InstanceCache->has($cache_key)) {
                        $Top = 0;
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "user ORDER BY level DESC");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                            $Top++;

                            if ($Top == 1) {
                                $TopImage = "/themes/img/top1.png";
                            } else if ($Top == 2) {
                                $TopImage = "/themes/img/top2.png";
                            } else if ($Top == 3) {
                                $TopImage = "/themes/img/top3.png";
                            } else if ($Top == 4) {
                                $TopImage = "/themes/img/top4.png";
                            } else if ($Top == 5) {
                                $TopImage = "/themes/img/top5.png";
                            } else $TopImage = "/themes/img/out_top.png";

                            if ($row['id'] == $user['id']) {
                                echo '<div class="flex flex-hozi-center" id="BangXepHangProfile" style="display: none;">
                                                <div class="stt-rank">
                                                    <img src="' . $TopImage . '">
                                                    <div class="top-rank">#TOP ' . $Top . '</div>
                                                </div>
                                                <div class="image-container-rank">
                                                    <img class="image-rank-home" src="' . $row['avatar'] . '" width="100" height="100" alt="' . $row['nickname'] . '">
                                                    <span class="rank-level">Lv ' . $row['level'] . '</span>
                                                    ' . RankIcon($row['level']) . '
                                                </div>
                                                <div class="rank-info">
                                                    <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">' . $row['nickname'] . '</span>
                                                    <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Exp : ' . number_format(LevelExp($row['level'], $row['exp'])) . '</span>
                                                    <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Cảnh Giới : ' . Danh_Hieu($row['level']) . '</span>
                                                    <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Icon : ' . UserIcon($row['id'], 18, 18) . '</span>
                                                </div>
                                            </div>';
                                break;
                            }
                        }
                        $InstanceCache->set($cache_key, $MyRank, $cf['time_cache'] * 3600);
                    } else echo $InstanceCache->get($cache_key);
                } ?>
                <div class="row">
                    <div class="flex" id="box-comment">
                        <script type="text/javascript" src="/themes/js_ob/fgEmojiPicker.js?v=1.7.4"></script>
                        <textarea class="comment-home" onkeydown="if(event.keyCode == 13) CommentHome();" name="HomeComment" placeholder="Nhập Bình Luận Của Bạn Vào Đây........" rows="3" maxlength="5000"></textarea>
                        <button class="icon-home-comment" type="button" id="IconCommentHome"><span class="material-icons-round">emoji_emotions</span></button>
                        <button type="button" onclick="CommentHome();" name="CommentButton" class="button-home-comment">Gửi <img src="/themes/img/message.png" width="25" height="25"></button>
                    </div>
                </div>
        </div>
        <script>
            var btn_load_home = function(btn, action, txt) {
                if (action != 'LoadComment') {
                    // $('#box-comment').hide();
                    $('#box-comment').show();
                } else {
                    $('#box-comment').show();
                }
                if ($(btn).hasClass("btn-active")) {
                    return;
                }
                $('.btn-grad').removeClass('btn-active');
                $(btn).addClass('btn-active');
                LoadHome(action);
            }
            BoxChatLoad();
            new FgEmojiPicker({
                trigger: ['#IconCommentHome'],
                position: ['bottom', 'right'],
                emit(obj, triggerElement) {
                    const emoji = obj.emoji;
                    //var result = $('.comment-home').val() + `&#x${emoji.codePointAt(0).toString(16)};`;
                    var result = $('.comment-home').val() + emoji;
                    $('.comment-home').val(result)
                }
            });
        </script>
    <?php } ?>

    </div>
    <script>
        LoadLichChieu(<?= sw_get_current_weekday() ?>);
    </script>
    <?= PopUnder('pop_under_home') ?>
    <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>