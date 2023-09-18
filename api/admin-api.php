<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
HeaderApplication();
if (!$_POST) die(HTMLMethodNot(503));
$action = (isset($_POST['action']) ? sql_escape($_POST['action']) : InputJson()['action']);

if (!$_SESSION['admin'] && $action != 'loginadmin') die(JsonMessage(401, "Error Login Admin Server"));
if ($action == 'loginadmin') {
    $username = sql_escape($_POST['username']);
    $password = md5(sql_escape($_POST['password']));
    if (get_total("admin", "WHERE username = '$username' AND password = '$password'") < 1) die(JsonMessage(401, "Tên Tài Khoản Hoặc Mật Khẩu Không Đúng"));
    $mysql->update("admin", "last_login = '" . DATEFULL . "'", "username = '$username'");
    $_SESSION['admin'] = $username;
    die(JsonMessage(200, "Đăng Nhập Tài Khoản Thành Công"));
} else if ($action == 'SearchMovie') {
    $keyword = sql_escape($_POST['keyword']);
    if (get_total("movie", "WHERE name LIKE '%$keyword%' AND other_name LIKE '%$keyword%'") < 1) die(JsonMessage(401, "Tên Tài Khoản Hoặc Mật Khẩu Không Đúng"));
    $MovieSearch .= '<div class="row mt-5">';
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie WHERE name LIKE '%$keyword%' AND other_name LIKE '%$keyword%' ORDER BY id DESC LIMIT 10");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $MovieSearch .= '<div class="col-lg-12">
        <div class="alert alert-primary inverse alert-dismissible fade show" role="alert">
            <img class="img-50" src="' . $row['image'] . '" alt="' . $row['name'] . '">
            <div class="fs-6 fw-bold">' . $row['name'] . ' (' . $row['other_name'] . ')</div>
        </div>
    </div>';
    }
    $MovieSearch .= '</div>';
    die(JsonMessage(200, $MovieSearch));
} else if ($action == 'ChangePassword') {
    $pw_old = md5(sql_escape($_POST['pw_old']));
    $pw_new = md5(sql_escape($_POST['pw_new']));
    $pw_new_re = md5(sql_escape($_POST['pw_new_re']));
    if ($admin['password'] != $pw_old) die(JsonMessage(503, "Mật Khẩu Cũ Bạn Nhập Không Chính Xác"));
    if ($pw_new  != $pw_new_re) die(JsonMessage(203, "Hai Mật Khẩu Không Khớp Nhau"));
    $mysql->update("admin", "password = '$pw_new'", "username = '$admin_username'");
    die(JsonMessage(200, "Đổi Mật Khẩu Mới Thành Công"));
} else if ($action == 'DangXuat') {
    unset($_SESSION['admin']);
    die(JsonMessage(200, "Đăng Xuất Thành Công"));
} else if ($action == 'NewCategory') {
    $Name = sql_escape($_POST['name']);
    $Link = chuyenslug($Name);
    if (get_total("category", "WHERE slug = '$Link'") >= 1) die(JsonMessage(201, "Thể Loại Này Đã Tồn Tại"));
    $mysql->insert("category", 'name,slug', "'$Name','$Link'");
    die(JsonMessage(200, "Thêm Thành Công Thể Loại : $Name"));
} else if ($action == 'XoaTable') {
    $table = sql_escape($_POST['table']);
    $id = sql_escape($_POST['id']);
    $mysql->delete($table, "id = '$id'");
    die(JsonMessage(200, "Xóa Thành Công Table ID : $id"));
} else if ($action == 'EditerForm') {
    $table = sql_escape($_POST['table']);
    $id = sql_escape($_POST['id']);
    $HTML = '<form submit-ajax="ngockush" form-action="UpdateDatabase" action="' . URL . '/admin/server/api" method="POST" form-check="true">';
    $HTML .= '<input type="text" name="table" value="' . $table . '" style="display: none;"><input type="text" name="id" value="' . $id . '" style="display: none;">';
    $HTML .= InputEdit_Table($table, "id = '$id'");
    $HTML .= '<div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-3" type="submit">Cập Nhật</button>
            </div>
            </form>
            <script src="' . URL . '/admin/assets/custom-theme/admin.js"></script>';
    die(JsonMessage(200, $HTML));
} else if ($action == 'UpdateDatabase') {
    $table = sql_escape($_POST['table']);
    $id = sql_escape($_POST['id']);
    $Feils = $_POST['data'];

    $Check = count($Feils);
    $ArrNum = 0;
    foreach ($Feils as $key => $value) {
        $ArrNum++;
        $ColumsKey = $key;
        if ($ColumsKey == 'slug') {
            $RowValue = chuyenslug($value);
        } else if ($ColumsKey == 'password') {
            $RowValue = md5($value);
        } else if ($ColumsKey == 'cate') {
            $RowValue = json_encode($Feils['cate'], JSON_UNESCAPED_UNICODE);
        } else if ($ColumsKey == 'lich_chieu') {
            $RowValue = json_encode($Feils['lich_chieu'], JSON_UNESCAPED_UNICODE);
        } else if ($ColumsKey == 'script_footer') {
            $RowValue = htmlchars($value);
        } else if ($ColumsKey == 'top_note') {
            $RowValue = htmlchars($value);
        } else if ($ColumsKey == 'googletagmanager') {
            $RowValue = htmlchars($value);
        } else if ($ColumsKey == 'name') {
            $RowValue = $value;
        } else if ($ColumsKey == 'keyword') {
            $key_seo = explode("\r", $value);
            $keyword = array();
            foreach ($key_seo as $k => $kw) {
                if ($kw != '') {
                    $Key = sql_escape(explode("|", $kw)[0]);
                    $URL = (explode("|", $kw)[1] ? sql_escape(explode("|", $kw)[1]) : URL);
                    $keyword[] = array(
                        "name" => $Key,
                        "url" => $URL
                    );
                }
            }
            $RowValue = json_encode($keyword, JSON_UNESCAPED_UNICODE);
        } else $RowValue = $value;
        if ($ArrNum < $Check) {
            $SQL .= "$key = '$RowValue',";
        } else $SQL .= "$key = '$RowValue'";
    }

    try {
        $mysql->update($table, $SQL, "id = '$id'");
    } catch (\Throwable $th) {
        die(JsonMessage(400, "Lỗi rồi => [$th]"));
    }
    die(JsonMessage(200, "Cập Nhật Thành Công"));
} else if ($action == 'AddNewDatabase') {
    $table = sql_escape($_POST['table']);
    $Feils = $_POST['New'];
    $Check = count($Feils);
    $ArrNum = 0;
    foreach ($Feils as $key => $value) {
        $ArrNum++;
        $RowValue = $value;
        $ColumsKey = $key;
        if ($ColumsKey == 'slug') {
            $RowValue = chuyenslug($RowValue);
        } else if ($ColumsKey == 'password') {

            $RowValue = md5($RowValue);
        } else if ($ColumsKey == 'cate') {
            $RowValue = json_encode($Feils['cate'], JSON_UNESCAPED_UNICODE);
        } else if ($ColumsKey == 'lich_chieu') {
            $RowValue = json_encode($Feils['lich_chieu'], JSON_UNESCAPED_UNICODE);
        } else if ($ColumsKey == 'name') {
            $RowValue = $value;
        } else if ($ColumsKey == 'googletagmanager') {
            $RowValue = htmlchars($value);
        } else if ($ColumsKey == 'keyword') {
            $key_seo = explode("\r", $value);
            $keyword = array();
            foreach ($key_seo as $key => $kw) {
                if ($kw  != '') {
                    $Key = sql_escape(explode("|", $kw)[0]);
                    $URL = (explode("|", $kw)[1] ? sql_escape(explode("|", $kw)[1]) : URL);
                    $keyword[] = array(
                        "name" => $Key,
                        "url" => $URL
                    );
                }
            }
            $RowValue = json_encode($keyword, JSON_UNESCAPED_UNICODE);
        }
        if ($ArrNum < $Check) {
            $Colums .= "$ColumsKey,";
            $Rows .= "'$RowValue',";
        } else {
            $Colums .= "$ColumsKey";
            $Rows .= "'$RowValue'";
        }
    }

    try {
        $mysql->insert($table, $Colums, $Rows);
    } catch (\Throwable $th) {
        die(JsonMessage(400, "Lỗi rồi => [$th]"));
    }
    die(JsonMessage(200, "Thêm Thành Công"));
} else if ($action == 'ServerAdd') {
    $MovieID = sql_escape($_POST['MovieID']);
    $ServerID = sql_escape($_POST['ServerID']);
    if (get_total('movie_server', "WHERE movie_id = '$MovieID' AND server_id = '$ServerID'") >= 1) die(JsonMessage(205, "Server Này Đã Được Thêm"));
    $mysql->insert('movie_server', 'movie_id,server_id', "'$MovieID','$ServerID'");
    die(JsonMessage(200, "Add Thành Công"));
} else if ($action == 'AddNewEpisode2') {
    $Json = InputJson()['data'];
    $movie_id = InputJson()['movie_id'];
    $movie = GetDataArr('movie', "id = '$movie_id'");
    foreach ($Json as $key => $value) {
        $epname = sql_escape($value['epname']);
        $JsonSever = json_encode($value['server']);
        if (get_total('episode', "WHERE movie_id = '$movie_id'") >= 1) {
            $num_ep = GetDataArr('episode', "movie_id = '$movie_id' ORDER BY id DESC")['ep_num'];
            $Ep_Numb = ($num_ep + 1);
        } else $Ep_Numb = 1;
        $mysql->insert('episode', 'movie_id,ep_name,ep_num,server', "'$movie_id','$epname','$Ep_Numb','$JsonSever'");
    }
    $Mytime = time();
    $mysql->update('movie', "timestap = '$Mytime',slug = '{$movie['slug']}'", "id = '$movie_id'");
    die(JsonMessage(200, "Thêm Thành Công  " . number_format(count($Json)) . " Episode"));
} else if ($action == 'UploadImages') {
    $width = sql_escape($_POST['width']);
    $height = sql_escape($_POST['height']);
    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $expensions = array("jpeg", "jpg", "png", "gif", "ico");
        $NameFile = chuyenslug(explode(".", $file_name)[0]);
        $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
        if (in_array($file_ext, $expensions) === false) die(JsonMessage(401, "Định Dạng File Không Hợp Lệ "));
        if ($file_size > 2097152) die(JsonMessage(401, "Dung Lượng File Vượt Quá Dung Lượng Cho Phép"));
        $Size = '_' . $width . 'x' . $height;
        $FileNew = UPLOAD_DIR . "/$NameFile$Size.$file_ext";
        if (file_exists($FileNew)) {
            $Images = URL . "/assets/upload/$NameFile$Size.$file_ext";
            die(JsonMessage(200, $Images));
        } else {
            $FileNew = UPLOAD_DIR . "/$NameFile$Size.$file_ext";
            resize_crop_image($width, $height, $file_tmp, $FileNew, 150);
            $Images = URL . "/assets/upload/$NameFile$Size.$file_ext";
            die(JsonMessage(200, $Images));
        }
    } else die(JsonMessage(401, "Vui Lòng Chọn File"));
} else if ($action == 'UpdateNewServer') {
    $episode_id = sql_escape($_POST['episode_id']);
    $epi = $_POST['episode'];
    $ep_name = $_POST['ep_name'];
    $ServerJson = json_encode($epi[0]['server'], JSON_UNESCAPED_UNICODE);
    $mysql->update('episode', "ep_name = '$ep_name',server = '$ServerJson'", "id = '$episode_id'");
    die(JsonMessage(200, "Cập Nhật Thành Công"));
} else if ($action == 'getlink') {
    $URL = sql_escape($_POST['link']);
    if (strpos($URL, 'youtube.com') !== false) {
        $YoutubeLink = getYoutubeIdFromUrl($URL);
        if (!$YoutubeLink) die(JsonMessage(404, $URL));
        die(JsonMessage(200, "https://youtube.com/embed/$YoutubeLink"));
    } else if (strpos($URL, 'animehay.club') !== false) {
        $HTML = $curl->get($URL);
        if (!$HTML) die(JsonMessage(404, "Không Lấy Được Link"));
        $LinkHydrax = explode('"', explode('https://playhydrax.com/?v=', $HTML)[1])[0];
        if (!$LinkHydrax) die(JsonMessage(404, "Không Lấy Được Link"));
        die(JsonMessage(200, "https://playhydrax.com/?v=$LinkHydrax"));
    } else die(JsonMessage(200, $URL));
} else if ($action == 'UploadImagesBase64') {
    $Uploader = imagesaver($_POST['image']);
    if (!$Uploader) die(JsonMessage(404, 'Upload Ảnh Không Thành Công'));
    die(JsonMessage(200, $Uploader));
} else if ($action == 'AddNewADS') {
    $post = $_POST['New'];
    $href = sql_escape($post['href']);
    $image = sql_escape($post['image']);
    $type = sql_escape($post['type']);
    $position_name = sql_escape($post['position_name']);
    $Numads = get_data_multi('num', 'ads', "position_name = '$position_name' ORDER BY num DESC");
    $AdsNum = ($Numads ? $Numads + 1 : 1);
    $mysql->insert('ads', 'position_name,href,image,type,num', "'$position_name','$href','$image','$type','$AdsNum'");
    die(JsonMessage(200, "Thêm Thành Công"));
} else if ($action == 'ServerDelete') {
    $ServerID = sql_escape($_POST['ServerID']);
    $MovieID = sql_escape($_POST['MovieID']);
    $mysql->delete('movie_server', "server_id = '$ServerID' AND movie_id = '$MovieID'");
    die(JsonMessage(200, "Remove Server Thành Công"));
} else if ($action == 'XoaCache') {
    if (!$InstanceCache->clear()) die(JsonMessage(404, '<div>
    <h4>Xóa cache không thành công</h4>
</div>'));
    die(JsonMessage(200, '<div>
        <h4>Hoàn Tất Quá Trình Xóa Cache</h4>
    </div>'));
} else if ($action == 'UpdateKeySeo') {
    $key_seo = explode("\n", $_POST['key_seo']);
    if (count($key_seo) < 1) die(JsonMessage(502, "Không Hợp Lệ Vui Lòng Thử Lại"));
    $arr = array();
    foreach ($key_seo as $key => $value) {
        $Key = sql_escape(explode("|", $value)[0]);
        $URL = (explode("|", $value)[1] ? sql_escape(explode("|", $value)[1]) : URL);
        $arr[] = array(
            "name" => $Key,
            "url" => $URL
        );
    }
    $mysql->update('config', "key_seo = '" . json_encode($arr, JSON_UNESCAPED_UNICODE) . "'", "id = 1");
    die(JsonMessage(200, "Cập Nhật Thành Công"));
} else if ($action == 'multitype_detele') {
    $arr = $_POST['arr'];
    $table = $_POST['table'];
    $Success = 0;
    if ($table == 'XoaFile') {
        $Success = 0;
        $Error = 0;
        foreach ($arr as $key => $file) {
            if (is_file($file)) {
                $Success++;
                unlink($file);
            } else $Error++;
        }
        die(JsonMessage(200, '<div>
        <h4>Hoàn Tất Quá Trình Xóa</h4>
        <span class="badge bg-success">Xóa Thành Công : ' . number_format($Success) . '</span> <span class="badge bg-danger">Xóa Không Thành Công : ' . number_format($Error) . '</span>
    </div>'));
    }
    foreach ($arr as $key => $value) {
        $Success++;
        $mysql->delete($table, "id = '$value'");
    }
    die(JsonMessage(200, "Xóa Thành Công $Success Trường"));
} else if ($action == 'RemoveLichChieu') {
    $MovieID = $_POST['MovieID'];
    $mysql->update('movie', "lich_chieu = NULL", "id = '$MovieID'");
    die(JsonMessage(200, "Xóa Lịch Chiếu Thành Công"));
} else if ($action == 'update-server-episode') {
    $server_list = explode("\n", $_POST['server_list']);
    $movie_id = $_POST['movie_id'];
    $server_name = $_POST['server_name'];
    $serverjson = array();
    $x = 0;
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "episode WHERE movie_id = '$movie_id' ORDER BY id ASC");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        if (!$server_list[$x]) {
            break;
        }
        foreach (json_decode($row['server'], true) as $key => $value) {
            if ($server_name == $value['server_name']) {
                $serverjson[$key] = array(
                    "server_name" => $value['server_name'],
                    "server_link" => $server_list[$x]
                );
            } else {
                $serverjson[$key] = array(
                    "server_name" => $value['server_name'],
                    "server_link" => $value['server_link']
                );
            }
        }
        $mysql->update('episode', "server = '" . json_encode($serverjson, JSON_UNESCAPED_UNICODE) . "'", "id = '{$row['id']}'");
        $x++;
    }
    die(JsonMessage(200, 'Cập Nhật Thành Công'));
} else if ($action == 'add-server-episode') {
    $server_list = explode("\n", $_POST['server_list']);
    $movie_id = $_POST['movie_id'];
    $server_name = $_POST['server_name'];
    $ep_num = GetDataArr('episode', "movie_id = '$movie_id' ORDER BY ep_num DESC")['ep_num'];
    foreach ($server_list as $key => $value) {
        $serverjson = array();
        $ep_num++;
        $serverjson[] = array(
            "server_name" => $server_name,
            "server_link" => $value
        );
        $mysql->insert('episode', "movie_id,ep_name,ep_num,server", "'$movie_id','Tập $ep_num','$ep_num','" . json_encode($serverjson, JSON_UNESCAPED_UNICODE) . "'");
    }
    die(JsonMessage(200, 'Thêm Thành Công ' . count($server_list) . ' Tập'));
} else if ($action == 'category_pin_top') {
    $data = array();
    foreach ($_POST['category'] as $v) {
        $data[] = array(
            "id" => $v
        );
    }
    $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    $mysql->update('config', "nominations_category = '$data'", 'id = 1');
    die(JsonMessage(200, 'Cập nhật danh sách thể loại đề cử thành công'));
} else if ($action == 'add-fast-server') {
    $movie_id = (int)$_POST['movie_id'];
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id ASC");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        if (get_total('movie_server', "where movie_id = $movie_id AND server_id = {$row['id']}") < 1) {
            $mysql->insert('movie_server', 'movie_id,server_id', "$movie_id,{$row['id']}");
        }
    }
    die(JsonMessage(200, 'Thêm nhanh server thành công'));
} else if ($action == 'upgrade-episode-server') {
    $movie_id = (int)$_POST['movie_id'];
    $data = array();
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie_server where movie_id = $movie_id ORDER BY id DESC");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $sv = GetDataArr('server', "id = {$row['server_id']}");
        $data[] = array(
            "server_name" => $sv['server_name'],
            "server_link" => ""
        );
    }
    $data = json_encode($data, JSON_UNESCAPED_UNICODE);
    $mysql->update('episode', "server = '$data'", "movie_id = $movie_id");
    die(JsonMessage(200, 'Cập nhật lại server thành công'));
} else if ($action == 'set-trang-thai') {
    $movie_type = $_POST['movie_type'];
    $list_movie = $_POST['list_movie'];
    foreach ($list_movie as $movie_id) {
        $mysql->update('movie', "public = '$movie_type'", "id = $movie_id");
    }
    die(JsonMessage(200, 'Cập nhật lại trạng thái cho phim thành công'));
}
// Không Có Thằng Action Nào Trùng Hợp
else die(HTMLMethodNot(503));
