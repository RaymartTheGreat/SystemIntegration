<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Check if the college_shirt_payment entry already exists
    $check_sql = "SELECT * FROM college_shirt_payment WHERE account_id=?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $exists = $check_result->num_rows > 0;
    $check_stmt->close();

    if ($exists) {
        // Update the member's status in the college_shirt_payment table
        $update_sql = "UPDATE college_shirt_payment SET status=? WHERE account_id=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("si", $status, $id);
    } else {
        // Insert a new entry into the college_shirt_payment table
        $insert_sql = "INSERT INTO college_shirt_payment (account_id, status) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("is", $id, $status);
    }

    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redirect back to the fetch_college_shirt.php page
    header("Location: fetch_college_shirt.php");
    exit;
}
?>