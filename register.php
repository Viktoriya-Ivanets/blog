<?php

session_start();

include_once('models/auth.php');
include_once('core/functions.php');
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $fields = extractFields($_POST, ['login', 'password', 'email', 'nickname']);
	$fields['password'] = generatePassword($fields['password']);
    $remember = isset($_POST['remember']);
    addUser($fields);
    $token = generateToken();
    $user = usersOne($fields['login']);
	sessionsAdd($user['id'], $token);
	$_SESSION['token'] = $token;

	if($remember){
		setcookie('token', $token, time() + 3600 * 24 * 30, '/php_lessons/php-hw2-sample-src/');
	}

	header('Location: index.php');
    exit();
}
include('views/auth/register.php')
?>