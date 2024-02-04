<?php

	include_once('models/article.php');		
	$id = $_GET['id'];
	removeArticle($id);
	echo "<br>";
	include('views/article/delete.php');
?>
