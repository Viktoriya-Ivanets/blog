<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $oldArticle = oneArticle($id);
    if (is_null($oldArticle)) {
        header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}

if ($authInfo == null || $authInfo['id'] !== $oldArticle['user_id']) {
	header('Location: index.php');
	exit();
}

$isSend = false;
$err = '';
$category_list = getAllCategories();
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
        $inputedTags = htmlspecialchars($_POST['tags']);
        preg_match_all('/#(\w+)/', $inputedTags, $rawTags);
        $rawTags = $rawTags[1];
    }
    $errors = validateArticle($fields, $rawTags);
    if (empty($errors)) {
        editArticle($fields);
        $tags = getTagNamesForArticle($id);
        removeTagsForArticle($id);
        if ($rawTags != null) {
            addTagsToArticle($rawTags, $id);
        }
        changeCategoryState($oldArticle['category_id']);
		changeCategoryState($fields['category_id']);
        foreach ($tags as $tag) {
            changeTagState($tag['id']);
        }
        $isSend = true;
        header("Location: article.php?id=" . $id);
    } else {
        $err = implode('<br>', $errors);
		$header = $fields['header'];
    	$content = $fields['content'];
		$tag_names_str = $_POST['tags'];
    }
} else {
    $header = $oldArticle['header'];
    $content = $oldArticle['content'];
    $category_id = $oldArticle['category_id'];
	$prev_category_id = $category_id;
}
include('views/article/edit.php');