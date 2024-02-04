<?php

session_start();

	include_once('models/article.php');
	include_once('models/category.php');
	include_once('models/auth.php');
	include_once('models/tags.php');
	$user = authGetUser();
	$mode = $_GET['mode'];
	$id = $_GET['id'];
	if ($mode ==='category'){ 
		$items = getCategories();
	}
	elseif ($mode ==='articles_by_category' && $id != 'NULL') {
		$items = getArticlesByCategory ($id);
	}
	elseif ($mode ==='articles_by_tags' && $id != 'NULL') {
		$items = getArticlesByTag ($id);
	}
	else {
	$items = getArticles();
	}
	include('views/index.php')
?>
