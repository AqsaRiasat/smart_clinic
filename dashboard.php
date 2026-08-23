<?php
session_start();
include 'database/db.php';

// Access Control Check
if (!isset($_SESSION['patient_id'])) {
    header("Location: user_login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

// Patient Profile Query
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$patient_id'");
$user_data = mysqli_fetch_assoc($user_query);

// Appointment Cancellation Handler
if (isset($_GET['cancel_id'])) {
    $cancel_id = $_GET['cancel_id'];
    
    $clean_cancel_id = "";
    $val_len = 0;
    while (isset($cancel_id[$val_len])) {
        $val_len++;
    }
    for ($i = 0; $i < $val_len; $i++) {
        if ($cancel_id[$i] == "'") {
            $clean_cancel_id .= "\\'";
        } else {
            $clean_cancel_id .= $cancel_id[$i];
        }
    }

    mysqli_query($conn, "DELETE FROM appointments WHERE id='$clean_cancel_id' AND user_id='$patient_id'");
    echo "<script>alert('Appointment cancelled successfully!'); window.location='dashboard.php';</script>";
    exit();
}

// Profile Information Update Handler
$profile_errors = [];
$profile_success = false;

if (isset($_POST['update_profile'])) {
    $new_name = trim($_POST['profile_name']);
    $new_email = trim($_POST['profile_email']);
    
    if ($new_name == "") {
        $profile_errors[] = "Name is required!";
    } else {
        $name_len = 0;
        $valid_name = true;
        while (isset($new_name[$name_len])) {
            $ch = $new_name[$name_len];
            if (($ch >= 'a' && $ch <= 'z') || ($ch >= 'A' && $ch <= 'Z') || $ch == ' ') {
            } else {
                $valid_name = false;
            }
            $name_len++;
        }
        if ($name_len < 3) {
            $profile_errors[] = "Name must be at least 3 characters!";
        } elseif (!$valid_name) {
            $profile_errors[] = "Name can only contain letters and spaces!";
        }
    }
    
    if ($new_email == "") {
        $profile_errors[] = "Email is required!";
    } else {
        $has_at = false; $has_dot = false;
        $el = 0;
        while (isset($new_email[$el])) {
            if ($new_email[$el] == "@") $has_at = true;
            if ($new_email[$el] == ".") $has_dot = true;
            $el++;
        }
        if (!$has_at || !$has_dot) {
            $profile_errors[] = "Please enter a valid email!";
        } else {
            $check_email = mysqli_real_escape_string($conn, $new_email);
            $email_check = mysqli_query($conn, "SELECT id FROM users WHERE email='$check_email' AND id!='$patient_id'");
            if (mysqli_num_rows($email_check) > 0) {
                $profile_errors[] = "This email is already registered!";
            }
        }
    }
    
    if (empty($profile_errors)) {
        $safe_name = mysqli_real_escape_string($conn, $new_name);
        $safe_email = mysqli_real_escape_string($conn, $new_email);
        mysqli_query($conn, "UPDATE users SET fullname='$safe_name', email='$safe_email' WHERE id='$patient_id'");
        
        $_SESSION['patient_name'] = $new_name;
        $patient_name = $new_name;
        
        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$patient_id'");
        $user_data = mysqli_fetch_assoc($user_query);
        
        $profile_success = true;
    }
}

// Password Change Handler
$pwd_errors = [];
$pwd_success = false;

if (isset($_POST['change_password'])) {
    $current_pwd = $_POST['current_password'];
    $new_pwd = $_POST['new_password'];
    $confirm_pwd = $_POST['confirm_password'];
    
    if ($current_pwd != $user_data['password']) {
        $pwd_errors[] = "Current password is incorrect!";
    }
    
    if ($new_pwd == "") {
        $pwd_errors[] = "New password is required!";
    } else {
        $pwd_len = 0;
        while (isset($new_pwd[$pwd_len])) { $pwd_len++; }
        if ($pwd_len < 6) {
            $pwd_errors[] = "New password must be at least 6 characters!";
        }
    }
    
    if ($new_pwd != $confirm_pwd) {
        $pwd_errors[] = "Passwords do not match!";
    }
    
    if (empty($pwd_errors)) {
        $safe_pwd = mysqli_real_escape_string($conn, $new_pwd);
        mysqli_query($conn, "UPDATE users SET password='$safe_pwd' WHERE id='$patient_id'");
        $pwd_success = true;
        
        $user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$patient_id'");
        $user_data = mysqli_fetch_assoc($user_query);
    }
}

// Dashboard Queries
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';

$appointments_query = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id='$patient_id' ORDER BY appointment_date DESC, appointment_time DESC");
$appointments_list = [];
while ($row = mysqli_fetch_assoc($appointments_query)) {
    $appointments_list[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
    <title>Patient Dashboard - Smart Clinic</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='45' fill='%230d6efd'/><path d='M30 30 L30 70 L70 70 L70 30 Z' fill='white' stroke='white' stroke-width='3'/><rect x='45' y='40' width='10' height='30' fill='%230d6efd'/><rect x='35' y='50' width='30' height='10' fill='%230d6efd'/></svg>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard.css?v=3.5">
</head>

<body>

    <div class="dashboard-layout">
        
        <!-- Left Sidebar Navigation -->
        <div class="left-sidebar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="index.php" class="sidebar-brand mb-0">
                    <i class="fas fa-hospital-user"></i> Smart Clinic
                </a>
                <button type="button" class="btn-close-sidebar" onclick="toggleSidebar()" aria-label="Close Sidebar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="sidebar-profile">
                <div class="profile-avatar-container">
                    <?php if (file_exists('images/patient_avatar.jpg')): ?>
                        <img src="images/patient_avatar.jpg?v=1.1" alt="<?php echo htmlspecialchars($patient_name); ?>" class="profile-avatar-img">
                    <?php else: ?>
                        <?php 
                            $words = explode(" ", $patient_name);
                            $initials = "";
                            foreach ($words as $w) {
                                if (isset($w[0])) {
                                    $initials .= $w[0];
                                }
                            }
                            $initials = substr(strtoupper($initials), 0, 2);
                            echo '<span class="profile-avatar-initials">' . $initials . '</span>';
                        ?>
                    <?php endif; ?>
                </div>
                <h5><?php echo htmlspecialchars($patient_name); ?></h5>
                <span>Registered Patient</span>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="menu-item <?php echo $active_tab == 'dashboard' ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="dashboard.php?tab=profile" class="menu-item <?php echo $active_tab == 'profile' ? 'active' : ''; ?>"><i class="fas fa-user-circle"></i> My Profile</a></li>
                <li><a href="appointment.php" class="menu-item"><i class="fas fa-calendar-plus"></i> Book Appointment</a></li>
                <li><a href="index.php" class="menu-item"><i class="fas fa-home"></i> Back to Home</a></li>
                <li>
                    <button class="menu-item w-100 border-0 bg-transparent text-start theme-toggle-btn" style="outline: none; box-shadow: none;">
                        <i class="fas fa-moon theme-toggle-icon"></i> <span class="theme-toggle-text">Dark Mode</span>
                    </button>
                </li>
                <li><a href="logout_user.php" class="menu-item text-danger"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Main Content Area -->
        <div class="main-content">
            
            <!-- Dashboard Top Header Bar -->
            <div class="dashboard-topbar">
                <button id="dashboard-toggle-btn" class="topbar-toggle" onclick="toggleSidebar()" type="button" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-date">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> <?php echo date('l, F j, Y'); ?>
                </div>
            </div>

            <div class="dashboard-container">

                <!-- Profile Tab View -->
                <?php if ($active_tab == 'profile'): ?>

                <div class="welcome-card mb-4">
                    <div class="welcome-text">
                        <h1><i class="fas fa-user-gear text-primary me-2"></i> Account Settings</h1>
                        <p>Manage and update your personal information and account security.</p>
                    </div>
                    <div class="quick-actions">
                        <a href="dashboard.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Personal Info Card -->
                    <div class="col-lg-6">
                        <div class="appointments-card h-100">
                            <div class="appointments-header border-bottom pb-3 mb-4">
                                <h3><i class="fas fa-user-edit text-primary"></i> Personal Details</h3>
                            </div>

                            <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background: rgba(13, 110, 253, 0.05); border: 1px solid rgba(13, 110, 253, 0.1);">
                                <img src="images/patient_avatar.jpg?v=1.1" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #0d6efd;">
                                <div>
                                    <h6 class="mb-1 fw-bold"><?php echo htmlspecialchars($user_data['fullname']); ?></h6>
                                    <small class="text-muted"><i class="fas fa-envelope me-1"></i> <?php echo htmlspecialchars($user_data['email']); ?></small>
                                </div>
                            </div>

                            <?php if ($profile_success): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle me-2 fs-5"></i>
                                <div>Profile updated successfully!</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($profile_errors)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($profile_errors as $err): ?>
                                    <li><?php echo htmlspecialchars($err); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form action="dashboard.php?tab=profile" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" name="profile_name" class="form-control" value="<?php echo htmlspecialchars($user_data['fullname']); ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" name="profile_email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Member Since</label>
                                    <input type="text" class="form-control" value="<?php echo isset($user_data['created_at']) ? date('F j, Y', strtotime($user_data['created_at'])) : 'Active Patient'; ?>" readonly disabled style="opacity: 0.7;">
                                </div>

                                <button type="submit" name="update_profile" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                                    <i class="fas fa-save me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Password Change Card -->
                    <div class="col-lg-6">
                        <div class="appointments-card h-100">
                            <div class="appointments-header border-bottom pb-3 mb-4">
                                <h3><i class="fas fa-key text-primary"></i> Change Password</h3>
                            </div>

                            <?php if ($pwd_success): ?>
                            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                <i class="fas fa-check-circle me-2 fs-5"></i>
                                <div>Password changed successfully!</div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($pwd_errors)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0 ps-3">
                                    <?php foreach ($pwd_errors as $err): ?>
                                    <li><?php echo htmlspecialchars($err); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form action="dashboard.php?tab=profile" method="POST">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock-open text-muted"></i></span>
                                        <input type="password" name="new_password" class="form-control" placeholder="Min 6 characters" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-shield-alt text-muted"></i></span>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Re-type new password" required>
                                    </div>
                                </div>

                                <button type="submit" name="change_password" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                                    <i class="fas fa-sync-alt me-1"></i> Update Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Tab View -->
                <?php else: ?>

                <?php
                $total = count($appointments_list);
                $upcoming = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id='$patient_id' AND appointment_date >= CURDATE()");
                $upcoming_count = mysqli_num_rows($upcoming);
                $completed = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id='$patient_id' AND appointment_date < CURDATE()");
                $completed_count = mysqli_num_rows($completed);

                $hour = (int)date('H');
                if ($hour < 12) {
                    $greeting = "Good Morning";
                    $greeting_icon = "fa-sun";
                } elseif ($hour < 17) {
                    $greeting = "Good Afternoon";
                    $greeting_icon = "fa-sun";
                } else {
                    $greeting = "Good Evening";
                    $greeting_icon = "fa-moon";
                }
                ?>

                <!-- Welcome Greeting Card -->
                <div class="welcome-card">
                    <div class="welcome-text">
                        <h1>Welcome, <?php echo $patient_name; ?>!</h1>
                        <p>Manage your appointments and medical tracking records in one place.</p>
                    </div>
                    <div class="welcome-greeting-badge">
                        <i class="fas <?php echo $greeting_icon; ?> greeting-sun-icon"></i>
                        <span class="greeting-label"><?php echo $greeting; ?></span>
                    </div>
                </div>

                <!-- Patient Statistics Overview -->
                <div class="stats-row">
                    <div class="stat-card stat-card-blue">
                        <div class="stat-card-header d-flex justify-content-between align-items-center">
                            <div class="stat-icon icon-blue"><i class="fas fa-calendar-check"></i></div>
                            <span class="stat-pill pill-blue"><i class="fas fa-database me-1"></i> Records</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $total; ?></div>
                            <div class="stat-label">Total Appointments</div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-gold">
                        <div class="stat-card-header d-flex justify-content-between align-items-center">
                            <div class="stat-icon icon-gold"><i class="fas fa-clock"></i></div>
                            <span class="stat-pill pill-gold"><i class="fas fa-hourglass-half me-1"></i> Scheduled</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $upcoming_count; ?></div>
                            <div class="stat-label">Upcoming Appointments</div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-emerald">
                        <div class="stat-card-header d-flex justify-content-between align-items-center">
                            <div class="stat-icon icon-emerald"><i class="fas fa-check-circle"></i></div>
                            <span class="stat-pill pill-emerald"><i class="fas fa-check-double me-1"></i> Completed</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $completed_count; ?></div>
                            <div class="stat-label">Finished Visits</div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-purple">
                        <div class="stat-card-header d-flex justify-content-between align-items-center">
                            <div class="stat-icon icon-purple"><i class="fas fa-shield-heart"></i></div>
                            <span class="stat-pill pill-purple"><i class="fas fa-user-check me-1"></i> Verified</span>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo isset($user_data['created_at']) ? date('Y', strtotime($user_data['created_at'])) : '2024'; ?></div>
                            <div class="stat-label">Member Since</div>
                        </div>
                    </div>
                </div>

                <?php $today = date('Y-m-d'); ?>

                <!-- Appointments List Table Section -->
                <div class="appointments-card">
                    <div class="appointments-header d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                        <h3><i class="fas fa-list text-primary"></i> My Appointments</h3>
                        <a href="appointment.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Appointment
                        </a>
                    </div>

                    <div class="table-responsive">
                        <?php if (count($appointments_list) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr><th>#</th><th>Department</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $count = 1;
                                foreach ($appointments_list as $row): 
                                    $app_date = $row['appointment_date'];
                                    if ($app_date < $today) {
                                        $status = "Completed";
                                        $status_class = "status-completed";
                                    } elseif ($app_date == $today) {
                                        $status = "Today";
                                        $status_class = "status-upcoming";
                                    } else {
                                        $status = "Upcoming";
                                        $status_class = "status-upcoming";
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($row['appointment_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['appointment_time']); ?></td>
                                    <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status; ?></span></td>
                                    <td>
                                        <a href="javascript:void(0);" class="action-btn btn-view" 
                                           data-id="<?php echo $row['id']; ?>"
                                           data-dept="<?php echo htmlspecialchars($row['department']); ?>"
                                           data-date="<?php echo date('d-m-Y', strtotime($row['appointment_date'])); ?>"
                                           data-time="<?php echo htmlspecialchars($row['appointment_time']); ?>"
                                           data-status="<?php echo $status; ?>"
                                           data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                           data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                           data-phone="<?php echo htmlspecialchars($row['phone']); ?>"
                                           data-message="<?php echo htmlspecialchars($row['message']); ?>"
                                           onclick="openDetails(this)">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <?php if ($app_date >= $today): ?>
                                        <a href="javascript:void(0);" class="action-btn btn-cancel" onclick="showCancelPopup(<?php echo $row['id']; ?>)">
                                            <i class="fas fa-times"></i> Cancel
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times"></i>
                            <h4>No Appointments Found</h4>
                            <p>You haven't booked any appointments yet.</p>
                            <a href="appointment.php" class="btn btn-primary mt-3">Book Your First Appointment</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel"><i class="fas fa-file-invoice text-primary"></i> Appointment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="details-list">
                        <div class="details-item">
                            <span class="details-label">Appointment ID</span>
                            <span class="details-value" id="modal-app-id"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Department</span>
                            <span class="details-value" id="modal-app-dept"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Date & Time</span>
                            <span class="details-value" id="modal-app-datetime"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Status</span>
                            <span class="details-value" id="modal-app-status"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Registered Name</span>
                            <span class="details-value" id="modal-app-name"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Email & Phone</span>
                            <span class="details-value" id="modal-app-contact"></span>
                        </div>
                        <div class="details-item">
                            <span class="details-label">Message / Notes</span>
                            <span class="details-value" id="modal-app-message" style="word-break: break-word;"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <a href="#" id="modal-print-btn" target="_blank" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-print me-1"></i> Print Slip
                    </a>
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Appointment Confirmation Modal -->
    <div id="cancelPopup" class="cancel-popup" style="display: none;">
        <i class="fas fa-exclamation-triangle"></i>
        <h4>Confirm Cancellation</h4>
        <p>Are you sure you want to cancel this appointment?</p>
        <div>
            <a href="#" id="confirmCancelBtn" class="btn-yes">Yes, Cancel</a>
            <button onclick="hideCancelPopup()" class="btn-no">No</button>
        </div>
    </div>
    <div id="popupOverlay" class="cancel-overlay" style="display: none;" onclick="hideCancelPopup()"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Navigation Sidebar Toggle
    window.toggleSidebar = function() {
        document.body.classList.toggle('sidebar-open');
    };

    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('dashboard-toggle-btn');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.toggleSidebar();
            });
        }

        const closeBtn = document.querySelector('.btn-close-sidebar');
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.body.classList.remove('sidebar-open');
            });
        }

        const overlay = document.querySelector('.sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.body.classList.remove('sidebar-open');
            });
        }
    });

    // Appointment Details Modal Handler
    function openDetails(btnElement) {
        var id = btnElement.getAttribute('data-id');
        var dept = btnElement.getAttribute('data-dept');
        var date = btnElement.getAttribute('data-date');
        var time = btnElement.getAttribute('data-time');
        var status = btnElement.getAttribute('data-status');
        var name = btnElement.getAttribute('data-name');
        var email = btnElement.getAttribute('data-email');
        var phone = btnElement.getAttribute('data-phone');
        var message = btnElement.getAttribute('data-message');
        
        document.getElementById('modal-app-id').innerText = '#' + id;
        document.getElementById('modal-app-dept').innerText = dept;
        document.getElementById('modal-app-datetime').innerText = date + ' @ ' + time;
        document.getElementById('modal-app-status').innerHTML = '<span class="status-badge ' + 
            (status.toLowerCase() === 'completed' ? 'status-completed' : 'status-upcoming') + '">' + status + '</span>';
        document.getElementById('modal-app-name').innerText = name;
        document.getElementById('modal-app-contact').innerText = email + ' / ' + phone;
        document.getElementById('modal-app-message').innerText = message ? message : 'N/A';
        document.getElementById('modal-print-btn').href = 'print_appointment.php?id=' + id;
        
        var myModal = new bootstrap.Modal(document.getElementById('detailsModal'));
        myModal.show();
    }

    // Cancellation Popup Handlers
    function showCancelPopup(id) {
        document.getElementById('confirmCancelBtn').href = 'dashboard.php?cancel_id=' + id;
        document.getElementById('cancelPopup').style.display = 'block';
        document.getElementById('popupOverlay').style.display = 'block';
    }
    
    function hideCancelPopup() {
        document.getElementById('cancelPopup').style.display = 'none';
        document.getElementById('popupOverlay').style.display = 'none';
    }
    </script>
    
    <script src="js/main.js"></script>
    <script src="js/theme-toggle.js"></script>
</body>

</html>