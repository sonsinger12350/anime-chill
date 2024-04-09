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
define('UPLOAD_DIR', $_SERVER["DOCUMENT_ROOT"] . '/assets/upload');
define('ROOT_DIR', $_SERVER["DOCUMENT_ROOT"]);
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
    $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
define('IP', $_SERVER['REMOTE_ADDR']);
define('USER_AGENT', $_SERVER['HTTP_USER_AGENT']);
define('URL_LOAD', $_SERVER["REQUEST_URI"]);
include('init.php');
