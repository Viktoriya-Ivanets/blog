<?php

include_once('init.php');

$pageTitle = '';

$mode = $_GET['mode'];
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!is_numeric($id) && !is_null($id)) {
	header('HTTP/1.1 400 Bad Request');
	make400Error($authInfo);
	exit;
}
if ($mode === 'category') {
	$items = getActiveCategories();
	$pageTitle = 'All categories';
} elseif ($mode === 'articles_by_category' && $id != 'NULL') {
	$items = getArticlesByCategory($id);
	$pageTitle = 'Articles by categories';
	if (is_null($items)) {
		header('HTTP/1.1 404 Not Found');
		make404Error($authInfo);
		exit;
	}
} elseif ($mode === 'articles_by_tags' && $id != 'NULL') {
	$items = getArticlesByTag($id);
	$pageTitle = 'Articles by tag';
	if (is_null($items)) {
		header('HTTP/1.1 404 Not Found');
		make404Error($authInfo);
		exit;
	}
} else {
	$items = getArticles();
	$pageTitle = 'All articles';
}

$pageContent = template('index', ['items' => $items, 'mode' => $mode, 'authInfo' => $authInfo]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent,
	'authInfo' => $authInfo
]);

echo $html;
