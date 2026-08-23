<?php
session_start();  
$page_title = "Services - Smart Clinic";
$active_page = "services";
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
            <h1 class="display-4 fw-bold" data-aos="fade-up">Our Services</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Services Grid Section -->
    <section class="services py-5" id="services">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h5 class="text-primary">Our Services</h5>
                <h2 class="display-5 fw-bold">Comprehensive Medical Care</h2>
                <p class="text-secondary">We offer a wide range of medical services to meet all your healthcare needs.</p>
            </div>

            <div class="row g-4">
                <!-- General Consultation -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="50">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h4>General Consultation</h4>
                        <p>Professional consultation for routine checkups and common illnesses.</p>
                        <a href="appointment.php" class="btn-link">Book Now <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Cardiology -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="100">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h4>Cardiology</h4>
                        <p>Complete heart care including diagnostics, monitoring, and treatment.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Pediatrics -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="150">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4>Pediatrics</h4>
                        <p>Specialized healthcare for infants, children, and adolescents with support.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Laboratory -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="200">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4>Laboratory</h4>
                        <p>Accurate laboratory testing with modern equipment and fast, diagnostic reports.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Neurology -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="250">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Neurology</h4>
                        <p>Expert care for brain, spine, and nervous system disorders with advanced diagnostic technology.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Orthopedic -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="300">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-bone"></i>
                        </div>
                        <h4>Orthopedic</h4>
                        <p>Comprehensive treatment for bone, joint, and muscle problems including sports injuries.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Dermatology -->
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="350">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-allergies"></i>
                        </div>
                        <h4>Dermatology</h4>
                        <p>Specialized skin care for acne, eczema, allergies, and other skin conditions treatment available.</p>
                        <a href="#" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>
</body>

</html>