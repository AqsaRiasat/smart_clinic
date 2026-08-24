<?php
session_start();

// Admin Access Control Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: user_login.php");
    exit();
}
include 'database/db.php'; 

$errors = [];

// Delete Appointment Handler
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $clean_delete_id = "";
    $val_len = 0;
    while (isset($delete_id[$val_len])) {
        $val_len++;
    }
    for ($i = 0; $i < $val_len; $i++) {
        if ($delete_id[$i] == "'") {
            $clean_delete_id .= "\\'";
        } else {
            $clean_delete_id .= $delete_id[$i];
        }
    }
    
    mysqli_query($conn, "DELETE FROM appointments WHERE id='$clean_delete_id'");
    header("Location: admin.php?success=deleted");
    exit();
}

// Delete Contact Message Handler
if (isset($_GET['delete_msg_id'])) {
    $delete_msg_id = $_GET['delete_msg_id'];
    
    $clean_delete_msg_id = "";
    $val_len = 0;
    while (isset($delete_msg_id[$val_len])) {
        $val_len++;
    }
    for ($i = 0; $i < $val_len; $i++) {
        if ($delete_msg_id[$i] == "'") {
            $clean_delete_msg_id .= "\\'";
        } else {
            $clean_delete_msg_id .= $delete_msg_id[$i];
        }
    }
    
    mysqli_query($conn, "DELETE FROM contact_messages WHERE id='$clean_delete_msg_id'");
    header("Location: admin.php?success=msg_deleted");
    exit();
}

// Appointment Add / Edit Form Handler
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_appointment'])) {
    $action   = $_POST['action'];
    $name     = $_POST['u_name'];
    $email    = $_POST['u_email'];
    $phone    = $_POST['u_phone'];
    $dept     = $_POST['u_dept'];  
    $app_date = $_POST['u_date'];  
    $app_time = $_POST['u_time'];  
    $message  = $_POST['u_message'];

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
    
    if ($phone == "") {
        $errors[] = "Phone number is required!";
    } else {
        $phone_len = 0;
        $valid_phone = true;
        while (isset($phone[$phone_len])) {
            $ch = $phone[$phone_len];
            if ($ch >= '0' && $ch <= '9') {
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

        if ($action == "add") {
            $sql = "INSERT INTO appointments (user_id, name, email, phone, department, appointment_date, appointment_time, message) 
                VALUES ('5', '{$clean['name']}', '{$clean['email']}', '{$clean['phone']}', '{$clean['dept']}', '{$clean['app_date']}', '{$clean['app_time']}', '{$clean['message']}')";
            if (mysqli_query($conn, $sql)) {
                header("Location: admin.php?success=added");
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($conn);
            }
        } elseif ($action == "edit") {
            $appt_id = $_POST['appointment_id'];
            
            $clean_appt_id = "";
            $val_len = 0;
            while (isset($appt_id[$val_len])) {
                $val_len++;
            }
            for ($i = 0; $i < $val_len; $i++) {
                if ($appt_id[$i] == "'") {
                    $clean_appt_id .= "\\'";
                } else {
                    $clean_appt_id .= $appt_id[$i];
                }
            }

            $sql = "UPDATE appointments SET 
                name = '{$clean['name']}',
                email = '{$clean['email']}',
                phone = '{$clean['phone']}',
                department = '{$clean['dept']}',
                appointment_date = '{$clean['app_date']}',
                appointment_time = '{$clean['app_time']}',
                message = '{$clean['message']}'
                WHERE id = '$clean_appt_id'";
            if (mysqli_query($conn, $sql)) {
                header("Location: admin.php?success=updated");
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($conn);
            }
        }
    }
}

// Edit Mode Pre-fill Query
$edit_appointment = false;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    
    $clean_edit_id = "";
    $val_len = 0;
    while (isset($edit_id[$val_len])) {
        $val_len++;
    }
    for ($i = 0; $i < $val_len; $i++) {
        if ($edit_id[$i] == "'") {
            $clean_edit_id .= "\\'";
        } else {
            $clean_edit_id .= $edit_id[$i];
        }
    }
    
    $edit_res = mysqli_query($conn, "SELECT * FROM appointments WHERE id='$clean_edit_id'");
    if (mysqli_num_rows($edit_res) > 0) {
        $edit_appointment = mysqli_fetch_assoc($edit_res);
    }
}

$form_action = "add";
$form_heading = "New Appointment";
$form_name = "";
$form_email = "";
$form_phone = "";
$form_dept = "Select Department";
$form_date = "";
$form_time = "Select Time";
$form_message = "";
$form_button = "Create Appointment";

if ($edit_appointment != false) {
    $form_action = "edit";
    $form_heading = "Edit Appointment (ID: " . $edit_appointment['id'] . ")";
    $form_name = $edit_appointment['name'];
    $form_email = $edit_appointment['email'];
    $form_phone = $edit_appointment['phone'];
    $form_dept = $edit_appointment['department'];
    $form_date = $edit_appointment['appointment_date'];
    $form_time = $edit_appointment['appointment_time'];
    $form_message = $edit_appointment['message'];
    $form_button = "Update Appointment";
}

// Admin Records Queries
$sql = "SELECT * FROM appointments ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

$msg_sql = "SELECT * FROM contact_messages ORDER BY id DESC";
$msg_result = mysqli_query($conn, $msg_sql);

$avatars = [
    'images/testimonial-1.jpg',
    'images/testimonial-2.jpeg',
    'images/testimonial-3.jpg',
    'images/testimonial-4.jpeg',
    'images/testimonial-5.jpeg',
    'images/testimonial-6.jpeg'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    <title>Admin Panel - Smart Clinic</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='45' fill='%230d6efd'/><path d='M30 30 L30 70 L70 70 L70 30 Z' fill='white' stroke='white' stroke-width='3'/><rect x='45' y='40' width='10' height='30' fill='%230d6efd'/><rect x='35' y='50' width='30' height='10' fill='%230d6efd'/></svg>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css?v=3.5">
</head>

<body>
    <!-- Background Decor Blobs -->
    <div class="glass-blob-1"></div>
    <div class="glass-blob-2"></div>
    <div class="glass-blob-3"></div>

    <div class="dashboard-layout">
        
        <!-- Left Sidebar Navigation -->
        <div class="left-sidebar">
            <div class="sidebar-brand-container d-flex align-items-center justify-content-between mb-4">
                <a href="index.php" class="sidebar-brand">
                    Smart Clinic
                </a>
                <button type="button" class="btn-close-sidebar" onclick="toggleSidebar()" aria-label="Close Sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div>
                <ul class="sidebar-menu">
                    <li><a href="admin.php" class="menu-item active"><i class="fas fa-chart-line"></i> Dashboard</a></li>
                    <li><a href="index.php" class="menu-item"><i class="fas fa-external-link-alt"></i> View Website</a></li>
                    <li><a href="#appointments-section" class="menu-item"><i class="fas fa-calendar-alt"></i> Appointments <span class="badge bg-danger ms-2"><?php echo mysqli_num_rows($result); ?></span></a></li>
                    <li><a href="#messages-section" class="menu-item"><i class="fas fa-comment-alt"></i> Messages <span class="badge bg-primary ms-2"><?php echo mysqli_num_rows($msg_result); ?></span></a></li>
                    <li>
                        <button class="menu-item w-100 border-0 bg-transparent text-start theme-toggle-btn" style="outline: none; box-shadow: none;">
                            <i class="fas fa-moon theme-toggle-icon"></i> <span class="theme-toggle-text">Dark Mode</span>
                        </button>
                    </li>
                    <li><a href="logout.php" class="menu-item"><i class="fas fa-lock"></i> Terminate Session</a></li>
                </ul>
            </div>
        </div>

        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Main Content Area -->
        <div class="main-content">
            
            <!-- Top Header Bar -->
            <div class="top-header">
                <div class="d-flex align-items-center gap-3">
                    <button id="header-toggle-btn" class="btn text-primary p-0 border-0" style="font-size: 22px; width: auto; height: auto;" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" id="admin-search-input" placeholder="Search appointments by name, dept, date...">
                    </div>
                </div>
                <div class="admin-profile">
                    <img src="images/team-11.jpeg" alt="Admin Avatar">
                    <div class="profile-info d-none d-sm-block">
                        <h5>Juben Doo</h5>
                        <span>Chief Administrator</span>
                    </div>
                </div>
            </div>

            <!-- Notifications Section -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-dismissible fade show mb-4 shadow-sm d-flex align-items-center gap-2" role="alert" style="border-radius:14px; background: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.25); color: #0d6efd;">
                    <i class="fas fa-check-circle fs-5 text-primary"></i>
                    <div>
                        <?php
                        if ($_GET['success'] == 'added') echo "<strong>Success!</strong> New appointment created successfully.";
                        if ($_GET['success'] == 'updated') echo "<strong>Success!</strong> Appointment updated successfully.";
                        if ($_GET['success'] == 'deleted') echo "<strong>Success!</strong> Appointment has been deleted successfully.";
                        if ($_GET['success'] == 'msg_deleted') echo "<strong>Success!</strong> Contact message removed successfully.";
                        ?>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- KPI Cards Overview Section -->
            <div class="row g-2 mb-1">
                <div class="col-md-4">
                    <div class="kpi-card kpi-card-appointments">
                        <div class="kpi-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="kpi-info">
                            <h6>Appointments</h6>
                            <h3><?php echo mysqli_num_rows($result); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card kpi-card-messages">
                        <div class="kpi-icon">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="kpi-info">
                            <h6>Inbox Messages</h6>
                            <h3><?php echo mysqli_num_rows($msg_result); ?></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="kpi-card kpi-card-doctors">
                        <div class="kpi-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="kpi-info w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>Doctors Active</h6>
                                    <h3>14</h3>
                                </div>
                                <div class="avatar-group d-flex align-items-center mb-1">
                                    <img src="images/team-11.jpeg" class="rounded-circle border border-2 border-white" style="width:28px; height:28px; object-fit:cover; margin-right:-8px; background:#fff;" title="Dr. Juben">
                                    <img src="images/team-12.jpeg" class="rounded-circle border border-2 border-white" style="width:28px; height:28px; object-fit:cover; margin-right:-8px; background:#fff;" title="Dr. Bertrand">
                                    <img src="images/team-13.jpeg" class="rounded-circle border border-2 border-white" style="width:28px; height:28px; object-fit:cover; margin-right:-8px; background:#fff;" title="Dr. Aqsa">
                                    <img src="images/team-14.jpeg" class="rounded-circle border border-2 border-white" style="width:28px; height:28px; object-fit:cover; background:#fff;" title="Dr. Juben">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar & Appointment Form Row -->
            <div class="row g-2 mb-1">
                
                <!-- Calendar & Heart Widget Column -->
                <div class="col-xl-4 col-lg-5 d-flex flex-column gap-2">
                    <div class="doclinic-card calendar-widget mb-0">
                        <div class="calendar-header d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-bold" style="font-size: 13px;" id="calendar-month-year">
                                <i class="fas fa-calendar-alt text-danger"></i> Loading...
                            </span>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1" id="prev-month-btn" style="font-size: 10px; border-radius: 4px;"><i class="fas fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-primary py-0 px-1" id="next-month-btn" style="font-size: 10px; border-radius: 4px;"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                        <div class="calendar-days mb-1">
                            <span class="calendar-day-label">Su</span>
                            <span class="calendar-day-label">Mo</span>
                            <span class="calendar-day-label">Tu</span>
                            <span class="calendar-day-label">We</span>
                            <span class="calendar-day-label">Th</span>
                            <span class="calendar-day-label">Fr</span>
                            <span class="calendar-day-label">Sa</span>
                        </div>
                        <div class="calendar-days" id="calendar-dates-grid">
                        </div>
                    </div>

                    <div class="doclinic-card heart-health-widget">
                        <div class="d-flex flex-column align-items-center text-center gap-2">
                            <div class="heart-svg-container">
                                <img src="images/anatomical_heart_clean.jpg" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 1.5px solid rgba(220, 53, 69, 0.25); background:#fff;">
                            </div>
                            <div>
                                <h5 class="m-0 fw-bold text-dark" style="font-size: 13px;">Heart Health Status</h5>
                                <p class="mb-0 text-muted" style="font-size: 11px; line-height: 1.4;">
                                    "A healthy heart beats with a purpose. Exercise 30 mins daily, choose low-sodium foods, and keep stress low to shield your heart."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Form Column -->
                <div class="col-xl-8 col-lg-7">
                    <div class="doclinic-card appointment-form-widget mb-0" id="appointment-form-section">
                        <h3 class="h5 mb-3 text-primary fw-bold"><i class="fas fa-edit"></i> <?php echo $form_heading; ?></h3>
                        
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger py-2 border-0 shadow-sm mb-3" style="border-radius:8px;">
                                <ul class="mb-0 ps-3">
                                    <?php foreach($errors as $error): ?>
                                        <li><small><?php echo $error; ?></small></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="admin.php" method="POST">
                            <input type="hidden" name="action" value="<?php echo $form_action; ?>">
                            <?php if ($edit_appointment): ?>
                                <input type="hidden" name="appointment_id" value="<?php echo $edit_appointment['id']; ?>">
                            <?php endif; ?>

                            <div>
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Patient Name *</label>
                                        <input type="text" class="form-control" name="u_name" value="<?php echo $form_name; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" name="u_email" value="<?php echo $form_email; ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" name="u_phone" value="<?php echo $form_phone; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Department *</label>
                                        <select class="form-select" name="u_dept" required>
                                            <option value="Select Department" <?php if ($form_dept == 'Select Department') echo 'selected'; ?>>Select Department</option>
                                            <option value="Cardiology" <?php if ($form_dept == 'Cardiology') echo 'selected'; ?>>Cardiology</option>
                                            <option value="General Medicine" <?php if ($form_dept == 'General Medicine') echo 'selected'; ?>>General Medicine</option>
                                            <option value="Pediatrics" <?php if ($form_dept == 'Pediatrics') echo 'selected'; ?>>Pediatrics</option>
                                            <option value="Orthopedics" <?php if ($form_dept == 'Orthopedics') echo 'selected'; ?>>Orthopedics</option>
                                            <option value="Dermatology" <?php if ($form_dept == 'Dermatology') echo 'selected'; ?>>Dermatology</option>
                                            <option value="Neurology" <?php if ($form_dept == 'Neurology') echo 'selected'; ?>>Neurology</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Date *</label>
                                        <input type="date" id="appointment-date-input" name="u_date" class="form-control" value="<?php echo $form_date; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Time Slot *</label>
                                        <select class="form-select" name="u_time" required>
                                            <option value="Select Time" <?php if ($form_time == 'Select Time') echo 'selected'; ?>>Select Time</option>
                                            <option value="9:00 AM" <?php if ($form_time == '9:00 AM') echo 'selected'; ?>>9:00 AM</option>
                                            <option value="10:00 AM" <?php if ($form_time == '10:00 AM') echo 'selected'; ?>>10:00 AM</option>
                                            <option value="11:00 AM" <?php if ($form_time == '11:00 AM') echo 'selected'; ?>>11:00 AM</option>
                                            <option value="2:00 PM" <?php if ($form_time == '2:00 PM') echo 'selected'; ?>>2:00 PM</option>
                                            <option value="3:00 PM" <?php if ($form_time == '3:00 PM') echo 'selected'; ?>>3:00 PM</option>
                                            <option value="4:00 PM" <?php if ($form_time == '4:00 PM') echo 'selected'; ?>>4:00 PM</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label class="form-label">Message / Notes</label>
                                        <textarea class="form-control" rows="2" name="u_message"><?php echo $form_message; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-2">
                                <div class="col-12 d-flex gap-2">
                                    <button type="submit" class="btn btn-doclinic-primary flex-grow-1" name="submit_appointment"><?php echo $form_button; ?></button>
                                    <?php if ($edit_appointment): ?>
                                        <a class="btn btn-outline-secondary" href="admin.php#appointments-section">Cancel</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            <!-- Management Data Tables Section -->
            <div class="row g-2">
                
                <!-- Appointments Table Card -->
                <div class="col-12">
                    <div class="doclinic-card mb-4" id="appointments-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 text-primary fw-bold m-0"><i class="fas fa-calendar-check"></i> Patient Appointments Manager</h2>
                            <span class="badge bg-primary rounded-pill"><?php echo mysqli_num_rows($result); ?> total</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact details</th>
                                        <th>Dept</th>
                                        <th>Schedule</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="appointments-tbody">
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while($row = mysqli_fetch_assoc($result)): 
                                            $avatar_url = $avatars[$row['id'] % count($avatars)];
                                        ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo $avatar_url; ?>" class="rounded-circle me-2" style="width:32px; height:32px; object-fit:cover; border: 1px solid rgba(13, 110, 253, 0.15); background:#fff;">
                                                        <strong><?php echo $row['name']; ?></strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small class="text-muted"><i class="fas fa-envelope"></i> <?php echo $row['email']; ?></small><br>
                                                    <small class="text-muted"><i class="fas fa-phone"></i> <?php echo $row['phone']; ?></small>
                                                </td>
                                                <td><span class="badge bg-light text-primary"><?php echo $row['department']; ?></span></td>
                                                <td>
                                                    <small><i class="fas fa-calendar"></i> <?php echo date('d-m-Y', strtotime($row['appointment_date'])); ?></small><br>
                                                    <small><i class="fas fa-clock"></i> <?php echo $row['appointment_time']; ?></small>
                                                </td>
                                                <td><small class="text-muted"><?php echo $row['message'] ? $row['message'] : '-'; ?></small></td>
                                                <td>
                                                    <div class="d-flex gap-1">
                                                        <a href="admin.php?edit_id=<?php echo $row['id']; ?>#appointment-form-section" class="btn btn-sm btn-outline-primary py-1" title="Edit"><i class="fas fa-edit"></i></a>
                                                        <a href="javascript:void(0);" onclick="confirmDeleteAppointment(<?php echo $row['id']; ?>)" class="btn btn-sm btn-outline-danger py-1" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="7" class="text-center text-muted py-4">No appointments found in database.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Contact Messages Table Card -->
                <div class="col-12">
                    <div class="doclinic-card" id="messages-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="h5 text-primary fw-bold m-0"><i class="fas fa-envelope-open-text"></i> Contact Messages Inbox</h2>
                            <span class="badge bg-primary text-white rounded-pill"><?php echo mysqli_num_rows($msg_result); ?> messages</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sender Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date Received</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($msg_result) > 0): ?>
                                        <?php while($row_msg = mysqli_fetch_assoc($msg_result)): 
                                            $msg_avatar_url = $avatars[($row_msg['id'] + 3) % count($avatars)];
                                        ?>
                                            <tr>
                                                <td><?php echo $row_msg['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo $msg_avatar_url; ?>" class="rounded-circle me-2" style="width:32px; height:32px; object-fit:cover; border: 1px solid rgba(13, 110, 253, 0.15); background:#fff;">
                                                        <strong><?php echo $row_msg['name']; ?></strong>
                                                    </div>
                                                </td>
                                                <td><small class="text-muted"><?php echo $row_msg['email']; ?></small></td>
                                                <td><strong><?php echo $row_msg['subject']; ?></strong></td>
                                                <td><small class="text-muted"><?php echo $row_msg['message']; ?></small></td>
                                                <td><small class="text-muted"><i class="fas fa-clock"></i> <?php echo date('d-m-Y H:i', strtotime($row_msg['created_at'])); ?></small></td>
                                                <td>
                                                    <a href="javascript:void(0);" onclick="confirmDeleteMessage(<?php echo $row_msg['id']; ?>)" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="7" class="text-center text-muted py-4">No contact messages found in inbox.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    function toggleSidebar() {
        if (window.innerWidth <= 991) {
            document.body.classList.toggle("sidebar-open");
        } else {
            document.body.classList.toggle("sidebar-collapsed");
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const headerToggleBtn = document.getElementById("header-toggle-btn");
        
        if (headerToggleBtn) {
            headerToggleBtn.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleSidebar();
            });
        }

        const overlay = document.querySelector(".sidebar-overlay");
        if (overlay) {
            overlay.addEventListener("click", function() {
                document.body.classList.remove("sidebar-open");
            });
        }

        // Calendar Widget Implementation
        const calendarGrid = document.getElementById("calendar-dates-grid");
        const calendarMonthYear = document.getElementById("calendar-month-year");
        const prevMonthBtn = document.getElementById("prev-month-btn");
        const nextMonthBtn = document.getElementById("next-month-btn");
        const dateInput = document.getElementById("appointment-date-input");

        let currentDate = new Date();
        if (dateInput && dateInput.value) {
            const parsed = new Date(dateInput.value);
            if (!isNaN(parsed.getTime())) {
                currentDate = parsed;
            }
        }
        let activeDate = new Date(currentDate);

        const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            if (calendarMonthYear) {
                calendarMonthYear.innerHTML = `<i class="fas fa-calendar-alt text-danger"></i> ${months[month]} ${year}`;
            }

            const firstDayIndex = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();
            const prevTotalDays = new Date(year, month, 0).getDate();

            let dateHtml = "";

            for (let i = firstDayIndex - 1; i >= 0; i--) {
                dateHtml += `<span class="calendar-date text-muted">${prevTotalDays - i}</span>`;
            }

            const today = new Date();
            for (let day = 1; day <= totalDays; day++) {
                const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() === year;
                const isActive = activeDate.getDate() === day && activeDate.getMonth() === month && activeDate.getFullYear() === year;
                
                let classes = "calendar-date";
                if (isToday) classes += " today-highlight";
                if (isActive) classes += " active";

                dateHtml += `<span class="${classes}" data-day="${day}">${day}</span>`;
            }

            const totalCells = firstDayIndex + totalDays;
            const remainingCells = (totalCells % 7 === 0) ? 0 : 7 - (totalCells % 7);
            for (let day = 1; day <= remainingCells; day++) {
                dateHtml += `<span class="calendar-date text-muted">${day}</span>`;
            }

            if (calendarGrid) {
                calendarGrid.innerHTML = dateHtml;

                calendarGrid.querySelectorAll(".calendar-date:not(.text-muted)").forEach(el => {
                    el.addEventListener("click", function() {
                        const selectedDay = parseInt(this.getAttribute("data-day"));
                        activeDate = new Date(year, month, selectedDay);
                        
                        calendarGrid.querySelectorAll(".calendar-date").forEach(c => c.classList.remove("active"));
                        this.classList.add("active");

                        if (dateInput) {
                            const formattedMonth = String(month + 1).padStart(2, '0');
                            const formattedDay = String(selectedDay).padStart(2, '0');
                            dateInput.value = `${year}-${formattedMonth}-${formattedDay}`;
                        }
                    });
                });
            }
        }

        if (prevMonthBtn) {
            prevMonthBtn.addEventListener("click", function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
        }

        if (nextMonthBtn) {
            nextMonthBtn.addEventListener("click", function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
        }

        renderCalendar();

        // AJAX Live Appointments Search
        const searchInput = document.getElementById("admin-search-input");
        const apptTbody = document.getElementById("appointments-tbody");
        let searchDebounce;

        if (searchInput && apptTbody) {
            searchInput.addEventListener("input", function() {
                const query = this.value.trim();
                clearTimeout(searchDebounce);
                searchDebounce = setTimeout(function() {
                    fetch("ajax/ajax_search_admin.php?q=" + encodeURIComponent(query))
                        .then(res => res.text())
                        .then(html => {
                            apptTbody.innerHTML = html;
                        })
                        .catch(() => {});
                }, 300);
            });
        }
    });

    // Delete Confirmation Modal Functions
    function confirmDeleteAppointment(id) {
        document.getElementById('deleteModalMessage').innerText = "Are you sure you want to permanently delete Appointment #" + id + "?";
        document.getElementById('confirmDeleteModalBtn').href = 'admin.php?delete_id=' + id;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        deleteModal.show();
    }

    function confirmDeleteMessage(id) {
        document.getElementById('deleteModalMessage').innerText = "Are you sure you want to permanently remove Message #" + id + "?";
        document.getElementById('confirmDeleteModalBtn').href = 'admin.php?delete_msg_id=' + id + '#messages-section';
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        deleteModal.show();
    }
    </script>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 320px; margin: auto;">
            <div class="modal-content text-center p-3 border-0 shadow-lg" style="border-radius: 16px; border-top: 5px solid #dc3545 !important;">
                <div class="my-2">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 42px;"></i>
                </div>
                <h5 class="fw-bold mb-1 text-dark" style="font-size: 17px;">Confirm Deletion</h5>
                <p class="text-muted mb-3" style="font-size: 13px;" id="deleteModalMessage">Are you sure you want to delete this item?</p>
                <div class="d-flex gap-2 justify-content-center mb-2">
                    <button type="button" class="btn btn-secondary px-3 py-1 rounded-pill fw-semibold" style="font-size: 13px;" data-bs-dismiss="modal">Cancel</button>
                    <a href="#" id="confirmDeleteModalBtn" class="btn btn-danger px-3 py-1 rounded-pill fw-semibold" style="font-size: 13px;">Yes, Delete</a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/theme-toggle.js"></script>
</body>

</html>