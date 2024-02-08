<?php

include_once('models/article.php');
include_once('models/notification.php');
$id = $_GET['id'];
$message = "Article rejected. Notification sent to user";
$article = oneArticle($id);
$notification = "Your article was rejected because it violates our community rules. Contact our administrator if an error occurs.";
$params = ['id_user' => $article['user_id'], 'article_id' => $article['id'], 'message' => $notification, 'comment_content' => NULL];
rejectArticle($id);
addNotification($params);
echo "<br>";
include('views/article/reject.php');
?>