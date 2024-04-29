
<?php
$serverName = "127.0.0.1";
$username = "root";
$password = "";
$dbName = "dbbolantef1";


$conn = new mysqli($serverName, $username, $password, $dbName);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
