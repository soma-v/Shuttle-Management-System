<!DOCTYPE html>
<html>
<head>
    <title>Example Page</title>
    <link rel="stylesheet" type="text/css" href="wallet.css">
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shuttle_management";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

session_start();
$username = $_SESSION['username'];

// Fetch wallet balance from the users table
$query = "SELECT wallet_balance FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$wallet_balance = $row['wallet_balance'];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve top-up amount from the form
  $topup_amount = $_POST['amount'];
  
  // Update the wallet balance in the users table
  $updated_wallet_balance = $wallet_balance + $topup_amount;
  $query = "UPDATE users SET wallet_balance='$updated_wallet_balance' WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  
  if ($result) {
    // Display success message
    echo "Wallet updated successfully!";
    
    // Update the wallet balance variable
    $wallet_balance = $updated_wallet_balance;
  } else {
    // Display error message
    echo "Error occurred while updating wallet.";
  }
}

// Display wallet balance and top-up form
echo "Wallet Amount: " . $wallet_balance . "<br>";
echo "<form method='post' action='wallet.php'>";
echo "<label for='amount'>Top up amount:</label>";
echo "<input type='number' id='amount' name='amount' step='0.01' required>";
echo "<input type='submit' name='topup' value='Top up'>";
echo "</form>";

mysqli_close($conn);
?>


</body>
</html>

