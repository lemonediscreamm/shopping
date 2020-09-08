<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\shopping\logout.php
*ファイル名:logout.php
*アクセスURL:http://localhost/DT/shopping/logout.php
*/
session_start();
$_SESSION = array();
session_destroy();
header('Location:http://localhost/DT/shopping/list.php');
?>
