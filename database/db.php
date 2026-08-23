<?php
// Database Connection Configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_clinic_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
