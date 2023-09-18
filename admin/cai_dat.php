<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Cài Đặt Website";
    require_once("defult/head.php");
    ?>
</head>

<body>
    <?php require_once("defult/loader.php"); ?>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <?php require_once("defult/header.php"); ?>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <?php require_once("defult/sidebar.php"); ?>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <h3><?= $title_admin ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid general-widget">
                    <div class="row">
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="UpdateDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
                                    <input type="text" class="form-control" name="table" value="config" style="display: none;">
                                    <input type="text" name="id" value="1" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Tiêu Đề</label>
                                            <input type="text" class="form-control" name="data[title]" value="<?= $cf['title'] ?>">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Mô Tả Website</label>
                                            <textarea class="form-control" name="data[description]"><?= $cf['description'] ?></textarea>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Favico</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="data[favico]" value="<?= $cf['favico'] ?>">
                                                <button type="button" class="btn btn-primary" onclick="$('#favico').click();">Chọn File</button>
                                                <input id="favico" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Ảnh Mô Tả</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="data[image]" value="<?= $cf['image'] ?>">
                                                <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                                                <input id="image" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Logo</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="data[logo]" value="<?= $cf['logo'] ?>">
                                                <button type="button" class="btn btn-primary" onclick="$('#logo').click();">Chọn File</button>
                                                <input id="logo" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Điều Khoản & Dịch Vụ</label>
                                            <textarea class="form-control" name="data[terms]"><?= $cf['terms'] ?></textarea>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Thời Gian Cache</label>
                                            <input type="text" class="form-control" name="data[time_cache]" value="<?= $cf['time_cache'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Slider</label>
                                            <select name="data[slider]" class="form-control">
                                                <option value="true" <?= Selected($cf['slider'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['slider'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Comment</label>
                                            <select name="data[cmt_on]" class="form-control">
                                                <option value="true" <?= Selected($cf['cmt_on'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['cmt_on'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Quảng Cáo TVC (Nhớ Phải Cài Đặt Quảng Cáo Video Player Trước)</label>
                                            <select name="data[tvc_on]" class="form-control">
                                                <option value="true" <?= Selected($cf['tvc_on'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['tvc_on'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt đăng ký tài khoản</label>
                                            <select name="data[sign_up]" class="form-control">
                                                <option value="1" <?= Selected($cf['sign_up'], 1) ?>>Bật</option>
                                                <option value="0" <?= Selected($cf['sign_up'], 0) ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Anti Ddos Lite Website</label>
                                            <select name="data[firewall]" class="form-control">
                                                <option value="true" <?= Selected($cf['firewall'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['firewall'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Onload Boxchat Trang Chủ</label>
                                            <select name="data[on_load_boxchat]" class="form-control">
                                                <option value="true" <?= Selected($cf['on_load_boxchat'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['on_load_boxchat'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Bật / Tắt Bảo Trì</label>
                                            <select name="data[baotri]" class="form-control">
                                                <option value="true" <?= Selected($cf['baotri'], 'true') ?>>Bật</option>
                                                <option value="false" <?= Selected($cf['baotri'], 'false') ?>>Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Mã Script Analytics</label>
                                            <textarea class="form-control" name="data[googletagmanager]"><?= un_htmlchars($cf['googletagmanager']) ?></textarea>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>FB App ID</label>
                                            <input type="text" class="form-control" name="data[fb_app_id]" value="<?= $cf['fb_app_id'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>VAST Ads Link</label>
                                            <input type="text" class="form-control" name="data[vast_link]" value="<?= $cf['vast_link'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>VAST Ads Video</label>
                                            <input type="text" class="form-control" name="data[vast_video]" value="<?= $cf['vast_video'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Thông Báo Chúc Mừng Khi Trên Level</label>
                                            <input type="text" class="form-control" name="data[level_notice]" value="<?= $cf['level_notice'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Giới Hạn Chúc Mừng Level</label>
                                            <input type="text" class="form-control" name="data[top_chucmung]" value="<?= $cf['top_chucmung'] ?>">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label>Giới Hạn Bảng Xếp Hạng</label>
                                            <input type="number" class="form-control" name="data[num_bxh]" value="<?= $cf['num_bxh'] ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Background Website</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="data[background]" value="<?= $cf['background'] ?>">
                                                <button type="button" class="btn btn-primary" onclick="$('#background').click();">Chọn File</button>
                                                <input id="background" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Tùy Chỉnh Mã Cuối Footer</label>
                                            <textarea class="form-control" name="data[script_footer]"><?= un_htmlchars($cf['script_footer']) ?></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Ghi Chú Đầu Trang (Có Thể Dùng HTML)</label>
                                            <textarea class="form-control" name="data[top_note]"><?= un_htmlchars($cf['top_note']) ?></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Hướng Dẫn (Có Thể Dùng HTML)</label>
                                            <textarea class="form-control" name="data[huong_dan]"><?= un_htmlchars($cf['huong_dan']) ?></textarea>
                                        </div>
                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info" type="submit">Cập Nhật Cài Đặt</button>
                                            <button class="btn btn-outline-danger" onclick="SendDataToServer({action: 'XoaCache'});" type="button">Xóa Cache Website</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="UpdateKeySeo" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Key Seo Phần Footer (VD : Tên Seo|Link Chuyển Hướng )</label>
                                            <textarea type="text" class="form-control" name="key_seo" rows="5" placeholder="Mỗi Key 1 Dòng VD: Phim Hay|<?= URL ?>"><?php foreach (json_decode($cf['key_seo'], true) as $key => $value) {
                                                                                                                                                                        echo $value['name'] . '|' . $value['url'] . "\n";
                                                                                                                                                                    } ?></textarea>
                                        </div>

                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info" type="submit">Cập Nhật</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once("defult/footer.php"); ?>
</body>

</html>