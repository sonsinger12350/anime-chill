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
	foreach ($fields as $key => $colums) {
		if ($colums != "id") :
			$row = GetDataArr($table, $where);
			$input .= '<div class="form-group mb-3"><label>' . ucfirst($colums) . '</label>';
			$input .= '<input type="text" class="form-control" name="data[' . $colums . ']" value="' . $row[$colums] . '"></div>';
		endif;
	}
	return $input;
}
#################
# GET CONFIG	#
$cf = GetDataArr('config', "id = 1");
#################
