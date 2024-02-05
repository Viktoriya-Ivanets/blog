<a href="index.php">Home</a>
<a href="add.php">Add article</a>
<a href="index.php?mode=category">Categories</a>
<a href="logout.php">Logout</a>
<hr>
<div class="form">
	<?php if($isSend):  ?>
		<p>Category sucessfully added!</p>
	<?php else: ?>
		<form method="post">
			Header:<br>
			<input type="text" name="header"><br>
			Description:<br>
			<textarea type="text" name="description"></textarea><br>
			<button>Send</button>
		</form>
	<?php endif; ?>
</div>
<hr>
<a href="index.php">Move to main page</a> 