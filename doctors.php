<?php
session_start();  
$page_title = "Our Doctors - Smart Clinic";
$active_page = "doctors";
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
            <h1 class="display-4 fw-bold" data-aos="fade-up">Our Doctors</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Doctors</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Doctors Showcase Section -->
    <section class="doctors py-5" id="doctors">
        <div class="container">
            <div class="row g-4">
                <!-- Doctor Card: Dr. Sarah Johnson -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in">
                    <div class="doctor-card">
                        <img src="images/team-11.jpeg" alt="Dr. Sarah Johnson" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Sarah Johnson</h4>
                            <p class="text-primary">Cardiologist</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. Michael Chen -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="100">
                    <div class="doctor-card">
                        <img src="images/team-12.jpeg" alt="Dr. Michael Chen" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Michael Chen</h4>
                            <p class="text-primary">General Physician</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. Emily White -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="150">
                    <div class="doctor-card">
                        <img src="images/team-13.jpeg" alt="Dr. Emily White" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Emily White</h4>
                            <p class="text-primary">Pediatrician</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. James Wilson -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="200">
                    <div class="doctor-card">
                        <img src="images/team-14.jpeg" alt="Dr. James Wilson" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. James Wilson</h4>
                            <p class="text-primary">Orthopedic Surgeon</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. Sarah Lee -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="400">
                    <div class="doctor-card">
                        <img src="images/team-18.jpeg" alt="Dr.Sarah Lee" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Sarah Lee</h4>
                            <p class="text-primary">Neurologist</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. Echael Brown -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="400">
                    <div class="doctor-card">
                        <img src="images/team-16.jpeg" alt="Dr. Michael Brown" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Echael Brown</h4>
                            <p class="text-primary">Dermatologist</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor Card: Dr. Emily Davis -->
                <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="300" data-aos-delay="500">
                    <div class="doctor-card">
                        <img src="images/team-17.jpeg" alt="Dr. Emily Davis" class="img-fluid" loading="lazy">
                        <div class="doctor-info">
                            <h4>Dr. Emily Davis</h4>
                            <p class="text-primary">Laboratory Specialist</p>
                            <div class="doctor-social">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
</body>

</html>