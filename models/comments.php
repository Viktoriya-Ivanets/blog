<?php
include_once('core/db.php');
function getCommentsForArticle(int $id)
{
    $sql = "SELECT comment_id, id_user, content, state FROM comments WHERE article_id = :id";
    $query = dbQuery($sql, ['id' => $id]);
    return $query->fetchAll();
}
function addComment(int $user_id, int $article_id, string $content)
{
    $params = ['id_user' => $user_id, 'article_id' => $article_id, 'content' => $content];
    $sql = "INSERT INTO comments (id_user, article_id, content) VALUES (:id_user, :article_id, :content)";
    $query = dbQuery($sql, $params);
    return true;
}
