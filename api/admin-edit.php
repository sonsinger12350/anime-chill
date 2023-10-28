<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_POST) die(HTMLMethodNot(503));

if (!$_POST['action']) die(HTMLMethodNot(503));
$FormEdit = sql_escape($_POST['FormEdit']);
$id = sql_escape($_POST['id']);
?>
<link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/select2.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/summernote.css">
<?php
if ($FormEdit == "server") {    
    $data = GetDataArr("server", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" name="table" value="server" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <div class="col-12 mb-3">
            <label>Tên Server</label>
            <input type="text" class="form-control" name="data[server_name]" value="<?= $data['server_name'] ?>">
        </div>
        <div class="col-12 mb-3">
            <label>Loại Player</label>
            <select class="form-control" name="data[server_player]">
                <option value="iframe" <?= Selected($data['server_player'], "iframe") ?>>Trình Phát Nhúng (Iframe)</option>
                <option value="player" <?= Selected($data['server_player'], "player") ?>>Trình Phát (Mp4,Hls,M3u8)</option>
            </select>
        </div>
        <div class="col-12 text-center mb-3">
            <button class="btn btn-outline-info mt-3" type="submit">Cập Nhật</button>
        </div>
    </form>
<?php } else if ($FormEdit == "movie") {
    $data = GetDataArr("movie", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
        <div class="col-12 text-center mb-3">
            <button class="btn btn-outline-info mt-2" type="submit">Cập Nhật Movie</button>
            <button class="btn btn-outline-danger mt-2" type="button" onclick="SendDataToServer({action: 'RemoveLichChieu',MovieID: '<?= $data['id'] ?>'});">Xóa Lịch Chiếu</button>
            <button onclick="location.href = '/admin_movie/episode-movie?movie_id=<?= $data['id'] ?>'" class="btn btn-warning-gradien mt-2" type="button">Manager Episode</button>
            <button onclick="location.href = '/admin_movie/movie-lien-ket?movie_id=<?= $data['id'] ?>'" class="btn btn-primary-gradien mt-2" type="button">Thêm Liên Kết Phim</button>
        </div>
        <input type="text" name="table" value="movie" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Tên Phim</label>
                <input type="text" class="form-control" name="data[name]" value="<?= $data['name'] ?>" oninput="$('#SlugMovide').val(this.value);">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Tên Khác</label>
                <input type="text" class="form-control" name="data[other_name]" value="<?= $data['other_name'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Tập Tiếp Theo: Tập 1 + Tập 2 + Tập 3</label>
                <textarea name="data[seo_title]" rows="1" class=" form-control"><?= $data['seo_title'] ?></textarea>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Seo Tập</label>
                <input type="text" class="form-control" name="data[seo_tap]" value="<?= $data['seo_tap'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Ảnh Nhỏ</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[image]" value="<?= $data['image'] ?>">
                    <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                    <input id="image" type="file" style="display: none;" onchange="UploadImages(this, 250, 350);" accept="image/*" />
                </div>
                <img class="mt-2" src="<?= $data['image'] ?>" style="max-width: 20%;" alt="<?= $data['name'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Ảnh Lớn</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[image_big]" value="<?= $data['image_big'] ?>">
                    <button type="button" class="btn btn-primary" onclick="$('#image_big').click();">Chọn File</button>
                    <input id="image_big" type="file" style="display: none;" onchange="UploadImages(this, 486, 274);" accept="image/*" />
                </div>
                <img class="mt-2" src="<?= $data['image_big'] ?>" style="max-width: 50%;" alt="<?= $data['name'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Thể Loại Phim</label>
                <select class="js-example-basic-hide-search col-sm-12" name="data[cate][][cate_id]" multiple="multiple">
                    <optgroup label="Thể Loại Phim">
                        <?php
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "category ORDER BY id DESC");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?= $row['id'] ?>" <?php foreach (json_decode($data['cate'], true) as $key => $value) if ($row['id'] == $value['cate_id']) echo "selected"; ?>><?= $row['name'] ?></option>
                        <?php } ?>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-6 col-md-12 mb-3" id="ThoiLuongPhim">
                <label>Thời Lượng Phim</label>
                <input type="number" class="form-control" name="data[movie_duration]" value="<?= $data['movie_duration'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3" id="TongSoTap">
                <label>Tổng Số Tập</label>
                <input type="text" class="form-control" name="data[ep_num]" value="<?= $data['ep_num'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3" id="TapHienTai" style="display: none;">
                <label>Tập Hiện Tại</label>
                <input type="text" class="form-control" name="data[ep_hien_tai]" value="<?= $data['ep_hien_tai'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Loại Phim</label>
                <select class="form-control" name="data[loai_phim]" onchange="ChangeElement(this);">
                    <option value="Phim Lẻ" <?= Selected($data['loai_phim'], "Phim Lẻ") ?>>Phim Lẻ</option>
                    <option value="Phim Bộ" <?= Selected($data['loai_phim'], "Phim Bộ") ?>>Phim Bộ</option>
                </select>
            </div>
            <script>
                ChangeElement('select[name="data[loai_phim]"]');

                function ChangeElement(select) {
                    var value = $(select).val();
                    if (value == 'Phim Lẻ') {
                        $('#ThoiLuongPhim').show();
                        $('#TongSoTap').hide();
                        $('#TapHienTai').hide();
                    } else if (value == 'Phim Bộ') {
                        $('#TongSoTap').show();
                        $('#TapHienTai').show();
                        $('#ThoiLuongPhim').hide();
                    }
                }
            </script>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Đề Cử Phim</label>
                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                    <div class="form-check form-check-inline radio radio-primary">
                        <input class="form-check-input" id="radioinline1" type="radio" name="data[de_cu]" value="true" <?= Checked($data['de_cu'], 'true') ?>>
                        <label class="form-check-label mb-0" for="radioinline1">Đề Cử Phim</label>
                    </div>
                    <div class="form-check form-check-inline radio radio-primary">
                        <input class="form-check-input" id="radioinline2" type="radio" name="data[de_cu]" value="false" <?= Checked($data['de_cu'], 'false') ?>>
                        <label class="form-check-label mb-0" for="radioinline2">Không Đề Cử</label>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Năm Sản Xuất</label>
                <select class="js-example-basic-hide-search col-sm-12" name="data[year]">
                    <optgroup label="Năm Sản Xuất">
                        <?php
                        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "year ORDER BY id DESC");
                        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <option value="<?= $row['year'] ?>" <?= Selected($data['year'], $row['year']) ?>><?= $row['year'] ?></option>
                        <?php } ?>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Trạng Thái</label>
                <select class="js-example-basic-hide-search col-sm-12" name="data[trang_thai]">
                    <optgroup label="Trạng Thái Phim">
                        <option value="Hoàn Thành" <?= Selected($data['trang_thai'], "Hoàn Thành") ?>>Hoàn Thành</option>
                        <option value="Đang Cập Nhật" <?= Selected($data['trang_thai'], "Đang Cập Nhật") ?>>Đang Cập Nhật</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Công Bố</label>
                <select class="js-example-basic-hide-search col-sm-12" name="data[public]">
                    <optgroup label="Công Bố">
                        <option value="true" <?= Selected($data['public'], "true") ?>>Công Khai</option>
                        <option value="false" <?= Selected($data['public'], "false") ?>>Riêng Tư</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Lịch Chiếu Phim</label>
                <select class="js-example-basic-hide-search col-sm-12" name="data[lich_chieu][][days]" multiple="multiple">
                    <optgroup label="Lịch Chiếu Phim">
                        <?php
                        for ($i = 2; $i < 8; $i++) {
                        ?>
                            <option value="<?= $i ?>" <?php foreach (json_decode($data['lich_chieu'], true) as $key => $value) if ($i == $value['days']) echo "selected"; ?>>Thứ <?= $i ?></option>
                        <?php } ?>
                        <option value="8" <?php foreach (json_decode($data['lich_chieu'], true) as $key => $value) if (8 == $value['days']) echo "selected"; ?>>Chủ Nhật</option>
                    </optgroup>
                </select>
            </div>

            <div class="col-lg-6 col-md-12 mb-3">
                <label>Từ Khóa Tìm Kiếm Phim</label>
                <textarea name="data[keyword]" rows="5" class="form-control"><?php foreach (json_decode($data['keyword'], true) as $key => $value) {
                                                                                    echo $value['name'] . '|' . $value['url'] . "\n";
                                                                                } ?></textarea>
            </div>
            <div class="col-lg-12 col-md-12 mb-3">
                <label>Nội Dung Phim</label>
                <textarea name="data[content]" class="summernote form-control"><?= $data['content'] ?></textarea>
            </div>
            <div class="col-lg-4 col-md-12 mb-3">
                <label>Điểm Vote</label>
                <input type="text" class="form-control" value="<?= $data['vote_point'] ?>" readonly>
            </div>
            <div class="col-lg-4 col-md-12 mb-3">
                <label>Số Người Vote</label>
                <input type="text" class="form-control" value="<?= $data['vote_all'] ?>" readonly>
            </div>
            <div class="col-lg-4 col-md-12 mb-3">
                <label>Lượt Xem</label>
                <input type="text" class="form-control" value="<?= $data['view'] ?>" readonly>
            </div>
            <input type="text" class="form-control" name="data[vote_point]" value="<?= $data['vote_point'] ?>" style="display: none;">
            <input type="text" class="form-control" name="data[vote_all]" value="<?= $data['vote_all'] ?>" style="display: none;">
            <input type="text" class="form-control" id="SlugMovide" name="data[slug]" value="<?= $data['slug'] ?>" style="display: none;">

        </div>
    </form>
<?php } else if ($FormEdit == "ServerAddEpisode") {
    $data = GetDataArr("episode", "id = $id");
    ?>
    <div class="mb-5">
        <h4 class="card-title">Chỉnh Sửa Episode <?= $data['ep_name'] ?></h4>
        <?php
        $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");
        while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
            echo '<button class="btn btn-success btn-sm mt-2" style="margin-right: 10px;" id="' . ServerName($row['server_name'])  . '" type="button" onclick="AddNewServer(\'' . $row['server_name'] . '\', \'' . ServerName($row['server_name']) . '\', this)">' . $row['server_name'] . ' <i class="fa fa-plus-square"></i></button>';
        }
        ?>
    </div>
    <form submit-ajax="ngockush" form-action="UpdateNewServer" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" class="form-control" name="episode_id" value="<?= $id ?>" style="display: none;">
        <div class="form-group mb-4">
            <label> Tên Tập</label>
            <input type="text" class="form-control" name="ep_name" value="<?= $data['ep_name'] ?>">
        </div>
        <div class="form-group" id="MainServer">
            <?php
            $Epnum = 0;
            $sername_json = array();
            foreach (json_decode($data['server'], true) as $key => $value) {
                $sername_json[] = ServerName($value['server_name']);
            ?>
                <div class="col-lg-12 row" id="input_<?= ServerName($value['server_name']) ?>">
                    <div class="col mb-3">
                        <label>Link Server <?= $value['server_name'] ?></label>
                        <input type="text" style="display: none;" class="form-control" name="episode[0][server][<?= $Epnum ?>][server_name]" value="<?= $value['server_name'] ?>">
                        <input type="text" onchange="GetLink(this);" class="form-control" name="episode[0][server][<?= $Epnum ?>][server_link]" value="<?= $value['server_link'] ?>">
                    </div>
                    <button class="btn btn-danger btn-xs" style="width: 20px;height: 20px;margin-top: 30px;" onclick="RemoveServer('input_<?= ServerName($value['server_name']) ?>')" type="button">Xóa</button>
                </div>
            <?php $Epnum++;
            } ?>

        </div>
        <div class="col-12 text-center mb-3">
            <button class="btn btn-outline-success mt-2" type="submit">Cập Nhật</button>
        </div>
    </form>
    <script type="text/javascript">
        var ServerAll = <?= $Epnum ?>;
        var ServerJson = <?= json_encode($sername_json) ?>;
        $.each(ServerJson, function(key, value) {
            $(`#${value}`).removeClass("btn-success");
            $(`#${value}`).addClass("btn-danger");
            $(`#${value}`).html(`${value} <i class="fa fa-close"></i>`);
        });

        function AddNewServer(ServerName, ServerID, button) {
            ServerAll++;
            if ($(button).hasClass('btn-danger')) {
                $(button).removeClass("btn-danger");
                $(button).addClass("btn-success");
                $(button).html(`${ServerName} <i class="fa fa-plus"></i>`);
                $(`#input_${ServerID}`).remove();
                // SendDataToServer({
                //     action: 'ServerDelete',
                //     ServerID: ServerID,
                //     MovieID: <?= $data['movie_id'] ?>
                // }, false);
                return;
            }

            // SendDataToServer({
            //     action: 'ServerAdd',
            //     ServerID: ServerID,
            //     MovieID: <?= $data['movie_id'] ?>
            // }, false);
            $(button).removeClass("btn-success");
            $(button).addClass("btn-danger");
            $(button).html(`${ServerName} <i class="fa fa-close"></i>`);
            const MainServer = $('#MainServer');
            const HTML = `<div class="col-lg-12 row" id="input_${ServerID}">
                            <div class="col mb-3">
                                <label>Link Server ${ServerName}</label>
                                <input type="text" style="display: none;" class="form-control" name="episode[0][server][${ServerAll}][server_name]" value="${ServerName}">
                                <input type="text" onchange="GetLink(this);" class="form-control" name="episode[0][server][${ServerAll}][server_link]">
                            </div>
                            <button class="btn btn-danger btn-xs" style="width: 20px;height: 20px;margin-top: 30px;" onclick="RemoveServer('input_${ServerID}')" type="button">Xóa</button>
                        </div>`;
            MainServer.append(HTML);
        }
    </script>
<?php } else if ($FormEdit == "level_color") {
    $data = GetDataArr("level_color", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" name="table" value="level_color" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-12 mb-3">
                <label>Level</label>
                <input type="number" class="form-control" name="data[level]" value="<?= $data['level'] ?>">
            </div>
            <div class="col-lg-12 col-md-12 mb-3">
                <label>Icon</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[icon]" value="<?= $data['icon'] ?>">
                    <button type="button" class="btn btn-primary" onclick="$('#icon').click();">Chọn File</button>
                    <input id="icon" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                </div>
            </div>
            <div class="col-12 mb-3">
                <label>Danh Hiệu</label>
                <input type="text" class="form-control" name="data[danh_hieu]" value="<?= $data['danh_hieu'] ?>">
            </div>
            <div class="col-12 mb-3">
                <label>Màu</label>
                <input type="color" class="form-control" name="data[color]" value="<?= $data['color'] ?>">
            </div>
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Cập Nhật</button>
            </div>
        </div>
    </form>
<?php } else if ($FormEdit == "user") {
    $data = GetDataArr("user", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" name="table" value="user" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-12 mb-3">
                <label>Địa Chỉ Email</label>
                <input type="text" class="form-control" value="<?= $data['email'] ?>" readonly>
            </div>
            <div class="col-12 mb-3">
                <label>Avatar</label>
                <input type="text" class="form-control" name="data[avatar]" value="<?= $data['avatar'] ?>">
            </div>
            <div class="col-12 mb-3">
                <label>Nick Name</label>
                <input type="text" class="form-control" name="data[nickname]" value="<?= $data['nickname'] ?>">
            </div>
            <div class="col-6 mb-3">
                <label>Kinh Nghiệm</label>
                <input type="number" class="form-control" name="data[exp]" value="<?= $data['exp'] ?>">
            </div>
            <div class="col-6 mb-3">
                <label>Level</label>
                <input type="number" class="form-control" name="data[level]" value="<?= $data['level'] ?>">
            </div>
            <div class="col-12 mb-3">
                <label>Khóa Tài Khoản</label>
                <select class="form-control" name="data[banned]">
                    <option value="false" <?php selected($data['danh_hieu'], 'false') ?>>Không Khóa</option>
                    <option value="true" <?php selected($data['danh_hieu'], 'true') ?>>Khóa</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>Châm Ngôn</label>
                <input type="text" class="form-control" name="data[quote]" value="<?= $data['quote'] ?>">
            </div>
            <div class="col-4 mb-3">
                <label>Coins</label>
                <input type="number" class="form-control" name="data[coins]" value="<?= $data['coins'] ?>">
            </div>
            <div class="col-4 mb-3">
                <label>Ipadress</label>
                <input type="text" class="form-control" name="data[ipadress]" value="<?= $data['ipadress'] ?>">
            </div>
            <div class="col-4 mb-3">
                <label>Thời Gian Tham Gia</label>
                <input type="text" class="form-control" value="<?= $data['time'] ?>" readonly>
            </div>
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Cập Nhật</button>
            </div>
        </div>
    </form>

    <h4 class="card-title mb-2">Thêm Icon Cho Thành Viên</h4>
    <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" class="form-control" name="table" value="user_icon" style="display: none;">
        <input type="text" class="form-control" name="New[user_id]" value="<?= $data['id'] ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Icon</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="New[icon]">
                    <button type="button" class="btn btn-primary" onclick="$('#icon').click();">Chọn File</button>
                    <input id="icon" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                </div>
            </div>
            <div class="col-6 mb-3">
                <label>Note Icon</label>
                <input type="text" class="form-control" name="New[note]">
            </div>
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Thêm Mới</button>
            </div>
        </div>
    </form>
    <h4 class="card-title mb-2">Gửi Thông Báo</h4>
    <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" class="form-control" name="table" value="notice" style="display: none;">
        <input type="text" class="form-control" name="New[user_id]" value="<?= $data['id'] ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-12 mb-3">
                <label>Nội Dung Comment</label>
                <input type="text" class="form-control" name="New[content]">
            </div>
            <input type="text" class="form-control" name="New[timestap]" value="<?= time() ?>" style="display: none;">
            <input type="text" class="form-control" name="New[time]" value="<?= DATEFULL ?>" style="display: none;">
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Thêm Mới</button>
            </div>
        </div>
    </form>
<?php } else if ($FormEdit == "ads") {
    $data = GetDataArr("ads", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" class="form-control" name="table" value="ads" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <input type="text" class="form-control" name="data[position_name]" value="<?= $data['position_name'] ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-12 mb-3">
                <label>Loại Quảng Cáo</label>
                <input type="text" class="form-control" value="<?= ADS_Name($data['position_name']) ?>" readonly>
            </div>
            <div class="col-12 mb-3">
                <label>Link Đích</label>
                <input type="text" class="form-control" name="data[href]" value="<?= $data['href'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Hình Ảnh</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[image]" value="<?= $data['image'] ?>">
                    <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                    <input id="image" type="file" style="display: none;" onchange="UploadImages(this, 250, 350);" accept="image/*" />
                </div>
            </div>
            <div class="col-6 mb-3">
                <label>Bật Tắt Quảng Cáo</label>
                <select class="form-control" name="data[type]">
                    <option value="true" <?= Selected($data['type'], 'true') ?>>Bật</option>
                    <option value="false" <?= Selected($data['type'], 'false') ?>>Tắt</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>Lượt Click</label>
                <input type="number" class="form-control" name="data[click]" value="<?= $data['click'] ?>">
            </div>
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Cập Nhật</button>
            </div>
        </div>
    </form>
<?php } else if ($FormEdit == "khung_vien") {
    $data = GetDataArr("khung_vien", "id = $id");
    ?>
    <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
        <input type="text" class="form-control" name="table" value="khung_vien" style="display: none;">
        <input type="text" name="id" value="<?= $id ?>" style="display: none;">
        <div class="form-group row">
            <div class="col-lg-12 col-md-12 mb-3">
                <label>Khung viền</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[icon]" value="<?=$data['icon']?>">
                    <button type="button" class="btn btn-primary" onclick="$('#icon').click();">Chọn File</button>
                    <input id="icon" type="file" style="display: none;" onchange="UploadImagesBase64(this, 'khung_vien');" accept="image/*" />
                </div>
            </div>
            <div class="col-12 mb-3">
                <label>Giá tiền</label>
                <input type="number" class="form-control" name="data[price]" value="<?=$data['price']?>">
            </div>
            <!-- <div class="col-12 mb-3">
                <label>Loại Quảng Cáo</label>
                <input type="text" class="form-control" value="<?= ADS_Name($data['position_name']) ?>" readonly>
            </div>
            <div class="col-12 mb-3">
                <label>Link Đích</label>
                <input type="text" class="form-control" name="data[href]" value="<?= $data['href'] ?>">
            </div>
            <div class="col-lg-6 col-md-12 mb-3">
                <label>Hình Ảnh</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="data[image]" value="<?= $data['image'] ?>">
                    <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                    <input id="image" type="file" style="display: none;" onchange="UploadImages(this, 250, 350);" accept="image/*" />
                </div>
            </div>
            <div class="col-6 mb-3">
                <label>Bật Tắt Quảng Cáo</label>
                <select class="form-control" name="data[type]">
                    <option value="true" <?= Selected($data['type'], 'true') ?>>Bật</option>
                    <option value="false" <?= Selected($data['type'], 'false') ?>>Tắt</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label>Lượt Click</label>
                <input type="number" class="form-control" name="data[click]" value="<?= $data['click'] ?>">
            </div> -->
            <div class="col-12 text-center mb-3">
                <button class="btn btn-outline-info mt-" type="submit">Cập Nhật</button>
            </div>
        </div>
    </form>
<?php
} else die("");
?>
<script src="<?= URL ?>/admin/assets/js/select2/select2.full.min.js"></script>
<script src="<?= URL ?>/admin/assets/js/select2/select2-custom.js"></script>
<script src="<?= URL ?>/admin/assets/js/jquery.ui.min.js"></script>
<script src="<?= URL ?>/admin/assets/js/editor/summernote/summernote.js"></script>
<script src="<?= URL ?>/admin/assets/js/editor/summernote/summernote.custom.js"></script>
<script src="<?= URL ?>/admin/assets/custom-theme/admin.js"></script>