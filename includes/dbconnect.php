<?php

class ConectSQL
{
    function connect($db_host, $db_username, $db_password, $db_name)
    {
        try {
            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            );
            $conn = new PDO('mysql:host=localhost;dbname=' . $db_name, $db_username, $db_password, $options);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
}
class mysql
{
    function query($input)
    {
        global $mysqldb;
        $data = $mysqldb->query($input) or die();
        return $data;
    }
    function update($table, $query, $value)
    {
        global $mysqldb;
        $data = $mysqldb->query("UPDATE " . DATABASE_FX . $table . " SET " . $query . " WHERE " . $value . "") or die();
        return $data;
    }
    function update_data($table, $query, $value)
    {
        global $mysqldb;
        $data = $mysqldb->query("UPDATE " . DATABASE_FX . $table . " SET " . $query . " " . $value . "") or die();
        return $data;
    }
    function delete($table, $value)
    {
        global $mysqldb;
        $data = $mysqldb->query("DELETE FROM " . DATABASE_FX . $table . " WHERE " . $value . "") or die();
        return $data;
    }
    function delete_all($table)
    {
        global $mysqldb;
        $data = $mysqldb->query("DELETE FROM " . DATABASE_FX . $table . "") or die();
        return $data;
    }
    function insert($table, $query, $value)
    {
        global $mysqldb;
        $data = $mysqldb->query("INSERT INTO " . DATABASE_FX . $table . " (" . $query . ") VALUES (" . $value . ");") or die();
        return $data;
    }
}
