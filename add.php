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
	$fields = extractFields($_POST, ['header']);
	$text = $_POST['content'];
	$fields['content'] = 'assets/articles/' . mt_rand(1000, 100000) . '.txt';
	if (!empty($_POST['tags'])) {
		$inputedTags = htmlspecialchars($_POST['tags']);
		preg_match_all('/#(\w+)/', $_POST['tags'], $rawTags);
		$rawTags = $rawTags[1];
	}
	$fields['user_id'] = $authInfo['id'];
	if (isset($_POST['category_id'])) {
		$fields['category_id'] = $_POST['category_id'];
	}
	$errors = validateArticle($fields, $rawTags, $text);
	if (empty($errors)) {
		addArticle($fields);
		$new_line = "<div style=\"border: 2px solid #000; padding: 20px; border-radius: 10px;\">\n";
		$text = $new_line . $text;
		file_put_contents($fields['content'], $text);
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
	} else {
		$err = implode('<br>', $errors);
		$header = $fields['header'];
		$content = $_POST['content'];
		$tag_names_str = $_POST['tags'];
	}
} else {
	$fields['header'] = '';
	$fields['content'] = '';
}
$pageContent = template('article/add', [
	'header' => $header,
	'content' => $content,
	'category_list' => $category_list,
	'tag_names_str' => $tag_names_str,
	'err' => $err
]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent,
	'authInfo' => $authInfo
]);

echo $html;
