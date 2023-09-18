<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
function captcha_create_image()
{
    global $_SESSION;

    $secret = (string)tokenString(6);
    $_SESSION["captcha"] = $secret;
    $width = 80;
    $height = 33;
    $image = imagecreatetruecolor($width, $height);
    $color_text = imagecolorallocate($image, 239, 202, 71);
    $color_background = imagecolorallocate($image, 0, 0, 0);
    imagefill($image, 0, 0, $color_background);
    // Draw text: image, font, x, y, text, color
    imagestring($image, 5, 15, 8, $secret, $color_text);
    ob_start();
    imagepng($image, null, 0, PNG_NO_FILTER);
    $image_base64 = 'data:image/png;base64,' . base64_encode(ob_get_contents());
    imagedestroy($image);
    ob_end_clean();
    return $image_base64;
}

/**
 * Captcha check code
 */
function captcha_check($captcha)
{
    global $_SESSION;

    $old_session_id = captcha_session_backup();
    $session_id = captcha_start_session();

    // check captcha
    if (isset($_SESSION['captcha'])) {
        if (hash_equals(
            $captcha,
            $_SESSION["captcha"]
        )) {
            session_destroy();
            captcha_session_restore($old_session_id);

            return true;
        } else {
            //echo "captcha wrong. try again:<br/>\n";
            unset($_SESSION['captcha']);
        }
    }
    session_write_close();
    captcha_session_restore($old_session_id);
    return false;
}

/**
 * Start php session
 */
function captcha_start_session()
{
    global $_POST;

    // start new php session:
    if (isset($_POST['session'])) {
        session_id($_POST['session']);
    } else {
        session_id(session_create_id());
    }
    // TODO: set expire
    session_start(array(
        "use_cookies" => 0,
        "use_only_cookies" => 0,
        "use_trans_sid" => 0,
        "use_strict_mode" => 0,
    ));

    $session_id = session_id();
    return $session_id;
}

/**
 * Save old php session
 */
function captcha_session_backup()
{
    // backup old php session:
    $old_session_id = null;
    if (session_status() === PHP_SESSION_ACTIVE) {
        $old_session_id = session_id();
        session_write_close();
    }

    return $old_session_id;
}

/**
 * Restore old php session
 */
function captcha_session_restore($old_session_id)
{
    if ($old_session_id) {
        // echo "restore: ".$old_session_id."<br/>";
        session_id($old_session_id);
        session_start(array(
            "use_cookies" => 0,
            "use_only_cookies" => 0,
            "use_trans_sid" => 0,
            "use_strict_mode" => 0,
        ));
    }
}

/**
 * Display HTML code
 */
function ImagesCapcha()
{
    $session_id = captcha_start_session();
    $image_base64 = captcha_create_image();
    return [
        "images" => $image_base64,
        "CapchaID" => $session_id
    ];
}
