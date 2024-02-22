<?php

include_once('init.php');

if ($authInfo == null) {
	$_SESSION['system_message'] = 'Log-In or Sign-Up to add new article';
	header('Location: index.php');
	exit();
}

$category_list = getAllCategories();

$err = '';
$tag_names_str = '';
$pageTitle = 'Add new article';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$rawTags = null;
	$fields = extractFields($_POST, ['header', 'content']);
	if (!empty($_POST['tags'])) {
		$inputedTags = htmlspecialchars($_POST['tags']);
		preg_match_all('/#(\w+)/', $_POST['tags'], $rawTags);
		$rawTags = $rawTags[1];
	}
	$fields['user_id'] = $authInfo['id'];
	if (isset($_POST['category_id'])) {
		$fields['category_id'] = $_POST['category_id'];
	}
	$errors = validateArticle($fields, $rawTags);
	if (empty($errors)) {
		addArticle($fields);
		$articleId = getArticleId($fields['header']);
		if ($rawTags != null) {
			addTagsToArticle($rawTags, $articleId['id']);
		}
		$tags = getTagNamesForArticle($articleId['id']);
		$category = oneArticle($articleId['id']);
		changeCategoryState($category['category_id']);
		foreach ($tags as $tag) {
			changeTagState($tag['id']);
			}
		$_SESSION['system_message'] = 'Article added successfully';
header("Location: index.php");
exit();
	}
	else {
		$err = implode('<br>', $errors);
		$header = $fields['header'];
    	$content = $fields['content'];
		$tag_names_str = $_POST['tags'];
	}
} else {
	$fields['header'] = '';
	$fields['content'] = '';
}
$pageContent = template('article/add', [
    'header' => $header, 
    'content'=> $content, 
    'category_list' => $category_list,
    'tag_names_str' => $tag_names_str, 
    'err' => $err]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent, 
    'authInfo' => $authInfo
]);

echo $html;
