<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <script src="signup.js"></script>
</head>
<body class="background">
    <h1>Sign up</h1>
    <div class="login">
    <form action="signup.php" method="post" onsubmit="return validate()">
        <label for="username">Enter your username</label>
        <br>
        <input type="text" required id="username" name="username" required>
        <br><br>
        <label for="email">Enter your email address</label>
        <br>
        <input type="text" required id="email" name="email" required>
        <br><br>
        <label for="phone">Enter your mobile number</label>
        <br>
        <input type="text" required id="phone" name="phone" required>
        <br><br>
        <label for="password">Enter your password</label>
        <br>
        <input type="password" required id="password" name="password" required>
        <br><br>
        <label for="password">confirm your password</label>
        <br>
        <input type="password" required id="cpassword" name="cpassword" required>
        <br><br><br>
        <button type="submit" name ="submit" id="signup">Submit</button>
    </form>
    <p id="message"></p>
   </div>
   <script>
        function validate(){
            var uname=document.getElementById("username").value
            var email=document.getElementById("email").value
            var number=document.getElementById("phone").value   
            var passwordInput = document.getElementById("password")
            var confirmPasswordInput = document.getElementById("cpassword")
            
            var password = passwordInput.value
            var confirmPassword = confirmPasswordInput.value
            
            //username pattern : should start with alphabhet and should be of length > 8
            var pattern1=/^[a-zA-Z][a-zA-Z0-9]{7,}$/         
            
            // password pattern
            var pattern2=/(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\w).{8,16}/

            //email validation
            var pattern3=/^[^\s@]+@gmail\.com$/

            var pattern4=/^[789]\d{9}$/

            //if the username does not match the pattern
            if(!pattern1.test(uname)){
                if(uname.length<8)
                document.getElementById("message").innerHTML ="Username should be of length at least 8 "
                else
                document.getElementById("message").innerHTML="Username should not start with digit"
                return false
            }

            //if the username is correct check for email
            else if(!pattern3.test(email)){
                document.getElementById("message").innerHTML ="The email is does not match the standard gmail format"
                return false
            }

            else if(!pattern4.test(number)){
                document.getElementById("message").innerHTML="The phone number is not a valid one"
                return false
            }

            //if username and email is correct check for the password
            else if(!pattern2.test(password))
            {
                document.getElementById("message").innerHTML ="Password should contain digits,alphabhets, special character and should be of length 8 to 16"
                return false
            }
            else if(password !== confirmPassword)
            {
                document.getElementById("message").innerHTML ="Confirm password does not match the entered password"
                return false
            }
            else{
                document.getElementById("message").innerHTML = "thank you!" 
                return true
            }
        }
   </script>
    <?php
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $uname = $_POST['username'];
                    $email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $pass = $_POST['password'];
            
                    // Hash the password
                    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            
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
            
                    // Prepare the SQL statement
                    $sql = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
            
                    // Prepare the statement
                    $stmt = $conn->prepare($sql);
            
                    // Bind the parameters to the statement
                    $stmt->bind_param("ssss", $uname, $email, $phone, $hashed_pass);
            
                    // Execute the statement
                    if ($stmt->execute()) {
                        echo "New record created successfully";
                        header("Location: login.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
            
                    // Close the statement and the connection
                    $stmt->close();
                    closeconnection($conn);
                
        }            
    ?>
</body>
</html>