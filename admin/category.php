<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Quản Lý Thể Loại Phim";
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
                                <h4 class="card-title">Thêm Thể Loại Phim</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="NewCategory" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <div class="form-group row">
                                        <div class="col-12 mb-3">
                                            <label>Tên Thể Loại</label>
                                            <input type="text" class="form-control" name="name">
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
<h4 class="card-title">Thể loại đề cử</h4>
                            </div>
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="category_pin_top" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                    <div class="col-lg-12 col-md-12 mb-3">
                                        <label>Thể Loại Phim</label>
                                        <select class="js-example-basic-hide-search col-sm-12" name="category[]" multiple="multiple">
                                            <optgroup label="Thể Loại Phim">
                                                <?php
                                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "category ORDER BY id DESC");
                                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                ?>
                                                    <option value="<?= $row['id'] ?>" <?php foreach (json_decode($cf['nominations_category'], true) as $v) echo ($v['id'] == $row['id'] ? 'selected' : ''); ?>><?= $row['name'] ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <div class="col-12 text-center mb-3">
                                        <button class="btn btn-outline-info mt-" type="submit">Cập nhật</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="card col-lg-12">
                            <div class="card-header">
                                <h4 class="card-title">Danh Sách Thể Loại</h4>
                                <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
                                                <th scope="col">#</th>
                                                <th scope="col">Tên</th>
                                                <th scope="col">Tiêu Đề</th>
                                                <th scope="col">Mô Tả</th>
                                                <th scope="col">Slug</th>
                                                <th scope="col">Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $table = "category";
                                            $stt = 0;
                                            $NumPage = (GetParam("p") ? GetParam("p") : 1);
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
                                                        <td><?= $row['name'] ?></td>
                                                        <td><?= $row['title'] ?></td>
                                                        <td><?= $row['description'] ?></td>
                                                        <td><?= $row['slug'] ?></td>
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