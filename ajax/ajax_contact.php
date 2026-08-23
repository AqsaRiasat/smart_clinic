<?php
include '../database/db.php';

header('Content-Type: application/json');

// AJAX Contact Message Handler
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    $errors = [];

    // Validations
    if ($name == "") {
        $errors[] = "Name is required!";
    }

    if ($email == "") {
        $errors[] = "Email is required!";
    } else {
        $has_at = false;
        $has_dot = false;
        $email_length = 0;
        while (isset($email[$email_length])) {
            if ($email[$email_length] == "@") { $has_at = true; }
            if ($email[$email_length] == ".") { $has_dot = true; }
            $email_length++;
        }
        if ($has_at == false || $has_dot == false) {
            $errors[] = "Please enter a valid email address!";
        }
    }

    if ($subject == "") {
        $errors[] = "Subject is required!";
    }

    if ($message == "") {
        $errors[] = "Message is required!";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "errors" => $errors]);
        exit();
    }

    // Manual string escaping
    $fields = ['name', 'email', 'subject', 'message'];
    $clean = [];
    foreach ($fields as $field) {
        $val = $$field;
        $clean_val = "";
        $val_len = 0;
        while (isset($val[$val_len])) {
            $val_len++;
        }
        for ($i = 0; $i < $val_len; $i++) {
            if ($val[$i] == "'") {
                $clean_val .= "\\'";
            } else {
                $clean_val .= $val[$i];
            }
        }
        $clean[$field] = $clean_val;
    }

    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('{$clean['name']}', '{$clean['email']}', '{$clean['subject']}', '{$clean['message']}')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode([
            "status" => "success",
            "message" => "Thank you! Your message has been sent successfully. We will get back to you soon."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "errors" => ["Database error: " . mysqli_error($conn)]
        ]);
    }
    exit();
}

echo json_encode(["status" => "error", "errors" => ["Invalid request method."]]);
exit();
?>
