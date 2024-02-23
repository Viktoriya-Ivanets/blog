<?php
include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($authInfo == null) {
    $_SESSION['system_message'] = 'Log-In or Sign-Up to add your comment';
    header("Location: article.php?id=" . $id);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $content = htmlspecialchars($_POST['comment']);
        addComment($authInfo['id'], $id, $content);
        $_SESSION['system_message'] = 'Comment added successfully';
        header("Location: article.php?id=$id");
        exit();
    } else {
        $_SESSION['err_add'] = "Missing comment";
        header("Location: article.php?id=$id");
        exit();
    }
}
