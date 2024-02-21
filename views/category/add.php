<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<a href="user_page.php?id=<?= $authInfo['id']; ?>">My page</a>
<a href="notification.php">Notifications</a>
<a href="logout.php">Logout</a>
<hr>
<div class="form">
	<?php if ($isSend): ?>
		<p>Category sucessfully added!</p>
	<?php else: ?>
		<form method="post">
			Header:<br>
			<input type="text" name="header" value="<?php echo $header; ?>"><br>
			Description:<br>
			<textarea type="text" name="description"><?= $description ?></textarea><br>
			<button>Send</button>
			<p>
                <?= $err ?>
            </p>
		</form>
	<?php endif; ?>
</div>
<hr>
<a href="index.php">Move to main page</a>