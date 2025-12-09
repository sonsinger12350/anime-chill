<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$config['db_host']    = 'localhost';
$config['db_name']     = 'animechill'; // Tên Database
$config['db_user']    = 'root'; // Tên Người Dùng Database
$config['db_pass']    = ''; // Mật Khẩu Database
$tb_prefix            = 'table_';
define('SERVER_HOST', $config['db_host']);
define('DATABASE_NAME', $config['db_name']);
define('DATABASE_USER', $config['db_user']);
define('DATABASE_PASS', $config['db_pass']);
define('DATABASE_FX',            'table_');
define('TIME', time());
define('DATE', date('Y-m-d'));
define('DATEFULL', date('d/m/Y - H:i:s'));
define('URL', 'http://localhost');
define('ADMIN', 'http://localhost/admin_movie');
define('EMAIL', 'None');
define('PASSMAIL', 'None');
define('UPLOAD_DIR', dirname(__DIR__) . '/assets/upload');
define('ROOT_DIR', dirname(__DIR__));
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
define('IP', $_SERVER['REMOTE_ADDR']);
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);
define('URL_LOAD', $_SERVER["REQUEST_URI"]);
define('GOOGLE_CLIENT_ID', '683221640163-u696gmgu75sp15afmbse3t3mdjo1q3jp.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'https://shumafood.com/login-google-callback');
include('init.php');
