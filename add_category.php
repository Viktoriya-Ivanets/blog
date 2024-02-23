<?php

include_once('init.php');

if ($authInfo == null || $authInfo['role'] !== 'admin') {
	$_SESSION['system_message'] = 'You are not permitted for such actions';
	header("Location: index.php?mode=category");
	exit();
}

$err = '';
$pageTitle = 'Add category';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fields = extractFields($_POST, ['header', 'description']);
	$errors = validateCategory($fields);
	if (empty($errors)) {
		addCategory($fields);
		$_SESSION['system_message'] = 'Category added successfully. It will be inactive until new article with such category not added';
		header("Location: index.php?mode=category");
		exit();
	} else {
		$err = implode('<br>', $errors);
		$header = $fields['header'];
		$description = $fields['description'];
	}
} else {
	$fields['header'] = '';
	$fields['description'] = '';
}
$pageContent = template('category/add', [
	'header' => $header,
	'content' => $description,
	'err' => $err
]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent,
	'authInfo' => $authInfo
]);

echo $html;
