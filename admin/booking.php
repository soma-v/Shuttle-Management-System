<!DOCTYPE html>
<html>
<head>
    <title>Booking Page</title>
    <!-- <link rel="stylesheet" type="text/css" href="book.css"> -->
</head>
<body>
<?php
// Establish database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'shuttle_management';

$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select all rows from the "booking" table
$sql = "SELECT * FROM booking";
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: " . $row["id"] . " - Username: " . $row["username"] ." - source: " . $row["source"] . " - destination: " . $row["destination"] . " - amount: " . $row["amount"] . " - timestamp: " . $row["timestamp"] . "<br>";
    }
} else {
    echo "0 results";
}

// Close database connection
mysqli_close($conn);
?>

</body>
</html>


