<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['delete'])) {

	// Get form data
	$id = $_POST['id'];

	// Delete query
	$sql = "DELETE FROM createuser WHERE id=$id";

	if ($conn->query($sql) === TRUE) {
		// Redirect to index page
		header("Location: index.php");
		exit;
	} else {
		echo "Error deleting record: " . $conn->error;
	}
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Delete User</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<script>
		function showDeleteAlert() {
			alert("User has been deleted.");
		}
	</script>

	<?php
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	?>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<h1>Delete User</h1>
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		<p>Are you sure you want to delete this user?</p>
		<button type="submit" name="delete" onclick="showDeleteAlert()">Delete</button>
		<a href="index.php">Cancel</a>
	</form>

</body>

</html>