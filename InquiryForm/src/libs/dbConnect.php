<?php
declare(strict_types=1);
$options = array(
  PDO::ATTR_EMULATE_PREPARES => false,
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_PERSISTENT => true
);
if (defined('PDO::MYSQL_ATTR_MULTI_STATEMENTS')) {
  $options[PDO::MYSQL_ATTR_MULTI_STATEMENTS] = false;
}

try {
  $db = new PDO('mysql:dbname=db_name;host=127.0.0.1;charset=utf8', 'db_user', 'db_password', $options);
} catch (PDOException $e) {
  echo 'DB接続エラー' . $e->getMessage();
}