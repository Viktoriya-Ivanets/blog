<a href="index.php">Home</a>
<a href="index.php?mode=category">Categories</a>
<?php if ($authInfo != null): ?>
    <a href="add.php">Add article</a>
    <a href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a>
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
<?php if (count($tagsResults) > 0): ?>
    <h2>Tags:</h2>
    <?php foreach ($tagsResults as $tagsResult): ?>
        <a href="index.php?mode=articles_by_tags&id=<?= $tagsResult['id'] ?>">
            <?php echo '#' . $tagsResult['header']; ?>
        </a><br>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (count($categoryResults) > 0): ?>
    <h2>Categories:</h2>
    <?php foreach ($categoryResults as $categoryResult): ?>
            <a href="index.php?mode=articles_by_category&id=<?= $categoryResult['id']; ?>">
                <?php echo $categoryResult['header']; ?>
            </a>
    <?php endforeach; ?>
<?php endif; ?>