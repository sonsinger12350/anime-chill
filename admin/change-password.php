<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Thay Đổi Mật Khẩu Tài Khoản";
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <form submit-ajax="ngockush" form-action="ChangePassword" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                                        <div class="form-group row">
                                            <div class="col-12 mb-2">
                                                <label>Mật Khẩu Cũ</label>
                                                <input type="text" class="form-control" name="pw_old">
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label>Mật Khẩu Mới</label>
                                                <input type="text" class="form-control" name="pw_new">
                                            </div>
                                            <div class="col-6 mb-2">
                                                <label>Nhập Lại Mật Khẩu Mới</label>
                                                <input type="text" class="form-control" name="pw_new_re">
                                            </div>
                                            <div class="col-12 mb-2 text-center">
                                                <button type="submit" class="btn btn-primary">Thay Đổi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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