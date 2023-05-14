<?php
session_start();

// Check if officer is logged in
if (isset($_SESSION['id'])) {
    // Get officer's id
    $officer_id = $_SESSION['id'];

    // Unset all session variables
    $_SESSION = array();

    // Set the officer's active status to 0 (false)
    require_once "db_conn.php";
    $stmt = $conn->prepare("UPDATE createuser SET active = 0 WHERE id = ?");
    $stmt->bind_param("i", $officer_id);
    $stmt->execute();

    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session
    session_destroy();
} else {
    // Officer is not logged in, redirect to login page or display an error message
    header("Location: login.php");
    exit;
}

// Redirect to the login page
header("Location: login.php");
exit;
?>
