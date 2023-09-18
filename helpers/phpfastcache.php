<?php
require_once(dirname(__FILE__) . "/phpfastcache/v3/base.php");
phpFastCache::$config = array(
    "storage" => "auto",
    "default_chmod" => 0777,
    "htaccess" => true,
    "path" => "cacheService",
    "securityKey" => "cachedFiles",
    "memcache" => array(
        array(
            "127.0.0.1",
            11211,
            1
        )
    ),
    "redis" => array(
        "host" => "127.0.0.1",
        "port" => "",
        "password" => "",
        "database" => "",
        "timeout" => ""
    ),
    "extensions" => array(),
    "fallback" => "files"
);
phpFastCache::$disabled = false;
