<?php 
session_start(); 
require_once "db_conn.php";
$_SESSION['officer_name'] = $row['name']; 


if (isset($_POST['username']) && isset($_POST['password'])) {

	function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	$username = validate($_POST['username']);
	$password = validate($_POST['password']);

	if (empty($username)) {
		header("Location: index.php?error=Username is required");
		exit();
	} else if (empty($password)) {
		header("Location: index.php?error=Password is required");
		exit();
	} else {
		$sql = "SELECT * FROM createuser WHERE username=? AND password=?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 1) {
			$row = mysqli_fetch_assoc($result);
			if ($row['username'] === $username && $row['password'] === $password) {
				$_SESSION['username'] = $row['username'];
				$_SESSION['id'] = $row['id'];
				$_SESSION['officer_name'] = $row['name']; // Store the officer's name in the session
		
				// Set the officer's active status to 1 (true)
				$sql = "UPDATE createuser SET active = 1 WHERE id = " . $row['id'];
				$conn->query($sql);
		
				header("Location: ../dashboard/main_dashboard.php");
				exit();
			} else {
				header("Location: index.php?error=Incorrect username or password");
				exit();
			}
		} else {
			header("Location: index.php?error=Incorrect username or password");
			exit();
		}		
	}
	
} else {
	header("Location: index.php");
	exit();
}
