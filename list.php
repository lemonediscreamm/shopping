<?php
/*
*ファイルパス:C:\xampp\htdocs\DT\shopping\list.php
*ファイル名:list.php
*アクセスURL:http://localhost/DT/shopping/list.php
*/

namespace shopping;

require_once dirname(__FILE__). '/Bootstrap.class.php';

use shopping\Bootstrap;
use shopping\lib\PDODatabase;
use shopping\lib\Session;
use shopping\lib\Item;

$db = new PDODatabase(Bootstrap::DB_HOST,Bootstrap::DB_USER, Bootstrap::DB_PASS,
Bootstrap::DB_NAME, Bootstrap::DB_TYPE);
$ses = new Session($db);
$itm = new Item($db);


$loader = new \Twig_Loader_Filesystem(Bootstrap::TEMPLATE_DIR);
$twig = new \Twig_Environment($loader, [
    'cache' => Bootstrap::CACHE_DIR
]);

$ses->checkSession();


$ctg_id = (isset($_GET['ctg_id']) === true && preg_match('/^[0-9]+$/',$_GET['ctg_id'])=== 1) ? $_GET['ctg_id'] : '';

$cateArr = $itm->getCategoryList();

$dataArr = $itm->getItemList($ctg_id);

$search =(isset($_GET['search']) === true) ? $_GET['search'] : '';
$search_bl= isset($_GET['search']);
$arr = $itm->getResult($search);

$session = (isset($_SESSION['username'])) ? true : false;


$context = [];
$context['cateArr'] = $cateArr;
$context['dataArr'] = $dataArr;
$context['arr'] = $arr;
$context['search_bl'] = $search_bl;
$context['session'] = $session;

$template = $twig->loadTemplate('list.html.twig');
$template->display($context);
