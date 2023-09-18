<?php
if (!defined('MovieAnime')) die("You are illegally infiltrating our website");
HeaderApplication();
$TokenTime = md5(tokenString(25) . time());
setcookie("TokenTime", json_encode(array($TokenTime => $TokenTime)), time() + 60, '/');
die(json_encode(["token" => $TokenTime]));
