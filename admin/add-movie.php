<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "movie";
$stt = 0;
$NumPage = GetParam("p");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Thêm Phim Mới";
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

                        <div class="card col-lg-12">
                            <div class="card-header">
                                <h4 class="card-title">Thêm Phim Mới</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
                                    <input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Tên Phim</label>
                                            <input type="text" class="form-control" name="New[name]" oninput="$('#SlugMovide').val(this.value);">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Tên Khác</label>
                                            <input type="text" class="form-control" name="New[other_name]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Tập Tiếp Theo: Tập 1 + Tập 2 + Tập 3</label>
                                            <input type="text" class="form-control" name="New[seo_title]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Seo Tập</label>
                                            <input type="text" class="form-control" name="data[seo_tap]" value="<?= $data['seo_tap'] ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Ảnh Nhỏ</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="New[image]">
                                                <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                                                <input id="image" type="file" style="display: none;" onchange="UploadImages(this, 250, 350);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Ảnh Lớn</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="New[image_big]">
                                                <button type="button" class="btn btn-primary" onclick="$('#image_big').click();">Chọn File</button>
                                                <input id="image_big" type="file" style="display: none;" onchange="UploadImages(this, 486, 274);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Thể Loại Phim</label>
                                            <select class="js-example-basic-hide-search col-sm-12" name="New[cate][][cate_id]" multiple="multiple">
                                                <optgroup label="Thể Loại Phim">
                                                    <?php
                                                    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "category ORDER BY id DESC");
                                                    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Đề Cử Phim</label>
                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                <div class="form-check form-check-inline radio radio-primary">
                                                    <input class="form-check-input" id="radioinline1" type="radio" name="New[de_cu]" value="true">
                                                    <label class="form-check-label mb-0" for="radioinline1">Đề Cử Phim</label>
                                                </div>
                                                <div class="form-check form-check-inline radio radio-primary">
                                                    <input class="form-check-input" id="radioinline2" type="radio" name="New[de_cu]" value="false" checked>
                                                    <label class="form-check-label mb-0" for="radioinline2">Không Đề Cử</label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Năm Sản Xuất</label>
                                            <select class="js-example-basic-hide-search col-sm-12" name="New[year]">
                                                <optgroup label="Năm Sản Xuất">
                                                    <?php
                                                    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "year ORDER BY id DESC");
                                                    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                    ?>
                                                        <option value="<?= $row['year'] ?>"><?= $row['year'] ?></option>
                                                    <?php } ?>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3" id="ThoiLuongPhim">
                                            <label>Thời Lượng Phim</label>
                                            <input type="number" class="form-control" name="New[movie_duration]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3" id="TongSoTap" style="display: none;">
                                            <label>Tổng Số Tập</label>
                                            <input type="text" class="form-control" name="New[ep_num]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3" id="TapHienTai" style="display: none;">
                                            <label>Tập Hiện Tại</label>
                                            <input type="text" class="form-control" name="New[ep_hien_tai]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Loại Phim</label>
                                            <select class="form-control" name="New[loai_phim]" onchange="ChangeElement(this);">
                                                <option value="Phim Lẻ">Phim Lẻ</option>
                                                <option value="Phim Bộ">Phim Bộ</option>
                                            </select>
                                        </div>
                                        <script>
                                            ChangeElement('select[name="New[loai_phim]"]');

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
                                            <label>Trạng Thái</label>
                                            <select class="js-example-basic-hide-search col-sm-12" name="New[trang_thai]">
                                                <optgroup label="Trạng Thái Phim">
                                                    <option value="Hoàn Thành">Hoàn Thành</option>
                                                    <option value="Đang Cập Nhật">Đang Cập Nhật</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Công Bố</label>
                                            <select class="js-example-basic-hide-search col-sm-12" name="New[public]">
                                                <optgroup label="Công Bố">
                                                    <option value="true">Công Khai</option>
                                                    <option value="false">Riêng Tư</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Lịch Chiếu Phim</label>
                                            <select class="js-example-basic-hide-search col-sm-12" name="New[lich_chieu][][days]" multiple="multiple">
                                                <optgroup label="Lịch Chiếu Phim">
                                                    <?php
                                                    for ($i = 2; $i < 8; $i++) {
                                                    ?>
                                                        <option value="<?= $i ?>">Thứ <?= $i ?></option>
                                                    <?php } ?>
                                                    <option value="8">Chủ Nhật</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Từ Khóa (Mỗi Từ Khóa 1 Dòng )</label>
                                            <textarea name="New[keyword]" class="form-control" rows="1" placeholder="Định Dạng : Từ Khóa | Link Từ Khóa"></textarea>
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label>Nội Dung Phim</label>
                                            <textarea name="New[content]" class="summernote form-control"></textarea>
                                        </div>
                                        <input type="text" class="form-control" name="New[time]" value="<?= DATEFULL ?>" style="display: none;">
                                        <input type="text" class="form-control" name="New[timestap]" value="<?= time(); ?>" style="display: none;">
                                        <input type="text" class="form-control" id="SlugMovide" name="New[slug]" style="display: none;">
                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info mt-2" type="submit">Thêm Mới</button>
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