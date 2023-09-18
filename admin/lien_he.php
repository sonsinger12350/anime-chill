<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "lien_he";
$stt = 0;
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
$WebsiteSlug = "/admin_movie/author";
if (GetParam("kw")) {
    $kw = sql_escape(GetParam("kw"));
    $LinkPage = $WebsiteSlug . "?kw=$kw&p=";
    $SQL = "WHERE name LIKE '%$kw%' OR url LIKE '%$kw%'";
} else $LinkPage = $WebsiteSlug . "?p=";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Thêm Liên Hệ";
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
                                <h4 class="card-title">Thêm Liên Hệ Mới</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="AddNewDatabase" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <input type="text" class="form-control" name="table" value="<?= $table ?>" style="display: none;">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Tên Liên Hệ</label>
                                            <input type="text" class="form-control" name="New[name]">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label>Địa Chỉ URL</label>
                                            <input type="text" class="form-control" name="New[url]">
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
                                    <div class="col-6">
                                        <h4 class="card-title">Danh Sách Liên Hệ</h4>
                                        <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="keyword" placeholder="Nhập Tên Liên Hệ Cần Tìm">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-success" onclick="location.href = `<?= $WebsiteSlug ?>?p=<?= $NumPage ?>&kw=${$('#keyword').val()}`">Tìm Kiếm</button>
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
                                                <th scope="col">Tên Liên Hệ</th>
                                                <th scope="col">URL</th>
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
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                    <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $stt ?></th>
                                                        <td><?= $row['name'] ?></td>
                                                        <td><a href="<?= $row['url'] ?>" target="_blank" rel="noopener noreferrer"><?= $row['url'] ?></a></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
                                                                <button class="btn btn-primary btn-xs" type="button" onclick="EditerForm('<?= $table ?>',<?= $row['id'] ?>);">Edit</button>
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