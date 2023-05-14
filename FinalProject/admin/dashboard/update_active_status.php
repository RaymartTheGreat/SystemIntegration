<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finalproject";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $active = $_GET['active'];
  
  $sql = "UPDATE createuser SET active = $active WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit;
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}

mysqli_close($conn);
?>
