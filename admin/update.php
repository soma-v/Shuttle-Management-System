<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Shuttle Location</title>
    <link rel="stylesheet" type="text/css" href="update.css">
</head>
<body>
    <h1>Update Shuttle Location</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="shuttle">Select Shuttle </label>
        <select name="shuttle" id="shuttle" required>
            <option value="">--Select Shuttle--</option>
            <?php
                // Function to open database connection
                function openConnection()
                {
                    $dbhost = "localhost";
                    $dbuser = "root";
                    $dbpass = "";
                    $db = "shuttle_management";
                    $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connection failed: " . $conn->error);
                    return $conn;
                }

                // Function to close database connection
                function closeConnection($conn)
                {
                    $conn->close();
                }

                // Fetch list of shuttles from the database
                $conn = openConnection();
                $sql = "SELECT name FROM shuttle";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                    }
                }
                closeConnection($conn);
            ?>
        </select>
        <br><br>
        <label for="location">Enter the location</label>
        <select name="location" id="location" required>
        <option selected disabled value>--select an option--</option>
        <option value="VIT park">VIT park</option>
        <option value="VIT lawn">VIT lawn</option>
        <option value="VIT main gate">VIT main gate</option>
        </select>
        <br><br>
        <button type="submit" name="submit">Submit</button>
    </form>

    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $shuttle = $_POST['shuttle'];
            $location = $_POST['location'];

            // Retrieve the latitude and longitude for the selected location
            $api_key = 'AIzaSyBWu7soH3vDChnQApj1Kv_rp1tR0qbafx0';
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location).'&key='.$api_key;
            $response = file_get_contents($url);
            $data = json_decode($response);

            // Check if geocoding API returned valid response
            if ($data->status == "OK") {
                $latitude = $data->results[0]->geometry->location->lat;
                $longitude = $data->results[0]->geometry->location->lng;

                // Update the shuttle record in the database
                $conn = openConnection();
                $stmt = $conn->prepare("UPDATE shuttle SET location=?, latitude=?, longitude=? WHERE name=?");
                $stmt->bind_param("sdds", $location, $latitude, $longitude, $shuttle);
                $stmt->execute();
                $stmt->close();
                closeConnection($conn);

                echo "<p>Location updated successfully for shuttle <b>" . $shuttle . "</b>.</p>";
                header("Location: dashboard.php");
            } else {
                echo "<p>Error: Geocoding API returned an error.</p>";
            }
        }
    ?>

</body>
</html>
