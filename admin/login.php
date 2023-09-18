<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (isset($_SESSION['admin'])) die(header("location:" . URL . "/admin_movie"));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= URL ?>/admin/assets/images/logo/favicon-icon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?= URL ?>/admin/assets/images/logo/favicon-icon.png" type="image/x-icon">
    <title>Đăng Nhập Tài Khoản Quản Trị </title>
    <!-- Google font-->
    <meta name="csrf-token" content="<?= $_SESSION['csrf-token'] ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?= URL ?>/admin/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= URL ?>/admin/assets/css/responsive.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- login page start-->
    <section> </section>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="login-card">
                    <form class="theme-form login-form" submit-ajax="ngockush" form-action="loginadmin" action="<?= URL ?>/admin/server/api" method="POST" form-check="true">
                        <h4>Đăng Nhập Tài Khoản Admin</h4>
                        <div class="form-group">
                            <label>Tên Tài Khoản</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-user"></i></span>
                                <input class="form-control" type="text" name="username" required="" placeholder="join164654**">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Mật Khẩu</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                                <input class="form-control" type="password" name="password" required="" placeholder="*********">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Đăng Nhập</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="<?= URL ?>/admin/assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?= URL ?>/admin/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="<?= URL ?>/admin/assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= URL ?>/admin/assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <!-- Sidebar jquery-->
    <script src="<?= URL ?>/admin/assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?= URL ?>/admin/assets/js/script.js"></script>
    <script src="<?= URL ?>/admin/assets/custom-theme/admin.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
</body>

</html>