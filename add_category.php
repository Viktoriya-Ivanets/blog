<?php

include_once('init.php');

if ($authInfo == null || $authInfo['role'] !== 'admin') {
	header("Location: index.php?mode=category");
	exit();
}

$isSend = false;
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['header', 'description']);
	$errors = validateCategory($fields);
	if (empty($errors)) {
	addCategory($fields);
	$isSend = true;
	}else {
		$err = implode('<br>', $errors);
		$header = $fields['header'];
    	$description = $fields['description'];
	}
} else {
	$fields['header'] = '';
	$fields['description'] = '';
}
include('views/category/add.php');
