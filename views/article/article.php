<a href="index.php">Home</a>
<a href="index.php?mode=category">Categories</a>
<?php if ($authInfo != null): ?>
	<a href="add.php">Add article</a>
	<a href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a>
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
		<?php if ($authInfo != null && $authInfo['id'] === $post['user_id']): ?>
			<a href="delete.php?id=<?= $id ?>">Remove</a>
			<hr>
			<a href="edit.php?id=<?= $id ?>">Edit</a>
			<hr>
		<?php elseif ($authInfo != null && $authInfo['role'] === 'admin' && $authInfo['id'] !== $post['user_id']): ?>
			<a href="reject.php?id=<?= $id ?>">Reject</a>
		<?php endif; ?>
	</div>
	<div class="tag">
		<?php foreach ($tags as $tag): ?>
			<a href="index.php?mode=articles_by_tags&id=<?= $tag['id']; ?>">
				<?php echo '#' . $tag['header']; ?>
			</a>
		<?php endforeach; ?>
	</div>
</div>
<hr>
<a href="index.php">Move to main page</a>
<hr>
<?php if($authInfo != null): ?>
<form action="add_comment.php?id=<?= $id ?>" method="post">
	Leave a comment:<br>
	<textarea type="text" name="comment"></textarea><br>
	<button>Send</button>
	<p>
		<?= $err_add ?>
	</p>
</form>
<hr>
<?php endif; ?>
<h2>Previous comments:</h2>
<div class="items">
	<?php if (!empty($items)): ?>
		<?php foreach ($items as $item): ?>
			<?php if ($item['state'] === 'active'): ?>
				<?php $userInfo = usersById($item['id_user']); ?>
				<div class="item">
					<img src="<?= $userInfo['avatar'] ?>" alt="Default Avatar" style="width:50px;height:50px;">
					<a href="user_page.php?id=<?= $userInfo['id']; ?>">
						<?= $userInfo['nickname'] ?>
					</a>
					<?= $item['content']; ?>
					<?php if ($authInfo['role'] === 'admin' && $authInfo['id'] !== $item['id_user']): ?>
						<a href="delete_comment.php?id=<?= $item['comment_id'] ?>">Delete</a>
					<?php elseif ($authInfo['id'] === $item['id_user']): ?>
						<a href="delete_comment.php?id=<?= $item['comment_id'] ?>">Delete</a>
						<a href="article.php?id=<?= $id ?>&mode=edit&comment_id=<?= $item['comment_id'] ?>">Edit</a>
						<?php if ($_GET['mode'] === 'edit' && isset($_GET['comment_id']) && $_GET['comment_id'] == $item['comment_id']): ?>
							<form action="edit_comment.php?id=<?= $item['comment_id'] ?>" method="post">
								Edit comment:<br>
								<textarea type="text" name="comment_edit"><?= $item['content'] ?></textarea><br>
								<button>Send</button>
								<a href="article.php?id=<?= $id ?>">Cancel</a>
								<p>
								<?= $err_edit ?>
								</p>
							</form>
						<?php endif; ?>
					<?php endif; ?>
					<hr>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php else: ?>
		No comments yet
	<?php endif; ?>