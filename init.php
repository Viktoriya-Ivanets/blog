<?php
session_start();
include_once("models/auth.php");
include_once("models/article.php");
include_once("models/tags.php");
include_once("models/category.php");
include_once("models/comments.php");
include_once("models/notification.php");
include_once("core/functions.php");
include_once("core/db.php");
$authInfo = authGetUser();
