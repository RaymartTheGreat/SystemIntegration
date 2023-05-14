<!DOCTYPE html>
<html>

<head>
  <title>Update User</title>
  <link rel="stylesheet" type="text/css" href="create_update_style.css">
</head>

<body>
  <?php
  // enable error reporting
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  // define the positions array
  $positions = array(
    'President',
    'Vice President',
    'Secretary',
    'Treasurer',
    'Sub-Treasurer',
    'Public Information Officer (P.I.O.)',
    'Auditor'
  );

  // connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "finalproject";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // check if the form was submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // get the form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $position = $_POST['position'];

    // update the form data in the database
    $sql = "UPDATE createuser SET username='$username', password='$password', name='$name', position='$position' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
      echo "<script>alert('User updated successfully');</script>";
      echo "<script>setTimeout(function(){window.location.href='index.php';},1000);</script>";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

  // get the user's current data from the database
  $id = $_GET['id'];
  $sql = "SELECT * FROM createuser WHERE id=$id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  mysqli_close($conn);
  ?>

  <h1>Update User</h1>
  <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" required><br>

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>

    <label for="position">Position:</label><br>
    <select id="position" name="position" required>
      <?php foreach ($positions as $pos) { ?>
        <option value="<?php echo $pos; ?>" <?php if ($row['position'] == $pos) {echo ' selected';} ?>><?php echo $pos; ?></option>
      <?php } ?>
    </select><br>

    <a href="index.php" class="btn-back">Back to Index</a>
    <input type="submit" value="Update" class="btn-update">
  </form>
</body>

</html>