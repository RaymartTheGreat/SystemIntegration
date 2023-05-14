<!DOCTYPE html>
<html>
<head>
    <title>IT Payment Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h1>IT Payment Dashboard</h1>
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
    </div>
    <div class="footer">
        <p>Copyright &copy; 2023 by Future Tech Solution (FST).
        <br>All rights reserved.</p>
    </div>
</body>
</html>
