<?php

// Database Connection Configuration
$servername = "sql212.infinityfree.com";
$username   = "if0_42734982";
$password   = "RUccYGVpUZ";
$dbname     = "if0_42734982_smart_clinic_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>


