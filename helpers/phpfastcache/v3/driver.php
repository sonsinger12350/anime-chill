<?php
interface phpfastcache_driver {
    function __construct($config = array());
    function checkdriver();
    function driver_set($keyword, $value = "", $time = 300, $option = array());
    function driver_get($keyword, $option = array());
    function driver_stats($option = array());
    function driver_delete($keyword, $option = array());
    function driver_clean($option = array());
}

//Main function
function initRedtube($requestUrl) {
    $getInfo = redTube($requestUrl);
	$data = explodeData('"mediaDefinitions":', ',"video_', $getInfo);
	$array = json_decode($data);
	if($array) {
		foreach ($array as $key => $value) {
			$file = $value->videoUrl;
			$label = $value->quality . 'p';
			if($file) {
				$video[] = array(
					'label' => $label,
					'type' => 'video/mp4',
					'file' => $file				
				);
			}
		}
		$jwplayerData = json_encode($video, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}else {
		$jwplayerData = 'Video not found or not ready to stream, waiting for encoding.';
	}
    return $jwplayerData;
}

//Helper functions
function redTube($requestUrl) {
    $handle = curl_init('https://api.codetabs.com/v1/proxy/?quest='.$requestUrl);
	curl_setopt_array($handle, array(
		CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
		CURLOPT_ENCODING => '', 
		CURLOPT_HTTPHEADER => array(
			'Referer: ' . $requestUrl,
			'Cookie: ua=480ab0ea437e023d38e280fd3bf88e97; platform=pc; bs=6mbs4e4f5hnfiuhi7nf1skn5mqeuykk7; ss=700004641742434642; language={"lang":"en","showMsg":false}; RNLBSERVERID=ded6785; sideMenu=true; il=v1XDjsvCv71lHuVDHFke9qr8Sg7y-PZWkZlx2dVoYCZ6UxNTY2OTA2MzgxbFo4ZWo0MzJGU3R4LXBtZEpHbjVNOWVRWF9hemtjT18xTzBGaDE5WA..; expiredEnterModalShown=1; FastPopSessionRequestNumber=9'
			
		), 
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_FOLLOWLOCATION => 1
	));
    $curl_response = curl_exec($handle);
    curl_close($handle);
    return $curl_response;
}

function explodeData($begin, $end, $data) {
    $data = explode($begin, $data);
    @$data = explode($end, $data[1]);
    return $data[0];
}



?>