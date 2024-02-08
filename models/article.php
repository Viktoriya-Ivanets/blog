<?php

include_once('core/db.php');
function getArticles(): array
{
	$sql = "SELECT * FROM article ORDER BY date DESC";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getArticlesByUser(int $id): array
{
	$sql = "SELECT id, header, state FROM article where user_id = :id ORDER BY date DESC";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->fetchAll();
}

function addArticle(array $fields): bool
{
	$sql = "INSERT article (user_id, header, content, category_id) VALUES (:user_id, :header, :content, :category_id)";
	dbQuery($sql, $fields);
	return true;
}

function oneArticle(int $id)
{
	$sql = "SELECT * FROM article WHERE id =:id";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->fetch();
}

function getArticleId(string $header)
{
	$sql = "SELECT id FROM article WHERE header =:header";
	$query = dbQuery($sql, ['header' => $header]);
	return $query->fetch();
}

function removeArticle(int $id)
{
	$sql = "DELETE FROM article WHERE id = :id";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->rowCount();
}

function editArticle(array $fields): bool
{
	$sql = "UPDATE article SET header = :header, content = :content, category_id = :category_id WHERE id = :id";
	dbQuery($sql, $fields);
	return true;
}

function rejectArticle(int $id)
{
	$sql = "UPDATE article SET state='rejected' WHERE id=:id";
	$query = dbQuery($sql, ['id' => $id]);
	return true;
}


function searchArticle(string $search)
{
	$sql = "SELECT * FROM article WHERE header LIKE :search OR content LIKE :search";
	$query = dbQuery($sql, ['search' => "%$search%"]);
	return $query->fetchAll();
}