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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST['id'];

    // Fetch the receipt image from the lanyard_payment table using account_id
    $sql = "SELECT payment_receipt FROM lanyard_payment WHERE account_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $stmt->bind_result($payment_receipt);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if ($payment_receipt) {
        // Set the content type and output the image
        header("Content-type: image/jpeg");
        echo $payment_receipt;
    } else {
        // Display an alert and close the tab if no image is uploaded
        echo "<!DOCTYPE html>
        <html>
        <head>
            <script>
                window.onload = function() {
                    alert('No image was uploaded.');
                    window.close();
                }
            </script>
        </head>
        <body>
        </body>
        </html>";
    }
}
?>
