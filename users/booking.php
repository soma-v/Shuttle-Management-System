<!DOCTYPE html>
<html>
<head>
    <title>Example Page</title>
    <link rel="stylesheet" type="text/css" href="book.css">
</head>
<body>
<?php
// start the session
session_start();

// check if user is logged in
if (!isset($_SESSION['username'])) {
  // redirect to login page if user is not logged in
  header("Location: login.php");
  exit();
}

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "shuttle_management";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// retrieve the booking data for the active user
$user_id = $_SESSION['username'];
$sql = "SELECT source, destination, amount, timestamp FROM booking WHERE username = '$user_id'";
$result = mysqli_query($conn, $sql);

// display the booking data in a table
if (mysqli_num_rows($result) > 0) {
  echo "<table id='booking-table'>";
  echo "<tr><th>Source</th><th>Destination</th><th>Amount</th><th>Timestamp</th></tr>";
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>".$row["source"]."</td><td>".$row["destination"]."</td><td>".$row["amount"]."</td><td>".$row["timestamp"]."</td></tr>";
  }
  echo "</table>";
} else {
  echo "No bookings found.";
  
}

// close the connection
mysqli_close($conn);
?>

</body>
</html>



