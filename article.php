<?php

include_once('init.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $post = oneArticle($id);
    if (is_null($post)) {
        header('HTTP/1.1 404 Not Found');
        make404Error($authInfo);
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    make400Error($authInfo);
    exit;
}
$post['content'] = file_get_contents($post['content']);
$pageTitle = $post['header'] . ' article';
$tags = getTagNamesForArticle($id);
$items = getCommentsForArticle($id);
$err_add = isset($_SESSION['err_add']) ? $_SESSION['err_add'] : '';
$err_edit = isset($_SESSION['err_edit']) ? $_SESSION['err_edit'] : '';
unset($_SESSION['err_edit']);
unset($_SESSION['err_add']);
$pageContent = template('article/article', ['id' => $id, 'post' => $post, 'authInfo' => $authInfo, 'tags' => $tags, 'items' => $items, 'err_add' => $err_add, 'err_edit' => $err_edit]);
$html = template('main', [
    'title' => $pageTitle,
    'content' => $pageContent,
    'authInfo' => $authInfo
]);

echo $html;
