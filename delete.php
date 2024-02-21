<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $articleInfo = oneArticle($id);
    if (is_null($articleInfo)) {
        header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}
$tags = getTagNamesForArticle($id);
if ($authInfo == null || $authInfo['id'] !== $articleInfo['user_id']) {
	header("Location: article.php?id=" . $articleInfo['id']);
	exit();
}

removeArticle($id);
changeCategoryState($articleInfo['category_id']);
foreach ($tags as $tag) {
changeTagState($tag['id']);
}
echo "<br>";
include('views/article/delete.php');