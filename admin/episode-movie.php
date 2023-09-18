<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
$movie_id = GetParam("movie_id");
if (get_total('movie', "WHERE id = '$movie_id'") < 1) die(header("location:/admin_movie/movie"));
$Movie = GetDataArr('movie', "id = '$movie_id'");
$Ep = GetDataArr('episode', "movie_id = '$movie_id' ORDER BY ep_num DESC");
$NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
if (GetParam("kw")) {
    $kw = sql_escape(GetParam("kw"));
    $Link_Slug = URL . "/admin_movie/episode-movie?movie_id=$movie_id&kw=$kw&p=";
    $SQL = "AND ep_name LIKE '%$kw%'";
} else $Link_Slug = URL . "/admin_movie/episode-movie?movie_id=$movie_id&p=";
$table = 'episode';
$CheckServer = get_total('movie_server', "WHERE movie_id = '$movie_id'");
$P = CheckPages($table, "WHERE movie_id = '$movie_id' $SQL", $cf['limits'], $NumPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Episode Phim " . $Movie['name'];
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
                                <h4 class="card-title"><button class="btn btn-danger btn-sm" onclick="$('#Edit_Item').html('');$('#Edit_Item').hide();$('#NewItem').show();" type="button">Đóng</button></h4>
                            </div>
                            <div class="card-body" id="BodyEditerAjax"></div>
                        </div>
                        <?php if ($CheckServer < 1) { ?>
                            <div class="alert alert-warning" style="border-radius: 10px;">
                                Chưa Thêm Server Nào
                            </div>
                        <?php } ?>
                        <?php if ($CheckServer >= 1 && $P['total'] >= 1) { ?>
                            <div class="card col-lg-12">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <h4 class="card-title">Danh Sách Episode <span class="badge bg-success">Tổng Số Episode : <span class="text-danger fw-bold"><?= number_format(get_total('episode', "WHERE movie_id = '$movie_id'")) ?></span> Episode</span></h4>
                                            <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('<?= $table ?>');">Xóa Đã Chọn</button>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="keyword" placeholder="Nhập Tên Episode Cần Tìm">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-success" onclick="location.href = `<?= URL ?>/admin_movie/episode-movie?movie_id=<?= $movie_id ?>&p=<?= $NumPage ?>&kw=${$('#keyword').val()}`">Tìm Kiếm</button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"><input class="form-check-input" id="chontatca" type="checkbox"></th>
                                                    <th scope="col">Episode ID</th>
                                                    <th scope="col">Tên Episode</th>
                                                    <th scope="col">Episode Num</th>
                                                    <th scope="col">Số Server</th>
                                                    <th scope="col">Thao Tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($P['total']) {
                                                    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "$table WHERE movie_id = '$movie_id' $SQL ORDER BY id DESC LIMIT {$P['start']},{$cf['limits']}");
                                                    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                                        $stt++;
                                                ?>
                                                        <tr id="<?= $table ?>_<?= $row['id'] ?>">
                                                            <td>
                                                                <input class="form-check-input" name="multi_del" type="checkbox" value="<?= $row['id'] ?>">
                                                            </td>
                                                            <th scope="row"><?= $row['id'] ?></th>
                                                            <td><?= $row['ep_name'] ?></td>
                                                            <td><?= $row['ep_num'] ?></td>
                                                            <td><?= count(json_decode($row['server'], true)) ?></td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <button class="btn btn-primary btn-sm" type="button" onclick="LoadFormEdit('ServerAddEpisode',<?= $row['id'] ?>);">Chỉnh Sửa</button>
                                                                    <button class="btn btn-danger btn-sm" type="button" onclick="TableXoa('<?= $table ?>',<?= $row['id'] ?>);">Xóa</button>
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
                        <?php } ?>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-header">
                                <h4 class="mb-4">Thêm Server <button type="button" class="btn btn-sm btn-primary" id="add-fast-server" data-movie="<?= $movie_id ?>">Thêm server nhanh</button></h4>
                                <?php if ($CheckServer >= 1) { ?>
                                    <div style="display: flex;" class="mb-4">
                                        <div>
                                            <button class="btn btn-success" style="margin-right: 10px;" type="button" onclick="FecthServerMovie();">Thêm Trường Tập Mới <i class="fa fa-plus-square"></i></button>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" id="add_episode_speed" min="0" class="form-control" placeholder="Thêm Nhanh">
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");
                                while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
                                    if (get_total("movie_server", "WHERE movie_id = '$movie_id' AND server_id = '{$row['id']}'") >= 1) {
                                        echo '<button class="btn btn-danger btn-sm mt-2" style="margin-right: 10px;" type="button" onclick="SendDataToServer({action: \'ServerDelete\',ServerID: \'' . $row['id'] . '\',MovieID: \'' . $movie_id . '\'});">' . $row['server_name'] . ' <i class="fa fa-close"></i></button>';
                                    } else {
                                        echo '<button class="btn btn-success btn-sm mt-2" style="margin-right: 10px;" type="button" onclick="SendDataToServer({action: \'ServerAdd\',MovieID: \'' . $movie_id . '\',ServerID: \'' . $row['id'] . '\'});">' . $row['server_name'] . ' <i class="fa fa-plus-square"></i></button>';
                                    }
                                }
                                ?>
                            </div>
                            <?php if ($CheckServer >= 1) { ?>
                                <div class="card-body">
                                    <form submit-ajax="Episode" form-action="AddNewEpisode2" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
                                        <input type="text" class="form-control" id="movie_id" value="<?= $movie_id ?>" style="display: none;">
                                        <div class="col-lg-12 mb-3" id="MainServer2"></div>
                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info mt-2" type="submit">Thêm Mới</button>
                                            <button class="btn btn-outline-warning mt-2" id="upgrade-episode-server" data-movie="<?= $movie_id ?>" type="button">Update lại server</button>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-header">
                                <h4 class="mb-4">Thao Tác Episode Server Nhanh</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-group mb-4">
                                        <label>Chọn Server</label>
                                        <select class="form-control" id="server_name">
                                            <?php
                                            $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "server ORDER BY id DESC");
                                            while ($row = $arr->fetch(PDO::FETCH_ASSOC)) { ?>
                                                <option value="<?= $row['server_name'] ?>"><?= $row['server_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group mb-4">
                                        <label>List Episode</label>
                                        <textarea rows="10" class="form-control" placeholder="Chú Ý Mỗi Link 1 Dòng" id="episode-server-list"></textarea>
                                    </div>
                                    <div class="form-group mb-4">
                                        <button type="button" class="btn btn-success" onclick="speed_edit_of_new('update-server-episode');">Cập Nhật</button>
                                        <button type="button" class="btn btn-primary" onclick="speed_edit_of_new('add-server-episode');">Thêm Mới</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("defult/footer.php"); ?>
    <script>
        function speed_edit_of_new(action) {
            let server_list = $('#episode-server-list').val();
            if (!server_list) {
                Swal.fire({
                    html: 'Vui Lòng Điền Danh Sách Link',
                    iconHtml: `<img src="/admin/assets/icon/warning.png" width="50" height="50">`,
                    confirmButtonText: 'Đồng Ý',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        icon: 'no-border'
                    }
                });
                return;
            }
            $.post('/admin/server/api', {
                "server_list": server_list,
                "server_name": $('#server_name').val(),
                "movie_id": <?= $movie_id ?>,
                "action": action
            }, function(data) {
                Swal.fire({
                    "title": `Code ${data.code}`,
                    html: data.message,
                    icon: 'success',
                    confirmButtonText: 'Đồng Ý',
                    customClass: {
                        confirmButton: "btn btn-primary",
                        icon: 'no-border'
                    }
                });
                if (data.code == 200) {
                    location.reload();
                }
            })
        };
    </script>
    <?php
    $Se = 0;
    $arr = $mysql->query("SELECT * FROM " . DATABASE_FX . "movie_server WHERE movie_id = '$movie_id' ORDER BY id DESC");
    while ($row = $arr->fetch(PDO::FETCH_ASSOC)) {
        $C = GetDataArr('server', "id = '{$row['server_id']}'");
        if (get_total('server', "WHERE id = '{$row['server_id']}'") < 1) {
            $mysql->delete('movie_server', "server_id = '{$row['server_id']}'");
        }
        $Jserver .= '{
            server_name:"' . $C['server_name'] . '",
            server_link: ""
        },';
        $FServer .= '<div class="col mb-3">
                    <label>Link Server ' . $C['server_name'] . '</label>
                    <input type="text" style="display: none;" class="form-control" name="New[${Num}][server][' . $Se . '][server_name]" value="' . $C['server_name'] . '">
                    <input type="text" onchange="GetLink(this);" oninput="PushServer(${Num}, ' . $Se . ', this)" class="form-control" name="New[${Num}][server][' . $Se . '][server_link]">
                </div>';
        $Se++;
    } ?>
    <script>
        var EpisodeArr = new Array();
        var Num = -1;
        var Episode = <?= ($Ep['ep_num'] ? $Ep['ep_num'] : 0) ?>;
        $("#add_episode_speed").on("change", function() {
            var n = $(this).val();
            for (let index = 0; Num < n; index++) {
                FecthServerMovie();
            }
        });

        function FecthServerMovie() {
            Num++;
            Episode++;
            EpisodeArr[Num] = {
                epname: Episode,
                server: [<?= $Jserver ?>]
            }
            console.log(EpisodeArr);
            $(`#MainServer2`).append(`
                                    <div class="form-group row bg-primary mb-3" id="server_id_${Num}" style="border-radius: 5px;padding: 10px;">
                                    <input type="text" class="form-control" name="New[${Num}][movie_id]" value="<?= $movie_id ?>" style="display: none;">
                                        <div class="col mb-3">
                                            <label>Tên Episode</label>
                                            <input type="text" class="form-control" name="New[${Num}][ep_name]" onchange="PushEpname(${Num}, this);" value="${Episode}">
                                        </div>
                                        <?= $FServer ?>
                                       <button class="btn btn-danger btn-xs" style="width: 35px;height: 25px;margin-top: 30px;" onclick="RemoveServer('server_id_${Num}')" type="button">Xóa</button>
                                    </div>`);

        }
    </script>
</body>

</html>