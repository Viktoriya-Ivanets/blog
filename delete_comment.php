<?php
session_start();

include_once('models/article.php');
include_once('models/notification.php');
include_once('models/comments.php');
include_once('models/auth.php');

$user = authGetUser();
$id = $_GET['id'];
$message = '';
$commentInfo = getCommentInfo($id);

if ($user['role'] === 'admin' && $user['id'] !== $commentInfo['id_user']) {
    $article = oneArticle($commentInfo['article_id']);
    $notification = "Your comment from article \"" . $article['header'] . "\" was deleted because it violates our community rules. Contact our administrator if an error occurs.";
    $params = ['id_user' => $commentInfo['id_user'], 'article_id' => $commentInfo['article_id'], 'message' => $notification, 'comment_content' => $commentInfo['content']];
    addNotification($params);
    deleteComment($id);
    $message = "Comment deleted. Notification sent to user";
} else {
    deleteComment($id);
    $message = "Your comment deleted";
}

include('views/article/reject.php');
?>