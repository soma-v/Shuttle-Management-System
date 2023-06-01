<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="shuttle.css">
</head>
<body>
  <div class="container">
    <h1>Shuttle</h1>
    <form method="post" action="shuttle.php">
      <label for="Source">Source:</label>
      <select name="Source" id="Source">
        <option></option>
        <option>SMV</option>
        <option>TT</option>
        <option>SJT</option>
        <option>PRP</option>
      </select>

      <label for="Destination">Destination:</label>
      <select name="Destination" id="Destination">
        <option></option>
        <option>SMV</option>
        <option>TT</option>
        <option>SJT</option>
        <option>PRP</option>
      </select>

      <label for="Amount">Amount:</label>
      <input type="text" id="Amount" name="Amount" placeholder="Enter Amount">

      <button type="submit" name="book_shuttle">Shuttle Booked</button>
    </form>
  </div>
  <?php
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
  
  $username = $_SESSION['username'];
  $source = $_POST['Source'];
  $destination = $_POST['Destination'];
  $amount = $_POST['Amount'];
  //echo $username;
  // Check if the amount is less or equal to the wallet balance
  $conn = mysqli_connect("localhost", "root", "", "shuttle_management");
  $query = "SELECT wallet_balance FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $wallet_balance = $row['wallet_balance'];

  if ($amount > $wallet_balance && $amount == 20) {
    echo "Top up your wallet to book the shuttle.";
  } else {
    // Deduct the amount from the wallet balance
    $updated_wallet_balance = $wallet_balance - $amount;
  
    // Update the wallet balance in the database
    $query = "UPDATE users SET wallet_balance='$updated_wallet_balance' WHERE username='$username'";
    $result = mysqli_query($conn, $query);
  
    if ($result) {
      // Insert the booking into the database
      $timestamp = date("Y-m-d H:i:s");
      $query = "INSERT INTO booking (username, source, destination, amount, timestamp) VALUES ('$username', '$source', '$destination', '$amount', '$timestamp')";
      $result = mysqli_query($conn, $query);
  
      if ($result) {
        echo "Shuttle booked successfully!";
        header("Location: dashboard.php");
      } else {
        echo "Error occurred while booking the shuttle.";
      }
    } else {
      echo "Error occurred while updating wallet balance.";
    }
  }
  

  mysqli_close($conn);
}
?>

</body>
</html>