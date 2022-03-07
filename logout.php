<?php
// PHPのお作法的なもの
session_start();

// ログインページに戻る
if(session_destroy()){
  header("location: login.php");
  exit;
}
