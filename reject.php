<?php

include_once('init.php');

if ($authInfo == null || $authInfo['role'] !== 'admin') {
    $_SESSION['system_message'] = 'You are not permitted for such actions';
	header('Location: index.php');
	exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $article = oneArticle($id);
    if (is_null($article)) {
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
$notification = "Your article was rejected because it violates our community rules. Contact our administrator if an error occurs.";
rejectArticle($id);
addNotification($article['user_id'], $article['id'], $notification, null);
changeCategoryState($article['category_id']);
foreach ($tags as $tag) {
    changeTagState($tag['id']);
    }
    $_SESSION['system_message'] = 'Article rejected. Notification sent to user';
    header("Location: index.php");
    exit();
