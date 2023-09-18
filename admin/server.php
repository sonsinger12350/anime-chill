<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "server";
$stt = 0;
$NumPage = GetParam("p");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Quản Lý Server Play Phim";
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
                            <div class="card-body" id="BodyEditerAjax">
                            </div>
                        </div>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-header">
                                <h4 class="card-title">Thêm Server Mới</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Tên Server</label>
                                            <input type="text" class="form-control" name="New[server_name]">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Loại Player</label>
                                            <select class="form-control" name="New[server_player]">
                                                <option value="iframe">Trình Phát Nhúng (Iframe)</option>
                                                <option value="player">Trình Phát (Mp4,Hls,M3u8)</option>
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
                                <h4 class="card-title">Danh Sách Server</h4>
                                <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
                                                <th scope="col">#</th>
                                                <th scope="col">Tên Server</th>
                                                <th scope="col">Trình Phát</th>
                                                <th scope="col">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $P = CheckPages($table, "", $cf['limits'], $NumPage);
                                            if ($P['total']) {
                                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "$table ORDER BY id DESC LIMIT {$P['start']},{$cf['limits']}");
                                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                    $stt++;
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                        <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $stt ?></th>
                                                        <td><?= $row['server_name'] ?></td>
                                                        <td><?= $row['server_player'] ?></td>
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
                                <?= view_pages_admin($P['total'], $cf['limits'], $NumPage, URL . "/admin_movie/$table?p=") ?>
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