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
if ($authInfo == null || $authInfo['id'] !== $commentInfo['id_user']) {
	header("Location: article.php?id=" . $commentInfo['article_id']);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment_edit']) && !empty($_POST['comment_edit'])) {
        $content = htmlspecialchars($_POST['comment_edit']);
        editComment($id, $content);
        header("Location: article.php?id=" . $commentInfo['article_id']);
        exit();
    }else {
        $_SESSION['err_edit'] = "Missing comment";
        header("Location: article.php?id=" . $commentInfo['article_id']. "&mode=edit&comment_id=". $id);
        exit();
    }
}
