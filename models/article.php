<?php

include_once('core/db.php');
function getArticles(): array
{
	$sql = "SELECT id, header FROM article WHERE state = 'active' ORDER BY date DESC";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getArticlesByUser(int $id): ?array
{
	$sql = "SELECT id, header FROM article where user_id = :id AND state = 'active' ORDER BY date DESC";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->rowCount() > 0 ? $query->fetchAll() : null;
}

function addArticle(array $fields): bool
{
	$sql = "INSERT article (user_id, header, content, category_id) VALUES (:user_id, :header, :content, :category_id)";
	dbQuery($sql, $fields);
	return true;
}

function oneArticle(int $id)
{
	$sql = "SELECT user_id, id, content, header, category_id FROM article WHERE id =:id";
	$query = dbQuery($sql, ['id' => $id]);
	return $query->fetch() ?: null;
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
	$sql = "SELECT id, header FROM article WHERE (header LIKE :search) AND state = 'active'";
	$query = dbQuery($sql, ['search' => "%$search%"]);
	return $query->fetchAll();
}

function validateArticle(array $fields, $tags, $text)
{
	$errors = [];
	if ($fields['header'] === '' || $text === "") {
		$errors[] = 'Fill header and content fields at least';
	}
	if (mb_strlen($fields['header'], 'UTF-8') > 256) {
		$errors[] = 'Header no more than 255 chars';
	}
	if (isset($fields['id'])) {
		$currentArticle = oneArticle($fields['id']);
		if ($currentArticle['header'] !== $fields['header'] && getArticleId($fields['header']) !== false) {
			$errors[] = 'Article with such name already exists!';
		}
	} else {
		if (getArticleId($fields['header']) !== false) {
			$errors[] = 'Article with such name already exists!';
		}
	}

	if ($tags !== null && count($tags) > 20) {
		$errors[] = 'No more than 20 tags';
	}

	return $errors;
}
