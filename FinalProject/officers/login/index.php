<!DOCTYPE html>
<html>
<head>
	<title>IT ORG</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="container">
		<h1>Login</h1>
		<?php if (isset($_GET['error'])) { ?>
     		<p class="error"><?php echo $_GET['error']; ?></p>
     	<?php } ?>
		<form action="login.php" method="POST">
			<label for="username">Username:</label>
			<input type="text" name="username" required>

			<label for="password">Password:</label>
			<input type="password" name="password" required>

			<input type="submit" value="Login">
		</form>
	</div>
</body>
</html>
