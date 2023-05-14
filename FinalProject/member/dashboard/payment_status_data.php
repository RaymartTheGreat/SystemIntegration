<?php
session_start();
require_once 'config/db.php';

$userId = $_SESSION['user_id'];

$query = "SELECT
  (SELECT status FROM college_shirt_payment WHERE account_id = ?) as college_shirt_status,
  (SELECT status FROM unigames_fee_payment WHERE account_id = ?) as unigames_fee_status,
  (SELECT status FROM lanyard_payment WHERE account_id = ?) as lanyard_status,
  (SELECT status FROM itsoc_membership_payment WHERE account_id = ?) as itsoc_membership_status
FROM member_account
WHERE id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param('iiiii', $userId, $userId, $userId, $userId, $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$paymentStatus = [
    'college_shirt' => $row['college_shirt_status'] === 'Payment Successful' ? 1 : 0,
    'unigames_fee' => $row['unigames_fee_status'] === 'Payment Successful' ? 1 : 0,
    'lanyard' => $row['lanyard_status'] === 'Payment Successful' ? 1 : 0,
    'itsoc_membership' => $row['itsoc_membership_status'] === 'Payment Successful' ? 1 : 0,
];

header('Content-Type: application/json');
echo json_encode(array_values($paymentStatus));
