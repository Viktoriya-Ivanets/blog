<div class="content">
    <div class="container">
        <div class="button-container">
            <a href="index.php" class="btn btn-primary">Move to main page</a>
            <a href="notification.php?mode=read_all" class="btn btn-primary">Mark all as read</a>
        </div>
        <div class="items">
            <?php if ($notifications != null): ?>
                <?php foreach ($notifications as $notification): ?>
                    <div class="item">
                        <h4>
                            <?= $notification['message']; ?>
                        </h4>
                        <?= $notification['message_detail']; ?>
                        <hr>
                        <?php if ($notification['state'] === 'unread'): ?>
                            <a href="notification.php?id=<?= $notification['id']; ?>">Mark as read</a>
                            <hr>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="big-centred-block">
                    <h2>Notification is empty</h2>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
