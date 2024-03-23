<?php
define('MovieAnime', true);
header("X-Frame-Options: SAMEORIGIN");
date_default_timezone_set('Asia/Ho_Chi_Minh');
mb_internal_encoding("UTF-8");
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('memory_limit', '512M');
include_once('vendor/autoload.php');
include_once('includes/configurations.php');
include_once('includes/Alltemplate.php');
include_once('includes/function.php');
include_once('includes/JSPacker.php');
include_once('includes/capcha.php');
//Phần Head
$header = getallheaders();
$x_csrf_token = (isset($header['X-CSRF-TOKEN']) ? sql_escape($header['X-CSRF-TOKEN']) : sql_escape($header['X-Csrf-Token']));
$firewall_token = (isset($header['FIREWALL-TOKEN']) ? sql_escape($header['FIREWALL-TOKEN']) : sql_escape($header['Firewall-Token']));
$referer = (isset($header['Referer']) ? sql_escape($header['Referer']) : sql_escape($header['referer']));
$user_agent = (isset($header['User-Agent']) ? sql_escape($header['User-Agent']) : sql_escape($header['user-agent']));
//Phần Head End
use Phpfastcache\Helper\Psr16Adapter;

$defaultDriver = 'Files';
$InstanceCache = new Psr16Adapter($defaultDriver);
if (isset($_SESSION['csrf-token'])) {
    define('TOKEN', $_SESSION['csrf-token']);
} else {
    $csrfToken = tokenString(35);
    define('TOKEN', $csrfToken);
    $_SESSION['csrf-token'] = $csrfToken;
}

if (isset($_SESSION['admin'])) {
    $admin_username = $_SESSION['admin'];
    $admin = GetDataArr('admin', "username = '$admin_username'");
}

if (isset($_COOKIE['author'])) {
    $_accesstoken = sql_escape($_COOKIE['_accesstoken']);
    $_author_cookie = sql_escape($_COOKIE['author']);
    if (get_total('user', "WHERE _accesstoken = '$_author_cookie'") >= 1) {
        $user = GetDataArr('user', "_accesstoken = '$_author_cookie'");
        $useremail = $user['email'];
        UpdateLevel($user);
        resetVipUser($user['vip_date_end'], $user['id'], $user['vip']);
        $mysql->update("user", "online = 0", "1");
        $mysql->update("user", "online = 1", "email = '$useremail'");
        // Check is first login
        $sqlCheck = "SELECT `id`, `type`, `movie_id`, `ads_type`
			FROM `table_history_add_coin` 
			WHERE `user_id` = ".$user['id']." AND `type` = 'first_login' AND `created_at` = '".date('Y-m-d')."'";
        $resultCheck = $mysql->query($sqlCheck);
        $dataCheck = $resultCheck->fetch(PDO::FETCH_ASSOC);

        if (empty($dataCheck)) {
            addCoin($user['id'], 'first_login');
        }
        $user['khung-vien'] = getIconStoreActive($user['id'], 'khung-vien');
        $user['icon-user'] = '';
        $listUserIconActive = listUserIconActive($user['id']);

        if (!empty($listUserIconActive)) {
            $user['icon-user'] .= "<div class='icon-user'>";

            foreach ($listUserIconActive as $k => $v) {
                $user['icon-user'] .= "<img src='".$v."' />";
            }

            $user['icon-user'] .= "</div>";
        }

        if ($_author_cookie != $user['_accesstoken']) {
            RemoveCookie();
        } else if (!$_author_cookie) {
            RemoveCookie();
        } else if ($user['id'] < 1) RemoveCookie();
    } else RemoveCookie();
}
RemoveViewUser();
ClearNotice();

if (isset($_GET['models'])) {
    $Gmodels    =    $_GET['models'];
    $value = array();
    $value    =    explode("/", $Gmodels);
    $models =   $value[1];
    $method = "public/$models";
} else if (isset($_GET['api'])) {
    $Gmodels    =    $_GET['api'];
    $value = array();
    $value    =    explode("/", $Gmodels);
    $models =   $value[1];
    $method = "api/$models";
} else if (isset($_GET['admin'])) {
    $Gmodels    =    $_GET['admin'];
    $value = array();
    $value    =    explode("/", $Gmodels);
    $models =   $value[1];
    $method = "admin/$models";
} else if (isset($_GET['author'])) {
    $Gmodels    =    $_GET['author'];
    $value = array();
    $value    =    explode("/", $Gmodels);
    $models =   $value[1];
    $folder = "author";
    $method = "author/$models";
} else {
    $method = "public/home";
}
$filename = ROOT_DIR . "/$method.php";
if (file_exists($filename)) {
    include_once($filename);
} else die(header('Location: /404-page'));
