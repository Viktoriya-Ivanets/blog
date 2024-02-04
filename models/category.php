<?php

	include_once('core/db.php');
	function getCategories (){
		$sql = "SELECT * FROM category ORDER BY header";
		$query = dbQuery($sql);
		return $query->fetchAll();
	}

	function getArticlesByCategory(int $id) {
		$sql = "SELECT * FROM article WHERE category_id = :id ORDER BY header";
		$query = dbQuery($sql, ['id' => $id]);
		return $query->fetchAll();
	}

	// function getCategoryIdByName(string $header) {
	// 	$sql = "SELECT id FROM category WHERE header = :header";
	// 	$query = dbQuery($sql, ['header' => $header]);
	// 	$id = $query->fetch();
	// 	return $id === false ? null : $id;
	// }