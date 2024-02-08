<?php
session_start();

include_once('models/article.php');
include_once('models/auth.php');
include_once('models/notification.php');
$id = $_GET['id'];
$user = authGetUser();
$notifications = getNotifications($user['id']);
if (!empty($id)) {
    setReadState($id);
    header('Location: notification.php');
}
include('views/notification.php');