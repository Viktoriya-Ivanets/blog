<?php
include_once("init.php");

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (is_numeric($id)) {
    $user = usersById($id);
    if (is_null($user)) {
        header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}
$articles = getArticlesByUser($id);
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];
    $errors = validateAvatar($file);

    if (!empty($errors)) {
        $err = implode('<br>', $errors);
    } else {
        $imageURL = 'assets/images/' . mt_rand(1000, 100000) . '.jpg';
        copy($file['tmp_name'], $imageURL);
        renewAvatar($id, $imageURL);
        if ($user['avatar'] !== 'assets/images/default.jpg')
            unlink($user['avatar']);
        header('Location: user_page.php?id=' . $authInfo['id']);
        exit();
    }
    if (isset($_POST['delete_avatar'])) {
        setDefaultAvatar($id);
        if ($user['avatar'] !== 'assets/images/default.jpg')
            unlink($user['avatar']);
        header('Location: user_page.php?id=' . $authInfo['id']);
        exit();
    }
}
include('views/user_page.php');