<!DOCTYPE html>
<html>

<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    .logout-btn {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style>
</head>

<body>
  <a class="logout-btn" href="../login/logout.php"><button>Logout</button></a>
  <h1>Admin Dashboard</h1>
  <a href="create_user.php"><button>Create User</button></a>
  <h2>Existing Users</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Name</th>
        <th>Position</th>
        <th>Action</th>
        <th>Active</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Connect to the database
      $conn = mysqli_connect('localhost', 'root', '', 'finalproject');

      // Check if the connection was successful
      if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
      }

      // Retrieve data from the database
      $sql = "SELECT * FROM createuser";
      $result = mysqli_query($conn, $sql);

      // Loop through the data and display it in the table
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['username']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['position']; ?></td>
          <td>
            <a href="update_user.php?id=<?php echo $row['id']; ?>">Edit</a> |
            <a href="delete_user.php?id=<?php echo $row['id']; ?>">Delete</a>
          </td>
          <td>
            <?php echo $row['active'] ? 'Active' : 'Offline'; ?>
          </td>
        </tr>
      <?php
      }

      // Close the database connection
      mysqli_close($conn);
      ?>
    </tbody>
  </table>
</body>

</html>