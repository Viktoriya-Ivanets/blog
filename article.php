<?php
session_start();
include_once('models/article.php');
include_once('models/auth.php');
include_once('models/tags.php');
$id = $_GET['id'];
$post = oneArticle($id);
$user = authGetUser();
$tags = getTagNamesForArticle($id);
include('views/article/article.php');
?>