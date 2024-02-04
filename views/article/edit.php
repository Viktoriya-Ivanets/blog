<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<a href="logout.php">Logout</a>
<hr>
<div class="form">
	<?php if($isSend):  ?>
		<p>Article successfully edited!</p>
	<?php else: ?>
		<form method="post">
			Header:<br>
			<input type="text" name="header" value="<?php echo $header;?>"><br>
			Content:<br>
			<textarea type="text" name="content"><?=$content?></textarea><br>
			Category:<br>
			<select name="category_id">
			<?php foreach($category_list as $category): ?>
				<option value="<?php echo $category['id']; ?>"><?php echo $category['header']; ?></option>
				<?php endforeach; ?>
			</select><br>
			<button>Send</button>
			<p><?=$err?></p>
		</form>
	<?php endif; ?>
</div>
<hr>
<a href="index.php">Move to main page</a>