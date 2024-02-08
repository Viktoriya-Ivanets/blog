<?php
session_start();
include_once("models/auth.php");
include_once("models/article.php");
include_once("core/functions.php");
$id = $_GET['id'];
$authInfo = authGetUser();
$user = usersById($id);
$articles = getArticlesByUser($id);
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];

    if ($file['name'] === '') {
        $err = 'Choose file!';
    } else if ($file['size'] === 0) {
        $err = 'File too large!';
    } else if (!checkImageName($file['name'])) {
        $err = 'Only jpg';
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