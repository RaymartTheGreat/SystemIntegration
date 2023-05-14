<?php
require_once 'db_config.php';

session_start();

$filter = [
    'year_level' => isset($_GET['year_level']) ? $_GET['year_level'] : '',
    'section' => isset($_GET['section']) ? $_GET['section'] : '',
    'status' => isset($_GET['status']) ? $_GET['status'] : '',
    'search' => isset($_GET['search']) ? trim($_GET['search']) : '',
];
$filter['item_type'] = isset($_GET['item_type']) ? $_GET['item_type'] : 'all';

// Prepare the SQL query
$stmt = $conn->prepare("
    SELECT member_account.member_id, member_account.first_name, member_account.last_name,
           college_shirt_payment.status AS college_shirt_status,
           unigames_fee_payment.status AS unigames_fee_status,
           lanyard_payment.status AS lanyard_status,
           itsoc_membership_payment.status AS itsoc_membership_status
    FROM member_account
    LEFT JOIN college_shirt_payment ON member_account.id = college_shirt_payment.account_id
    LEFT JOIN unigames_fee_payment ON member_account.id = unigames_fee_payment.account_id
    LEFT JOIN lanyard_payment ON member_account.id = lanyard_payment.account_id
    LEFT JOIN itsoc_membership_payment ON member_account.id = itsoc_membership_payment.account_id
    WHERE (:search = '' OR member_account.member_id LIKE :search) AND
          (:year_level = '' OR member_account.year_level = :year_level) AND
          (:section = '' OR member_account.section = :section) AND
          (:status = '' OR (
            (:item_type = 'all' AND (college_shirt_payment.status = :status OR unigames_fee_payment.status = :status OR lanyard_payment.status = :status OR itsoc_membership_payment.status = :status)) OR
            (:item_type = 'college_shirt' AND college_shirt_payment.status = :status) OR
            (:item_type = 'unigames_fee' AND unigames_fee_payment.status = :status) OR
            (:item_type = 'lanyard' AND lanyard_payment.status = :status) OR
            (:item_type = 'itsoc_membership' AND itsoc_membership_payment.status = :status)
          ))
");

// Bind the values to the named placeholders
$stmt->bindValue(':search', '%' . $filter['search'] . '%', PDO::PARAM_STR);
$stmt->bindValue(':year_level', $filter['year_level'], PDO::PARAM_STR);
$stmt->bindValue(':section', $filter['section'], PDO::PARAM_STR);
$stmt->bindValue(':status', $filter['status'], PDO::PARAM_STR);
$stmt->bindValue(':item_type', $filter['item_type'], PDO::PARAM_STR);

// Execute the prepared statement
$stmt->execute();

// Fetch member account and payment statuses
$member_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>IT Payment Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div class="header">
        <h1>IT Payment Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['officer_name']); ?></p>
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

        <div class="table-section">
            <div class="filter-form-container">
                <form class="filter-form" action="" method="GET">
                    <label for="year_level">Year Level:</label>
                    <select name="year_level">
                        <option value="">All</option>
                        <option value="1" <?php if (isset($_GET['year_level']) && $_GET['year_level'] == '1') echo 'selected'; ?>>1</option>
                        <option value="2" <?php if (isset($_GET['year_level']) && $_GET['year_level'] == '2') echo 'selected'; ?>>2</option>
                        <option value="3" <?php if (isset($_GET['year_level']) && $_GET['year_level'] == '3') echo 'selected'; ?>>3</option>
                        <option value="4" <?php if (isset($_GET['year_level']) && $_GET['year_level'] == '4') echo 'selected'; ?>>4</option>
                    </select>
                    <label for="section">Section:</label>
                    <select name="section">
                        <option value="">All</option>
                        <option value="A" <?php if (isset($_GET['section']) && $_GET['section'] == 'A') echo 'selected'; ?>>A</option>
                        <option value="B" <?php if (isset($_GET['section']) && $_GET['section'] == 'B') echo 'selected'; ?>>B</option>
                    </select>
                    <label for="status">Status:</label>
                    <select name="status">
                        <option value="">All</option>
                        <option value="Payment Successful" <?php echo $filter['status'] == 'Payment Successful' ? 'selected' : ''; ?>>Paid</option>
                        <option value="Not yet paid" <?php echo $filter['status'] == 'Not yet paid' ? 'selected' : ''; ?>>Unpaid</option>
                    </select>

                    <label for="item_type">Item Type:</label>
                    <select name="item_type">
                        <option value="all" <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'all') echo 'selected'; ?>>All</option>
                        <option value="college_shirt" <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'college_shirt') echo 'selected'; ?>>College Shirt</option>
                        <option value="unigames_fee" <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'unigames_fee') echo 'selected'; ?>>Unigames Fee</option>
                        <option value="lanyard" <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'lanyard') echo 'selected'; ?>>Lanyard</option>
                        <option value="itsoc_membership" <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'itsoc_membership') echo 'selected'; ?>>ITSOC Membership</option>
                    </select>
                    <button type="submit" name="apply_filter">Apply Filter</button>
                </form>
            </div>

            <div class="status-table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Member ID</th>
                            <th>Name</th>
                            <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'college_shirt') : ?>
                                <th>College Shirt</th>
                            <?php endif; ?>
                            <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'unigames_fee') : ?>
                                <th>Unigames Fee</th>
                            <?php endif; ?>
                            <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'lanyard') : ?>
                                <th>Lanyard</th>
                            <?php endif; ?>
                            <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'itsoc_membership') : ?>
                                <th>ITSOC Membership</th>
                            <?php endif; ?>
                        </tr>

                    </thead>
                    <tbody>
                        <?php foreach ($member_data as $member) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['member_id']); ?></td>
                                <td><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></td>
                                <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'college_shirt') : ?>
                                    <td><?php echo htmlspecialchars($member['college_shirt_status']); ?></td>
                                <?php endif; ?>
                                <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'unigames_fee') : ?>
                                    <td><?php echo htmlspecialchars($member['unigames_fee_status']); ?></td>
                                <?php endif; ?>
                                <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'lanyard') : ?>
                                    <td><?php echo htmlspecialchars($member['lanyard_status']); ?></td>
                                <?php endif; ?>
                                <?php if ($filter['item_type'] == 'all' || $filter['item_type'] == 'itsoc_membership') : ?>
                                    <td><?php echo htmlspecialchars($member['itsoc_membership_status']); ?></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($member_data)) : ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No data found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="footer">
        <p>Copyright &copy; 2023 by Future Tech Solution (FST).
            <br>All rights reserved.
        </p>
    </div>
</body>

</html>