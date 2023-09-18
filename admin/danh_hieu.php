<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "level_color";
$stt = 0;
$NumPage = GetParam("p") ? GetParam("p") : 1;
$LinkPage = URL . "/admin_movie/danh_hieu?p=";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Danh Hiệu Và Màu Level";
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
                                <h4 class="card-title">Trình Chỉnh Sửa Trực Quan DATABASE</h4>
                            </div>
                            <div class="card-body" id="BodyEditerAjax"></div>
                        </div>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-header">
                                <h4 class="card-title">Thêm Danh Hiệu Và Màu Level</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Level</label>
                                            <input type="number" class="form-control" name="New[level]">
                                        </div>
                                        <div class="col-lg-12 col-md-12 mb-3">
                                            <label>Icon</label>
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="New[icon]">
                                                <button type="button" class="btn btn-primary" onclick="$('#icon').click();">Chọn File</button>
                                                <input id="icon" type="file" style="display: none;" onchange="UploadImagesBase64(this);" accept="image/*" />
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Danh Hiệu</label>
                                            <input type="text" class="form-control" name="New[danh_hieu]">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Màu</label>
                                            <input type="color" class="form-control" name="New[color]">
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
                                <h4 class="card-title">Danh Sách</h4>
                                <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
                                                <th scope="col">#</th>
                                                <th scope="col">Level</th>
                                                <th scope="col">Icon</th>
                                                <th scope="col">Danh Hiệu</th>
                                                <th scope="col">Màu</th>
                                                <th scope="col">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $P = CheckPages($table, "", $cf['limits'], $NumPage);
                                            if ($P['total'] >= 1) {
                                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "$table ORDER BY id DESC LIMIT {$P['start']},{$cf['limits']}");
                                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                    $stt++;
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                        <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $stt ?></th>
                                                        <td><?= $row['level'] ?></td>
                                                        <td><?= ($row['icon'] ? "<img src=\"{$row['icon']}\" width=\"50\" height=\"50\">" : 'Không Có Icon') ?></td>
                                                        <td><?= $row['danh_hieu'] ?></td>
                                                        <td class="fw-bold" style="color: <?= $row['color'] ?>;"><?= $row['color'] ?></td>
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