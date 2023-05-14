<?php
session_start();
require_once('db_conn.php');

if (!isset($_SESSION['member_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$member_id = $_SESSION['member_id'];

$query_account = "SELECT id, first_name, last_name FROM member_account WHERE member_id = ?";
$stmt_account = $conn->prepare($query_account);
$stmt_account->bind_param("s", $member_id);
$stmt_account->execute();
$result_account = $stmt_account->get_result();
$account = $result_account->fetch_assoc();

$account_id = $account['id'];
$first_name = $account['first_name'];
$last_name = $account['last_name'];

$query_payments = "SELECT 'College Shirt' AS item_type, status FROM college_shirt_payment WHERE account_id = ?
UNION
SELECT 'Unigames Fee' AS item_type, status FROM unigames_fee_payment WHERE account_id = ?
UNION
SELECT 'Lanyard' AS item_type, status FROM lanyard_payment WHERE account_id = ?
UNION
SELECT 'ITSOC Membership' AS item_type, status FROM itsoc_membership_payment WHERE account_id = ?";

$stmt_payments = $conn->prepare($query_payments);
$stmt_payments->bind_param("iiii", $account_id, $account_id, $account_id, $account_id);
$stmt_payments->execute();
$result_payments = $stmt_payments->get_result();

$payments = [];
while ($row = $result_payments->fetch_assoc()) {
    $payments[] = $row;
}
?>



<!DOCTYPE html>
<html>

<head>
    <title>Member | Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>Main Dashboard</h1>
        <span class="member-name">Welcome, <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></span>
        <form class="logout-form" action="../login/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    <div class="container">
        <div class="nav-container">
            <div class="nav">
                <ul>
                    <li><a href="main_dashboard.php">HOME</a></li>
                    <li><a href="college_shirt.php">COLLEGE SHIRT</a></li>
                    <li><a href="unigames_fee.php">UNIGAMES FEE</a></li>
                    <li><a href="lanyard.php">LANYARD</a></li>
                    <li><a href="itsoc_membership.php">ITSOC MEMBERSHIP</a></li>
                    <li><a href="#">RUN FOR A CAUSE</a></li>
                    <li><a href="#">CAS FAMILY DAY</a></li>
                    <li><a href="#">SCHOOL PAPER</a></li>
                    <li><a href="#">FINES UNIGAMES</a></li>
                    <li><a href="#">FINES ORG UNIFORM</a></li>
                </ul>
            </div>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Item Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payments as $payment) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($payment['item_type']); ?></td>
                            <td><?php echo htmlspecialchars($payment['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
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