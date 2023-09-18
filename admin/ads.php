<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = 'ads';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Cài Đặt Quảng Cáo";
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

                        <div class="card col-lg-12" id="Edit_Item" style="display: none;">
                            <div class="card-header">
                                <h4 class="card-title">Chỉnh Sửa Quảng Cáo</h4>
                            </div>
                            <div class="card-body" id="BodyEditerAjax"></div>
                        </div>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-header">
                                <h4 class="card-title">Thêm Quảng Cáo</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="AddNewADS" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-lg-6 mb-3">
                                            <label>Link Chuyển Hướng</label>
                                            <input type="text" class="form-control" name="New[href]">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Hình Ảnh</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="New[image]">
                                                <button type="button" class="btn btn-primary" onclick="$('#image').click();">Chọn File</button>
                                                <input id="image" type="file" style="display: none;" onchange="UploadImages(this, 250, 350);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label>Bật Tắt Quảng Cáo</label>
                                            <select class="form-control" name="New[type]">
                                                <option value="true">Bật</option>
                                                <option value="false">Tắt</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label>Loại Quảng Cáo</label>
                                            <select class="form-control" name="New[position_name]">
                                                <option value="floating_left"><?= ADS_Name('floating_left') ?></option>
                                                <option value="floating_right"><?= ADS_Name('floating_right') ?></option>
                                                <option value="top_banner_pc"><?= ADS_Name('top_banner_pc') ?></option>
                                                <option value="bot_banner_pc"><?= ADS_Name('bot_banner_pc') ?></option>
                                                <option value="top_banner_mb"><?= ADS_Name('top_banner_mb') ?></option>
                                                <option value="bot_banner_mb"><?= ADS_Name('bot_banner_mb') ?></option>
                                                <option value="banner_balloon_catfish"><?= ADS_Name('banner_balloon_catfish') ?></option>
                                                <option value="balloon_catfish_mb"><?= ADS_Name('balloon_catfish_mb') ?></option>
                                                <option value="pop_under"><?= ADS_Name('pop_under') ?></option>
                                                <option value="pop_under_home"><?= ADS_Name('pop_under_home') ?></option>
                                                <option value="pop_under_info"><?= ADS_Name('pop_under_info') ?></option>
                                                <option value="pop_under_watch"><?= ADS_Name('pop_under_watch') ?></option>
                                                <option value="banner_player_watch_mb"><?= ADS_Name('banner_player_watch_mb') ?></option>
                                                <option value="banner_player_watch"><?= ADS_Name('banner_player_watch') ?></option>
                                            </select>
                                        </div>
                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info mt-" type="submit">Thêm Mới</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-lg-12">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h4 class="card-title">Danh Sách Quảng Cáo</h4>
                                        <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>

                                                <th scope="col">#</th>
                                                <th scope="col">Loại Quảng Cáo</th>
                                                <th scope="col">Link Đích</th>
                                                <th scope="col">Hình Ảnh</th>
                                                <th scope="col">Trạng Thái</th>
                                                <th scope="col">Lượt Click</th>
                                                <th scope="col">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $P = CheckPages($table, "$SQL", $cf['limits'], $NumPage);
                                            if ($P['total']) {
                                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "$table $SQL ORDER BY id DESC LIMIT {$P['start']},{$cf['limits']}");
                                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                    $stt++;
                                                    if ($row['type'] == 'true') {
                                                        $TrangThai = '<span class="badge bg-success">Đang Bật</span>';
                                                    } else $TrangThai = '<span class="badge bg-danger">Đang Tắt</span>';
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                        <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $stt ?></th>
                                                        <td><?= ADS_Name($row['position_name']) ?></td>
                                                        <td><?= $row['href'] ?></td>
                                                        <td><img style="max-width: 200px;" src="<?= $row['image'] ?>" alt=""></td>
                                                        <td><?= $TrangThai ?></td>
                                                        <td><?= number_format($row['click']) ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-primary btn-xs" type="button" onclick="LoadFormEdit('<?= $table ?>',<?= $row['id'] ?>);">Edit</button>
                                                                <button class="btn btn-danger btn-xs" type="button" onclick="TableXoa('<?= $table ?>',<?= $row['id'] ?>);">Xóa</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?= view_pages_admin($P['total'], $cf['limits'], $NumPage, $LinkPage) ?>
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