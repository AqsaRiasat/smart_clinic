<?php
include 'database/db.php';

$errors = [];

// Signup Processing
if (isset($_POST['signup'])) {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Form Validations
    if ($name == "") {
        $errors[] = "Full name is required!";
    } else {
        $name_len = 0;
        $valid_name = true;
        while (isset($name[$name_len])) {
            $ch = $name[$name_len];
            if (($ch >= 'a' && $ch <= 'z') || ($ch >= 'A' && $ch <= 'Z') || $ch == ' ') {
            } else {
                $valid_name = false;
            }
            $name_len++;
        }
        if ($name_len < 3) {
            $errors[] = "Name must be at least 3 characters!";
        } elseif ($valid_name == false) {
            $errors[] = "Name can only contain letters and spaces!";
        }
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
    
    if ($password == "") {
        $errors[] = "Password is required!";
    } else {
        $pwd_length = 0;
        while (isset($password[$pwd_length])) {
            $pwd_length++;
        }
        if ($pwd_length < 6) {
            $errors[] = "Password must be at least 6 characters!";
        }
    }

    // Account Creation
    if (empty($errors)) {
        $clean_name = "";
        $n_len = 0;
        while (isset($name[$n_len])) {
            $n_len++;
        }
        for ($i = 0; $i < $n_len; $i++) {
            if ($name[$i] == "'") {
                $clean_name .= "\\'";
            } else {
                $clean_name .= $name[$i];
            }
        }

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
        
        // Email Uniqueness Check
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$clean_email'");
        if (mysqli_num_rows($check) > 0) {
            $errors[] = "Email already registered!";
        } else {
            $sql = "INSERT INTO users (fullname, email, password) VALUES ('$clean_name', '$clean_email', '$password')";
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('Account created successfully! Please login.'); window.location='user_login.php';</script>";
            } else {
                $errors[] = "Registration failed!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Smart Clinic</title>
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
                <h2>Modern Healthcare <br><strong>Just For You</strong></h2>
                <p>Access top specialist doctors, book instantly, and manage your health records in one secure place.</p>
                
                <div class="features-list mt-5">
                    <div class="feature-item-small mb-3 d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Easy Online Doctor Appointments</span>
                    </div>
                    <div class="feature-item-small mb-3 d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>24/7 Digital Dashboard Access</span>
                    </div>
                    <div class="feature-item-small d-flex align-items-center gap-3">
                        <div class="icon-wrap bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink:0;">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Secure Patient Portal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signup Form Panel -->
        <div class="split-right">
            <div class="form-wrapper">
                <div class="signup-card">
                    <h2>Sign Up</h2>
                    <p class="subtitle">Please fill in the details to create your account.</p>
                    
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

                    <form method="POST" id="signupForm">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" id="signup_email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required autocomplete="off">
                            <div id="email-ajax-msg" class="mt-1" style="font-size: 13px; font-weight: 500;"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="signup" id="submitBtn" class="btn btn-primary w-100 mb-3">Create Account</button>
                        <p class="text-center mb-0 text-muted-custom">Already have an account? <a href="user_login.php">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
    
    <!-- AJAX Live Email Availability Checker -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('signup_email');
        const emailMsg = document.getElementById('email-ajax-msg');
        const submitBtn = document.getElementById('submitBtn');
        let debounceTimer;

        if (emailInput && emailMsg) {
            emailInput.addEventListener('input', function() {
                const emailVal = this.value.trim();
                clearTimeout(debounceTimer);

                if (emailVal.length < 3 || emailVal.indexOf('@') === -1) {
                    emailMsg.innerHTML = '';
                    emailInput.style.borderColor = '';
                    if (submitBtn) submitBtn.disabled = false;
                    return;
                }

                emailMsg.innerHTML = '<span class="text-muted"><i class="fas fa-spinner fa-spin me-1"></i> Checking availability...</span>';

                debounceTimer = setTimeout(function() {
                    fetch('ajax/ajax_check_email.php?email=' + encodeURIComponent(emailVal))
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'taken') {
                                emailMsg.innerHTML = '<span class="text-danger"><i class="fas fa-times-circle me-1"></i> ' + data.message + '</span>';
                                emailInput.style.borderColor = '#dc3545';
                                if (submitBtn) submitBtn.disabled = true;
                            } else if (data.status === 'available') {
                                emailMsg.innerHTML = '<span class="text-primary"><i class="fas fa-check-circle me-1"></i> ' + data.message + '</span>';
                                emailInput.style.borderColor = '#0d6efd';
                                if (submitBtn) submitBtn.disabled = false;
                            } else {
                                emailMsg.innerHTML = '';
                                emailInput.style.borderColor = '';
                                if (submitBtn) submitBtn.disabled = false;
                            }
                        })
                        .catch(() => {
                            emailMsg.innerHTML = '';
                            if (submitBtn) submitBtn.disabled = false;
                        });
                }, 400);
            });
        }
    });
    </script>
</body>
</html>