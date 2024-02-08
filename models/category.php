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

	return $query->rowCount() > 0 ? $query->fetchAll() : null;
}

function addCategory(array $fields)
{
	$sql = "INSERT category (header, description) VALUES (:header, :description)";
	dbQuery($sql, $fields);
	return true;
}
function searchCategory(string $search)
{
	$sql = "SELECT * FROM category WHERE header LIKE :search";
	$query = dbQuery($sql, ['search' => "%$search%"]);
	return $query->fetchAll();
}
function changeState(int $id)
{
	$sql = "UPDATE category SET state = 'active' WHERE id = :id";
	if (getArticlesByCategory($id) == null) {
		$sql = "UPDATE category SET state = 'inactive' WHERE id = :id";
	}
	$query = dbQuery($sql, ['id' => $id]);
	return true;
}
function oneCategory(int $id)
{
	$sql = "SELECT * FROM category WHERE id = :id";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->fetch();
}