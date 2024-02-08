<?php

include_once('core/db.php');

function addNotification(array $fields)
{
    $sql = "INSERT notification (id_user, article_id, message, comment_content) VALUES (:id_user, :article_id, :message, :comment_content)";
    dbQuery($sql, $fields);
    return true;
}
function getNotifications(int $id)
{
    $sql = "SELECT * FROM notification WHERE id_user = :id ORDER BY date DESC";
    $query = dbQuery($sql, ['id' => $id]);
    return $query->fetchAll();
}

function setReadState(int $id)
{
    $sql = "UPDATE notification SET state = 'read' WHERE id = :id";
    dbQuery($sql, ['id' => $id]);
    return true;
}