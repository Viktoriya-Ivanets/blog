<?php

include_once('init.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $post = oneArticle($id);
    if (is_null($post)) {
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
$items = getCommentsForArticle($id);
$err_add = isset($_SESSION['err_add']) ? $_SESSION['err_add'] : '';
$err_edit = isset($_SESSION['err_edit']) ? $_SESSION['err_edit'] : '';
unset($_SESSION['err_edit']);
unset($_SESSION['err_add']);
include('views/article/article.php');
