<a href="index.php">Home</a>
<a href="index.php?mode=category">Categories</a>
<a href="login.php">Login</a>
<form method="post">
	<div class="form-group">
		<label for="auth-login">Enter login</label>
		<input type="text" class="form-control" id="auth-login" name="login" value="<?php echo $login; ?>">
	</div>
	<div class="form-group">
		<label for="auth-password">Enter password</label>
		<input type="password" class="form-control" id="auth-password" name="password" value="<?php echo $pass; ?>">
	</div>
	<div class="form-group">
		<label for="auth-login">Enter email</label>
		<input type="text" class="form-control" id="auth-email" name="email" value="<?php echo $email; ?>">
	</div>
	<div class="form-group">
		<label for="auth-login">Enter your nick</label>
		<input type="text" class="form-control" id="auth-nick" name="nickname" value="<?php echo $nickname; ?>">
	</div>
	<div class="form-check">
		<input class="form-check-input" type="checkbox" id="login-remember" name="remember">
		<label class="form-check-label" for="login-remember">
			Remember auth to 1 month
		</label>
	</div>
	<hr>
	<button class="btn btn-primary">Sign-Up</button>
	<p>
                <?= $err ?>
            </p>
</form>