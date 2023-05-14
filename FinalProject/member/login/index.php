<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($_GET['error'])) echo "<div class='error'>" . $_GET['error'] . "</div>"; ?>
        <form action="login.php" method="post">
            <label for="member_id">Member ID:</label>
            <input type="text" name="member_id" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
