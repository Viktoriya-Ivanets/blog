<img src="<?= $user['avatar'] ?>" alt="Default Avatar" style="width:150px;height:150px;">
<?php if ($user['id'] === $authInfo['id']): ?>
    <div class="form">
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button>Set new avatar</button>
            <?php if ($user['avatar'] !== 'assets/images/default.jpg'): ?>
                <button type="submit" name="delete_avatar">Delete avatar</button>
            <?php endif; ?>
            <p>
                <?= $err ?>
            </p>
        </form>
    </div>
<?php else: ?>
<?php endif; ?>
<h1>
    <?php echo $user['nickname'] ?>
</h1>
<h2>
    User's articles:
</h2>
<?php foreach ($articles as $article): ?>
        <h1>
            <?php echo $article['header'] ?>
        </h1>
        <a href="article.php?id=<?= $article['id']; ?>">Read more</a>
        <hr>
<?php endforeach; ?> 