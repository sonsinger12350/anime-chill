<?php
@session_start();
@header("Content-Type: text/html; charset=UTF-8");
if (!ini_get('register_globals')) {
	extract($_GET);
	extract($_POST);
}
include('dbconnect.php');
include('CurlClass/vendor/autoload.php');
$ConnectSQL = new ConectSQL;
$mysqldb = $ConnectSQL->connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
$mysql = new mysql;
$vipIcon = 'https://hhtqtv.vip/assets/upload/aupvGDHrGf3jcUD1699022571.png';

use Curl\Curl;

$curl = new Curl();
#######################################
# GET DATABASE
#######################################
function get_data($f1, $table, $f2, $f2_value)
{
	global $mysql;
	$q = $mysql->query("SELECT $f1 FROM " . DATABASE_FX . $table . " WHERE $f2 = '" . $f2_value . "'");
	$row = $q->fetch(PDO::FETCH_ASSOC);
	$f1_value = $row[$f1];
	return $f1_value;
}
function GetDataArr($table, $f2)
{
	global $mysql;
	$q = $mysql->query("SELECT * FROM " . DATABASE_FX . $table . " WHERE $f2");
	$row = $q->fetch(PDO::FETCH_ASSOC);
	return $row;
}
function GetDataArr_Multi($table, $f1)
{
	global $mysql;
	$q = $mysql->query("SELECT $f1 FROM " . DATABASE_FX . $table);
	$row = $q->fetch(PDO::FETCH_ASSOC);
	return $row;
}
function get_data_multi($f1, $table, $f2)
{
	global $mysql;
	$q = $mysql->query("SELECT $f1 FROM " . DATABASE_FX . $table . " WHERE $f2");
	$row = $q->fetch(PDO::FETCH_ASSOC);
	$f1_value = $row[$f1];
	return $f1_value;
}
function get_total($table, $f2 = '')
{
	global $mysqldb;
	$sql = "SELECT count(*) FROM " . DATABASE_FX . $table . " " . $f2 . "";
	$result = $mysqldb->prepare($sql);
	$result->execute();
	$number_of_rows = $result->fetchColumn();
	return $number_of_rows;
}
function get_total_trung($tab, $table, $f2 = '')
{
	global $mysqldb;
	$sql = "SELECT DISTINCT count(*) FROM " . DATABASE_FX . $table . " " . $f2 . "";
	$result = $mysqldb->prepare($sql);
	$result->execute();
	$number_of_rows = $result->fetchColumn();
	return $number_of_rows;
}
function get_total_multi($tab, $table, $f2 = '')
{
	global $mysqldb;
	$sql = "SELECT count($tab) FROM " . DATABASE_FX . $table . " " . $f2 . "";
	$result = $mysqldb->prepare($sql);
	$result->execute();
	$number_of_rows = $result->fetchColumn();
	return $number_of_rows;
}
function InputEdit_Table($table, $where)
{
	global $mysql;
	$result = $mysql->query("SELECT * FROM " . DATABASE_FX . $table . " WHERE $where");
	$fields = array_keys($result->fetch(PDO::FETCH_ASSOC));
	$input = '';
	foreach ($fields as $key => $colums) {
		if ($colums != "id") :
			$row = GetDataArr($table, $where);
			$input .= '<div class="form-group mb-3"><label>' . ucfirst($colums) . '</label>';
			$input .= '<input type="text" class="form-control" name="data[' . $colums . ']" value="' . $row[$colums] . '"></div>';
		endif;
	}
	return $input;
}
function checkVipUser($userId)
{
	global $mysqldb;
	$sql = "SELECT COUNT(*) FROM `table_user` WHERE `id` = {$userId} AND `vip` = 1";
	$result = $mysqldb->prepare($sql);
	$result->execute();
	$number_of_rows = $result->fetchColumn();
	if ($number_of_rows > 0) return true;
	return false;
}
function UpdateVipUser($cash_return, $vip_icon, $vip_date_end, $vip_term, $user_id)
{
	global $mysql;
	$sql = "UPDATE `table_user` SET `coins`='{$cash_return}',`vip`='1',`vip_icon`='{$vip_icon}',`vip_date_end`='{$vip_date_end}',`vip_term`='{$vip_term}' WHERE `id` = '{$user_id}'";
	$result = $mysql->query($sql);
	if ($result) {
		return true;
	} else {
		return false;
	}
}
function resetVipUser($vip_date_end, $user_id, $vip_user)
{	
	
	$vip_date_end = date("Y-m-d", $vip_date_end);
	// $vip_date_end = "2023-10-26";
	$date_current = new DateTime();
	$date_current_formatted = $date_current->format('Y-m-d');
	if ($vip_date_end == $date_current_formatted || $vip_date_end < $date_current_formatted && $vip_date_end !== NULL) {
		global $mysql;
		$sql = "UPDATE `table_user` SET `vip`='0',`vip_icon`=NULL,`vip_term`='0' WHERE `id` = '{$user_id}'";
		$result = $mysql->query($sql);
	}
	return false;
}
#################
# GET CONFIG	#
$cf = GetDataArr('config', "id = 1");
#################

function categoryStore() {
	return [
		'khung-vien'	=>	'Khung viền',
		'non'			=>	'Nón',
		'toc'			=>	'Tóc',
		'kinh'			=>	'Kính',
		'mat'			=>	'Mắt',
		'khuon-mat'		=>	'Khuôn mặt',
		'mat-na'		=>	'Mặt nạ',
		'ao'			=>	'Áo',
		'quan'			=>	'Quần',
		'canh'			=>	'Cánh',
		'hao-quang'		=>	'Hào quang',
		'do-cam-tay'	=>	'Đồ cầm tay',
		'thu-cung'		=>	'Thú cưng',
		'icon-user'		=>	'Icon',
	];
}

function isItemStore($item) {
	if (empty($item)) {
		return false;
	}

	if (!in_array($item, ['khung-vien', 'icon-user'])) {
		return true;
	}

	return false;
}

function listItemStore() {
	global $mysql;

	$data = array_map(function ($value) {return [];}, categoryStore());

	$sql = "SELECT `id`, `name`, `price`, `image`, `type` FROM `table_vat_pham` ORDER BY `price` DESC";
	$query = $mysql->query($sql);

	while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		$data[$row['type']][$row['id']] = $row;
	}

	return $data;
}

function listUserItemActive($userId, $option = 'get-image') {
	global $mysql;

	$categoryStore = categoryStore();
	$flipCategoryStore = array_flip($categoryStore);
	$data = array_map(
		function ($value) use ($flipCategoryStore) {
			if ($flipCategoryStore[$value] != 'icon-user') {
				return '/assets/upload/icon-default/'.$flipCategoryStore[$value].'.webp';
			}
		}, $categoryStore);

	if (!empty($userId)) {
		$sql = "SELECT `vp`.`id`,`vp`.`type`,`vp`.`image`
			FROM `table_user_icon_store` `uis`
			JOIN `table_vat_pham` `vp` ON `uis`.`icon_id` = `vp`.`id`
			WHERE `user_id` = $userId AND `active` = 1";

		$query = $mysql->query($sql);

		if ($option == 'get-image') {
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$data[$row['type']] = $row['image'];
			}
		}
		else {
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$data[$row['type']] = $row['id'];
			}
		}
	}

	return $data;
}

function listUserItemOwner($userId) {
	global $mysql;

	$data = array_map(function ($value) {return [];}, categoryStore());

	if (!empty($userId)) {
		$sql = "SELECT `icon_id`, `type` 
			FROM `table_user_icon_store` 
			WHERE `user_id` = $userId";

		$query = $mysql->query($sql);

		while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			$data[$row['type']][] = $row['icon_id'];
		}
	}

	return $data;
}

function listUserIconActive($userId, $option = "key-value") {
	global $mysql;
	$data = [];
	
	if (!empty($userId)) {
		$sql = "SELECT `vp`.`id`,`vp`.`image`, `vp`.`name`
			FROM `table_user_icon_store` `uis`
			JOIN `table_vat_pham` `vp` ON `uis`.`icon_id` = `vp`.`id`
			WHERE `user_id` = $userId AND `active` = 1 AND `vp`.`type` = 'icon-user'";

		$query = $mysql->query($sql);

		if ($option == 'all') {
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$data[$row['id']] = $row;
			}
		}
		else {
			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				$data[$row['id']] = $row['image'];
			}
		}
	}

	return $data;
}

function addCoin($userId, $type, $params = []) {
	if (!empty($userId) && !empty($type)) {
		if ($type == 'first_comment' && empty($params['movie_id'])) {
			return false;
		}

		if ($type == 'first_ads_by_type' && empty($params['ads_type'])) {
			return false;
		}

		global $mysql;

		$data = [];
		$amountType = [
			'first_login'			=>	100,
			'first_comment'			=>	5,
			'first_avatar'			=>	100,
			'register'				=>	500,
			'first_ads_by_type'		=>	10,
		];

		$where = "";

		if (in_array($type, ['first_login', 'first_comment', 'first_ads_by_type'])) {
			$where .= " AND `created_at` = '".date('Y-m-d')."'";
		}

		$sqlCheck = "SELECT `id`, `type`, `movie_id`, `ads_type`
			FROM `table_history_add_coin` 
			WHERE `user_id` = $userId AND `type` = '".$type."' $where";
		$result = $mysql->query($sqlCheck);

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $row;
		}

		if (!in_array($type, ['first_ads_by_type', 'first_comment'])) {
			if (count($data) >= 1) {
				return false;
			}
		}
		else {
			if ($type == 'first_comment') {
				if (count($data) >= 5) {
					return false;
				}
	
				foreach ($data as $checkComment) {
					if ($checkComment['movie_id'] == $params['movie_id']) {
						return false;
					}
				}
			}
			elseif ($type == 'first_ads_by_type') {
				foreach ($data as $checkAds) {
					if ($checkAds['ads_type'] == $params['ads_type']) {
						return false;
					}
				}
			}
		}

		$paramsInsert = [
			'user_id'	=>	$userId,
			'type'		=>	$type,
			'amount'	=>	$amountType[$type],
			'created_at'	=>	date('Y-m-d')
		];

		if ($type == 'first_comment') {
		    if ($params['movie_id'] == 'all') {
		        return true;
		    }

			$paramsInsert['movie_id'] = $params['movie_id'];
		}

		if ($type == 'first_ads_by_type') {
			$paramsInsert['ads_type'] = $params['ads_type'];
		}

		$mysql->insert('history_add_coin', '`'.implode('`,`', array_keys($paramsInsert)).'`', '"'.implode('", "', $paramsInsert).'"');

		$mysql->update('user', "coins = coins + ".$amountType[$type], 'id = '.$userId);
	}
}

function canShowAds($type, $timeDistance, $numberDisplayed) {
	if (!empty($_COOKIE[$type]) && $_COOKIE[$type] <= Date("Y-m-d H:i:s")) {
		setcookie($type, null, -1, '/');
		$_SESSION['ads'][$type] = 0;
		return 1;
	}

	if ($_SESSION['ads'][$type] == $numberDisplayed-1) {
		$date = Date("Y-m-d H:i:s", strtotime(Date('Y-m-d H:i:s').' + '.$timeDistance.' minutes'));
		setcookie($type, $date, time() + 60*60*60, '/');
	}

	if (!empty($_COOKIE[$type]) && $_COOKIE[$type] > time()) {
		return 0;
	}
	elseif (!empty($_SESSION['ads'][$type]) && $_SESSION['ads'][$type] >= $numberDisplayed) {
		return 0;
	}

	return 1;
}