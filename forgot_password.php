<?php
session_start();
include 'database/db.php';

$errors = [];
$step = 1;
$verified_email = "";
$verified_name = "";

// Step 1: Verify Account
if (isset($_POST['verify_account'])) {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];

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

    if ($fullname == "") {
        $errors[] = "Full Name is required!";
    }

    if (empty($errors)) {
        $clean_email = "";
        $em_len = 0;
        while (isset($email[$em_len])) { $em_len++; }
        for ($i = 0; $i < $em_len; $i++) {
            if ($email[$i] == "'") { $clean_email .= "\\'"; }
            else { $clean_email .= $email[$i]; }
        }

        $clean_name = "";
        $nm_len = 0;
        while (isset($fullname[$nm_len])) { $nm_len++; }
        for ($i = 0; $i < $nm_len; $i++) {
            if ($fullname[$i] == "'") { $clean_name .= "\\'"; }
            else { $clean_name .= $fullname[$i]; }
        }

        $check_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$clean_email' AND fullname='$clean_name'");

        if (mysqli_num_rows($check_query) > 0) {
            $user_data = mysqli_fetch_assoc($check_query);
            $verified_email = $user_data['email'];
            $verified_name = $user_data['fullname'];
            $step = 2;
        } else {
            $errors[] = "No account found matching this email and name! Please check your details.";
            $step = 1;
        }
    }
}

// Step 2: Set New Password
if (isset($_POST['set_new_password'])) {
    $verified_email = $_POST['verified_email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password == "") {
        $errors[] = "New Password is required!";
    } else {
        $pwd_length = 0;
        while (isset($new_password[$pwd_length])) {
            $pwd_length++;
        }
        if ($pwd_length < 6) {
            $errors[] = "Password must be at least 6 characters!";
        }
    }

    if ($new_password != $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    if (empty($errors)) {
        $clean_email = "";
        $em_len = 0;
        while (isset($verified_email[$em_len])) { $em_len++; }
        for ($i = 0; $i < $em_len; $i++) {
            if ($verified_email[$i] == "'") { $clean_email .= "\\'"; }
            else { $clean_email .= $verified_email[$i]; }
        }

        $clean_pwd = "";
        $pw_len = 0;
        while (isset($new_password[$pw_len])) { $pw_len++; }
        for ($i = 0; $i < $pw_len; $i++) {
            if ($new_password[$i] == "'") { $clean_pwd .= "\\'"; }
            else { $clean_pwd .= $new_password[$i]; }
        }

        $update = mysqli_query($conn, "UPDATE users SET password='$clean_pwd' WHERE email='$clean_email'");
        if ($update) {
            $step = 3;
        } else {
            $errors[] = "Failed to update password. Please try again.";
            $step = 2;
        }
    } else {
        $step = 2;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Smart Clinic</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='45' fill='%230d6efd'/><path d='M30 30 L30 70 L70 70 L70 30 Z' fill='white' stroke='white' stroke-width='3'/><rect x='45' y='40' width='10' height='30' fill='%230d6efd'/><rect x='35' y='50' width='30' height='10' fill='%230d6efd'/></svg>" type="image/svg+xml">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/auth.css?v=1.1">
</head>
<body>
    <div class="split-container">
        <!-- Brand Information Panel -->
        <div class="split-left">
            <div class="left-content">
                <a class="logo" href="index.php">
                    <i class="fas fa-hospital-user"></i> Smart Clinic
                </a>
                <h2>Account Recovery <br><strong>Quick & Secure</strong></h2>
                <p>Verify your registered identity details to reset your password and regain access to your medical portal.</p>
                
                <div class="features-list mt-5">
                    <div class="feature-item-small mb-3 d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <span>Step 1: Verify Registered Details</span>
                    </div>
                    <div class="feature-item-small mb-3 d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-key"></i>
                        </div>
                        <span>Step 2: Set New Password</span>
                    </div>
                    <div class="feature-item-small d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span>Instant Account Access</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="split-right">
            <div class="form-wrapper">
                <div class="login-card">
                    
                    <!-- Step 1: Verification Form -->
                    <?php if ($step == 1): ?>
                    <h2>Forgot Password</h2>
                    <p class="subtitle">Step 1: Enter your registered Email and Full Name to verify your account.</p>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="error-box mb-3">
                            <strong>Please fix these errors:</strong>
                            <ul class="mb-0 ps-3">
                                <?php foreach($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Registered Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="e.g. user@example.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Registered Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="fullname" class="form-control" placeholder="e.g. John Doe" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
                            </div>
                        </div>

                        <button type="submit" name="verify_account" class="btn btn-primary w-100 mb-3 py-2 fw-semibold">
                            <i class="fas fa-search me-1"></i> Verify Account
                        </button>

                        <p class="text-center mb-0 text-muted-custom">
                            Remember your password? <a href="user_login.php" class="text-primary fw-semibold">Login here</a>
                        </p>
                    </form>

                    <!-- Step 2: New Password Form -->
                    <?php elseif ($step == 2): ?>
                    <h2>Set New Password</h2>
                    <p class="subtitle">Step 2: Identity verified! Enter your new password below.</p>
                    
                    <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3" style="background: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.2);">
                        <i class="fas fa-check-circle text-primary fs-5"></i>
                        <div>
                            <strong class="text-primary d-block small">Account Verified!</strong>
                            <span class="small text-muted"><?php echo htmlspecialchars($verified_email); ?></span>
                        </div>
                    </div>

                    <?php if (!empty($errors)): ?>
                        <div class="error-box mb-3">
                            <strong>Please fix these errors:</strong>
                            <ul class="mb-0 ps-3">
                                <?php foreach($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="verified_email" value="<?php echo htmlspecialchars($verified_email); ?>">

                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" name="new_password" class="form-control" placeholder="Min 6 characters" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-shield-alt text-muted"></i></span>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Re-type new password" required>
                            </div>
                        </div>

                        <button type="submit" name="set_new_password" class="btn btn-primary w-100 mb-3 py-2 fw-semibold">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>
                    </form>

                    <!-- Step 3: Success Confirmation -->
                    <?php elseif ($step == 3): ?>
                    <div class="text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-check-circle text-primary" style="font-size: 56px;"></i>
                        </div>
                        <h2 class="mb-2">Password Reset Done!</h2>
                        <p class="subtitle mb-4">Your account password has been updated successfully. You can now login with your new password.</p>
                        
                        <a href="user_login.php" class="btn btn-primary w-100 py-3 fw-semibold rounded-pill text-white" style="color: #ffffff !important; display: block; text-align: center;">
                            <i class="fas fa-sign-in-alt me-1"></i> Go to Login
                        </a>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
