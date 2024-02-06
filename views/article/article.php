<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<?php if ($user != null): ?>
	<a href="notification.php">Notifications</a>
	<a href="logout.php">Logout</a>
<?php else: ?>
	<a href="login.php">Login</a>
<?php endif; ?>
<hr>
<div class="content">
	<div class="article">
		<h1>
			<?= $post['header'] ?>
		</h1>
		<div>
			<?= $post['content'] ?>
		</div>
		<hr>
		<?php if ($user != null && $user['id'] === $post['user_id']): ?>
			<a href="delete.php?id=<?= $id ?>">Remove</a>
			<hr>
			<a href="edit.php?id=<?= $id ?>">Edit</a>
			<hr>
		<?php elseif ($user != null && $user['role'] === 'admin' && $user['id'] !== $post['user_id']): ?>
			<a href="reject.php?id=<?= $id ?>">Reject</a>
		<?php endif; ?>
	</div>
	<div class="tag">
		<?php foreach ($tags as $tag): ?>
			<a href="index.php?mode=articles_by_tags&id=<?= $tag['id'] ?>">
				<?php echo '#' . $tag['header']; ?>
			</a>
		<?php endforeach; ?>
	</div>
</div>
<hr>
<a href="index.php">Move to main page</a>
<hr>
<form action="add_comment.php?id=<?= $id ?>" method="post">
Leave a comment:<br>
<textarea type="text" name="comment"></textarea><br>
<button>Send</button>
</form>
<hr>
<h2>Previous comments:</h2>
<div class="items">
    <?php if (!empty($items)): ?>
        <?php foreach ($items as $item): ?>
            <?php if ($item['state'] === 'active'): ?>
                <div class="item">
                    <?php echo $item['content']; ?>
                    <hr>
                </div>
            <?php else: ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        No comments yet
    <?php endif; ?>