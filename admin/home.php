<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Trang Quản Trị Admin";
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
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Số Thể Loại</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("category")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Episode</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("episode")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Phim</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("movie")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Báo Lỗi</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("report")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Server</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("server")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Năm</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("year")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Bình Luận</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("comment")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Thông Báo</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("notice")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Báo Lỗi</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("report")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Thành Viên</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("user")) ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-lg-6">
                            <div class="card o-hidden">
                                <div class="card-body">
                                    <div class="media static-widget">
                                        <div class="media-body">
                                            <h6 class="font-roboto fs-5 fw-bold">Tổng Số Liên Hệ</h6>
                                            <h4 class="mb-0 counter"><?= number_format(get_total("lien_he")) ?></h4>
                                        </div>
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
</body>

</html>