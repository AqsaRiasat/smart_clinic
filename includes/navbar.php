<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-light" data-aos="fade-down" data-aos-duration="400">
    <div class="container-fluid px-lg-5 px-3">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-hospital-user"></i>
            Smart Clinic
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Navigation Links Centered on Desktop -->
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'home') ? 'active' : ''; ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'about') ? 'active' : ''; ?>" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'services') ? 'active' : ''; ?>" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'doctors') ? 'active' : ''; ?>" href="doctors.php">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'testimonials') ? 'active' : ''; ?>" href="testimonials.php">Testimonials</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo (isset($active_page) && $active_page == 'contact') ? 'active' : ''; ?>" href="contact.php">Contact</a>
                </li>
                
                <!-- Center Dashboard or Admin Panel links next to Contact when logged in -->
                <?php if (isset($_SESSION['admin_logged_in'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($active_page) && $active_page == 'admin') ? 'active' : ''; ?>" href="admin.php">Admin Panel</a>
                    </li>
                <?php elseif (isset($_SESSION['patient_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($active_page) && $active_page == 'dashboard') ? 'active' : ''; ?>" href="dashboard.php">Dashboard</a>
                    </li>
                <?php endif; ?>
            </ul>
            
            <!-- Action Buttons Right-Aligned on Desktop -->
            <ul class="navbar-nav ms-auto gap-2 mt-3 mt-lg-0">
                <!-- SESSION BUTTONS ONLY (ADMIN / PATIENT / GUEST) -->
                <?php if (isset($_SESSION['admin_logged_in'])): ?>
                    <li class="nav-item">
                        <a href="logout.php" class="btn btn-danger btn-sm rounded-pill">Logout</a>
                    </li>
                <?php elseif (isset($_SESSION['patient_id'])): ?>
                    <li class="nav-item">
                        <a href="appointment.php" class="btn btn-primary btn-sm rounded-pill">Book Now</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout_user.php" class="btn btn-danger btn-sm rounded-pill">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="appointment.php" class="btn btn-primary btn-sm rounded-pill">Book Now</a>
                    </li>
                    <li class="nav-item">
                        <a href="user_login.php" class="btn btn-outline-primary btn-sm rounded-pill">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="signup.php" class="btn btn-success btn-sm rounded-pill">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->
