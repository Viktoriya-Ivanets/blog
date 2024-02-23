<div class="centered-container small-container">
    <form method="post">
        <div class="form-group">
            <label for="header">Header:</label>
            <input type="text" class="form-control" id="header" name="header" value="<?php echo $header; ?>">
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="5"><?= $content ?></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category_id">
                <?php foreach ($category_list as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo $category['header']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <textarea class="form-control" id="tags" name="tags"><?php echo $tag_names_str ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
        <?php if ($err !== ''): ?>
            <div class="alert alert-danger">
                <?= $err ?>
            </div>
        <?php endif; ?>
    </form>
</div>
<div class="my-container text-center">
    <a href="index.php" class="btn btn-primary">Move to main page</a>
</div>
