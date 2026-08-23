<?php
session_start();
include 'database/db.php';

$errors = [];

// Login Processing
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Form Validations
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

    // Authentication
    if (empty($errors)) {
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

        // Admin Authentication
        if ($clean_email == "admin@gmail.com") {
            if ($password == "admin123") {
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin.php");
                exit();
            } else {
                $errors[] = "Wrong password!";
            }
        } else {
            // Patient Authentication
            $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$clean_email'");
            
            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                
                if ($password == $user['password']) {
                    $_SESSION['patient_id'] = $user['id'];
                    $_SESSION['patient_name'] = $user['fullname'];
                    header("Location: index.php");
                    exit();
                } else {
                    $errors[] = "Wrong password!";
                }
            } else {
                $errors[] = "Email not found!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Smart Clinic</title>
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

        <!-- Login Form Panel -->
        <div class="split-right">
            <div class="form-wrapper">
                <div class="login-card">
                    <h2>Login</h2>
                    <p class="subtitle">Please enter your credentials to access your dashboard.</p>
                    
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

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="forgot_password.php" class="small text-primary text-decoration-none fw-semibold">Forgot Password?</a>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary w-100 mb-3">Login</button>
                        <p class="text-center mb-0 text-muted-custom">Don't have an account? <a href="signup.php">Signup here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>