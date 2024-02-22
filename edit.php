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
    $_SESSION['system_message'] = 'You are not permitted for such actions';
	header('Location: index.php');
	exit();
}
$pageTitle = $oldArticle['header'] . 'edit page';
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
        $_SESSION['system_message'] = 'Article edited successfully';
        header("Location: article.php?id=" . $id);
        exit();
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

$pageContent = template('article/edit', [
    'header' => $header, 
    'content'=> $content, 
    'category_list' => $category_list, 
    'prev_category_id' => $prev_category_id, 
    'tag_names_str' => $tag_names_str, 
    'err' => $err]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent, 
    'authInfo' => $authInfo
]);

echo $html;