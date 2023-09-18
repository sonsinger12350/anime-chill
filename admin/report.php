<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$table = "report";
$stt = 0;
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
$WebsiteSlug = "/admin_movie/report";
if (GetParam("kw")) {
    $kw = sql_escape(GetParam("kw"));
    $LinkPage = $WebsiteSlug . "?kw=$kw&p=";
    $SQL = "WHERE content LIKE '%$kw%'";
} else $LinkPage = $WebsiteSlug . "?p=";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Quản Lý Báo Lỗi";
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
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <h4 class="card-title">Danh Sách Báo Lỗi Phim</h4>
                                        <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="keyword" placeholder="Nhập Nội Dung Cần Tìm">
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
                                                <th scope="col">Tên Phim</th>
                                                <th scope="col">Tên Tập</th>
                                                <th scope="col">Nội Dung</th>
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
                                                    $Movie = GetDataArr('movie', "id = '{$row['movie_id']}'");
                                                    $Ep = GetDataArr('episode', "id = '{$row['episode_id']}'");
                                            ?>
                                                    <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                        <td>
                                                            <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                        </td>
                                                        <th scope="row"><?= $stt ?></th>
                                                        <td><a href="<?= URL ?>/admin_movie/movie?p=1&kw=<?= $Movie['name'] ?>"><?= $Movie['name'] ?></a></td>
                                                        <td><a href="<?= URL ?>/admin_movie/episode-movie?movie_id=<?= $Movie['id'] ?>&p=1&kw=<?= $Ep['ep_name'] ?>"><?= $Ep['ep_name'] ?></a></td>
                                                        <td><?= $row['content'] ?></td>
                                                        <td>
                                                            <div class="btn-group" role="group">
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