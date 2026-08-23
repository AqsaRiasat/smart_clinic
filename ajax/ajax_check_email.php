<?php
include '../database/db.php';

header('Content-Type: application/json');

// Email Availability Check Handler
if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
    
    if ($email == "") {
        echo json_encode(["status" => "empty", "message" => ""]);
        exit();
    }

    // Manual string escape loop
    $clean_email = "";
    $em_len = 0;
    while (isset($email[$em_len])) {
        $em_len++;
    }
    for ($i = 0; $i < $em_len; $i++) {
        if ($email[$i] == "'") {
            $clean_email .= "\\'";
        } else {
            $clean_email .= $email[$i];
        }
    }

    $query = mysqli_query($conn, "SELECT id FROM users WHERE email='$clean_email'");
    
    if (mysqli_num_rows($query) > 0) {
        echo json_encode(["status" => "taken", "message" => "This email is already registered!"]);
    } else {
        echo json_encode(["status" => "available", "message" => "Email is available!"]);
    }
    exit();
}

echo json_encode(["status" => "invalid", "message" => "No email provided."]);
exit();
?>
