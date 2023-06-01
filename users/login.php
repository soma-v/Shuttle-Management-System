<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="new.css">
</head>
<body class="background">
    <h1>Login</h1>
    <div class="login">
    <form action="login.php" method="post">
        <label for="username">Enter your username</label>
        <br>
        <input type="text" required id="username" name="username">
        <br><br>
        <label for="password">Enter your password</label>
        <br>
        <input type="password" required id="password" name="password">
        <br>
        <a href="#" style="color:red;">Forgot Password</a>
        <button type="login" name ="login" id="login">Login</button>
        <br>
        <a href="signup.php" style="color:red;">Don't have an account</a>
    </form>
   </div>
   <?php
   session_start();
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
       $uname=$_POST['username'];
       $pass=$_POST['password'];
       function openconnection(){
           $dbhost="localhost";
           $dbuser="root";
           $dbpass=""; // replace with your database password
           $db="shuttle_management";
           $conn=new mysqli($dbhost,$dbuser,$dbpass,$db) or die("connection failed ".$conn->error);
           return $conn;
       }
       function closeconnection($conn){
           $conn->close();
       }
       $conn=openconnection();
       $sql="SELECT * FROM users WHERE username='$uname'";
       $result=$conn->query($sql);
       if($result->num_rows==1){
           $row=$result->fetch_assoc();
           $hashed_password=$row['password'];
           if(password_verify($pass,$hashed_password)){
               // login successful
               $_SESSION['username'] = $uname; // set session variable
               header("Location: dashboard.php");
           }
           else{
               // login failed
               echo "Invalid username or password";
           }
       }
       else{
           // login failed
           echo "Invalid username or password";
       }
       closeconnection($conn);
   }   
?>
  </body>
</html>
