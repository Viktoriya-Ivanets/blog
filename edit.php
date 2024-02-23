<?php

include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $oldArticle = oneArticle($id);
    if (is_null($oldArticle)) {
        header('HTTP/1.1 404 Not Found');
        make404Error($authInfo);
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    make400Error($authInfo);
    exit;
}

if ($authInfo == null || $authInfo['id'] !== $oldArticle['user_id']) {
    $_SESSION['system_message'] = 'You are not permitted for such actions';
    header('Location: index.php');
    exit();
}
$pageTitle = $oldArticle['header'] . 'edit page';
$err = '';
$category_list = getAllCategories();
$tags = getTagNamesForArticle($id);
$tag_names_str = '';
$oldText = file_get_contents($oldArticle['content']);
$lines = explode("\n", $oldText);
array_shift($lines);
$oldText = implode("\n", $lines);
foreach ($tags as $tag) {
    $tag_names_str .= '#' . $tag['header'] . ' ';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = extractFields($_POST, ['header', 'category_id']);
    $text = $_POST['content'];
    $fields['content'] = $oldArticle['content'];
    $fields['id'] = $id;
    $rawTags = null;
    if (!empty($_POST['tags'])) {
        $inputedTags = htmlspecialchars($_POST['tags']);
        preg_match_all('/#(\w+)/', $inputedTags, $rawTags);
        $rawTags = $rawTags[1];
    }
    $errors = validateArticle($fields, $rawTags, $text);
    if (empty($errors)) {
        editArticle($fields);
        $new_line = "<div style=\"border: 2px solid #000; padding: 20px; border-radius: 10px;\">\n";
        $text = $new_line . $text;
        file_put_contents($oldArticle['content'], $text);
        $tags = getTagNamesForArticle($id);
        removeTagsForArticle($id);
        if ($rawTags != null) {
            addTagsToArticle($rawTags, $id);
        }
        changeCategoryState($oldArticle['category_id']);
        changeCategoryState($fields['category_id']);
        foreach ($tags as $tag) {
            changeTagState($tag['id']);
        }
        $_SESSION['system_message'] = 'Article edited successfully';
        header("Location: article.php?id=" . $id);
        exit();
    } else {
        $err = implode('<br>', $errors);
        $header = $fields['header'];
        $content = $text;
        $tag_names_str = $_POST['tags'];
    }
} else {
    $header = $oldArticle['header'];
    $content = $oldText;
    $category_id = $oldArticle['category_id'];
    $prev_category_id = $category_id;
}

$pageContent = template('article/edit', [
    'id' => $id,
    'header' => $header,
    'content' => $content,
    'category_list' => $category_list,
    'prev_category_id' => $prev_category_id,
    'tag_names_str' => $tag_names_str,
    'err' => $err
]);
$html = template('main', [
    'title' => $pageTitle,
    'content' => $pageContent,
    'authInfo' => $authInfo
]);

echo $html;
