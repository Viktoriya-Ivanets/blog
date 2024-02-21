<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $commentInfo = getCommentInfo($id);
    if (is_null($commentInfo)) {
        header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}
$message = '';
if ($authInfo == null) {
	header("Location: article.php?id=" . $commentInfo['article_id']);
	exit();
}

if ($authInfo['role'] === 'admin' && $authInfo['id'] !== $commentInfo['id_user']) {
    $article = oneArticle($commentInfo['article_id']);
    $notification = "Your comment from article \"" . $article['header'] . "\" was deleted because it violates our community rules. Contact our administrator if an error occurs.";
    addNotification($commentInfo['id_user'], $commentInfo['article_id'], $notification, $commentInfo['content']);
    deleteComment($id);
    $message = "Comment deleted. Notification sent to user";
} 
if($authInfo['id'] === $commentInfo['id_user']) {
    deleteComment($id);
    $message = "Your comment deleted";
}

include('views/article/reject.php');
?>