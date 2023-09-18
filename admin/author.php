<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "user";
$stt = 0;
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
$WebsiteSlug = "/admin_movie/author";
if (GetParam("kw")) {
    $kw = sql_escape(GetParam("kw"));
    $LinkPage = $WebsiteSlug . "?kw=$kw&p=";
    $SQL = "WHERE email LIKE '%$kw%' OR nickname LIKE '%$kw%' OR ipadress LIKE '%$kw%'";
} else $LinkPage = $WebsiteSlug . "?p=";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Quản Lý Thành Viên";
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

                        <div class="card col-lg-12">
                            <div class="card-header">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <h4 class="card-title">Danh Sách Thành Viên</h4>
                                        <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="keyword" placeholder="Nhập Email Hoặc NickName Hoặc Địa Chỉ Ip">
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
                                                <th scope="col">User ID</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">NickName</th>
                                                <th scope="col">Kinh Nghiệm</th>
                                                <th scope="col">Level</th>
                                                <th scope="col">Banned</th>
                                                <th scope="col">Thời Gian Tham Gia</th>
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
                                                    if ($row['banned'] == 'false') {
                                                        $Band = '<span class="badge bg-success">Không Khóa</span>';
                                                    } else $Band = '<span class="badge bg-danger">Đã Khóa</span>';
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                        <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $row['id'] ?></th>
                                                        <td><img style="border-radius: 10px;" src="<?= $row['avatar'] ?>" width="50" height="50" alt="<?= $row['email'] ?>"><?= $row['email'] ?></td>
                                                        <td><?= $row['nickname'] ?> <?= UserIcon($row['id'], 20, 20) ?></td>
                                                        <td><?= $row['exp'] ?></td>
                                                        <td><?= $row['level'] ?></td>
                                                        <td><?= $Band ?></td>
                                                        <td><?= $row['time'] ?></td>
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