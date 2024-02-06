<?php

include_once('core/db.php');
function getArticles(): array
{
	$sql = "SELECT * FROM article ORDER BY date DESC";
	$query = dbQuery($sql);
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
	$sqlDeleteTags = "DELETE FROM article_tags WHERE article_id = :id";
	$queryTags = dbQuery($sqlDeleteTags, ['id' => $id]);
	$sqlDeleteNotifications = "DELETE FROM notification WHERE article_id = :id";
	$querryNotification = dbQuery($sqlDeleteNotifications, ['id' => $id]);
	$sqlDeleteComments = "DELETE FROM comments WHERE article_id = :id";
	$querryComments = dbQuery($sqlDeleteComments, ["id"=> $id]);
	$sqlDeleteArticle = "DELETE FROM article WHERE id = :id";
	$queryArticle = dbQuery($sqlDeleteArticle, ['id' => $id]);
	return $queryArticle->rowCount();
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