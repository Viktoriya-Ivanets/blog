<?php

include_once('core/db.php');
function getActiveCategories()
{
	$sql = "SELECT id, header FROM category WHERE state = 'active' ORDER BY header";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getAllCategories()
{
	$sql = "SELECT id, header FROM category ORDER BY header";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getArticlesByCategory(int $id)
{
	$sql = "SELECT id, header FROM article WHERE category_id = :id AND state = 'active' ORDER BY header";
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
	$sql = "SELECT id, header FROM category WHERE header LIKE :search AND state = 'active'";
	$query = dbQuery($sql, ['search' => "%$search%"]);
	return $query->fetchAll();
}
function changeCategoryState(int $id)
{
	$sql = "UPDATE category SET state = 'active' WHERE id = :id";
	if (getArticlesByCategory($id) == null) {
		$sql = "UPDATE category SET state = 'inactive' WHERE id = :id";
	}
	$query = dbQuery($sql, ['id' => $id]);
	return true;
}

function getCategoryByHeader(string $header) {
	$sql = "SELECT header FROM category WHERE header = :header";
	$query = dbQuery($sql, ['header' => $header]);
	return $query->fetch();
}

function validateCategory(array $fields){
	$errors = [];
	if ($fields['header'] === '' || $fields['description'] === '') {
		$errors[] = 'Fill all fields';
	}
	if (mb_strlen($fields['header']) > 255 || mb_strlen($fields['description']) > 255) {
    $errors[] = 'No more than 255 chars';
}

	if (getCategoryByHeader($fields['header']) !== false) {
		$errors[] = 'Category with such name already exists!';
	}

	return $errors;
}
