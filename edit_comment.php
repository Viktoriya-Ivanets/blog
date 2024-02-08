<?php
session_start();
include_once('models/comments.php');
include_once('models/auth.php');

$user = authGetUser();
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_edit'])) {
        $content = $_POST['comment_edit'];
        $articleId = getCommentInfo($id);
        editComment($id, $content);
        header("Location: article.php?id=" . $articleId['article_id']);
        exit();
    }
} else {
    $comment = getCommentInfo($id);
    $comment_content = $comment['content'];
}
