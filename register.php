<?php

include_once('init.php');
$err ='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['login', 'password', 'email', 'nickname']);
	$remember = isset($_POST['remember']);
	$errors = validateRegistration($fields);
	if (empty($errors)) {
	$fields['password'] = generatePassword($fields['password']);
	addUser($fields);
	$token = generateToken();
	$user = usersOne($fields['login']);
	sessionsAdd($user['id'], $token);
	$_SESSION['token'] = $token;

	if ($remember) {
		setcookie('token', $token, time() + 3600 * 24 * 30, '/php_lessons/php-hw2-sample-src/');
	}

	header('Location: index.php');
	exit();
} else {
	$err = implode('<br>', $errors);
		$login = $fields['login'];
    	$email = $fields['email'];
		$nickname = $fields['nickname'];
		$pass = $fields['password'];
}
}
include('views/auth/register.php');