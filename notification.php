<?php
include_once('init.php');

if ($authInfo == null) {
	header('Location: index.php');
	exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!is_null($id) && !is_numeric($id)) {
    header('HTTP/1.1 400 Bad Request');
    include 'views/error/e400.php';
    exit;
}
$pageTitle = 'Notifications page';
$notifications = getNotifications($authInfo['id']);
if(!is_null($id)) {
$userFromNotification = getOneNotification($id);
if ($authInfo['id'] === $userFromNotification['id_user']) {
    setReadState($id);
    header('Location: notification.php');
} else{
    header('HTTP/1.1 404 Not Found');
        include 'views/error/e404.php';
        exit;
}
}
foreach ($notifications as &$notification) {
    $article = oneArticle($notification['article_id']);
    if ($notification['comment_content'] !== null) {
        $notification['message_detail'] = "Deleted comment - " . $notification['comment_content'];
    } else {
        $notification['message_detail'] = "Rejected article - " . $article['header'];
    }
    if($_GET['mode'] === 'read_all'){
    setReadState($notification['id']);
    header('Location: notification.php');
    }
}
unset($notification);
$pageContent = template('notification', ['notifications' => $notifications]);
$html = template('main', [
	'title' => $pageTitle,
	'content' => $pageContent, 
    'authInfo' => $authInfo
]);

echo $html;