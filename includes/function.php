<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
function RemoveCookie()
{
    setcookie('author', null, -1, '/', URL_None_HTTP(), false);
    setcookie('_accesstoken', null, -1, '/', URL_None_HTTP(), false);
}
function LevelExp($level, $KinhNghiem)
{
    $exp = 0;
    if ($level < 2) return $KinhNghiem;
    for ($i = 1; $i < $level + 1; $i++) {
        if ($level > $i) {
            $e = ($i * 30);
            $exp += $e;
        }
    }
    if ($KinhNghiem >= 1) return ($exp + $KinhNghiem);
    return $exp;
}
function ClearNotice()
{
    global $mysql;
    $Timer = date('Y-m-d');
    $mysql->delete('notice', "time != '$Timer'");
}
function RenderAccessToken()
{
    $Accesstoken = encrypt_decrypt('encrypt', json_encode(array(
        "timestap" => time(),
        "full_date" => date("Y-m-d H:i:s"),
        "domain" => URL,
        "AccessToken" => tokenString(25),
        "ipadress" => IP
    )));
    return $Accesstoken;
}
function RemoveViewUser()
{
    global $cf, $mysql;
    $day = date('d');
    if ($cf['day'] != $day) {
        $mysql->update('config', "day = $day", "id = 1");
        $mysql->delete('user_movie', "day != $day");
    }
}
function JsonMessage($code, $message)
{
    $Json_API = array('code' => $code, 'message' => $message);
    return json_encode($Json_API);
}

function SaveTxt($filename, $content)
{
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, mb_convert_encoding($content, 'UTF-8'));
    fclose($myfile);
}
function UpdateLevel($user)
{
    global $mysql;
    if (isset($user['id'])) {
        $KinhNghiem = getExpLevel($user['level']);
        if ($user['exp'] >= $KinhNghiem) {
            $LevelPlus = ($user['level'] + 1);
            $mysql->insert('notice', 'user_id,content,timestap,time', "'{$user['id']}','Chúc Mừng Bạn Đã Thằng Cấp Từ Level " . number_format($user['level']) . " Lên Level " . number_format($LevelPlus) . " Hãy Cố Gắng Để Đạt Được Những Cấp Cao Hơn Nhé','" . time() . "','" . DATE . "'");
            $mysql->update("user", "exp = 0,level = level + 1", "id = '{$user['id']}'");
        }
    }
}
function getYoutubeIdFromUrl($url)
{
    $parts = parse_url($url);
    if (isset($parts['query'])) {
        parse_str($parts['query'], $qs);
        if (isset($qs['v'])) {
            return $qs['v'];
        } else if (isset($qs['vi'])) {
            return $qs['vi'];
        }
    }
    if (isset($parts['path'])) {
        $path = explode('/', trim($parts['path'], '/'));
        return $path[count($path) - 1];
    }
    return false;
}
function Voteting($point, $all)
{
    try {
        $average = round(($point / $all), 1);
    } catch (\Throwable $th) {
        $average = 0;
    }
    return $average;
}

function GetParam($Param)
{
    $Val = urldecode(explode("&", explode("$Param=", URL_LOAD)[1])[0]);
    return isset($Val) ? sql_escape($Val) : false;
}
function SendMail($title, $content, $to_email)
{
    global $mail, $cf;
    try {
        $mail->isSMTP();                                          //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
        $mail->Username   = $cf['smtp_email'];                    //SMTP username
        $mail->Password   = $cf['smtp_password'];                 //SMTP password
        $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($cf['smtp_email'], $title);
        $mail->addAddress($to_email);               //Name is optional
        $mail->isHTML(true);                        //Set email format to HTML
        $mail->Subject = $title;
        $mail->Body    = $content;
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
function FireWall()
{
    global $cf;

    if ($cf['firewall'] == 'true' && !$_SESSION['admin'] && !$_SESSION['FireWallSuccess']) {
        if (!$_SESSION['FireWallSuccess']) die(header("location:/confirm-robot"));
    } else if (!$_SESSION['admin'] && !$_GET['admin'] && $cf['baotri'] == 'true') {
        header("location:" . URL . '/website/bao-tri');
    }
}
function Selected($txt, $txt1)
{
    if ($txt == $txt1) {
        return "selected";
    }
}
function Checked($txt, $txt1)
{
    if ($txt == $txt1) {
        return "checked";
    }
}

function Webname()
{
    if (explode(".", explode("https://", URL)[1])[0]) {
        $NameWeb = explode(".", explode("https://", URL)[1])[0];
    } else {
        $NameWeb = explode(".", explode("http://", URL)[1])[0];
    }
    return $NameWeb;
}
function URL_None_HTTP()
{
    if (explode("https://", URL)[1]) {
        $NameWeb = explode("https://", URL)[1];
    } else {
        $NameWeb = explode("http://", URL)[1];
    }
    return $NameWeb;
}
function HeaderApplication()
{
    header("content-type:application/json");
}
function InputJson()
{
    $json = json_decode(file_get_contents('php://input'), true);
    return $json;
}
function imagesaver($image_data, $folder = '')
{

    list($type, $data) = explode(';', $image_data); // exploding data for later checking and validating 

    if (preg_match('/^data:image\/(\w+);base64,/', $image_data, $type)) {
        $data = substr($data, strpos($data, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, gif

        if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png', 'webp', 'gif'])) {
            return false;
        }

        $data = base64_decode($data);

        if ($data === false) {
            return false;
        }
    }
    else {
        return false;
    }

    $FileName = tokenString(15) . time();
    $FileNew = !empty($folder) ? UPLOAD_DIR ."/". $folder . "/$FileName.$type"  : UPLOAD_DIR . "/$FileName.$type";

    if (file_put_contents($FileNew, $data)) {
        $Images = !empty($folder) ? "/assets/upload/$folder/$FileName.$type" : URL . "/assets/upload/$FileName.$type";
    }
    else {
        return false;
    }

    /* it will return image name if image is saved successfully 
    or it will return error on failing to save image. */
    return $Images;
}
function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80)
{
    $imgsize = getimagesize($source_file);
    $width = $imgsize[0];
    $height = $imgsize[1];
    $mime = $imgsize['mime'];

    switch ($mime) {
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;

        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;

        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;

        default:
            return false;
            break;
    }

    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);

    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if ($width_new > $width) {
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    } else {
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled(
            $dst_img,
            $src_img,
            0,
            0,
            $w_point,
            0,
            $max_width,

            $max_height,
            $width_new,
            $height
        );
    }

    $image($dst_img, $dst_dir, $quality);

    if ($dst_img) imagedestroy($dst_img);
    if ($src_img) imagedestroy($src_img);
}
function CheckCapcha($captcha)
{
    global $cf;
    $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(json_decode($cf['recapcha'], true)['secret_key']) .  '&response=' . urlencode($captcha));
    $responseKeys = json_decode($response, true);
    if ($responseKeys["success"]) {
        return true;
    } else return false;
}
function format_size($size)
{
    $mod = 1024;
    $units = explode(' ', 'B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }

    return round($size, 2) . ' ' . $units[$i];
}
function HTMLMethodNot($method)
{
    header("HTTP/1.1 $method");
    $html = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8" />
        <meta name="robots" content="noindex,nofollow,noarchive" />
        <title>An Error Occurred: Method Not Allowed</title>
        <style>body { background-color: #fff; color: #222; font: 16px/1.5 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; margin: 0; }
    .container { margin: 30px; max-width: 600px; }
    h1 { color: #dc3545; font-size: 24px; }
    h2 { font-size: 18px; }</style>
    </head>
    <body>
    <div class="container">
        <h1>Oops! An Error Occurred</h1>
        <h2>The server returned a "' . $method . ' Method Not Allowed".</h2>
    
        <p>
            Something is broken. Please let us know what you were doing when this error occurred.
            We will fix it as soon as possible. Sorry for any inconvenience caused.
        </p>
    </div>
    </body>
    </html>';
    return $html;
}
function ProxyTinsoft($api_key)
{
    global $curl;
    $new_proxy = json_decode($curl->get('http://proxy.tinsoftsv.com/api/changeProxy.php?key=' . $api_key));
    if ($new_proxy->success == true) {
        return $new_proxy->proxy;
    } else if ($new_proxy->success == false) {
        if ($new_proxy->description == 'wrong key!') {
            return false; // Lỗi Key Đã Hết Hạn Hoặc Không Sử Dụng Được
        } else {
            $new_proxy3 = json_decode($curl->get('http://proxy.tinsoftsv.com/api/getProxy.php?key=' . $api_key));
            return $new_proxy3->proxy;
        }
    }
}
function Del($str)
{
    $str = str_replace("for (;;);", "", $str);
    $str = str_replace("\u00253", "%3", $str);
    $str = str_replace("\u00252", "%2", $str);
    $str = str_replace("\u00253D", "=", $str);
    $str = str_replace("\/", "/", $str);

    return $str;
}

function ChuyenXangCDN($url)
{
    $url = explode('.net/', $url)[1];
    return 'https://scontent.cdninstagram.com/' . $url;
}
function GetCookie($username, $password)
{
    global $curl;
    $url = 'https://b-api.facebook.com/method/auth.login?access_token=237759909591655%25257C0f140aabedfb65ac27a739ed1a2263b1&format=json&sdk_version=2&email=' . $username . '&locale=en_US&password=' . $password . '&sdk=ios&generate_session_cookies=1&sig=3f555f99fb61fcd7aa0c44f58f522ef6';
    $curl->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36');
    $curl->get($url);
    $json = json_decode(json_encode($curl->response));
    if (!$json->session_cookies[0]->name) return false;
    $Cookies = $json->session_cookies[0]->name . '=' . $json->session_cookies[0]->value . ';' . $json->session_cookies[1]->name . '=' . $json->session_cookies[1]->value . ';' . $json->session_cookies[2]->name . '=' . $json->session_cookies[2]->value . ';' . $json->session_cookies[3]->name . '=' . $json->session_cookies[3]->value . ';';
    return $Cookies;
}
function json_api($statut, $message)
{
    $json = array('statut' => $statut, 'message' => $message);
    return json_encode($json);
}
function Swaler($notice)
{
    $html = "<script>
                Swal.fire({
                    html: '$notice',
                    buttonsStyling: false,
                    confirmButtonText: 'Tôi Đồng Ý',
                    customClass: {
                        confirmButton: 'btn font-weight-bold btn-light'
                    }
                })
            </script>";
    return $html;
}
function Swaler_reload($notice)
{
    $html = "<script>
                Swal.fire('" . $notice . "').then((result) => {
                    window.location.href = '" . URL_LOAD . "';
                })
            </script>";
    return $html;
}
function CheckPages($table, $f2, $limit, $page)
{
    $total_records = get_total($table, $f2);
    //TÌM LIMIT VÀ CURRENT_PAGE
    $current_page = $page ? $page : 1;
    // TÍNH TOÁN TOTAL_PAGE VÀ START
    // tổng số trang
    $total_page = ceil($total_records / $limit);
    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    // Tìm Start
    $start = ($current_page - 1) * $limit;
    $SoSad = array(
        'start' => $start,
        'total' => $total_records
    );
    return $SoSad;
}
function pagination($total_records, $limit, $page)
{
    $current_page = $page ? $page : 1;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page) {
        $current_page = $total_page;
    } else if ($current_page < 1) {
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
    $SoSad = array(
        'start' => $start,
        'total' => $total_records
    );
    return $SoSad;
}
function chuyenslug($str)
{
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '-', $str);
    return $str;
}
function ServerName($str)
{
    $str = trim(mb_strtolower($str));
    $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
    $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
    $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
    $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
    $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
    $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
    $str = preg_replace('/(đ)/', 'd', $str);
    $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
    $str = preg_replace('/([\s]+)/', '_', $str);
    return $str;
}
function XoaDauPhay($str)
{
    $str = preg_replace('/,/', '', $str);
    return $str;
}
function PopUnder($Location)
{   
    // Handler Stop Ads for User Vip
    $user = [];
    $user['id'] = 0;
    if (isset($_COOKIE['author'])) {
        $_accesstoken = sql_escape($_COOKIE['_accesstoken']);
        $_author_cookie = sql_escape($_COOKIE['author']);
        if (get_total('user', "WHERE _accesstoken = '$_author_cookie'") >= 1) {
            $user = GetDataArr('user', "_accesstoken = '$_author_cookie'");
            $useremail = $user['email'];
            UpdateLevel($user);
            if ($_author_cookie != $user['_accesstoken']) {
                RemoveCookie();
            } else if (!$_author_cookie) {
                RemoveCookie();
            } else if ($user['id'] < 1) RemoveCookie();
        } else RemoveCookie();
    }
    if(checkVipUser($user['id'])) return;
    // [End] Stop Ads for User Vip
    if (get_total("ads", "WHERE position_name = '$Location' AND type = 'true'") < 1) return;
    $ads = GetDataArr("ads", "position_name = '$Location' AND type = 'true'");
    return '<div id="popup-giua-man-hinh">
                <div class="popUpBannerBox" style="display: block;">
                    <div class="popUpBannerInner">
                        <div class="popUpBannerContent">
                            <p><a href="#" class="closeButton">ĐÓNG</a></p>
                            <a href="' . $ads['href'] . '" onclick="updateClickAds(' . $ads['id'] . ');" target="_blank" rel="nofollow" style="display: block;" class="banner-link">
                                <img class="responsive" src="' . $ads['image'] . '" alt="Letou" style="max-width: 100%;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>';
}
function ADS_Name($name)
{
    if ($name == 'balloon_catfish_mb') {
        return 'Catfish Mobile';
    } else if ($name == 'banner_balloon_catfish') {
        return 'Catfish PC';
    } else if ($name == 'bot_banner_mb') {
        return 'Banner Footer Trên Mobile';
    } else if ($name == 'top_banner_mb') {
        return 'Banner Top Trên Mobile';
    } else if ($name == 'bot_banner_pc') {
        return 'Banner Footer Trên PC';
    } else if ($name == 'top_banner_pc') {
        return 'Banner Top Trên PC';
    } else if ($name == 'floating_right') {
        return 'Banner Phải';
    } else if ($name == 'floating_left') {
        return 'Banner Trái';
    } else if ($name == 'pop_under') {
        return 'Quảng Cáo Popup';
    } else if ($name == 'pop_under_home') {
        return 'Quảng Cáo Nổi Trang Chủ';
    } else if ($name == 'pop_under_info') {
        return 'Quảng Cáo Nổi Thông Tin Phim';
    } else if ($name == 'pop_under_watch') {
        return 'Quảng Cáo Nổi Xem Phim';
    } else if ($name == 'banner_player_watch') {
        return 'Quảng Cáo Player PC';
    } else if ($name == 'banner_player_watch_mb') {
        return 'Quảng Cáo Player Mobile';
    }
}
function get_ascii($str)
{
    $chars = array(
        'a'    =>    array('ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'á', 'à', 'ả', 'ã', 'ạ', 'â', 'ă', 'Á', 'À', 'Ả', 'Ã', 'Ạ', 'Â', 'Ă'),
        'e'     =>    array('ế', 'ề', 'ể', 'ễ', 'ệ', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê'),
        'i'    =>    array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'),
        'o'    =>    array('ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'Ố', 'Ồ', 'Ổ', 'Ô', 'Ộ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ơ', 'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ơ'),
        'u'    =>    array('ứ', 'ừ', 'ử', 'ữ', 'ự', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư'),
        'y'    =>    array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'),
        'd'    =>    array('đ', 'Đ'),
    );
    foreach ($chars as $key => $arr)
        foreach ($arr as $val)
            $str = str_replace($val, $key, $str);
    return $str;
}
function Khoangtrang($string)
{
    $name = preg_replace('/\s+/', '', $string);
    return $name;
}
function getCurURL()
{
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
        $pageURL = "https://";
    } else $pageURL = 'http://';
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    return $pageURL;
}
function htmltxt($document)
{
    $search = array(
        '@<script???[^>]*?>.*?</script???>@si',  // Strip out javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
        '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
    );
    $text = preg_replace($search, '', $document);
    return $text;
}
function un_htmlchars($str)
{

    return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;', '&#92;', '&#39'), array('<', '>', '"', '&', chr(92), chr(39)), $str);
}
function LevelColor($level)
{
    if (!$level) return '#e8dcf4';
    if (get_total("level_color", "WHERE level <= '$level' ORDER BY level DESC") < 1) {
        if ($level >= 10) {
            return '#6ebee5';
        } else return '#e8dcf4';
    }
    $row = GetDataArr("level_color", "level <= '$level' ORDER BY level DESC");
    return $row['color'];
}
function LevelIcon($level, $width, $height)
{
    if (!$level) return '&nbsp;<span data-tooltip="Người Mới"><img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="' . $width . '" height="' . $height . '" alt="Người Mới"></span>&nbsp;';
    if (get_total("level_color", "WHERE level <= '$level' ORDER BY level DESC") < 1) {
        if ($level >= 10) {
            return '&nbsp;<span data-tooltip="Người Mới"><img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="' . $width . '" height="' . $height . '" alt="Người Mới"></span>&nbsp;';
        } else return '&nbsp;<span data-tooltip="Người Mới"><img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="' . $width . '" height="' . $height . '" alt="Người Mới"></span>&nbsp;';
    }
    $row = GetDataArr("level_color", "level <= '$level' ORDER BY level DESC");
    if (!$row['icon']) return '&nbsp;<span data-tooltip="' . $row['danh_hieu'] . '"><img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="' . $width . '" height="' . $height . '" alt="' . $row['danh_hieu'] . '"></span>&nbsp;';
    return '&nbsp;<span data-tooltip="' . $row['danh_hieu'] . '"><img style="border-radius: 5px;" src="' . $row['icon'] . '" width="' . $width . '" height="' . $height . '" alt="' . $row['danh_hieu'] . '"></span>&nbsp;';
}
function Danh_Hieu($level)
{
    if (!$level) return 'Nhập Môn';
    if (get_total("level_color", "WHERE level <= '$level' ORDER BY level DESC") < 1) {
        if ($level >= 10) {
            return 'Thành Viên Chính Thức';
        } else return 'Nhập Môn';
    }
    $row = GetDataArr("level_color", "level <= '$level' ORDER BY level DESC");
    return $row['danh_hieu'];
}
function RankIcon($level)
{
    if (!$level) return '<span class="level-icon-rank" data-tooltip="Người Mới">
                            <img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="20" height="20" alt="Người Mới">
                        </span>';
    if (get_total("level_color", "WHERE level <= '$level' ORDER BY level DESC") < 1) {
        if ($level >= 10) {
            return '<span class="level-icon-rank" data-tooltip="Người Mới">
                        <img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="20" height="20" alt="Người Mới">
                    </span>';
        } else return '<span class="level-icon-rank" data-tooltip="Người Mới">
                        <img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="20" height="20" alt="Người Mới">
                    </span>';
    }
    $row = GetDataArr("level_color", "level <= '$level' ORDER BY level DESC");
    if (!$row['icon']) return '<span class="level-icon-rank" data-tooltip="Người Mới">
                                <img style="border-radius: 5px;" src="' . URL . '/themes/img/new.png" width="20" height="20" alt="Người Mới">
                            </span>';
    return '<span class="level-icon-rank" data-tooltip="' . $row['danh_hieu'] . '">
                <img style="border-radius: 5px;" src="' . $row['icon'] . '" width="20" height="20" alt="' . $row['danh_hieu'] . '">
            </span>';
}
function htmlchars($str)
{

    return str_replace(
        array('&', '<', '>', '"', chr(92), chr(39)),
        array('&amp;', '&lt;', '&gt;', '&quot;', '&#92;', '&#39'),
        $str
    );
}
function htmlchars_cmt($str)
{

    return str_replace(
        array('"', '<', '>', '"', chr(92), chr(39)),
        array('', '&lt;', '&gt;', '&quot;', '&#92;', '&#39'),
        $str
    );
}
function injection($str)
{

    $chars = array('chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(', 'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20', 'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20', '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/X11R6/bin/xterm', 'lsof%20', '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml', 'file\://', 'window.open', '<SCRIPT>', 'javascript\://', 'img src', 'img%20src', '.jsp', 'ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', '/robot.txt', '/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=', '\'');

    foreach ($chars as $key => $arr)

        $str = str_replace($arr, '*', $str);

    return $str;
}
function sql_escape($value)
{
    $value = trim(htmlchars(stripslashes(urldecode(injection($value)))));
    return $value;
}
function RemainTime($timestamp, $detailLevel = 1)
{

    $periods = array("giây", "phút", "giờ", "ngày", "tuần", "tháng", "năm", "thập kỷ");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();

    // check validity of date
    if (empty($timestamp)) return "Unknown time";

    // is it future date or past date
    if ($now > $timestamp) {
        $difference = $now - $timestamp;
        $tense = "trước";
    } else {
        $difference = $timestamp - $now;
        $tense = "from now";
    }

    if ($difference == 0) return "vài giây trước";

    $remainders = array();

    for ($j = 0; $j < count($lengths); $j++) {
        $remainders[$j] = floor(fmod($difference, $lengths[$j]));
        $difference = floor($difference / $lengths[$j]);
    }

    $difference = round($difference);

    $remainders[] = $difference;

    $string = "";

    for ($i = count($remainders) - 1; $i >= 0; $i--) {
        if ($remainders[$i]) {
            $string .= $remainders[$i] . " " . $periods[$i];

            if ($remainders[$i] != 1)  $string .= "";

            $string .= " ";

            $detailLevel--;

            if ($detailLevel <= 0) break;
        }
    }

    return $string . $tense;
}
function IpAdress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else $ip_address = $_SERVER['REMOTE_ADDR'];

    return $ip_address;
}
function tokenString($length)
{
    $str = "";
    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
    $max = count($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
function encrypt_decrypt($action, $string)
{
    $output         = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key     = 'hacklamcaigiwebcuatao';
    $secret_iv      = 'duanaohacklamconcho';
    $key            = hash('sha256', $secret_key);
    $iv             = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function RegexParam($text, $text1, $str, $num)
{
    $value = sql_escape(urldecode(explode($text1, explode($text, $str)[$num])[0]));
    if (!$value) return false;
    return $value;
}
function unescapeUTF8EscapeSeq($str)
{
    return preg_replace_callback("/\\\u([0-9a-f]{4})/i", create_function('$matches', 'return html_entity_decode(\'&#x\'.$matches[1].\';\', ENT_QUOTES, \'UTF-8\');'), $str);
}
function get_idyoutube($urls)
{
    $url = explode('v=', $urls);
    $url = explode('&', $url[1]);
    $id = $url[0];
    return $id;
}
function Keyword($keyword)
{
    $kw = false;
    foreach (json_decode($keyword, true) as $key => $value) {
        if ($value['name']) {
            $kw .= $value['name'] . ",";
        }
    }
    return $kw;
}
function sw_get_current_weekday()
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch ($weekday) {
        case 'monday':
            $weekday = 2;
            break;
        case 'tuesday':
            $weekday = 3;
            break;
        case 'wednesday':
            $weekday = 4;
            break;
        case 'thursday':
            $weekday = 5;
            break;
        case 'friday':
            $weekday = 6;
            break;
        case 'saturday':
            $weekday = 7;
            break;
        default:
            $weekday = 8;
            break;
    }
    return $weekday;
}
function RemoveHtml($document)
{
    $search = array(
        '@<script[^>]*?>.*?</script>@si', // Chứa javascript
        '@<[\/\!]*?[^<>]*?>@si', // Chứa các thẻ HTML
        '@<style[^>]*?>.*?</style>@siU', // Chứa các thẻ style
        '@<![\s\S]*?--[ \t\n\r]*>@' // Xóa toàn bộ dữ liệu bên trong các dấu ngoặc "<" và ">"
    );
    $text   = preg_replace($search, '', $document);
    $text   = strip_tags($text);
    $text   = trim($text);
    return $text;
}
function is_mobile()
{
    if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    if (preg_match('/wap.|.wap/i', $_SERVER['HTTP_ACCEPT']))
        return true;

    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        $user_agents = array(
            'midp', 'j2me', 'avantg', 'docomo', 'novarra', 'palmos',
            'palmsource', '240x320', 'opwv', 'chtml', 'pda',
            'mmp\/', 'blackberry', 'mib\/', 'symbian', 'wireless', 'nokia',
            'cdm', 'up.b', 'audio', 'SIE-', 'SEC-',
            'samsung', 'mot-', 'mitsu', 'sagem', 'sony', 'alcatel',
            'lg', 'erics', 'vx', 'NEC', 'philips', 'mmm', 'xx', 'panasonic',
            'sharp', 'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt',
            'pg', 'vox', 'amoi', 'bird', 'compal', 'kg', 'voda', 'sany',
            'kdd', 'dbt', 'sendo', 'sgh', 'gradi', 'jb', 'dddi', 'moto', 'ipad', 'iphone', 'Opera Mobi', 'android'
        );
        $user_agents = implode('|', $user_agents);
        if (preg_match("/$user_agents/i", $_SERVER['HTTP_USER_AGENT']))
            return true;
    }

    return false;
}
function vn_to_str($str)
{

    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd' => 'đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D' => 'Đ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );

    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ', ' ', $str);
    return $str;
}

function view_pages($ttrow, $limit, $page, $link)
{
    $total = ceil($ttrow / $limit);
    if ($total <= 1) return;
    $main .= "<div class=\"pagination\"><div>";
    if ($page <> 1) {
        $main .= "<a class=\"page-link\" href=\"" . $link . "1\" tabindex=\"-1\" data-original-title=\"\" title=\"\">Đầu</a>";
        //$main .= "<a class=\"page-link\" href=\"$link" . ($page - 1) . "\" tabindex=\"-1\" data-original-title=\"\" title=\"\">Trước</a>";
    }
    for ($num = 1; $num <= $total; $num++) {
        if ($num < $page - 1 || $num > $page + 4) continue;
        if ($num == $page) {
            $main .= "<a class=\"page-link active_page\" href=\"#$num\" data-original-title=\"\" title=\"\">$num</a>";
        } else  $main .= "<a class=\"page-link\" href=\"$link$num\" data-original-title=\"\" title=\"\">$num</a>";
    }
    $main .= '<div class="go_page" style="display:none">
                <form action="javascript:Gotopage(' . $total . ',\'' . $link . '\')">
                    <input type="number" name="PageGotoNum" placeholder="Nhập page cần đến" id="PageGotoNum">
                    <button type="submit"><span class="material-icons-round">
                    mouse
                    </span></button>
                </form>
            </div>';
    $main .= '<a href="javascript:toggleGoPage()" style="background: #a54f4f;">GO</a>';
    if ($page <> $total) {
        $main .= "<a class=\"page-link\" href=\"$link" . $total . "\" data-original-title=\"\" title=\"\">Cuối</a>";
    }
    $main .= '</div></div>';
    return $main;
}
function view_pages_admin($ttrow, $limit, $page, $link)
{

    $total = ceil($ttrow / $limit);
    if ($total <= 1) return;
    $main .= " <div class=\"text-center mt-4\">
    <ul class=\"pagination pagination-primary\">";
    if ($page <> 1) {
        $main .= "<li class='page-item'><a class=\"page-link\" href=\"" . $link . "1\" tabindex=\"1\"><i class=\"fa fa-angle-double-left\"></i></a></li>";
        $main .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$link" . ($page - 1) . "\" tabindex=\"-1\" data-original-title=\"\" title=\"\"><i class=\"fa fa-angle-left\"></i></a></li>";
    }
    for ($num = 1; $num <= $total; $num++) {
        if ($num < $page - 1 || $num > $page + 4)  continue;
        if ($num == $page) {
            $main .= "<li class=\"page-item active\"><a class=\"page-link\" href=\"#$num\" data-original-title=\"\" title=\"\">$num <span class=\"sr-only\">(current)</span></a></li>";
        } else {
            $main .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$link$num\" data-original-title=\"\" title=\"\">$num</a></li>";
        }
    }
    $main .= "<li class=\"page-item disabled\">
    <a class=\"page-link\" href=\"#\" tabindex=\"-1\">&hellip;</a>
    </li>";
    if ($page <> $total) {
        $main .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$link" . ($page + 1) . "\" tabindex=\"+1\" data-original-title=\"\" title=\"\"><i class=\"fa fa-angle-right\"></i></a></li>";
        $main .= "<li class=\"page-item\"><a class=\"page-link\" href=\"$link" . $total . "\" data-original-title=\"\" title=\"\"><i class=\"fa fa-angle-double-right\"></i></a></li>";
    }
    $main .= '  </ul>
    </div>';
    return $main;
}

function getConfigGeneralUserInfo($keys)
{
    global $mysql;

    if (empty($keys) || !is_array($keys)) {
        return [];
    }
    try {

        $data = [];
        $sql = "SELECT `key`,`value` FROM `table_configs` WHERE `key` IN ('".implode("','", $keys)."')";
        $query = $mysql->query($sql);
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[$row['key']] = $row['value'];
        }
    } catch (\Throwable $th) {
        die(JsonMessage(400, "Lỗi rồi => [$th]"));
    }
    
    return $data;
}

function getExpLevel($level) {
    $exp = 0;

    if ($level == 0) {
        return 0;
    }

    for ($i = 0; $i <= $level; $i++) {
        $e = ($i * 30);
        $exp += $e;
    }
    
    return $exp;
}

function numberFormat($num) {
    return number_format($num, 0, ',', '.');
}

function getIconStoreActive($id, $type) {
    $image =  URL . '/assets/upload/store/khung-vien/default.webp';

    if (!empty($id)) {
        global $mysql;
        $sql = "SELECT `image` 
        FROM `table_vat_pham` `v` 
        JOIN `table_user_icon_store` `i` ON `v`.`id` = `i`.`icon_id` 
        WHERE `i`.`user_id` = $id AND `i`.`type` = '$type' AND `active` = 1";
        $query = $mysql->query($sql);
        $rs = $query->fetch(PDO::FETCH_ASSOC);

        if (!empty($rs)) {
            $image = $rs['image'];
        }
    }
    
    return $image;
}

function getLastInsertId($table) {
    global $mysql, $tb_prefix;

    if (empty($table)) {
        return null;
    }

    $tbl = $tb_prefix.$table;
    $rs = $mysql->query("SELECT MAX(`id`) `id` FROM `$tbl`");
    $last = $rs->fetch(PDO::FETCH_ASSOC);

    if (empty($last['id'])) {
        return null;
    }

    return $last['id'];
}

function activeIconStore($user, $id, $type, $active) {
    global $mysql;

    $rs = $mysql->query("SELECT `user_id`, `active` FROM `table_user_icon_store` WHERE `user_id` = $user AND `icon_id` = $id");
    $userIcon = $rs->fetch(PDO::FETCH_ASSOC);

    if ($type == 'icon-user') {
        if (!empty($userIcon)) {
            $statusActive = $active == 1 ? 0 : 1;
            return $mysql->update("user_icon_store", "active = $statusActive", "user_id = $user AND icon_id = $id");
        }

        $paramsInsert = [
            'user_id'    =>  $user,
            'icon_id'    =>  $id,
            'type'      =>  $type,
            'active'    =>  1,
        ];

        return $mysql->insert("user_icon_store", implode(',', array_keys($paramsInsert)), "'".implode("','", array_values($paramsInsert))."'");
    }
    else {
        if ($userIcon['active'] == 1) {
            return $mysql->update("user_icon_store", "active = 0", "user_id = '$user' AND icon_id = '$id'");
        }

        $mysql->update("user_icon_store", "active = 0", "active = 1 AND type = '$type' AND user_id = $user");
        return $mysql->update("user_icon_store", "active = 1", "user_id = $user AND icon_id = $id");
    }
}

function getUserCoin($user_id) {
    global $mysql;

    if (empty($user_id)) {
        return 0;
    }

    $rs = $mysql->query('SELECT `coins` FROM `table_user` WHERE `id` = '.$user_id);
    $data = $rs->fetch(PDO::FETCH_ASSOC);

    if (empty($data['coins'])) {
        return 0;
    }

    return $data['coins'];
}