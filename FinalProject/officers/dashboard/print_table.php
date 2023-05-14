<?php
require_once 'print_page.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>IT Payment Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style_print_table.css">
</head>

<body>
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

</body>

</html>