<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<a href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a>
<a href="notification.php">Notifications</a>
<a href="logout.php">Logout</a>
<hr>
<div class="content">
    <div class="items">
        <?php if ($notifications != null): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="item">
                    <h2>
                        <?= $notification['message']; ?>
                    </h2>
                    <?= $notification['message_detail']; ?>
                    <hr>
                    <?php if ($notification['state'] === 'unread'): ?>
                        <a href="notification.php?id=<?= $notification['id']; ?>">Mark as read</a>
                        <hr>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            Notification is empty
            <hr>
        <?php endif; ?>
    </div>
    <a href="notification.php?mode=read_all">Mark all as read</a>
    <a href="index.php">Move to main page</a>
</div>
