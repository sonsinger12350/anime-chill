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
                                            <label>Time Stap</label>
                                            <input type="text" class="form-control" name="data[timestap]" value="<?= $data['timestap'] ?>">
                                        </div>
                                            <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Link Phim</label>
                                            <input type="text" class="form-control" name="data[slug]" value="<?= $data['slug'] ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Tập Tiếp Theo:</label><input type="text" value="Tập 1 + Tập 2 + Tập 3" id="myInput">
                                            <input type="text" class="form-control" name="New[seo_title]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Seo Tập: </label><input type="text" value="Tập 1, Tập 2, Tập 3, Tập 4, Tập 5, Tập 6, Tập 7, Tập 8, Tập 9, Tập 10, Tập 11, Tập 12, Tập 13, Tập 14, Tập 15, Tập 16, Tập 17, Tập 18, Tập 19, Tập 20, Tập 21, Tập 22, Tập 23, Tập 24, Tập 25, Tập 26, Tập 27, Tập 28, Tập 29, Tập 30, Tập 31, Tập 32, Tập 33, Tập 34, Tập 35, Tập 36, Tập 37, Tập 38, Tập 39, Tập 40, Tập 41, Tập 42, Tập 43, Tập 44, Tập 45, Tập 46, Tập 47, Tập 48, Tập 49, Tập 50, Tập 51, Tập 52, Tập 53, Tập 54, Tập 55, Tập 56, Tập 57, Tập 58, Tập 59, Tập 60, Tập 61, Tập 62, Tập 63, Tập 64, Tập 65, Tập 66, Tập 67, Tập 68, Tập 69, Tập 70, Tập 71, Tập 72, Tập 73, Tập 74, Tập 75, Tập 76, Tập 77, Tập 78, Tập 79, Tập 80, Tập 81, Tập 82, Tập 83, Tập 84, Tập 85, Tập 86, Tập 87, Tập 88, Tập 89, Tập 90, Tập 91, Tập 92, Tập 93, Tập 94, Tập 95, Tập 96, Tập 97, Tập 98, Tập 99, Tập 100, Tập 101, Tập 102, Tập 103, Tập 104, Tập 105, Tập 106, Tập 107, Tập 108, Tập 109, Tập 110, Tập 111, Tập 112, Tập 113, Tập 114, Tập 115, Tập 116, Tập 117, Tập 118, Tập 119, Tập 120, Tập 121, Tập 122, Tập 123, Tập 124, Tập 125, Tập 126, Tập 127, Tập 128, Tập 129, Tập 130, Tập 131, Tập 132, Tập 133, Tập 134, Tập 135, Tập 136, Tập 137, Tập 138, Tập 139, Tập 140, Tập 141, Tập 142, Tập 143, Tập 144, Tập 145, Tập 146, Tập 147, Tập 148, Tập 149, Tập 150, Tập 151, Tập 152, Tập 153, Tập 154, Tập 155, Tập 156, Tập 157, Tập 158, Tập 159, Tập 160, Tập 161, Tập 162, Tập 163, Tập 164, Tập 165, Tập 166, Tập 167, Tập 168, Tập 169, Tập 170, Tập 171, Tập 172, Tập 173, Tập 174, Tập 175, Tập 176, Tập 177, Tập 178, Tập 179, Tập 180, Tập 181, Tập 182, Tập 183, Tập 184, Tập 185, Tập 186, Tập 187, Tập 188, Tập 189, Tập 190, Tập 191, Tập 192, Tập 193, Tập 194, Tập 195, Tập 196, Tập 197, Tập 198, Tập 199, Tập 200," id="myInput">
                                            <input type="text" class="form-control" name="New[seo_tap]">
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
                                            <label>Giờ Chiếu</label>
                                            <input type="text" class="form-control" name="New[showtimes]">
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