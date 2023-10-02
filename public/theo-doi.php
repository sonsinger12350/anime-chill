<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
FireWall();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    $title = "Tủ Phim Bạn Đang Theo Dõi - {$cf['title']}";
    $description =  "Tủ Phim Bạn Đang Theo Dõi - {$cf['title']}";
    require_once(ROOT_DIR . '/view/head.php');
    ?>
    <style>
		.display_axios .pagination {
			list-style: none;
		}
		
		.display_axios .pagination .pagination-item.active a {
			background-color: #4caf50;
		}
    </style>
</head>

<body class="scroll-bar">
    <div id="fb-root"></div>
    <div id="ah_wrapper">
        <?php require_once(ROOT_DIR . '/view/header.php'); ?>
        <div class="ah_content">
            <?php require_once(ROOT_DIR . '/view/top-note.php'); ?>
            <div class="ah_follows">
                <div class="margin-10-0 bg-brown flex flex-space-auto">
                    <div class="fs-17 fw-700 padding-0-20 color-gray inline-flex height-40 flex-hozi-center bg-black border-l-t">
                        <h3 class="section-title"><span>Phim bạn theo dõi</span></h3>
                    </div>
                </div>
                <div class="display_axios ah-frame-bg">
                    <div class="ah_loading">
                        <div class="lds-ellipsis">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                var run_ax = true;
                (() => {
                    document.addEventListener("DOMContentLoaded", function(event) {
                        showMovieFollow(0);
                    });
                })();
                $('body').on('click', '.movie-follow-pagination', function() {
                    if ($(this).parent().hasClass('active')) {
                        return false;
                    }

                    let page = $(this).attr('data-page');
                    showMovieFollow(page);
                });
                async function showMovieFollow(page) {
                    try {
                        let movie_follow = document.getElementsByClassName('display_axios')[0];
                        let response = await loadFollowmovie(page);
                        let data = response.data;
                        movie_follow.innerHTML = data;
                    } catch (e) {
                        console.log(e)
                    }
                    $user.id && asyncFollow();
                }
                asyncFollow = async () => {
                    let local_store = localStorage.getItem("data_follow");
                    let data_follow_store = local_store ? JSON.parse(local_store) : [];
                    var check_async_follow = localStorage.getItem("async_follow");
                    await securityCode();
                    if (!check_async_follow) {
                        await axios.post('/server/api', {
                            "action": 'async_follow',
                            "token": $dt.token,
                            "data_follow": JSON.stringify(data_follow_store),
                        }).then(reponse => {
                            run_ax = true;
                            if (reponse.data == "success") {
                                localStorage.setItem("async_follow", true);
                                let success = document.createElement("div");
                                let el_ah_follows = document.getElementsByClassName("ah_follows")[0];
                                success.setAttribute('class', 'noti-success');
                                success.innerHTML = 'Đồng bộ phim theo dõi lưu trên trình duyệt sang tài khoản thành công!';
                                el_ah_follows.insertBefore(success, el_ah_follows.childNodes[2]);
                                location.reload();
                            }
                        }).catch(e => run_ax = true)
                    }
                }
                loadFollowmovie = (page = 0) => {
                    let local_store = localStorage.getItem("data_follow");
                    let data_follow_store = local_store ? JSON.parse(local_store) : [];
                    return axios.post(
                        '/server/api', {
                            "action": "data_follow",
                            "data_follow": JSON.stringify(data_follow_store),
                            "page_now": page,
				            "screen_width": screen.width,
                        }
                    );
                }

                followGuestmovie = (e, movie_id) => {
                    let local_store = localStorage.getItem("data_follow");
                    let data_follow_store = local_store ? JSON.parse(local_store) : [];
                    var index_this_movie = data_follow_store.indexOf(movie_id);
                    if (index_this_movie !== -1) {
                        data_follow_store.splice(index_this_movie, 1);
                        e.target.parentNode.remove();
                        Toast({
                            message: "Xoá theo dõi thành công!",
                            type: "success"
                        });
                    }
                    localStorage.setItem("data_follow", JSON.stringify(data_follow_store));
                }
                delFollowmovie = (e, movie_id) => {
                    e.preventDefault();
                    if (!$user.id) {
                        followGuestmovie(e, movie_id)
                    } else {
                        if (run_ax) {
                            run_ax = false;
                            axios.post('/server/api', {
                                "action": 'del_follow',
                                "movie_id": movie_id,
                            }).then(reponse => {
                                run_ax = true;
                                if (reponse.data == "success") {
                                    followGuestmovie(e, movie_id)
                                } else {
                                    alert('Xoá theo dõi thất bại, thử lại sau!');
                                }
                            }).catch(e => run_ax = true)
                        }
                    }

                }
            </script>

        </div>
        <?= PopUnder('pop_under_home') ?>
        <?php require_once(ROOT_DIR . '/view/footer.php'); ?>
    </div>
</body>

</html>