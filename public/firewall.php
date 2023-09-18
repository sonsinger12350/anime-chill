<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
if ($cf['firewall'] == 'false' && !$_SESSION['admin']) die(header("location: /"));
if (isset($_SESSION['FireWallSuccess']) && !$_SESSION['admin']) die(header("location: /"));
if ($_SESSION['Error_FireWall'] >= 5 && !$_SESSION['admin']) die(header("location: https://www.google.com/search?q=" . Webname()));
    
if (!$_SESSION['FireWallToken']) {
    $FireWallToken = base64_encode(json_encode(array(
        "token" => tokenString(20),
        "ipadress" => IP,
        "time" => time()
    )));
    $_SESSION['FireWallToken'] = $FireWallToken;
} else $FireWallToken = $_SESSION['FireWallToken'];

if ($_POST['access_confirmation']) {
    HeaderApplication();
    // Thần Đồng Thuật Toán à :v
    if ($_SESSION['Error_FireWall']) {
        $_SESSION['Error_FireWall'] += 1;
    } else $_SESSION['Error_FireWall'] = 1;

    $access_confirmation = sql_escape($_POST['access_confirmation']);
    $confirmation_capcha = sql_escape($_POST['confirmation_capcha']);
    $TokenF = json_decode(base64_decode($_SESSION['FireWallToken']), true);
    if ($TokenF['ipadress'] != IP) die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if ($firewall_token != $_SESSION['FireWallToken']) die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if ($TokenF['time'] > time()) die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if ($referer != URL . '/confirm-robot') die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if (!$user_agent) die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if ($TokenF['ipadress'] != $access_confirmation) die(JsonMessage(401, "Không Thể Xác Minh Về Trình Duyệt Của Bạn"));
    if (IP != $access_confirmation) die("6");
    if ($confirmation_capcha != $_SESSION["captcha"]) die(JsonMessage(401, "Mã Xác Minh Không Đúng Vui Lòng Thử Lại"));
    $_SESSION['FireWallSuccess'] = IP;
    die(JsonMessage(200, "Xác Minh Thành Công Bạn Có Thể Truy Cập Website"));
}
if (!$_POST) {
    $Capcha = ImagesCapcha();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Xác Nhận Bạn Không Phải Robot</title>
    <link rel="canonical" href="<?= URL ?>" />
    <link rel="icon" href="<?= $cf['favico'] ?>" />
    <meta name="_firewall-token" content="<?= $FireWallToken ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?= URL ?>/themes/styles/css.css?v=1.4.0" rel="stylesheet" />
    <script src="https://polyfill.io/v3/polyfill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .image-robot {
            padding: 0px 10px;
        }
    </style>

</head>

<body class="scroll-bar">
    <script>
        function SendCheck(input) {
            let InputCapcha = $(input);
            let TextCapcha = InputCapcha.val();
            if (TextCapcha.length < 6) {
                $('#capcha-message').html(`<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Mã Xác Minh Phải Bao Gồm 6 Ký Tự</div>`);
                return
            }
            if (TextCapcha.length > 6) {
                $('#capcha-message').html(`<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Mã Xác Minh Phải Bao Gồm 6 Ký Tự</div>`);
                return;
            }
            $('.input-zero').hide();
            $('#capcha-message').html(`<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Đang Check Mã Của Bạn Vui Lòng Chờ<img class="image-robot" src="/themes/img/loader.svg" style="width: 25px;height: 25px"></div>`);
            setTimeout(function() {
                let setting = {
                    type: "POST",
                    url: "/confirm-robot",
                    data: {
                        access_confirmation: "<?= IP ?>",
                        confirmation_capcha: TextCapcha
                    },
                    headers: {
                        "firewall-token": $('meta[name="_firewall-token"]').attr("content"),
                    },
                    dataType: "json",
                    success: function(res) {
                        if (res.code == 200) {
                            $('#capcha-message').html(`<div class="noti-success flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Xác Minh Thành Công Bạn Sẽ Được Chuyển Hướng Sau 3s</div>`);
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            $('#capcha-message').html(`<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Mã Xác Minh Không Đúng Vui Lòng Thử Lại</div>`);
                            $('.input-zero').show();
                            InputCapcha.val('');
                        }
                    },
                    error: function(error) {
                        $('#capcha-message').html(`<div class="noti-error flex flex-hozi-center"><span class="material-icons-round margin-0-5">error</span>Check Mã Xác Minh Không Thành Công</div>`);
                        location.reload();
                    }
                };
                $.ajax(setting);
            }, 200);
        }
    </script>
    <div id="ah_wrapper">
        <div class="ah_content">
            <div class="margin-10-0 flex flex-ver-center">
                <h3 class="section-title">
                    <span>Checking If Brower You're A Robot <span id="firewall-second"></span>
                </h3>
            </div>
            <div class="margin-10-0 align-center">
                <div id="capcha-message"></div>
                <div class="input-zero">
                    <label><img src="<?= $Capcha['images'] ?>" width="100"></label>
                    <input type="text" name="capcha" placeholder="Nhập Mã Xong Nhấn Enter" onchange="SendCheck(this);" onsubmit="SendCheck(this);">
                </div>
                <img src="/themes/img/Xl3c.gif" style="width: 100px;height: 100px">
            </div>

        </div>

    </div>

</body>

</html>