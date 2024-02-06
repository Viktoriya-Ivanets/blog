<?php

session_start();


include_once('models/auth.php');
$authErr = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$login = trim($_POST['login']);
	$password = trim($_POST['password']);
	$remember = isset($_POST['remember']);

	if ($login != '' && $password != '') {
		$user = usersOne($login);
		if ($user !== null && password_verify($password, $user['password'])) {
			$token = generateToken();
			sessionsAdd($user['id'], $token);
			$_SESSION['token'] = $token;

			if ($remember) {
				setcookie('token', $token, time() + 3600 * 24 * 30, '/php_lessons/php-hw2-sample-src/');
			}

			header('Location: index.php');
			exit();
		}
	}
} else {
	$authErr = true;
}
include('views/auth/login.php')
	?>