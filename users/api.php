<!DOCTYPE html>
<html>
<head>
  <title>Map Demo</title>
  <style>
    #map {
      height: 700px;
      width: 100%;
    }
    button {
    background-color: rgb(5, 68, 104); 
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 10px;
  }
  </style>
</head>
<body>
<?php
// Connect to the database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'shuttle_management';
$conn = mysqli_connect($host, $user, $password, $dbname);
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Fetch shuttle information from the database
$sql = "SELECT name, latitude, longitude, location FROM shuttle";
$result = mysqli_query($conn, $sql);

// Create shuttle buttons
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    echo '<button onclick="window.location.href =\'shuttle.php?name=' . $name . '\'">' . $name . '</button>';
}

// Create map with shuttle markers
echo '<div id="map"></div>';
echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWu7soH3vDChnQApj1Kv_rp1tR0qbafx0"></script>';
echo '<script>';
echo 'function initMap() {';
echo '  var center = { lat: 12.9716, lng: 79.1590 };';
echo '  var map = new google.maps.Map(document.getElementById(\'map\'), {';
echo '    zoom: 15,';
echo '    center: center';
echo '  });';

// Add shuttle markers to the map
mysqli_data_seek($result, 0);
while ($row = mysqli_fetch_assoc($result)) {
    $name = $row['name'];
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    $location = $row['location'];
    echo '  var marker = new google.maps.Marker({';
    echo '    position: {lat: ' . $latitude . ', lng: ' . $longitude . '},';
    echo '    map: map,';
    echo '    title: \'' . $name . '\',';
    echo '    label: \'' . $location . '\''; // Set the location name as label for the marker
    echo '  });';
}

echo '}';
echo '</script>';
echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWu7soH3vDChnQApj1Kv_rp1tR0qbafx0&callback=initMap"></script>';

mysqli_close($conn);
?>
</body>
</html>
