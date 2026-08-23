<?php
session_start();

// Access Control Check
if (!isset($_SESSION['patient_id'])) {
    header("Location: user_login.php");
    exit();
}
$user_id = $_SESSION['patient_id'];

include 'database/db.php'; 

$errors = [];

// Appointment Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_appointment'])) {
    $name     = $_POST['u_name'];
    $email    = $_POST['u_email'];
    $phone    = $_POST['u_phone'];
    $dept     = $_POST['u_dept'];  
    $app_date = $_POST['u_date'];  
    $app_time = $_POST['u_time'];  
    $message  = $_POST['u_message'];

    // Form Validations
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
    
    if ($phone == "") {
        $errors[] = "Phone number is required!";
    } else {
        $phone_len = 0;
        $valid_phone = true;
        while (isset($phone[$phone_len])) {
            $ch = $phone[$phone_len];
            if ($ch >= '0' && $ch <= '9') {
                // valid digit
            } else {
                $valid_phone = false;
            }
            $phone_len++;
        }
        if ($phone_len != 11 || $valid_phone == false) {
            $errors[] = "Phone number must be 11 digits (e.g., 03001234567)!";
        }
    }
    
    if ($dept == "" || $dept == "Select Department") {
        $errors[] = "Please select a department!";
    }
    
    if ($app_date == "") {
        $errors[] = "Please select appointment date!";
    }
    
    if ($app_time == "" || $app_time == "Select Time") {
        $errors[] = "Please select appointment time!";
    }

    // Save Appointment to Database
    if (empty($errors)) {
        $fields = ['name', 'email', 'phone', 'dept', 'app_date', 'app_time', 'message'];
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

        $sql = "INSERT INTO appointments (user_id, name, email, phone, department, appointment_date, appointment_time, message) 
            VALUES ('$user_id', '{$clean['name']}', '{$clean['email']}', '{$clean['phone']}', '{$clean['dept']}', '{$clean['app_date']}', '{$clean['app_time']}', '{$clean['message']}')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: appointment.php?success=1");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($conn);
        }
    }
}

$page_title = "Appointment - Smart Clinic";
$active_page = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>
    
    <!-- Page Header Section -->
    <section class="page-header py-5">
        <div class="container text-center text-white">
            <h1 class="display-4 fw-bold" data-aos="fade-up">Book Appointment</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Appointment</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Success Popup Notification -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="success-popup">
        <i class="fas fa-check-circle"></i>
        <h4>Success!</h4>
        <p>Appointment Booked Successfully!</p>
        <button onclick="window.location.href='dashboard.php'">OK</button>
    </div>
    <div class="popup-overlay" onclick="window.location.href='dashboard.php'"></div>
    <?php endif; ?>

    <!-- Booking Form Section -->
    <section class="appointment py-5" id="appointment">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="appointment-form p-4 p-lg-5">
                        <h3 class="mb-4 text-center">Book Your Appointment</h3>

                        <?php if (!empty($errors)): ?>
                        <div class="error-box">
                            <strong>Please fix these errors:</strong>
                            <ul>
                                <?php foreach($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <form action="appointment.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Full Name" name="u_name"
                                        value="<?php echo isset($_POST['u_name']) ? $_POST['u_name'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" placeholder="Email Address" name="u_email"
                                        value="<?php echo isset($_POST['u_email']) ? $_POST['u_email'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control" placeholder="Phone Number (11 digits)" name="u_phone"
                                        value="<?php echo isset($_POST['u_phone']) ? $_POST['u_phone'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="u_dept" required>
                                        <option value="Select Department" <?php echo (!isset($_POST['u_dept']) || $_POST['u_dept']=='Select Department') ? 'selected' : ''; ?>>Select Department</option>
                                        <option value="Cardiology" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='Cardiology') ? 'selected' : ''; ?>>Cardiology</option>
                                        <option value="General Medicine" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='General Medicine') ? 'selected' : ''; ?>>General Medicine</option>
                                        <option value="Pediatrics" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='Pediatrics') ? 'selected' : ''; ?>>Pediatrics</option>
                                        <option value="Orthopedics" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='Orthopedics') ? 'selected' : ''; ?>>Orthopedics</option>
                                        <option value="Dermatology" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='Dermatology') ? 'selected' : ''; ?>>Dermatology</option>
                                        <option value="Neurology" <?php echo (isset($_POST['u_dept']) && $_POST['u_dept']=='Neurology') ? 'selected' : ''; ?>>Neurology</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="date" name="u_date" class="form-control"
                                        value="<?php echo isset($_POST['u_date']) ? $_POST['u_date'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-select" name="u_time" required>
                                        <option value="Select Time" <?php echo (!isset($_POST['u_time']) || $_POST['u_time']=='Select Time') ? 'selected' : ''; ?>>Select Time</option>
                                        <option value="9:00 AM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='9:00 AM') ? 'selected' : ''; ?>>9:00 AM</option>
                                        <option value="10:00 AM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='10:00 AM') ? 'selected' : ''; ?>>10:00 AM</option>
                                        <option value="11:00 AM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='11:00 AM') ? 'selected' : ''; ?>>11:00 AM</option>
                                        <option value="2:00 PM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='2:00 PM') ? 'selected' : ''; ?>>2:00 PM</option>
                                        <option value="3:00 PM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='3:00 PM') ? 'selected' : ''; ?>>3:00 PM</option>
                                        <option value="4:00 PM" <?php echo (isset($_POST['u_time']) && $_POST['u_time']=='4:00 PM') ? 'selected' : ''; ?>>4:00 PM</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="4" placeholder="Message (Optional)" name="u_message"><?php echo isset($_POST['u_message']) ? $_POST['u_message'] : ''; ?></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100 py-3" name="submit_appointment">Book Appointment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
</body>
</html>