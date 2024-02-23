<br>
<h1>Results:</h1>
<?php if ($message !== ''): ?>
    <div class="big-centred-block">
        <h2>
            <?php echo $message; ?>
        </h2>
    </div>
<?php endif; ?>
<?php if (isset($articleResults) && count($articleResults) > 0): ?>
    <h2>Articles:</h2>
    <?php foreach ($articleResults as $articleResult): ?>
        <a href="article.php?id=<?= $articleResult['id']; ?>">
            <?php echo $articleResult['header']; ?>
        </a> <br>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (isset($tagsResults) && count($tagsResults) > 0): ?>
    <h2>Tags:</h2>
    <?php foreach ($tagsResults as $tagsResult): ?>
        <a href="index.php?mode=articles_by_tags&id=<?= $tagsResult['id'] ?>">
            <?php echo '#' . $tagsResult['header']; ?>
        </a><br>
    <?php endforeach; ?>
<?php endif; ?>
<?php if (isset($categoryResults) && count($categoryResults) > 0): ?>
    <h2>Categories:</h2>
    <?php foreach ($categoryResults as $categoryResult): ?>
        <a href="index.php?mode=articles_by_category&id=<?= $categoryResult['id']; ?>">
            <?php echo $categoryResult['header']; ?>
        </a><br>
    <?php endforeach; ?>
<?php endif; ?>

