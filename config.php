<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login_db');

// MySQLデータベースに繋げる
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// 繋ぐチェック
if ($db === false) {
  die("Error: Connection error." . mysqli_connect_error());
}
