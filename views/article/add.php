<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<a href="notification.php">Notifications</a>
<a href="logout.php">Logout</a>
<hr>
<div class="form">
	<?php if($isSend):  ?>
		<p>Article sucessfully added!</p>
	<?php else: ?>
		<form method="post">
			Header:<br>
			<input type="text" name="header" value="<?php echo htmlspecialchars($fields['header'] ?? ''); ?>"><br>
			Content:<br>
			<textarea type="text" name="content"><?php echo htmlspecialchars($fields['content'] ?? ''); ?></textarea><br>
			Category:<br>
			<select name="category_id">
			<?php foreach($category_list as $category): ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['header']; ?></option>
				<?php endforeach; ?>
			</select><br>
			Tags:<br>
			<textarea type="text" name="tags"><?php echo $tagsStr ?? '' ?></textarea><br>
			<button>Send</button>
			<p><?=$err?></p>
		</form>
	<?php endif; ?>
</div>
<hr>
<a href="index.php">Move to main page</a> 