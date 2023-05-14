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