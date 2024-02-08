<a href="index.php">Home</a>
<a href="index.php?mode=category">Categories</a>
<?php if ($user != null): ?>
    <a href="add.php">Add article</a>
    <a href="user_page.php?id=<?= $user['id']; ?>">My page</a>
    <a href="notification.php">Notifications</a>
    <a href="logout.php">Logout</a>
<?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Signup</a>
<?php endif; ?>
<form method="post" action="search.php">
    Search:<input type="text" name="search">
    <button>Send</button>
</form>
<hr>
<div class="items">
    <?php foreach ($items as $item): ?>
        <?php if ($item['state'] === 'active'): ?>
            <div class="item">
                <h2>
                    <?= $item['header']; ?>
                </h2>
                <?php if ($mode === 'category'): ?>
                    <a href="index.php?mode=articles_by_category&id=<?= $item['id']; ?>">Read more</a>
                <?php elseif ($mode === 'articles_by_tags'): ?>
                    <a href="article.php?id=<?= $item['id']; ?>">Read more</a>
                <?php else: ?>
                    <a href="article.php?id=<?= $item['id']; ?>">Read more</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?php if ($mode === 'category' && $user['role'] === 'admin'): ?>
        <hr>
        <a href="add_category.php">Add more categories</a>
    <?php else: ?>
    <?php endif; ?>
</div>