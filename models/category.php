<?php

include_once('core/db.php');
function getCategories()
{
	$sql = "SELECT * FROM category ORDER BY header";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getArticlesByCategory(int $id)
{
	$sql = "SELECT * FROM article WHERE category_id = :id ORDER BY header";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->fetchAll();
}
function addCategory(array $fields)
{
	$sql = "INSERT category (header, description) VALUES (:header, :description)";
	dbQuery($sql, $fields);
	return true;
}