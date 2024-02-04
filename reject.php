<?php

	include_once('models/article.php');		
	$id = $_GET['id'];
	if(is_numeric($id)) rejectArticle($id);
	echo "<br>";
	include('views/article/reject.php');
?>