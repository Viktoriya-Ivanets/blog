<div class="items">
    <?php if ($mode === 'category' && $authInfo['role'] === 'admin'): ?>
        <a href="add_category.php" class="btn btn-primary">Add more categories</a>
    <?php else: ?>
    <?php endif; ?>
    <?php foreach ($items as $item): ?>
        <div class="item">
            <h2>
                <?= $item['header']; ?>
            </h2>
            <?php if ($mode === 'category'): ?>
                <a href="index.php?mode=articles_by_category&id=<?= $item['id']; ?>">Read more</a>
                <hr>
            <?php elseif ($mode === 'articles_by_tags'): ?>
                <a href="article.php?id=<?= $item['id']; ?>">Read more</a>
                <hr>
            <?php else: ?>
                <a href="article.php?id=<?= $item['id']; ?>">Read more</a>
                <hr>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
