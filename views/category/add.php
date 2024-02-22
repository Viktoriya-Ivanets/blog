<div class="form">
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
</div>
<hr>
<a href="index.php">Move to main page</a>