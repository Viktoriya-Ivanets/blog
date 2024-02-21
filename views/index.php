<div class="items">
    <?php foreach ($items as $item): ?>
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
    <?php endforeach; ?>
    <?php if ($mode === 'category' && $authInfo['role'] === 'admin'): ?>
        <hr>
        <a href="add_category.php">Add more categories</a>
    <?php else: ?>
    <?php endif; ?>
</div>