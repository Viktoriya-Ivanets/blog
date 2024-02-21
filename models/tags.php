<?php

include_once('core/db.php');

function getTagNamesForArticle(int $article_id)
{
    $sql = "SELECT tags.id, tags.header FROM tags JOIN article_tags ON article_tags.tag_id = tags.id WHERE article_tags.article_id = :article_id";
    $query = dbQuery($sql, ['article_id' => $article_id]);
    return $query->fetchAll();
}

function getArticlesByTag(int $tag_id)
{
    $sql = "SELECT article.id, article.header FROM article
                JOIN article_tags ON article.id = article_tags.article_id
                JOIN tags ON article_tags.tag_id = tags.id
                WHERE tags.id = :tag_id AND article.state = 'active'";

    $query = dbQuery($sql, ['tag_id' => $tag_id]);
    return $query->rowCount() > 0 ? $query->fetchAll() : null;
}

function addTag(string $header)
{
    $sql = "INSERT INTO tags (header) VALUES (:header) ON DUPLICATE KEY UPDATE header = :header";
    dbQuery($sql, ['header' => $header]);
    return true;
}

function removeTagsForArticle(int $id)
{
    $sql = "DELETE FROM article_tags WHERE article_id = :id";
    $query = dbQuery($sql, ['id' => $id]);
    return true;
}

function linkArticleWithTag(int $articleId, int $tagId)
{
    $params = ['article_id' => $articleId, 'tag_id' => $tagId];
    $sql = "INSERT INTO article_tags (article_id, tag_id) VALUES (:article_id, :tag_id) 
                ON DUPLICATE KEY UPDATE article_id=article_id";
    dbQuery($sql, $params);
    return true;
}

function getTagId(string $header)
{
    $sql = "SELECT id FROM tags WHERE header =:header";
    $query = dbQuery($sql, ['header' => $header]);
    return $query->fetch();
}

function searchTag(string $search)
{
    $sql = "SELECT id, header FROM tags WHERE header LIKE :search AND state = 'active'";
    $query = dbQuery($sql, ['search' => "%$search%"]);
    return $query->fetchAll();
}
function changeTagState(int $id)
{
    $sql = "UPDATE tags SET state = 'active' WHERE id = :id";
    if (getArticlesByTag($id) == null) {
        $sql = "UPDATE tags SET state = 'inactive' WHERE id = :id";
    }
    $query = dbQuery($sql, ['id' => $id]);
    return true;
}
function addTagsToArticle(array $rawTags, int $id){
    foreach ($rawTags as $rawTag) {
        addTag($rawTag);
    }
    $tagIds = [];
    foreach ($rawTags as $rawTag) {
        $tagIds[] = getTagId($rawTag);
    }
    foreach ($tagIds as $tagId) {
        linkArticleWithTag($id, $tagId['id']);
    }
}