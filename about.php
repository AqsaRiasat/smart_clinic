<?php
session_start();
$page_title = "About Us - Smart Clinic";
$active_page = "about";
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
            <h1 class="display-4 fw-bold" data-aos="fade-up">About Us</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">About</li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- About Details Section -->
    <section class="about py-5" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="400">
                    <img src="images/about-image.jpg" alt="About Us" class="img-fluid rounded-4 shadow" loading="lazy">
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="400" data-aos-delay="100">
                    <h5 class="text-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">About Us</h5>
                    <h2 class="display-5 fw-bold mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                        Leading Healthcare Provider with Modern Technology</h2>
                    <p class="text-secondary mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                        Smart Clinic is a modern healthcare facility dedicated to providing exceptional medical care with
                        compassion and cutting-edge technology. Our team of experienced doctors and staff work
                        tirelessly to ensure every patient receives personalized attention and the best possible
                        treatment.
                    </p>

                    <div class="row g-4">
                        <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="50">
                            <div class="about-feature">
                                <i class="fas fa-user-md fa-2x text-primary mb-3"></i>
                                <h5>Expert Doctors</h5>
                                <p class="text-secondary">Board certified specialists</p>
                            </div>
                        </div>
                        <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="100">
                            <div class="about-feature">
                                <i class="fas fa-clock fa-2x text-primary mb-3"></i>
                                <h5>24/7 Service</h5>
                                <p class="text-secondary">Always here for you</p>
                            </div>
                        </div>
                        <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="150">
                            <div class="about-feature">
                                <i class="fas fa-calendar-check fa-2x text-primary mb-3"></i>
                                <h5>Easy Booking</h5>
                                <p class="text-secondary">Online appointments</p>
                            </div>
                        </div>
                        <div class="col-sm-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="200">
                            <div class="about-feature">
                                <i class="fas fa-heart fa-2x text-primary mb-3"></i>
                                <h5>Compassionate Care</h5>
                                <p class="text-secondary">Patient first approach</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="p-4 bg-white rounded-4 shadow h-100">
                        <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                        <h3>Our Mission</h3>
                        <p class="text-secondary">To provide accessible, high-quality healthcare services to every
                            patient with compassion, respect, and advanced medical technology.</p>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <div class="p-4 bg-white rounded-4 shadow h-100">
                        <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                        <h3>Our Vision</h3>
                        <p class="text-secondary">To be the leading healthcare provider known for excellence in patient
                            care, innovation, and community well-being.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
</body>

</html>