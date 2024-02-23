<div class="content">
    <div class="container">
        <div class="article text-center">
            <h1>
                <?= $post['header'] ?>
            </h1>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <div>
                <?php if ($authInfo != null && $authInfo['id'] === $post['user_id']): ?>
                    <a href="delete.php?id=<?= $id ?>" class="btn btn-primary mr-2">Remove</a>
                    <a href="edit.php?id=<?= $id ?>" class="btn btn-primary mr-2">Edit</a>
                <?php elseif ($authInfo != null && $authInfo['role'] === 'admin' && $authInfo['id'] !== $post['user_id']): ?>
                    <a href="reject.php?id=<?= $id ?>" class="btn btn-primary">Reject</a>
                <?php endif; ?>
            </div>
            <div>
                <a href="index.php" class="btn btn-primary">Move to main page</a>
            </div>
        </div>

        <div>
            <?= $post['content'] ?>
        </div>
        <div class="tag mt-3">
            <?php foreach ($tags as $tag): ?>
                <a href="index.php?mode=articles_by_tags&id=<?= $tag['id']; ?>" class="btn btn-outline-secondary m-1">
                    <?= '#' . $tag['header']; ?>
                </a>
            <?php endforeach; ?>
        </div>
        <hr>
    </div>
    <div class="container">
        <?php if ($authInfo != null): ?>
            <form action="add_comment.php?id=<?= $id ?>" method="post" class="mt-3">
                <div class="form-group">
                    <label for="comment">Leave a comment:</label>
                    <textarea class="form-control" id="comment" name="comment"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send</button>
                <p class="text-danger">
                    <?= $err_add ?>
                </p>
            </form>
        <?php endif; ?>

        <h2 class="mt-3">Previous comments:</h2>

        <div class="items">
            <?php if (!empty($items)): ?>
                <?php foreach ($items as $item): ?>
                    <?php if ($item['state'] === 'active'): ?>
                        <?php $userInfo = usersById($item['id_user']); ?>
                        <div class="comment-item">
                            <div class="left-content">
                                <img src="<?= $userInfo['avatar'] ?>" alt="Default Avatar" class="comment-avatar">
                                <a href="user_page.php?id=<?= $userInfo['id']; ?>">
                                    <?= $userInfo['nickname'] ?>
                                </a>
                                <?= $item['content']; ?>
                            </div>
                            <div class="right-content">
                                <?php if ($authInfo['role'] === 'admin' && $authInfo['id'] !== $item['id_user']): ?>
                                    <a href="delete_comment.php?id=<?= $item['comment_id'] ?>" class="btn btn-primary">Delete</a>
                                <?php elseif ($authInfo['id'] === $item['id_user']): ?>
                                    <a href="delete_comment.php?id=<?= $item['comment_id'] ?>" class="btn btn-primary">Delete</a>
                                    <a href="article.php?id=<?= $id ?>&mode=edit&comment_id=<?= $item['comment_id'] ?>"
                                        class="btn btn-primary">Edit</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($_GET['mode'] === 'edit' && isset($_GET['comment_id']) && $_GET['comment_id'] == $item['comment_id']): ?>
                            <form action="edit_comment.php?id=<?= $item['comment_id'] ?>" method="post" class="mt-2">
                                <div class="form-group">
                                    <label for="comment_edit">Edit comment:</label>
                                    <textarea class="form-control" id="comment_edit"
                                        name="comment_edit"><?= $item['content'] ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                                <a href="article.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
                                <p class="text-danger">
                                    <?= $err_edit ?>
                                </p>
                            </form>
                        <?php endif; ?>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No comments yet</p>
                <br>
            <?php endif; ?>
        </div>
    </div>
</div>
