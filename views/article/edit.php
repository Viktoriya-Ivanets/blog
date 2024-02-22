<div class="form">
        <form method="post">
            Header:<br>
            <input type="text" name="header" value="<?php echo $header; ?>"><br>
            Content:<br>
            <textarea type="text" name="content"><?= $content ?></textarea><br>
            Category:<br>
            <select name="category_id">
    <?php foreach ($category_list as $category): ?>
        <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $prev_category_id) echo 'selected'; ?>>
            <?php echo $category['header']; ?>
        </option>
    <?php endforeach; ?>
</select><br>
            Tags:<br>
            <textarea type="text" name="tags"><?php echo $tag_names_str ?></textarea><br>
            <button>Send</button>
            <p>
                <?= $err ?>
            </p>
        </form>
</div>
<hr>
<a href="index.php">Move to main page</a>