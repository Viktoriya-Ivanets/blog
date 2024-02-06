<?php
session_start();
include_once('models/article.php');
include_once('models/auth.php');
include_once('models/tags.php');
include_once('models/comments.php');
$id = $_GET['id'];
$post = oneArticle($id);
$user = authGetUser();
$tags = getTagNamesForArticle($id);
$items = getCommentsForArticle($id);
include('views/article/article.php');
