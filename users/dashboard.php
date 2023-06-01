<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <img src="shuttle.jpeg" class="background-img">

    <?php
        // Start session
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION['username'])) {
            // Redirect to login page if not logged in
            header('Location: login.php');
            exit();
        }

        // Get username from session
        $username = $_SESSION['username'];
    ?>

    <div class="wrapper">
        <!--Top menu -->
        <div class="sidebar">
           <!--profile image & text-->
            <!--menu item-->
            <div class="profile">
                <h3><?php echo $username; ?></h3>
            </div>
            <ul>
                <li>
                    <a href="Profile.php" class="active">
                        <span class="icon"><i class="profile"></i></span>
                        <span class="item">Update Profile</span>
                    </a>
                </li>
                <li>
                    <a href="booking.php">
                        <span class="icon"><i class="booking"></i></span>
                        <span class="item">Booking Details</span>
                    </a>
                </li>
                <li>
                    <a href="api.php">
                        <span class="icon"><i class="shuttle"></i></span>
                        <span class="item">Shuttle Availability</span>
                    </a>
                </li>
                <li>
                    <a href="wallet.php">
                        <span class="icon"><i class="Wallet Top-Up"></i></span>
                        <span class="item">Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="../Home.html">
                        <span class="icon"><i class="Logout"></i></span>
                        <span class="item">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
        
</body>
</html>
