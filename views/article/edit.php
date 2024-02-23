<div class="centered-container small-container">
    <form method="post">
        <div class="form-group">
            <label for="header">Header:</label>
            <input type="text" class="form-control" id="header" name="header" value="<?= $header; ?>">
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content"><?= $content ?></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category:</label>
            <select class="form-control" id="category" name="category_id">
                <?php foreach ($category_list as $category): ?>
                    <option value="<?= $category['id']; ?>" <?php if ($category['id'] == $prev_category_id)
                          echo 'selected'; ?>>
                        <?= $category['header']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tags">Tags:</label>
            <textarea class="form-control" id="tags" name="tags"><?= $tag_names_str ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
        <?php if ($err !== ''): ?>
            <div class="alert alert-danger">
                <?= $err ?>
            </div>
        <?php endif; ?>
    </form>
</div>
<hr>
<div class="my-container text-center">
    <a href="article.php?id=<?= $id ?>" class="btn btn-primary">Move back</a>
</div>
