<!DOCTYPE html>
<html>

<head>
  <title>Create User</title>
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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $position = $_POST['position'];

    // insert the form data into the database
    $sql = "INSERT INTO createuser (username, password, name, position) VALUES ('$username', '$password', '$name', '$position')";

    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

  mysqli_close($conn);
  ?>

  <h1>Create User</h1>
  <form method="post" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>

    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>

    <label for="position">Position:</label><br>
    <select id="position" name="position" required>
      <?php foreach ($positions as $pos) { ?>
        <option value="<?php echo $pos; ?>"><?php echo $pos; ?></option>
      <?php } ?>
    </select><br>
    <a href="index.php" class="btn-back">Back to Index</a>
    <input type="submit" value="Create" class="btn-create">

  </form>
</body>

</html>