<?php 
include_once('core/functions.php');
include_once('models/article.php');
include_once('models/category.php');
$id = $_GET['id'];
$isSend = false;
$err = '';
$oldArticle = oneArticle($id);
$category_list = getCategories ();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
	$fields = extractFields($_POST, ['header', 'content', 'category_id']);
	$fields['id'] = $id;
		
	if($fields['header'] === '' || $fields['content'] === '' || $fields['category_id'] === ''){
		$err = 'Заполните все поля!';
	}
	else{
		editArticle($fields);
		$isSend = true;
	}
}
else{
	$header = $oldArticle['header'];
	$content = $oldArticle['content'];
	$category_id = $oldArticle['category_id'];
}
include('views/article/edit.php');
?>
