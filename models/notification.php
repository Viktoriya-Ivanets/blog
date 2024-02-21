<?php

include_once('core/db.php');

function addNotification(int $userId, int $articleId, string $notification, $comment_content)
{
    $params = ['id_user' => $userId, 'article_id' => $articleId, 'message' => $notification, 'comment_content' => $comment_content];
    $sql = "INSERT notification (id_user, article_id, message, comment_content) VALUES (:id_user, :article_id, :message, :comment_content)";
    dbQuery($sql, $params);
    return true;
}
function getNotifications(int $id)
{
    $sql = "SELECT id, article_id, message, state, comment_content FROM notification WHERE id_user = :id ORDER BY date DESC";
    $query = dbQuery($sql, ['id' => $id]);
    return $query->fetchAll();
}

function setReadState(int $id)
{
    $sql = "UPDATE notification SET state = 'read' WHERE id = :id";
    dbQuery($sql, ['id' => $id]);
    return true;
}

function getOneNotification(int $id){
    $sql = "SELECT id_user, article_id FROM notification WHERE id = :id";
    $query = dbQuery($sql, ['id' => $id]);
	return $query->fetch() ?: null;
}