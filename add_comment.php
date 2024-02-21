<?php
include_once('init.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($authInfo == null) {
	header("Location: article.php?id=" . $id);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $content = htmlspecialchars($_POST['comment']);
        addComment($authInfo['id'], $id, $content);
        header("Location: article.php?id=$id");
        exit();
    } else {
        $_SESSION['err_add'] = "Missing comment";
        header("Location: article.php?id=$id");
        exit();
    }
}
