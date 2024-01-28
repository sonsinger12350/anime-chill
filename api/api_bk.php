<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
HeaderApplication();
$Json = InputJson();
if ($Json['action'] == 'live_search') {
    $kw = sql_escape($Json['keyword']);
    $kw = chuyenslug($kw);
    $CheckMovie = get_total('movie', "WHERE public = 'true' AND name LIKE '%$kw%' OR slug LIKE '%$kw%'");
    if ($CheckMovie < 1) die(json_encode(array(
        "data" => "<div class='padding-10'>Không tìm thấy phim theo từ khoá</div>",
        "result" => null,
        "status" => "failed"
    )));
    $cache_key = "cache.Search_$kw";
    if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
    $data = array();
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE public = 'true' AND name LIKE '%$kw%' OR slug LIKE '%$kw%' ORDER BY id DESC LIMIT 30");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $NumEpisode = ($row['ep_hien_tai'] ? $row['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$row['id']}'"));
        if ($row['loai_phim'] == 'Phim Lẻ') {
            $statut = "{$row['movie_duration']} Phút";
        } else {
            $statut = "$NumEpisode/{$row['ep_num']}";
        }
        $data['data'] = '<a href="' . URL . '/thong-tin-phim/' . $row['slug'] . '.html"><div class="row_one"><img src="' . $row['image'] . '"></div><div class="row_two"><span class="fw-500">' . $row['name'] . '</span> <span class="fs-12 margin-t-5">' . $statut . '</span></div></a>';
        $data['result'] = '<a href="' . URL . '/thong-tin-phim/' . $row['slug'] . '.html"><div class="row_one"><img src="' . $row['image'] . '"></div><div class="row_two"><span class="fw-500">' . $row['name'] . '</span> <span class="fs-12 margin-t-5">' . $statut . '</span></div></a>';
    }
    $data['status'] = 'success';
    $InstanceCache->set($cache_key, json_encode($data), $cf['time_cache'] * 3600);
    die(json_encode($data));
} elseif ($Json['action'] == 'add_rate') {
    if ($_author_cookie) {
        if ($user['banned'] == 'true') die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }
    $movie_id = sql_escape($Json['movie_id']);
    $rating = sql_escape($Json['rating']);

    if (!json_decode($_COOKIE['vote'], true)[$movie_id]) {
        $ServerJson = array(
            "result" => "Vote Thành Công",
            "status" => "success"
        );
        setcookie('vote', json_encode(array($movie_id => $rating)), time() + 48000, '/');
        $mysql->update("movie", "vote_point = vote_point + '$rating',vote_all = vote_all + 1", "id = '$movie_id'");
    } else {
        $ServerJson = array(
            "result" => "Bạn Đã Vote Phim Này Rồi",
            "status" => "failed"
        );
    }

    die(json_encode($ServerJson));
} else if ($Json['action'] == 'data_history') {
    $History .= '<div class="watch-history ah-frame-bg">';
    $HisCheck = 0;

    foreach (json_decode($Json['data_history'], true) as $key => $value) {
        $MovieID = sql_escape($value['movie_id']);
        $EpisodeID = sql_escape($value['no_ep']);
        if (get_total("movie", "WHERE id = '$MovieID'") >= 1) {
            if (get_total("episode", "WHERE ep_name = '$EpisodeID' AND movie_id = '$MovieID'") >= 1) {
                $HisCheck++;
                $Movie = GetDataArr("movie", "id = '$MovieID'");
                $Ep = GetDataArr("episode", "ep_name = '$EpisodeID' AND movie_id = '$MovieID'");
                $History .= '<div class="item">
                <a href="' . URL . '/xem-hhchina/' . $Movie['slug'] . '-episode-id-' . $MovieID . '.html">
                <div>
                <img src="' . $Movie['image'] . '" />
                </div>
                <div>
                <div>' . $Movie['name'] . '</div><div>Bạn đã xem tập ' . $Ep['ep_name'] . '</div>
                </div>
                </a>
                </div>';
            }
        }
    }

    if ($HisCheck == 0) {
        $History .= '<div class="ah_noti">Lịch sử trống</div>';
    }
    $History .= '</div>';
    echo $History;
} else if ($Json['action'] == 'data_follow') {
    $HTML_DATA .= '<div class="movies-list">';
    $HisCheck = 0;
    $page_limit = !empty($Json['limit']) ? $Json['limit'] : 9;

    if (!$_author_cookie) {
        $list_id = json_decode($Json['data_follow'], true);

        if (empty($list_id)) {
            $HTML_DATA .= '<div class="ah_noti">Bạn Chưa Theo Dõi Bộ Phim Nào</div>';
            $HTML_DATA .= '</div>';
            die($HTML_DATA);
        }

        $id_chunk = array_chunk($list_id, $page_limit, true);
        $pagination = array_keys($id_chunk);
        $activePage = !empty($Json['page']) ? $Json['page']-1 : 0;
        $id_query = $id_chunk[$activePage];

        foreach ($id_query as $key => $value) {
            $MovieID = sql_escape($value);
            if (get_total("movie", "WHERE id = '$MovieID'") >= 1) {
                $HisCheck++;
                $Movie = GetDataArr("movie", "id = '$MovieID'");
                $NumEpisode = ($Movie['ep_hien_tai'] ? $Movie['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$Movie['id']}'"));
                if ($Movie['loai_phim'] == 'Phim Lẻ') {
                    $statut = "{$Movie['movie_duration']} Phút";
                } else $statut = "$NumEpisode/{$Movie['ep_num']}";

                $HTML_DATA .= '<div class="movie-item" movie-id="' . $MovieID . '">
                                    <a class="delete" href="#" onclick="delFollowmovie(event,' . $MovieID . ')">X</a>
                                    <a href="' . URL . '/thong-tin-phim/' . $Movie['slug'] . '.html" title="' . $Movie['name'] . '">
                                        <div class="episode-latest">
                                            <span>' . $statut . '</span>
                                        </div>
                                        <div>
                                            <img src="' . $Movie['image'] . '" alt="' . $Movie['name'] . '" />
                                        </div>
                                        <div class="score">
                                            ' . Voteting($Movie['vote_point'], $Movie['vote_all']) . '
                                        </div>
                                        <div class="name-movie">
                                        ' . $Movie['name'] . '
                                        </div>
                                    </a>
                                </div>';
            }
        }
    } else if (isset($_author_cookie)) {
        $arr = $mysql->query("SELECT `movie_save`, `movie_save` FROM " . DATABASE_FX . "history WHERE user_id = '{$user['id']}' ORDER BY id DESC");
        $list_id = $arr->fetchAll(PDO::FETCH_KEY_PAIR);

        if (empty($list_id)) {
            $HTML_DATA .= '<div class="ah_noti">Bạn Chưa Theo Dõi Bộ Phim Nào</div>';
            $HTML_DATA .= '</div>';
            die($HTML_DATA);
        }

        $id_chunk = array_chunk($list_id, $page_limit, true);
        $pagination = array_keys($id_chunk);
        $activePage = !empty($Json['page_now']) ? $Json['page_now'] : 0;
        $id_query = $id_chunk[$activePage];
        
        foreach ($id_query as $id) {
            $HisCheck++;
            $Movie = GetDataArr("movie", "id = '{$id}'");
            $NumEpisode = ($Movie['ep_hien_tai'] ? $Movie['ep_hien_tai'] : get_total("episode", "WHERE movie_id = '{$Movie['id']}'"));
            if ($Movie['loai_phim'] == 'Phim Lẻ') {
                $statut = "{$Movie['movie_duration']} Phút";
            } else $statut = "$NumEpisode/{$Movie['ep_num']}";
            $HTML_DATA .= '<div class="movie-item" movie-id="' . $id . '">
                <a class="delete" href="#" onclick="delFollowmovie(event,' . $id . ')">X</a>
                <a href="' . URL . '/thong-tin-phim/' . $Movie['slug'] . '.html" title="' . $Movie['name'] . '">
                    <div class="episode-latest">
                        <span>' . $statut . '</span>
                    </div>
                    <div>
                        <img src="' . $Movie['image'] . '" alt="' . $Movie['name'] . '" />
                    </div>
                    <div class="score">
                        ' . Voteting($Movie['vote_point'], $Movie['vote_all']) . '
                    </div>
                    <div class="name-movie">
                    ' . $Movie['name'] . '
                    </div>
                </a>
            </div>';
        }
    }

    if ($HisCheck == 0) {
        $HTML_DATA .= '<div class="ah_noti">Bạn Chưa Theo Dõi Bộ Phim Nào</div>';
    }

    $HTML_DATA .= '</div>';
    if (!empty($pagination) && count($pagination) > 1) {
        $totalPage = count($pagination);
        $HTML_DATA .= '<ul class="pagination">';

        if ($totalPage > 5) {
            if ($activePage > 2 ) {
                $HTML_DATA .= '
                <li class="pagination-item '.($activePage==$page ? 'active' : '').'">
                    <a href="javascript:void(0)" class="movie-follow-pagination" data-page="0"><i class="fa-solid fa-angles-left"></i></a>
                </li>
                ';
            }
            $count = 0;
            foreach ($pagination as $page) {
                if ($count == 5) {
                    break;
                }

                if ($activePage >= 3) {
                    if ($page > ($activePage-3)) {
                        $HTML_DATA .= '
                        <li class="pagination-item '.($activePage==$page ? 'active' : '').'">
                            <a href="javascript:void(0)" class="movie-follow-pagination" data-page="'.$page.'">'.($page+1).'</a>
                        </li>
                        ';
                        $count++;
                    }
                } else {
                    $HTML_DATA .= '
                    <li class="pagination-item '.($activePage==$page ? 'active' : '').'">
                        <a href="javascript:void(0)" class="movie-follow-pagination" data-page="'.$page.'">'.($page+1).'</a>
                    </li>
                    ';
                    $count++;
                }
            }

            if ($activePage <= ($totalPage-2) ) {
                $HTML_DATA .= '
                <li class="pagination-item '.($activePage==$page ? 'active' : '').'">
                    <a href="javascript:void(0)" class="movie-follow-pagination" data-page="'.end($pagination).'"><i class="fa-solid fa-angles-right"></i></a>
                </li>
                ';
            }
        } else {
            foreach ($pagination as $page) {
                $HTML_DATA .= '
                <li class="pagination-item '.($activePage==$page ? 'active' : '').'">
                    <a href="javascript:void(0)" class="movie-follow-pagination" data-page="'.$page.'">'.($page+1).'</a>
                </li>
                ';
            }
        }

        $HTML_DATA .= '</ul>';
    }

    die($HTML_DATA);
} else if ($Json['action'] == 'upload_avatar') {
    if ($user['banned'] == 'true') die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    if ($_COOKIE["success_avt"]) die(json_encode(["result" => "Để Tránh Spam Vui Lòng Thử Lại Sau 2 Tiếng", "status" => "failed"]));
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => "Token Hết Thời Hạn ", "status" => "failed"]));
    $Uploader = imagesaver($Json['base64']);
    if (!$Uploader) die(json_encode(["result" => "Upload Ảnh Không Thành Công , Thử Lại Sau", "status" => "failed"]));
    $mysql->update("user", "avatar = '$Uploader'", "email = '$useremail'");
    setcookie("success_avt", "success", time() + (2 * 3600));
    die(json_encode(["result" => "Tải Ảnh Lên Thành Công", "status" => "success"]));
} else if ($Json['action'] == 'load_comments') {
    if ($cf['cmt_on'] == 'false') die(json_encode(["result" => "Chức Năng Comment Đang Tắt", "status" => "failed"]));
    //if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $get_type = sql_escape($Json['get_type']);
    $id_load_more = sql_escape($Json['id_load_more']);
    if ($id_load_more < 1) {
        $CurenPage = 1;
    } else $CurenPage = $id_load_more;

    $limit = isset($Json['limit']) ? sql_escape($Json['limit']) : 6;
    $movie_id = sql_escape($Json['movie_id']);
    $token = sql_escape($Json['token']);

    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => "Token Hết Thời Hạn ", "status" => "failed"]));
    if (get_total('movie', "WHERE id = $movie_id") < 1) die(json_encode(["result" => "Phim Không Tồn Tại", "status" => "failed"]));
    $P = CheckPages('comment', "WHERE movie_id = '$movie_id' AND show_cmt = 'true' AND reply_comment IS NULL", $limit, $CurenPage);

    if ($P['total'] >= 1) {
        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "comment WHERE movie_id = '$movie_id' AND show_cmt = 'true' AND reply_comment IS NULL ORDER BY id DESC LIMIT {$P['start']},$limit");
        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
            $User_Arr = GetDataArr("user", "id = '{$row['user_id']}'");
            if (get_total('user', "WHERE id = '{$row['user_id']}'") < 1) {
                $mysql->delete('comment', "user_id = '{$row['user_id']}'");
            }
            if ($row['user_id'] == $user['id']) {
                $CmtSetting = '<div class="flex flex-hozi-center relative"><a href="javascript:void(0)" onclick="clickEventDropDown(this,\'expand_more\')" class="toggle-dropdown fs-21 inline-flex" bind="drop-down-oc-' . $row['id'] . '"><span class="material-icons-round">expand_more</span></a>
                                    <div id="drop-down-oc-' . $row['id'] . '" class="dropdown-option bg-black">
                                        <div onclick="showFrameEditComment(' . $row['id'] . ',\'comment_main\')"><span class="material-icons-round margin-0-5">
                                                edit
                                            </span>Sửa</div>
                                        <div onclick="optionComment({id_comment:' . $row['id'] . ',perform:\'hide\',type_comment:\'comment_main\'})"><span class="material-icons-round margin-0-5">
                                                hide_source
                                            </span>Ẩn</div>
                                    </div>
                                </div>';
            } else $CmtSetting = "";
            if (isset($_author_cookie)) {
                $ShowReply = '<a href="javascript:void(0)" onclick="showFrameReplyComment(' . $row['id'] . ',\'' . $User_Arr['nickname'] . '\',' . $row['user_id'] . ',\'0068c15cfb8ec6a0060b94d9def64ea0\')" class="margin-r-5">Trả lời</a>';
                $ShowReply1 = '<div id="toggle_frame_comment_' . $row['id'] . '"></div>';
            } else {
                $ShowReply = "";
                $ShowReply1 = "";
            }
            $Comment .= '<div id="comment_' . $row['id'] . '" class="user-comment relative">
                            <div class="flex bg-comment">
                                <div class="left" onclick="initViewProfile(' . $row['user_id'] . ')">
                                    <div class="avatar">
                                        <img class="avatar-img" src="' . $User_Arr['avatar'] . '">
                                        <img class="avatar-frame" src="'.getIconStoreActive($User_Arr['id'], 'khung-vien').'">
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="flex flex-column">
                                        <div class="flex flex-space-auto">
                                            <div class="flex flex-hozi-center">
                                                <div class="nickname">' . $User_Arr['nickname'] . LevelIcon($User_Arr['level'], 18, 18) . UserIcon($User_Arr['id'], 18, 18) . '</div>
                                                <div class="color-red fw-700 fs-12" style="color:' . LevelColor($User_Arr['level']) . '"> Lv.' . $User_Arr['level'] . ' </div>
                                            </div>
                                            ' . $CmtSetting . '
                                        </div>
                                        <div class="content">' . $row['content'] . '</div>
                                        <div class="flex fs-12"> 
                                            ' . $ShowReply . '
                                            <div> ' . RemainTime($row['timestap']) . ' </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="feedback_' . $row['id'] . '" class="frame-reply-comments">
                                    ' . ShowReplyComment($row['id']) . '
                        </div>' . $ShowReply1;
        }

        $total = ceil($P['total'] / $limit);
        if ($total > $CurenPage) {
            $Comment .= '<div class="flex flex-ver-center fw-700 load-more button-default bg-blue" onclick="loadComments({id_load_more:' . ($CurenPage + 1) . ',element_append:this})"><a href="javascript:void(0)">Tải thêm bình luận</a></div>';
        }
    }
    die(json_encode(["result" => $Comment, "status" => "success", "total" => $total]));
} else if ($Json['action'] == 'add_comment') {
    if ($cf['cmt_on'] == 'false') die(json_encode(["result" => "Chức Năng Comment Đang Tắt", "status" => "failed"]));
    if ($user['banned'] == 'true') die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $content = htmlchars_cmt(injection(urldecode($Json['content'])));
    if (!$content) die(json_encode(["result" => "Nội Dung Comment Không Được Để Trống", "status" => "failed"]));
    if (strlen($content) > 1000) die(json_encode(["result" => "Nội Dung Comment Quá Dài", "status" => "failed"]));
    if (isset($_COOKIE['add_comments'])) {
        setcookie("add_comments", $user['nickname'], time() + 20);
        die(json_encode(["result" => "Vui Lòng Thực Hiện Sau 20s, Càng Ấn Nhiều Đợi Càng Lâu", "status" => "failed"]));
    }
    $movie_id = sql_escape($Json['movie_id']);
    $reply_comment_id = sql_escape($Json['reply_comment_id']);
    $reply_user_id = sql_escape($Json['reply_user_id']);
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => "Token Hết Thời Hạn ", "status" => "failed"]));
    if ($movie_id != 'all') {
        if (get_total('movie', "WHERE id = $movie_id") < 1) die(json_encode(["result" => "Phim Không Tồn Tại", "status" => "failed"]));
    }
    if ($reply_comment_id >= 1) {
        if (get_total('comment', "WHERE id = $reply_comment_id") < 1) die(json_encode(["result" => "Bình Luận Không Tồn Tại", "status" => "failed"]));
    }

    if ($reply_user_id >= 1) {
        if (get_total('user', "WHERE id = $reply_user_id") < 1) die(json_encode(["result" => "Thành Viên Không Tồn Tại", "status" => "failed"]));
    }

    if ($reply_comment_id >= 1 && $reply_user_id >= 1) {
        $mysql->insert('comment', 'user_id,movie_id,content,reply_comment,reply_user_id,timestap,time', "'{$user['id']}','$movie_id','$content','$reply_comment_id','$reply_user_id','" . time() . "','" . DATEFULL . "'");
    } else $mysql->insert('comment', 'user_id,movie_id,content,timestap,time', "'{$user['id']}','$movie_id','$content','" . time() . "','" . DATEFULL . "'");
    if (!$_SESSION['add_comments']) setcookie("add_comments", $user['nickname'], time() + 20);
    $User_Arr = GetDataArr("user", "id = '{$user['id']}'");
    die(json_encode(["comment" => '<div id="comment_' . $User_Arr['id'] . '" class="user-comment relative">
            <div class="flex bg-comment">
                <div class="left" onclick="initViewProfile(' . $User_Arr['id'] . ')">
                    <div class="avatar">
                        <img class="avatar-img" src="' . $User_Arr['avatar'] . '">
                        <img class="avatar-frame" src="'.getIconStoreActive($User_Arr['id'], 'khung-vien').'">
                    </div>
                </div>
                <div class="right">
                    <div class="flex flex-column">
                        <div class="flex flex-space-auto">
                            <div class="flex flex-hozi-center">
                                <div class="nickname">' . $User_Arr['nickname'] . LevelIcon($User_Arr['level'], 18, 18) . UserIcon($User_Arr['id'], 18, 18) . '</div>
                                <div class="color-red fw-700 fs-12" style="color:' . LevelColor($User_Arr['level']) . '"> Lv.' . $User_Arr['level'] . ' </div>
                            </div>
                            <div class="flex flex-hozi-center relative"><a href="javascript:void(0)" onclick="clickEventDropDown(this,\'expand_more\')" class="toggle-dropdown fs-21 inline-flex" bind="drop-down-oc-' . $User_Arr['id'] . '"><span class="material-icons-round">expand_more</span></a>
                                <div id="drop-down-oc-' . $User_Arr['id'] . '" class="dropdown-option bg-black">
                                    <div onclick="showFrameEditComment(' . $User_Arr['id'] . ',\'comment_main\')"><span class="material-icons-round margin-0-5">
                                            edit
                                        </span>Sửa</div>
                                    <div onclick="optionComment({id_comment:' . $User_Arr['id'] . ',perform:\'hide\',type_comment:\'comment_main\'})"><span class="material-icons-round margin-0-5">
                                            hide_source
                                        </span>Ẩn</div>
                                </div>
                            </div>
                        </div>
                        <div class="content">' . $content . '</div>
                        <div class="flex fs-12"> <a href="javascript:void(0)" onclick="showFrameReplyComment(' . $User_Arr['id'] . ',\'' . $User_Arr['nickname'] . '\',' . $User_Arr['id'] . ',\'0068c15cfb8ec6a0060b94d9def64ea0\')" class="margin-r-5">Trả lời</a>
                            <div> 0 Phút Trước </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="feedback_' . $User_Arr['id'] . '" class="frame-reply-comments"></div>
        <div id="toggle_frame_comment_' . $User_Arr['id'] . '"></div>', "result" => "Gửi bình luận thành công!", "status" => "success"]));
} else if ($Json['action'] == 'option_comment') {
    if ($cf['cmt_on'] == 'false') die(json_encode(["result" => "Chức Năng Comment Đang Tắt", "status" => "failed"]));
    if ($user['banned'] == 'true') die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $content = htmlchars_cmt(injection(urldecode($Json['content'])));
    $id_comment = sql_escape($Json['id_comment']);
    $perform = sql_escape($Json['perform']);
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => "Token Hết Thời Hạn ", "status" => "failed"]));
    if (get_total('comment', "WHERE id = $id_comment AND user_id = '{$user['id']}'") < 1) die(json_encode(["result" => "Bình Luận Không Tồn Tại", "status" => "failed"]));
    if ($perform == 'edit') {
        $mysql->update('comment', "content = '$content'", "id = '$id_comment' AND user_id = '{$user['id']}'");
        die(json_encode(["result" => "Chỉnh Sửa Comment Thành Công", "status" => "success"]));
    } else if ($perform == 'hide') {
        $mysql->update('comment', "show_cmt = 'false'", "id = '$id_comment' AND user_id = '{$user['id']}'");
        die(json_encode(["result" => "Ẩn bình luận Thành công!", "status" => "success"]));
    }
} else if ($Json['action'] == 'get_profile') {
    $user_id = sql_escape($Json['user_id']);
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => "Token Hết Thời Hạn", "status" => "failed"]));
    if (get_total('user', "WHERE id = '$user_id'") < 1) die(json_encode(["result" => "Tài Khoản Không Tồn Tại", "status" => "failed"]));
    // $cache_key = "cache.Profile_$user_id";
    // if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
    $Profile = GetDataArr('user', "id = '$user_id'");
    if ($Profile['quote']) {
        $quote = $Profile['quote'];
    } else $quote = "Thanh Niên Này Chưa Cập Nhật Châm Ngôn Sống";

    $HTMLProfile = '<div class="flex flex-hozi-center border-style-2" style="">
                    <div class="avatar flex flex-column">
                        <div class="avatar-img">
                            <img class="avatar-image" src="' . $Profile['avatar'] . '">
                            <img class="avatar-frame" src="' . getIconStoreActive($Profile['id'], 'khung-vien') . '">
                        </div>
                    
                        <div class="level padding-5 align-center color-white" style="color:' . LevelColor($Profile['level']) . '">Lv.' . $Profile['level'] . '</div>
                    </div>
                    <div class="flex flex-column">
                        <div class="flex flex-hozi-center">
                            <span>ID:</span><span>#' . $Profile['id'] . '</span>
                        </div>

                        <div class="flex flex-hozi-center">
                            <span>Biệt danh:</span><span class="color-yellow">' . $Profile['nickname'] . LevelIcon($Profile['level'], 18, 18) . UserIcon($Profile['id'], 18, 18) . '</span>
                        </div>

                        <div class="flex flex-hozi-center">
                            <span>Tiền xu:</span><span>' . number_format($Profile['coins']) . '</span>
                        </div>

                        <div class="flex flex-hozi-center">
                            <span>Kinh nghiệm:</span><span>' . $Profile['exp'] . '/' . ($Profile['level'] * 30) . '</span>
                        </div>

                        <div class="flex flex-hozi-center">
                            <span>Ngày tham gia:</span><span>' . $Profile['time'] . '</span>
                        </div>

                        <div class="flex flex-hozi-center">
                            <span>Cảnh Giới:</span><span style="color:' . LevelColor($Profile['level']) . '">' . Danh_Hieu($Profile['level']) . '</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-ver-center color-green-2 fs-19 fw-700">
                ' . $quote . '
                </div>';
    // $InstanceCache->set($cache_key, json_encode(["result" => $HTMLProfile, "status" => "success"]), $cf['time_cache'] * 3600);
    die(json_encode(["result" => $HTMLProfile, "status" => "success"]));
} else if ($Json['action'] == 'load_notification') {
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => '<div class="padding-0-10 fw-500 fs-15">Token Hết Thời Hạn</div>', "status" => "success"]));
    if (!$_author_cookie) die(json_encode(["result" => '<div class="padding-0-10 fw-500 fs-15">Bạn Chưa Đăng Nhập Tài Khoản</div>', "status" => "success"]));
    if (get_total("notice", "WHERE user_id = '{$user['id']}'") < 1) die(json_encode(["result" => '<div class="padding-0-10 fw-500 fs-15">Chưa Có Thông Báo Nào</div>', "status" => "success"]));
    $Check = 0;
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "notice WHERE user_id = '{$user['id']}' ORDER BY id DESC LIMIT 10");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        if ($Check < 1) {
            $Check++;
        } else $Check++;
        if ($row['view'] == 'true') {
            $visited = 'visited';
        } else $visited = '';
        if ($row['time'] == DATE) {
            $HTML_NOTICE .= '<div onclick="javascript:window.location.href=\'/tin-nhan/view/' . $row['id'] . '?notif_id=' . $row['id'] . '\'" noti-id="' . $row['id'] . '" class="notification notification-comment flex flex-hozi-center ' . $visited . '">
                                <div class="avatar margin-r-5"><img src="https://i.imgur.com/JzGNfi6.png"></div>
                                <div class="flex flex-column flex-1">
                                    <div class="text-shortcut fw-700"><span class="color-red-2">Tin nhắn từ hệ thống</span></div>
                                    <div class="text-shortcut fs-12 fw-500 margin-5-0">' . $row['content'] . '</div>
                                    <div class="fs-12 fw-500 color-blue text-shortcut">' . RemainTime($row['timestap']) . '</div>

                                </div>
                            </div>';
        }
        if ($row['time'] != DATE) {
            $HTML_NOTICE .= '<div onclick="javascript:window.location.href=\'/tin-nhan/view/' . $row['id'] . '?notif_id=' . $row['id'] . '\'" noti-id="' . $row['id'] . '" class="notification notification-comment flex flex-hozi-center ' . $visited . '">
            <div class="avatar margin-r-5"><img src="https://i.imgur.com/JzGNfi6.png"></div>
            <div class="flex flex-column flex-1">
                <div class="text-shortcut fw-700"><span class="color-red-2">Tin nhắn từ hệ thống</span></div>
                <div class="text-shortcut fs-12 fw-500 margin-5-0">' . $row['content'] . '</div>
                <div class="fs-12 fw-500 color-blue text-shortcut">' . RemainTime($row['timestap']) . '</div>

            </div>
        </div>';
        }
    }
    die(json_encode(["result" => $HTML_NOTICE, "status" => "success"]));
} else if ($Json['action'] == 'visited_noti') {
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $notif_id = sql_escape($Json['notif_id']);
    if (get_total("notice", "WHERE id = '$notif_id' AND view = 'false'") < 1) die(json_encode(["result" => "updated visited notification fail", "status" => "failed"]));
    $mysql->update("notice", "view = 'true'", "id = '$notif_id'");
    die(json_encode(["result" => "updated visited notification success", "status" => "success"]));
} else if ($Json['action'] == 'add_follow') {
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $movie_id = sql_escape($Json['movie_id']);
    if (get_total('history', "WHERE movie_save = '$movie_id' AND user_id = '{$user['id']}'") < 1) {
        $mysql->insert('history', 'user_id,movie_save', "'{$user['id']}','$movie_id'");
        die("success");
    } else die(json_encode(["result" => "Phim Này Bạn Đã Follow Rồi", "status" => "failed"]));
} else if ($Json['action'] == 'async_follow') {
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $JsonFollow = json_decode($Json['data_follow'], true);
    if (count($JsonFollow) < 1) die('failed');
    foreach ($JsonFollow as $key => $value) {
        $Movie_Id = sql_escape($value);
        if (get_total('history', "WHERE movie_save = '$Movie_Id' AND user_id = '{$user['id']}'") < 1 && get_total('movie', "WHERE id = '$Movie_Id'") >= 1) {
            $mysql->insert('history', 'user_id,movie_save', "'{$user['id']}','$Movie_Id'");
        }
    }
    die('success');
} else if ($Json['action'] == 'del_follow') {
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $movie_id = sql_escape($Json['movie_id']);
    if (get_total('history', "WHERE movie_save = '$movie_id' AND user_id = '{$user['id']}'") < 1) die(json_encode(["result" => "Bạn Chưa Follow Phim Này", "status" => "failed"]));
    // if (get_total('movie', "WHERE id = '$movie_id'") < 1) die('success'); //json_encode(["result" => "Phim Không Tồn Tại", "status" => "success"])
    $mysql->delete('history', "movie_save = '$movie_id' AND user_id = '{$user['id']}'");
    die('success');
} else if ($Json['action'] == 'init_ads') {
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => 'Token Hết Thời Hạn', "status" => "success"]));
    if (get_total('ads', "WHERE type = 'true'") < 1) die(json_encode(["result" => 'Không Có Quảng Cáo Nào', "status" => "failed"]));
    $cache_key = "cache.WebsiteADS";
    if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
    $ADS = array();
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "ads WHERE type = 'true' ORDER BY id ASC");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $ADS['data'][] = array(
            'position_name' => $row['position_name'],
            'href' => $row['href'],
            'image' => $row['image'],
            'id' => $row['id'],
            'num' => $row['num'],
        );
    }
    $ADS['status'] = 'success';
    $InstanceCache->set($cache_key, json_encode($ADS), $cf['time_cache'] * 3600);
    die(json_encode($ADS));
} else if ($Json['action'] == 'update_click_ads') {
    $token = sql_escape($Json['token']);
    if (!json_decode($_COOKIE["TokenTime"], true)[$token]) die(json_encode(["result" => 'Token Hết Thời Hạn', "status" => "success"]));
    $adv_id = sql_escape($Json['adv_id']);
    $mysql->update('ads', "click = click + 1", "id = '$adv_id'");
    die(json_encode(["result" => 'Click To ADS', "status" => "success"]));
} else if ($Json['action'] == 'view_all_notice') {
    if (!$_author_cookie) die(json_encode(["result" => "Bạn Chưa Đăng Nhập", "status" => "failed"]));
    $mysql->update('notice', "view = 'true'", "user_id = '{$user['id']}'");
    die(json_encode(["result" => "view", "status" => "success"]));
} else if ($Json['action'] == 'Load_Comment_Home') {

    $limit = 30;
    $CurenPage = 1;
    $data = array();
    $P = CheckPages('comment', "WHERE show_cmt = 'true' AND reply_comment IS NULL AND movie_id = 'all'", $limit, $CurenPage);
    if ($P['total'] >= 1) {
        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "comment WHERE show_cmt = 'true' AND reply_comment IS NULL AND movie_id = 0 ORDER BY id DESC LIMIT {$P['start']},$limit");
        $Comment_data = $arr->fetchAll(PDO::FETCH_ASSOC);
        sort($Comment_data);
        foreach ($Comment_data as $key => $row) {
            $User_Arr = GetDataArr("user", "id = '{$row['user_id']}'");
            if (get_total('user', "WHERE id = '{$row['user_id']}'") < 1) {
                $mysql->delete('comment', "user_id = '{$row['user_id']}'");
            }
            $HTML .= '<li style="margin-bottom: 10px;">
                        <div class="boxchat-images">
                            <img class="avatar" src="' . $User_Arr['avatar'] . '" width="100" height="100" alt="' . $User_Arr['nickname'] . '">
                            <img class="avatar-frame" src="'.getIconStoreActive($User_Arr['id'], 'khung-vien').'">
                        </div>
                        

                            <div class="p-comment-home">
                                <div class="box-chat-nickname" style="color:' . LevelColor($User_Arr['level']) . ';">' . $User_Arr['nickname'] . ' (Lv.' . $User_Arr['level'] . ') ' . LevelIcon($User_Arr['level'], 20, 20) . UserIcon($User_Arr['id'], 20, 20) . ' <span class="Time-cmt-home">' . RemainTime($row['timestap']) . '</span></div>
                            </div>
                            <div class="boxchat-content">' . $row['content'] . '</div>
                    </li>';
        }
        die(json_encode(["result" => $HTML, "status" => "success"]));
    } else die(json_encode(["result" => '<div class="home-status">Không Có Comment Nào</div>', "status" => "failed"]));
} else if ($Json['action'] == 'top_bxh') {
    $cache_key = "cache.BangXepHang";
    // if ($InstanceCache->has($cache_key)) die($InstanceCache->get($cache_key));
    $Top = 0;
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "user ORDER BY level DESC LIMIT {$cf['num_bxh']}");
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
        $HTML .= '<li class="home-rank">
                    <div class="flex flex-hozi-center" style="padding: 14px 0px;">
                        <div class="stt-rank">
                            <img src="' . $TopImage . '">
                            <div class="top-rank">#TOP ' . $Top . '</div>
                        </div>
                        <div class="image-container-rank">
                            <div class="image-rank-home">
                                <img class="avatar"  src="' . $row['avatar'] . '" alt="' . $row['nickname'] . '">
                                <img class="avatar-frame"  src="' . getIconStoreActive($row['id'], 'khung-vien') . '">
                            </div>
                            
                            <span class="rank-level">Lv ' . $row['level'] . '</span>
                            ' . RankIcon($row['level']) . '
                        </div>
                        <div class="rank-info">
                            <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">' . $row['nickname'] . '</span>
                            <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Exp : ' . number_format(LevelExp($row['level'], $row['exp'])) . '</span>
                            <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Cảnh Giới : ' . Danh_Hieu($row['level']) . '</span>
                            <span class="rank-text" style="color: ' . LevelColor($row['level']) . ';">Icon : ' . UserIcon($row['id'], 18, 18) . '</span>
                        </div>

                    </div>
                </li>';
    }
    $InstanceCache->set($cache_key, json_encode(["result" => $HTML, "status" => "success"]), $cf['time_cache'] * 3600);
    die(json_encode(["result" => $HTML, "status" => "success"]));
} else if ($Json['action'] == 'huong_dan') {
    if (!$cf['huong_dan']) die(json_encode(["result" => '<div class="home-status">Chưa Có Hướng Dẫn Nào</div>', "status" => "failed"]));
    die(json_encode(["result" => un_htmlchars($cf['huong_dan']), "status" => "success"]));
} else if ($Json['action'] == 'list_comment') {
    if ($user['banned'] == 'true') {
        die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }

    $sql = "SELECT `c`.*, `m`.`name` `movie_name` , `m`.`slug` `movie_slug` 
    FROM `table_comment` as `c`
    JOIN `table_movie` as `m` ON `c`.`movie_id` = `m`.`id`
    WHERE `user_id` = ".$user['id']." AND `show_cmt` = 'true' 
    ORDER BY `timestap` DESC 
    LIMIT 10
    ";
    $arr = $mysql->query($sql);
    $html = '';
    $results = $arr->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($results)) {
        die(json_encode(["result" => "Không có bình luận", "status" => "success"]));
    }

    foreach ($results as $result) {
        $html .= '
        <div class="comment-main user-comment cmt-438631">
            <div class="flex bg-comment">
                <div class="left">
                    <div class="avatar">
                        <img class="avatar-img" src="'.$user['avatar'].'">
                        <img class="avatar-frame" src="'.getIconStoreActive($user['id'], 'khung-vien').'">
                    </div>
                </div>
                <div class="right">
                    <div class="flex flex-column">
                        <div class="content">'.$result['content'].'</div>
                        <div class="flex fs-12 toolbarr">
                            <label>
                                <a href="' . URL . '/thong-tin-phim/' . $result['movie_slug'] . '.html"><i class="fa fa-film"></i> '.$result['movie_name'].'</a>
                            </label>
                            <span class="cmt-time color-gray">'.RemainTime($result['timestap']).'</span><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    die(json_encode(["result" => $html, "status" => "success"]));
} else if ($Json['action'] == 'change_password') {
    if ($user['banned'] == 'true') {
        die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }

    if (empty($Json['new_password'])) {
        die(json_encode(["result" => "Chưa nhập mật khẩu mới", "status" => "failed"]));
    }

    $new_password = md5(sql_escape($Json['new_password']));
    $error = 0;

    if ($new_password == $user['password']) {
        $error++;
        die(json_encode(["result" => "Mật khẩu mới phải khác mật khẩu hiện tại", "status" => "failed"]));
    }

    if (strlen($Json['new_password']) < 6) {
        $error++;
        die(json_encode(["result" => "Mật khẩu đặt phải nhiều hơn 6 kí tự", "status" => "failed"]));
    }

    if ($error == 0) {
        $useremail = $user['email'];
        $mysql->update("user", "password = '$new_password'", "email = '$useremail'");
        die(json_encode(["result" => "Thay Đổi Mật Khẩu Thành Công", "status" => "success"]));
    }
} else if ($Json['action'] == 'add_deposit') {
    if ($user['banned'] == 'true') {
        die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }

    $data = $Json['data'];
    $configs = getConfigGeneralUserInfo([
		'deposit_rate',
		'deposit_exp',
	]);

    $rs = [
        'success'   => false,
        'message'   => ''
    ];

    // save log
    if (!empty($data['id'])) {
        $pathLog = 'storage\log\deposit.log';
        $logDeposit = "\n".date('Y-m-d H:i:s') .' '. "Deposit ".$data['purchase_units'][0]['amount']['value']. ' '.$data['purchase_units'][0]['amount']['currency_code']. ' by user '.$user['id'].' with paypalID '.$data['id'];
        error_log($logDeposit, 3, $pathLog);
    }

    if (empty($data['purchase_units'][0]['amount']['currency_code'])) {
        $rs['message'] = 'Có lỗi. Vui lòng thử lại';
        die(json_encode($rs));
    }

    $currency = $data['purchase_units'][0]['amount']['currency_code'];
    $amount = $data['purchase_units'][0]['amount']['value'];
    $coin = $amount * $configs['deposit_rate'];
    $exp = $amount * $configs['deposit_exp'];

    $insertHistory = [
        'user'          =>  $user['id'],
        'money'         =>  $amount,
        'currency'      =>  $currency,
        'coin'          =>  $coin,
        'exp'           =>  $exp,
        'id_paypal'     =>  $data['id'],
        'status'        =>  1,
        'created_at'    =>  date('Y-m-d H:i'),
    ];

    // insert deposit history
    $insert = $mysql->insert('deposit_history', implode(',', array_keys($insertHistory)), '"'.implode('", "', $insertHistory).'"');
    
    // plus coin and exp for user
    $userQuery = $mysql->query('SELECT `id`,`exp`,`level`,`coins` FROM `table_user` WHERE `id` = '.$user['id']);
    $userData = $userQuery->fetch(PDO::FETCH_ASSOC);
    
    $level = $userData['level'];
	$currentExp = $userData['exp'];

	while($exp > 0) {
		$expLevel = getExpLevel($level) - $currentExp;
		$currentExp = 0;

		if ($exp - $expLevel > 0) {
			$level++;
			$exp = $exp - $expLevel;
		} else {
			$currentExp = $exp;
			$exp = 0;
		}
    }

    $updateUser = "level = ". $level . ", exp = " . $currentExp . ", coins = coins +" . $coin;
    $mysql->update("user", $updateUser, "id = ".$user['id']);

    // insert notify
    $mysql->insert('notice', 'user_id,content,timestap,time', "'{$user['id']}','Chúc Mừng Bạn Đã Thằng Cấp Từ Level " . number_format($user['level']) . " Lên Level " . number_format($level) . " Hãy Cố Gắng Để Đạt Được Những Cấp Cao Hơn Nhé','" . time() . "','" . DATE . "'");
    

    $rs['success'] = true;
    $rs['message'] = 'Nạp xu thành công';
    die(json_encode($rs));
} else if ($Json['action'] == 'buy_icon_store') {
    if ($user['banned'] == 'true') {
        die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }

    $data = $Json['data'];
    $response = [
        'success'   => false,
        'message'   => '',
        'data'      => [],
        'exist'     => false
    ];

    if (empty($data['id'])) {
        $response['message'] = 'Có lỗi. Vui lòng thử lại';
        die(json_encode($response));
    }

    $rs = $mysql->query('SELECT `user_id` FROM `table_user_icon_store` WHERE `user_id` = '.$user['id'].' AND `icon_id` = '.$data['id']);
    $existIcon = $rs->fetch(PDO::FETCH_ASSOC);

    if (!empty($existIcon)) {
        $response['message'] = 'Đã sở hữu';
        $response['exist'] = true;
        die(json_encode($response));
    }

    $rs = $mysql->query('SELECT `id`,`image`,`price`, `type` FROM `table_vat_pham` WHERE `id` = '.$data['id']);
    $icon = $rs->fetch(PDO::FETCH_ASSOC);
    
    if (empty($icon)) {
        $response['message'] = 'Có lỗi. Vui lòng thử lại.';
        die(json_encode($response));
    }

    if ($user['coins'] < $icon['price']) {
        $response['message'] = 'Không đủ xu.';
        die(json_encode($response));
    }

    // insert to table transaction
    $insertTransaction = [
        'user_id' => $user['id'],
        'amount' => $icon['price'],
        'type' => $icon['type'],
        'desc' => "User ".$user['id']." đã mua ".$icon['type']." ".$icon['id'],
    ];
    
    $insert = $mysql->insert('transaction', '`'.implode('`,`', array_keys($insertTransaction)).'`', '"'.implode('", "', $insertTransaction).'"');
    $transactionId = getLastInsertId('table_transaction');

    // insert to table_user_icon_store
    $insertUserFrame = [
        'user_id' => $user['id'],
        'icon_id' => $icon['id'],
        'type' => $icon['type'],
        'transaction_id' => $transactionId
    ];
    
    $insert = $mysql->insert('user_icon_store', '`'.implode('`,`', array_keys($insertUserFrame)).'`', '"'.implode('", "', $insertUserFrame).'"');
    $update = $mysql->update('user', 'coins = coins -'.$icon['price'], 'id = '.$user['id']);
    activeIconStore($user['id'], $icon['id'], $icon['type']);
    
    $response['success'] = true;
    $response['message'] = 'Mua vật phẩm thành công';
    $response['data']['coin'] = number_format(getUserCoin($user['id']));
    die(json_encode($response));
} else if ($Json['action'] == 'active_icon_store') {
    if ($user['banned'] == 'true') {
        die(json_encode(["result" => "Tài Khoản Bị Khóa", "status" => "failed"]));
    }

    $data = $Json['data'];
    $response = [
        'success'   => false,
        'message'   => '',
    ];

    if (empty($data['id'])) {
        $response['message'] = 'Có lỗi. Vui lòng thử lại';
        die(json_encode($response));
    }

    $rs = $mysql->query('SELECT `user_id` FROM `table_user_icon_store` WHERE `user_id` = '.$user['id'].' AND `icon_id` = '.$data['id']);
    $existIcon = $rs->fetch(PDO::FETCH_ASSOC);

    if (empty($existIcon)) {
        $response['message'] = 'Chưa sở hữu';
        die(json_encode($response));
    }
    
    activeIconStore($user['id'], $data['id'], $data['type']);

    $response['success'] = true;
    $response['message'] = 'Kích hoạt thành công';
    die(json_encode($response));
}
