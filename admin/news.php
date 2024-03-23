<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "news";
$stt = 0;
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
if (GetParam("kw")) {
    $kw = sql_escape(GetParam("kw"));
    $Link_Slug = URL . "/admin_movie/news?kw=$kw&p=";
    $SQL = "WHERE name LIKE '%$kw%' OR other_name LIKE '%$kw%'";
} else $Link_Slug = URL . "/admin_movie/news?p=";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $title_admin = "Danh Sách News";
        require_once("defult/head.php");
    ?>
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/select2.css">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/summernote.css">

    <style>
        .btn-edit {
            width: 35px;
        }

        .btn-view {
            width: 70px;
        }
    </style>
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
                        <div class="card col-lg-12">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <h4 class="card-title">Dánh Sách News</h4>
                                        <button class="btn btn-danger-gradien mb-2" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                        <button class="btn btn-success-gradien mb-2 set-trang-thai" data-type="true" type="button">Công khai</button>
                                        <button class="btn btn-warning-gradien mb-2 set-trang-thai" data-type="false" type="button">Riêng tư</button>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="keyword" placeholder="Nhập Tên Phim Cần Tìm">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success" onclick="location.href = `<?= URL ?>/admin_movie/news?p=<?= $NumPage ?>&kw=${$('#keyword').val()}`">Tìm Kiếm</button>
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
                                                <th scope="col">Tên Phim</th>
                                                <th scope="col" style="width: 85px;">Lượt đọc</th>
                                                <th scope="col" style="width: 95px;">Công Khai</th>
                                                <th scope="col">Thời Gian</th>
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
                                                    if ($row['public'] == 'true') {
                                                        $Public = '<span class="badge bg-success fs-7">Công Khai</span>';
                                                    } else $Public = '<span class="badge bg-warning fs-7">Riêng Tư</span>';
                                            ?>
                                                <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                    <td>
                                                        <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                    </td>
                                                    <th scope="row"><?= $stt ?></th>
                                                    <td><?= $row['name'] ?></td>
                                                    <td><?= $row['view'] ?></td>
                                                    <td><?= $Public ?></td>
                                                    <td><span class="badge bg-primary fs-7"><?= $row['time'] ?></span></td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <button class="btn btn-primary btn-xs btn-edit" type="button" onclick="LoadFormEdit('<?= $table ?>',<?= $row['id'] ?>);">Sửa</button>
                                                            <button class="btn btn-danger btn-xs" type="button" onclick="TableXoa('<?= $table ?>',<?= $row['id'] ?>);">Xóa</button>
                                                            <a class="btn btn-info btn-xs btn-view" href="<?= URL ?>/news/<?= $row['slug'] ?>.html" target="_blank">Xem Thử</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?= view_pages_admin($P['total'], $cf['limits'], $NumPage, $Link_Slug) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once("defult/footer.php"); ?>
    <script src="<?= URL ?>/admin/assets/js/select2/select2.full.min.js"></script>
    <script src="<?= URL ?>/admin/assets/js/select2/select2-custom.js"></script>
    <script src="<?= URL ?>/admin/assets/js/jquery.ui.min.js"></script>
    <script src="<?= URL ?>/admin/assets/js/editor/summernote/summernote.js"></script>
    <script src="<?= URL ?>/admin/assets/js/editor/summernote/summernote.custom.js"></script>
</body>

</html>