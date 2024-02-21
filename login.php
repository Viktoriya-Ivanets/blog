<?php

include_once('init.php');

$authErr = [];
$pageTitle = 'Login';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['login', 'password', 'remember']);
	if ($fields['login'] != '' && $fields['password'] != '') {
		$user = usersOne($fields['login']);
		if ($user !== null && password_verify($fields['password'], $user['password'])) {
			$token = generateToken();
			sessionsAdd($user['id'], $token);
			$_SESSION['token'] = $token;

			if ($fields['remember'] === 'on') {
				setcookie('token', $token, time() + 3600 * 24 * 30, '/php_lessons/php-hw2-sample-src/');
			}

			header('Location: index.php');
			exit();
		}else{
			$authErr[] = "Incorrect auth data";
		}
	} else{
		$authErr[] = "Fill all fields";
	}
}
$err = implode('<br>', $authErr);
$pageContent = template('auth/login', ['err' => $err]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent, 
    'authInfo' => $authInfo
]);

echo $html;