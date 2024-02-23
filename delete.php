<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $articleInfo = oneArticle($id);
    if (is_null($articleInfo)) {
        header('HTTP/1.1 404 Not Found');
        make404Error($authInfo);
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    make400Error($authInfo);
    exit;
}
$tags = getTagNamesForArticle($id);
if ($authInfo == null || $authInfo['id'] !== $articleInfo['user_id']) {
    $_SESSION['system_message'] = 'You are not permitted for such actions';
    header("Location: article.php?id=" . $articleInfo['id']);
    exit();
}

removeArticle($id);
changeCategoryState($articleInfo['category_id']);
unlink($articleInfo['content']);
foreach ($tags as $tag) {
    changeTagState($tag['id']);
}
$_SESSION['system_message'] = 'Article deleted successfully';
header("Location: index.php");
exit();
