<?php
include_once('core/db.php');
function getCommentsForArticle(int $id)
{
    $sql = "SELECT comment_id, id_user, content, state FROM comments WHERE article_id = :id ORDER BY date DESC";
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
function editComment(int $comment_id, string $content)
{
    $params = ['comment_id' => $comment_id, 'content' => $content];
    $sql = "UPDATE comments SET content = :content WHERE comment_id = :comment_id";
    $query = dbQuery($sql, $params);
    return true;
}
function deleteComment(int $id)
{
    $sql = "DELETE FROM comments WHERE comment_id = :id";
    $query = dbQuery($sql, ['id' => $id]);
    return true;
}
function getCommentInfo(int $id)
{
    $sql = "SELECT content, article_id, id_user FROM comments WHERE comment_id = :id";
    $query = dbQuery($sql, ['id' => $id]);
    return $query->fetch() ?: null;
}
