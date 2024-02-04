<?php
session_start();

	include_once('core/functions.php');
	include_once('models/article.php');
	include_once('models/auth.php');
	include_once('models/category.php');
	include_once('models/tags.php');

	$user = authGetUser();
	if ($user == null) {
		header('Location: index.php');
				exit();
	}
	
	$category_list = getCategories ();

	$isSend = false;
	$err = '';

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$rawTags = null;
		$fields = extractFields($_POST, ['header', 'content']);
		if (!empty($_POST['tags'])) {
			preg_match_all('/#(\w+)/', $_POST['tags'], $rawTags);
			$rawTags = $rawTags[1];
		}
		$fields['user_id'] = $user['id'];
		if (isset($_POST['category_id'])) {
			$fields['category_id'] = $_POST['category_id'];
		}
		if($fields['header'] === '' || $fields['content'] === ''){
			$err = 'Заполните все поля!';
		}
		addArticle($fields);
		if($rawTags!=null){
		$articleId = getArticleId($fields['header']);
		$tags = getAllTags();
		foreach ($rawTags as $rawTag) {
			$tagExists = false;
			foreach ($tags as $tag) {
				if ($tag['header'] === $rawTag) {
					$tagExists = true;
					break;
				}
			}
			if (!$tagExists) {
				addTag($rawTag);
			}
    	}
		$tagIds = [];
		foreach ($rawTags as $rawTag) {
		$tagIds[] = getTagId($rawTag);
		}
		foreach ($tagIds as $tagId) {
			linkArticleWithTag($articleId['id'], $tagId['id']);
		}
	}
		$isSend = true;
	}
	else{
		$fields['header'] = '';
		$fields['content'] = '';
	}
	include('views/article/add.php');
?>