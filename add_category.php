<?php
session_start();

	include_once('core/functions.php');
	include_once('models/category.php');

	$isSend = false;
	$err = '';

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$fields = extractFields($_POST, ['header', 'description']);
		if($fields['header'] === '' || $fields['description'] === ''){
			$err = 'Заполните все поля!';
		}
		addCategory($fields);
		$isSend = true;
	}
	else{
		$fields['header'] = '';
		$fields['description'] = '';
	}
	include('views/category/add.php');
?>