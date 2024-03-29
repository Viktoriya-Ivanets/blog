<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $commentInfo = getCommentInfo($id);
    if (is_null($commentInfo)) {
        header('HTTP/1.1 404 Not Found');
        make404Error($authInfo);
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    make400Error($authInfo);
    exit;
}
$message = '';
if ($authInfo == null) {
    $_SESSION['system_message'] = 'You are not permitted for such actions';
    header("Location: article.php?id=" . $commentInfo['article_id']);
    exit();
}

if ($authInfo['role'] === 'admin' && $authInfo['id'] !== $commentInfo['id_user']) {
    $article = oneArticle($commentInfo['article_id']);
    $notification = "Your comment from article \"" . $article['header'] . "\" was deleted because it violates our community rules. Contact our administrator if an error occurs.";
    addNotification($commentInfo['id_user'], $commentInfo['article_id'], $notification, $commentInfo['content']);
    deleteComment($id);
    $_SESSION['system_message'] = 'Comment deleted. Notification sent to user';
    header("Location: article.php?id=" . $commentInfo['article_id']);
    exit();
}
if ($authInfo['id'] === $commentInfo['id_user']) {
    deleteComment($id);
    $_SESSION['system_message'] = 'Comment deleted successfully';
    header("Location: article.php?id=" . $commentInfo['article_id']);
    exit();
}
