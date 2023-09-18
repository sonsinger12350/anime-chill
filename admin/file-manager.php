<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Quản Lý Tập Tin Ảnh";
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
                    <div class="col-xl-12 card">
                        <div class="card-header">
                            <h3><?= $title_admin ?></h3>
                            <button type="button" class="btn btn-primary" onclick="$('#chontatca').click();">Chọn Tất Cả</button>
                            <input class="form-check-input" style="display: none;" id="chontatca" type="checkbox">
                            <button class="btn btn-danger-gradien" type="button" onclick="MultiDel('XoaFile');">Xóa</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                $folder = ROOT_DIR . '/assets/upload';
                                $files = glob($folder . "/*.{jpg,JPG,jpeg,JPEG,png,PNG}", GLOB_BRACE);
                                $FileNum = count($files);
                                if ($FileNum >= 1) {
                                    $NumPage = (GetParam("p") ? sql_escape(GetParam("p")) : 1);
                                    $P = pagination($FileNum, 8, $NumPage);
                                    $start = $P['start'];
                                    for ($i = 0; $i < 8; $i++) {
                                        $start++;
                                        $file = $files[$start];
                                        $filesize1 = filesize($file); // bytes
                                        $filesize = format_size($filesize1);
                                        if (is_file($file)) {
                                ?>
                                            <div class="col-xl-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div class="text-center">
                                                            <img class="img-fluid" src="/assets/upload/<?= basename($file) ?>" style="width: auto;height: 100px;">
                                                            <div class="fw-bold mt-2">
                                                                <span class="text-danger">(<?= $filesize ?>)</span>
                                                            </div>
                                                            <div class="fw-bold mt-2">
                                                                <span class="text-danger"><?= (strlen(basename($file)) >= 36 ? substr(basename($file), 30) : basename($file)) ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body fw-bold">
                                                        <div class="mt-2">
                                                            <div class="form-check checkbox mb-0">
                                                                <input class="form-check-input" id="checkbox_<?= $i ?>" name="multi_del" type="checkbox" value="<?= $file ?>">
                                                                <label class="form-check-label" for="checkbox_<?= $i ?>">Chọn</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php }
                                    }
                                } ?>
                            </div>
                            <?= view_pages_admin($P['total'], 8, $NumPage, URL . "/admin_movie/file-manager?p=") ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php require_once("defult/footer.php"); ?>
</body>

</html>