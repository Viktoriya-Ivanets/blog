<?php

include_once('init.php');

$mode = $_GET['mode'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!is_numeric($id) && !is_null($id)){
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}
if ($mode === 'category') {
	$items = getActiveCategories();
} elseif ($mode === 'articles_by_category' && $id != 'NULL') {
	$items = getArticlesByCategory($id);
	if(is_null($items)){
		header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
	}
} elseif ($mode === 'articles_by_tags' && $id != 'NULL') {
	$items = getArticlesByTag($id);
	if(is_null($items)){
		header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
	}
} else {
	$items = getArticles();
}
include('views/index.php');