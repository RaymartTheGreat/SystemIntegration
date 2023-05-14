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

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Update the SQL query to join member_account and lanyard_payment tables
$sql = "SELECT ma.*, lp.status 
        FROM member_account AS ma
        LEFT JOIN lanyard_payment AS lp ON ma.id = lp.account_id";

if ($search != '') {
    $sql .= " WHERE ma.member_id LIKE '%$search%'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>IT Payment Dashboard - Lanyard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>IT Payment Dashboard - Lanyard</h1>
        <form class="search-form" action="" method="GET">
            <input type="text" name="search" placeholder="Search member ID...">
            <button type="submit">Search</button>
        </form>
        <form class="logout-form" action="../login/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    <div class="container">
        <div class="nav-container">
            <div class="nav">
                <ul>
                    <li><a href="main_dashboard.php">HOME</a></li>
                    <li><a href="fetch_college_shirt.php">COLLEGE SHIRT</a></li>
                    <li><a href="fetch_unigames_fee.php">UNIGAMES FEE</a></li>
                    <li><a href="fetch_lanyard.php">LANYARD</a></li>
                    <li><a href="fetch_itsoc_membership.php">ITSOC MEMBERSHIP</a></li>
                    <li><a href="#">RUN FOR A CAUSE</a></li>
                    <li><a href="#">CAS FAMILY DAY</a></li>
                    <li><a href="#">SCHOOL PAPER</a></li>
                    <li><a href="#">FINES UNIGAMES</a></li>
                    <li><a href="#">FINES ORG UNIFORM</a></li>
                </ul>
            </div>
        </div>
        <div class="members-table-container">
            <table class="members-table">
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Year Level</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Action</th>
                    <th>Payment Receipt</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["member_id"] . "</td>";
                        echo "<td>" . $row["first_name"] . "</td>";
                        echo "<td>" . $row["last_name"] . "</td>";
                        echo "<td>" . $row["year_level"] . "</td>";
                        echo "<td>" . $row["section"] . "</td>";
                        echo "<td>" . ($row["status"] ? $row["status"] : "Not yet paid") . "</td>";
                        echo "<td>";
                        echo "<form method='POST' action='update_member_status_lanyard.php'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<input type='hidden' name='status' value='" . ($row["status"] == "Payment Successful" ? "Not yet paid" : "Payment Successful") . "'>";
                        echo "<button type='submit' class='blue-button'>" . ($row["status"] == "Payment Successful" ? "Mark Unpaid" : "Mark Paid") . "</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "<td>";
                        echo "<form method='POST' action='view_receipt_lanyard.php' target='_blank'>";
                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' class='blue-button'>View Receipt</button>";
                        echo "</form>";
                        echo "</td>";

                        echo "</tr>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                ?>
            </table>
        </div>

    </div>
    <div class="footer">
        <p>Copyright &copy; 2023 by Future Tech Solution (FST).
            <br>All rights reserved.
        </p>
    </div>
</body>

</html>