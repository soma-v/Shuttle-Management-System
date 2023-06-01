<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
    <h1>User Profile</h1>
    <form method="post" action="profile.php">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" placeholder="Enter your username">

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email address">

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" placeholder="Enter your password">

      <input type="submit" value="Profile Updated">
    </form>
  <?php
  // Get the form data
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $username = $_POST['username'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
      // Connect to the database
      function openconnection() {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "";
        $db = "shuttle_management";
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("connection failed " . $conn->error);
        return $conn;
      }

      function closeconnection($conn) {
        $conn->close();
      }

      $conn = openconnection();

      // Update the user's information
      $query = "UPDATE users SET phone='$phone', email='$email', password='$hashed_pass' WHERE username='$username'";
      $result = mysqli_query($conn, $query);

      if ($result) {
        echo "User information updated successfully";
      } 
      else {
        echo "Error updating user information: " . mysqli_error($conn);
      }

      // Close the database connection
      closeconnection($conn);
    }
  ?>

</body>
</html>
