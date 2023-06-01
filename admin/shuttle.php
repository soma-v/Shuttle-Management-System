<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="update.css">

</head>
<body>
    <form action="shuttle.php" method="post">
        <label for="shuttle">Enter the shuttle name</label>
        <input type="text" name="shuttle" id="shuttle" required>
        <label for="location">Enter the location</label>
        <select name="location" id="location" required>
        <option selected disabled value>--select an option--</option>
        <option value="VIT park">VIT park</option>
        <option value="VIT lawn">VIT lawn</option>
        <option value="VIT main gate">VIT main gate</option>
        </select>
        <button type="submit" name ="submit" id="signup">Submit</button>
    </form>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $location = $_POST['location'];
            $name=$_POST['shuttle'];
            echo $location;
            // Retrieve the latitude and longitude for the selected location
            $api_key = 'AIzaSyBWu7soH3vDChnQApj1Kv_rp1tR0qbafx0';
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location).'&key='.$api_key;
            $response = file_get_contents($url);
            $data = json_decode($response);
            

            function openconnection()
            {
                $dbhost = "localhost";
                $dbuser = "root";
                $dbpass = "";
                $db = "shuttle_management";
                $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("connection failed " . $conn->error);
                return $conn;
            }

            function closeconnection($conn)
            {
                $conn->close();
            }

            if ($data->status == "OK") {
                $latitude = $data->results[0]->geometry->location->lat;
                $longitude = $data->results[0]->geometry->location->lng;

                echo $latitude.'<br>'.$longitude;
                
                // Generate a unique shuttle ID
                $shuttle_id = uniqid();
                
                // Insert the new shuttle record into the shuttle table
                $conn = openconnection();
                $stmt = $conn->prepare("INSERT INTO shuttle ( name,location, latitude, longitude) VALUES ( ?,?, ?, ?)");
                $stmt->bind_param("ssdd",  $name,$location, $latitude, $longitude);
                $stmt->execute();
                $stmt->close();
                closeconnection($conn);
                header("Location: dashboard.php");
            } else {
                echo "Geocoding API returned an error: ".$data->status;
            }


        }
    ?>

</body>
</html>