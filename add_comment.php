<?php
session_start();
include_once('models/comments.php');
include_once('models/auth.php');

$user = authGetUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        $content = $_POST['comment'];
        $id = $_GET['id'];
        addComment($user['id'], $id, $content);
        header("Location: article.php?id=$id");
        exit();
    } else {
        echo "Error: Missing comment";
    }
}
?>