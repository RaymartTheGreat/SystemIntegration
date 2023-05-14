<?php
session_start();
$member_id = $_SESSION['member_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES["image"];
        $imageData = addslashes(file_get_contents($image["tmp_name"]));
        
        // Upload the image data to the itsoc_membership_payment table
        $conn = mysqli_connect("localhost", "root", "", "finalproject");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the account_id from the member_account table
        $sql = "SELECT id FROM member_account WHERE member_id = '$member_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $account_id = $row['id'];

        // Check if the account_id exists in the itsoc_membership_payment table
        $sql = "SELECT * FROM itsoc_membership_payment WHERE account_id = '$account_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Update the existing record
            $sql = "UPDATE itsoc_membership_payment SET payment_receipt = '$imageData' WHERE account_id = '$account_id'";
        } else {
            // Insert a new record
            $sql = "INSERT INTO itsoc_membership_payment (account_id, status, payment_receipt) VALUES ('$account_id', 'Not yet paid', '$imageData')";
        }

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Image uploaded successfully.');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    } else {
        echo "<script>alert('No image was uploaded.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Member | Portal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AQuMV7wAmo59K7mHBHicsS8f-_W_qo64_kQiTCb24-beuHSPsPdTv20ZWRoSIm-MHe_riYThOyULSObr&currency=USD"></script>
</head>
<body>
    <div class="header">
        <h1>ITSOC MEMBERSHIP</h1>
        <form class="logout-form" action="../login/logout.php" method="POST">
            <button type="submit">Logout</button>
        </form>
    </div>
    <div class="container">
        <h2>Pay for ITSOC MEMBERSHIP</h2>
        <div class="paypal-container">
            <div id="paypal-button-container-college"></div>
        </div>
        <form method="POST" enctype="multipart/form-data">
            <label for="image">Choose an image:</label>
            <input type="file" id="image" name="image" accept="image/*"> <br>
            <button type="submit">Upload Image</button>
        </form>
        <button class="back-button" onclick="window.location.href='main_dashboard.php'">Back</button>
    </div>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [
                        {
                            amount: {
                                value: "5.00",
                            },
                            member_id: "<?php echo $member_id; ?>",
                        },
                    ],
                });
            },
                onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    alert('Transaction complete by ' + details.payer.name.given_name + '. Status will be updated shortly.');
                });
            }
        }).render('#paypal-button-container-college');
    </script>
    <div class="footer">
        <p>Copyright &copy; 2023 by Future Tech Solution (FST).
        <br>All rights reserved.</p>
    </div>
</body>
</html>