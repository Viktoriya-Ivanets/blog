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
<h1>Results:</h1>
<?php echo $message; ?>
<?php if (count($articleResults) > 0): ?>
    <h2>Articles:</h2>
    <?php foreach ($articleResults as $articleResult): ?>
        <a href="article.php?id=<?= $articleResult['id']; ?>">
            <?php echo $articleResult['header']; ?>
        </a> <br>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (count($activeTagResults) > 0): ?>
    <h2>Tags:</h2>
    <?php foreach ($tagsResults as $tagsResult): ?>
        <a href="index.php?mode=articles_by_tags&id=<?= $tagsResult['id'] ?>">
            <?php echo '#' . $tagsResult['header']; ?>
        </a><br>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (count($activeCategoryResults) > 0): ?>
    <h2>Categories:</h2>
    <?php foreach ($activeCategoryResults as $categoryResult): ?>
        <?php if ($categoryResult['state'] === 'active'): ?>
            <a href="index.php?mode=articles_by_category&id=<?= $categoryResult['id']; ?>">
                <?php echo $categoryResult['header']; ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>