<?php
include_once('init.php');

$_SESSION = array();

setcookie('token', '', time() - 1, '/php_lessons/php-hw2-sample-src/');

header('Location: login.php');
