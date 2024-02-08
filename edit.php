<?php
session_start();
include_once('core/functions.php');
include_once('models/article.php');
include_once('models/category.php');
include_once('models/tags.php');
include_once('models/auth.php');

$user = authGetUser();
$id = $_GET['id'];
$isSend = false;
$err = '';
$oldArticle = oneArticle($id);
$category_list = getCategories();
$tags = getTagNamesForArticle($id);
$tag_names_str = '';
foreach ($tags as $tag) {
	$tag_names_str .= '#' . $tag['header'] . ' ';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['header', 'content', 'category_id']);
	$fields['id'] = $id;
	$rawTags = null;
	if (!empty($_POST['tags'])) {
		preg_match_all('/#(\w+)/', $_POST['tags'], $rawTags);
		$rawTags = $rawTags[1];
	}

	if ($fields['header'] === '' || $fields['content'] === '' || $fields['category_id'] === '') {
		$err = 'Fill all fields!';
	} else {
		editArticle($fields);
		removeTagsForArticle($id);
		if ($rawTags != null) {
			foreach ($rawTags as $rawTag) {
				addTag($rawTag);
			}
			$tagIds = [];
			foreach ($rawTags as $rawTag) {
				$tagIds[] = getTagId($rawTag);
			}
			foreach ($tagIds as $tagId) {
				linkArticleWithTag($id, $tagId['id']);
			}
		}
		$isSend = true;
		header("Location: article.php?id=" . $id);
	}
} else {
	$header = $oldArticle['header'];
	$content = $oldArticle['content'];
	$category_id = $oldArticle['category_id'];
}
include('views/article/edit.php');