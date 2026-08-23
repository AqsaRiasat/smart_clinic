<?php
session_start();  
$page_title = "Testimonials - Smart Clinic";
$active_page = "testimonials";
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
            <h1 class="display-4 fw-bold" data-aos="fade-up">Patient Testimonials</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Testimonials</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Testimonials Grid Section -->
    <section class="testimonials py-5">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="400">
                <h5 class="text-primary">Testimonials</h5>
                <h2 class="display-5 fw-bold">What Our Patients Say</h2>
                <p class="text-secondary">Read what our patients have to say about their experience at Smart Clinic.</p>
            </div>

            <div class="row g-4">
                <!-- Testimonial: Ahmed Khan -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Excellent service! The online booking system is so easy to use. I got an appointment within minutes. The doctor was very professional and friendly."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-1.jpg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ahmed Khan</h5>
                                <p class="text-secondary mb-0">Karachi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial: Ayesha Malik -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Very impressed with the facilities and staff. The digital health records system is a game changer. Highly recommend Smart Clinic to everyone."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-2.jpeg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ayesha Malik</h5>
                                <p class="text-secondary mb-0">Lahore</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial: Ali Raza -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The doctors here are truly experts. My surgery went smoothly and the follow-up care was excellent. The staff is very supportive and caring."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-3.jpg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ali Raza</h5>
                                <p class="text-secondary mb-0">Islamabad</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial: Sana Farooq -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Great experience from start to finish. The online consultation saved me time and money. Doctor listened to all my concerns patiently."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-4.jpeg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Sana Farooq</h5>
                                <p class="text-secondary mb-0">Hyderabad</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial: Fatima Akhtar -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The pediatric department is amazing. My child feels comfortable here. The doctors are very gentle and explain everything clearly."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-5.jpeg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Fatima Akhtar</h5>
                                <p class="text-secondary mb-0">Karachi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial: Bilal Ahmed -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Affordable and quality healthcare. The laboratory tests are accurate and reports come quickly. I trust Smart Clinic completely."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-6.jpeg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Bilal Ahmed</h5>
                                <p class="text-secondary mb-0">Lahore</p>
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