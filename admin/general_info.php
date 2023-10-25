<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if (!$_SESSION['admin']) die(header("location:" . URL . "/admin_movie/login"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $title_admin = "Cài đặt Thông Tin Chung";
    $configs = getConfigGeneralUserInfo([
        'vip_package',
        'join_telegram',
        'first_login',
        'online_reward',
        'farm_tree',
        'comment',
        'first_upload_avatar',
        'vip_icon',
        'deposit_min',
        'deposit_rate',
        'deposit_exp',
        'vip_fee',
    ]);
    
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
                        <div class="card col-lg-12" id="NewItem">
                            <div class="card-body">
                                <form submit-ajax="ngockush" form-action="update-user-general-info" action="<?= URL ?>/admin/server/api" method="POST" form-check="false">
                                    <div class="form-group row">
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Gói VIP ADS:</label>
                                            <textarea class="form-control" name="data[vip_package]"><?= $configs['vip_package'] ?></textarea>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Tham gia nhóm Telegram:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="data[join_telegram]" value="<?= $configs['join_telegram'] ?>">
                                                <div class="input-group-text">XU</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Đăng nhập mỗi ngày:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="data[first_login]" value="<?= $configs['first_login'] ?>">
                                                <div class="input-group-text">XU</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Online:</label>
                                            <textarea class="form-control" name="data[online_reward]"><?= $configs['online_reward'] ?></textarea>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Cây khế nông trại:</label>
                                            <input type="text" class="form-control" name="data[farm_tree]" value="<?= $configs['farm_tree'] ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Bình luận:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="data[comment]" value="<?= $configs['comment'] ?>">
                                                <div class="input-group-text">XU</div>
                                            </div>
                                            <span>mỗi bình luận trong bộ phim trong 1 ngày + <?= $configs['comment'] ?> xu (chỉ tính bình luận đầu tiên trong ngày của bộ phim đó ).</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Up Avatar:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="data[first_upload_avatar]" value="<?= $configs['first_upload_avatar'] ?>">
                                                <div class="input-group-text">XU</div>
                                            </div>
                                            <span>+<?= $configs['first_upload_avatar'] ?> xu ( lần đầu )</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Vip Icon:</label>
                                            <input type="text" class="form-control" name="data[vip_icon]" value="<?= $configs['vip_icon'] ?>">
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Nạp Xu:</label>
                                            <div class="d-flex align-items-center mb-2" style="gap: 10px">
                                                Nạp ít nhất 
                                                <div class="input-group w-50">
                                                    <input type="nunber" name="data[deposit_min]" value="<?=$configs['deposit_min']?>" class="form-control">
                                                    <div class="input-group-text">$</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-2" style="gap: 10px">
                                                Mỗi 1$ = 
                                                <div class="input-group w-50">
                                                    <input type="nunber" name="data[deposit_rate]" value="<?=$configs['deposit_rate']?>" class="form-control">
                                                    <div class="input-group-text">XU</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center" style="gap: 10px">
                                                Kinh nghiệm nhận được 1$ = 
                                                <div class="input-group w-50">
                                                    <input type="nunber" name="data[deposit_exp]" value="<?=$configs['deposit_exp']?>" class="form-control">
                                                    <div class="input-group-text">EXP</div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 mb-3">
                                            <label>Giá Vip / Tháng:</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="data[vip_fee]" value="<?= $configs['vip_fee'] ?>">
                                                <div class="input-group-text">XU</div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mb-3">
                                            <button class="btn btn-outline-info" type="submit">Cập Nhật Cài Đặt</button>
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
    <?php require_once("defult/footer.php"); ?>
</body>

</html>