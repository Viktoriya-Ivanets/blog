<a href="index.php">Home</a>
<a href="index.php?mode=category">Categories</a>
<a href="register.php">Signup</a>
<form method="post">
	<div class="form-group">
		<label for="auth-login">Login</label>
		<input type="text" class="form-control" id="auth-login" name="login">
	</div>
	<div class="form-group">
		<label for="auth-password">Password</label>
		<input type="password" class="form-control" id="auth-password" name="password">
	</div>
	<div class="form-check">
		<input class="form-check-input" type="checkbox" id="login-remember" name="remember">
		<label class="form-check-label" for="login-remember">
			Remember auth to 1 month
		</label>
	</div>
	<hr>
	<button class="btn btn-primary">Auth now</button>
		<hr>
		<div class="alert alert-danger">
		<?= $err ?>
		</div>
</form>