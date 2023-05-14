<?php
session_start();
require_once "db_conn.php";

if (isset($_POST['member_id']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $member_id = validate($_POST['member_id']);
    $password = validate($_POST['password']);

    if (empty($member_id)) {
        header("Location: index.php?error=Member ID is required");
        exit();
    } else if (empty($password)) {
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM member_account WHERE member_id='$member_id' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($row['member_id'] === $member_id && $row['password'] === $password) {
                $_SESSION['member_id'] = $row['member_id'];
                $_SESSION['name'] = $row['first_name'] . ' ' . $row['last_name'];
                header("Location: ../dashboard/main_dashboard.php");
                exit();
            } else {
                header("Location: index.php?error=Incorrect Member ID or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect Member ID or password");
            exit();
        }
    }
    
} else {
    header("Location: index.php");
    exit();
}
