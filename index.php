<?php
session_start();

$page_title = "Smart Clinic - Healthcare";
$active_page = "home";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'includes/header.php'; ?>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-blend"></div>

        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 hero-content">
                    <h5 class="text-primary" data-aos="fade-up" data-aos-duration="400" data-aos-delay="50">Welcome to Smart Clinic</h5>
                    <h1 class="display-4 fw-bold" data-aos="fade-up" data-aos-duration="400" data-aos-delay="100">Your Health Is Our <span class="text-primary">Priority</span></h1>
                    <p class="lead" data-aos="fade-up" data-aos-duration="400" data-aos-delay="150">Book appointments with top doctors instantly. Get quality healthcare from the comfort of your home.</p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-duration="400" data-aos-delay="200">
                        <a href="appointment.php" class="btn btn-primary btn-lg rounded-pill me-3">Book Appointment</a>
                        <a href="about.php" class="btn btn-outline-primary btn-lg rounded-pill">Learn More</a>
                    </div>
                    <div class="hero-stats mt-5" data-aos="fade-up" data-aos-duration="400" data-aos-delay="250">
                        <div class="row">
                            <div class="col-4">
                                <h3 class="text-primary">50+</h3>
                                <p>Expert Doctors</p>
                            </div>
                            <div class="col-4">
                                <h3 class="text-primary">10k+</h3>
                                <p>Happy Patients</p>
                            </div>
                            <div class="col-4">
                                <h3 class="text-primary">24/7</h3>
                                <p>Support</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="400" data-aos-delay="100">
                    <img src="images/hero-image.png" alt="Doctor" class="img-fluid" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- About Overview Section -->
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

    <!-- Services Overview Section -->
    <section class="services py-5 bg-light" id="services">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="400">
                <h5 class="text-primary">Our Services</h5>
                <h2 class="display-5 fw-bold">Comprehensive Medical Care</h2>
                <p class="text-secondary">We offer a wide range of medical services to meet all your healthcare needs.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="50">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h4>General Consultation</h4>
                        <p>Professional consultation for routine checkups, common illnesses, and preventive healthcare support.</p>
                        <a href="services.php" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="100">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h4>Cardiology</h4>
                        <p>Complete heart care including diagnostics, monitoring, and advanced cardiology treatment.</p>
                        <a href="services.php" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="150">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4>Pediatrics</h4>
                        <p>Specialized healthcare for infants, children, and adolescents with compassionate support.</p>
                        <a href="services.php" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="flip-left" data-aos-duration="300" data-aos-delay="200">
                    <div class="service-card">
                        <div class="icon-box">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4>Laboratory</h4>
                        <p>Accurate laboratory testing with modern equipment and fast, reliable diagnostic reports.</p>
                        <a href="services.php" class="btn-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5" data-aos="fade-up" data-aos-duration="300" data-aos-delay="250">
                <a href="services.php" class="btn btn-primary btn-lg rounded-pill">View All Services</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Features Section -->
    <section class="features py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="400">
                    <h5 class="text-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Why Choose Us</h5>
                    <h2 class="display-5 fw-bold mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">Making Healthcare Better, Together</h2>
                    <p class="text-secondary mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">We combine medical expertise with compassionate care to provide the best possible experience for our patients.</p>

                    <div class="feature-list">
                        <div class="feature-item d-flex mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                            <div class="feature-icon me-4">
                                <i class="fas fa-check-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Qualified Doctors</h5>
                                <p class="text-secondary mb-0">Experienced and board-certified specialists.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                            <div class="feature-icon me-4">
                                <i class="fas fa-check-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Modern Equipment</h5>
                                <p class="text-secondary mb-0">Latest medical technology for accurate diagnosis.</p>
                            </div>
                        </div>
                        <div class="feature-item d-flex mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                            <div class="feature-icon me-4">
                                <i class="fas fa-check-circle fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Emergency Care</h5>
                                <p class="text-secondary mb-0">24/7 emergency services available.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="400" data-aos-delay="100">
                    <img src="images/feature-image.jpg" alt="Features" class="img-fluid rounded-4 shadow" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Overview Section -->
    <section class="doctors py-5 bg-light" id="doctors">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="400">
                <h5 class="text-primary">Our Doctors</h5>
                <h2 class="display-5 fw-bold">Meet Our Specialist Team</h2>
                <p class="text-secondary">Highly qualified and experienced medical professionals.</p>
            </div>

            <div class="row g-4">
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
            </div>
        </div>
    </section>

    <!-- Quick Appointment Section -->
    <section class="appointment py-5" id="appointment">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="400">
                    <h5 class="text-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Book Appointment</h5>
                    <h2 class="display-5 fw-bold mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">Schedule Your Visit Today</h2>
                    <p class="text-secondary mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">Fill out the form and we'll contact you to confirm your appointment. It's quick and easy!</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="400" data-aos-delay="100">
                    <div class="appointment-form p-4 p-lg-5">
                        <h3 class="mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Book Your Appointment</h3>
                        <form action="appointment.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                                    <input type="text" class="form-control" name="u_name" placeholder="Full Name" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="75">
                                    <input type="email" class="form-control" name="u_email" placeholder="Email Address" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                                    <input type="tel" class="form-control" name="u_phone" placeholder="Phone Number" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="125">
                                    <select name="u_dept" class="form-select" required>
                                        <option selected>Select Department</option>
                                        <option>Cardiology</option>
                                        <option>General Medicine</option>
                                        <option>Pediatrics</option>
                                        <option>Orthopedics</option>
                                    </select>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                                    <input type="date" name="u_date" class="form-control" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="175">
                                    <select name="u_time" class="form-select" required>
                                        <option selected>Select Time</option>
                                        <option>9:00 AM</option>
                                        <option>10:00 AM</option>
                                        <option>11:00 AM</option>
                                        <option>2:00 PM</option>
                                        <option>3:00 PM</option>
                                        <option>4:00 PM</option>
                                    </select>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-duration="300" data-aos-delay="200">
                                    <textarea class="form-control" rows="4" name="u_message" placeholder="Message (Optional)"></textarea>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-duration="300" data-aos-delay="225">
                                    <button type="submit" name="submit_appointment" class="btn btn-primary w-100 py-3">Book Appointment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Overview Section -->
    <section class="testimonials py-5 bg-light" id="testimonials">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="400">
                <h5 class="text-primary">Testimonials</h5>
                <h2 class="display-5 fw-bold">What Our Patients Say</h2>
                <p class="text-secondary">Read what our patients have to say about their experience at Smart Clinic.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Excellent service! The online booking system is so easy to use. I got an appointment within minutes."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-1.jpg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ahmed Khan</h5>
                                <p class="text-secondary mb-0">Karachi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"Very impressed with the facilities and staff. The digital health records system is a game changer."</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-2.jpeg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ayesha Malik</h5>
                                <p class="text-secondary mb-0">Lahore</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                    <div class="testimonial-card">
                        <div class="testimonial-rating mb-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                        <p class="testimonial-text">"The doctors here are truly experts. My surgery went smoothly and the follow-up care was excellent. Highly recommended!"</p>
                        <div class="testimonial-author d-flex align-items-center">
                            <img src="images/testimonial-3.jpg" alt="Patient" class="rounded-circle me-3" width="60" loading="lazy">
                            <div>
                                <h5 class="mb-1">Ali Raza</h5>
                                <p class="text-secondary mb-0">Islamabad</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Overview Section -->
    <section class="contact py-5" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="400">
                    <h5 class="text-primary" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Contact Us</h5>
                    <h2 class="display-5 fw-bold mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">Get In Touch</h2>
                    <p class="text-secondary mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">Have questions? We're here to help. Send us a message and we'll respond as soon as possible.</p>

                    <div class="contact-info">
                        <div class="d-flex mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Visit Us</h5>
                                <p class="text-secondary mb-0">123 Medical Zone, Hyderabad, Pakistan</p>
                            </div>
                        </div>
                        <div class="d-flex mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                            <div class="contact-icon me-3">
                                <i class="fas fa-phone-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Call Us</h5>
                                <p class="text-secondary mb-0">+92 22 1234567</p>
                                <p class="text-secondary mb-0">+92 300 9876543</p>
                            </div>
                        </div>
                        <div class="d-flex" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                            <div class="contact-icon me-3">
                                <i class="fas fa-envelope fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Email Us</h5>
                                <p class="text-secondary mb-0">info@smartclinic.com</p>
                                <p class="text-secondary mb-0">support@smartclinic.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="400" data-aos-delay="100">
                    <div class="contact-form p-4 p-lg-5">
                        <h3 class="mb-4" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">Send Message</h3>
                        
                        <!-- AJAX Alert Box -->
                        <div id="home-contact-alert"></div>

                        <form id="homeContactForm" action="contact.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="50">
                                    <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6" data-aos="fade-up" data-aos-duration="300" data-aos-delay="75">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-duration="300" data-aos-delay="100">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-duration="300" data-aos-delay="125">
                                    <textarea class="form-control" rows="5" name="message" placeholder="Your Message" required></textarea>
                                </div>
                                <div class="col-12" data-aos="fade-up" data-aos-duration="300" data-aos-delay="150">
                                    <button type="submit" name="send_message" id="homeContactBtn" class="btn btn-primary w-100 py-3">
                                        <i class="fas fa-paper-plane me-1"></i> Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>

    <!-- AJAX Contact Form Script -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const hForm = document.getElementById("homeContactForm");
        const hAlert = document.getElementById("home-contact-alert");
        const hBtn = document.getElementById("homeContactBtn");

        if (hForm) {
            hForm.addEventListener("submit", function(e) {
                e.preventDefault();
                hBtn.disabled = true;
                hBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Sending...';

                fetch("ajax/ajax_contact.php", {
                    method: "POST",
                    body: new FormData(hForm)
                })
                .then(res => res.json())
                .then(data => {
                    hBtn.disabled = false;
                    hBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Send Message';

                    if (data.status === "success") {
                        hAlert.innerHTML = `
                            <div class="alert alert-success d-flex align-items-center mb-4 shadow-sm" style="border-radius: 12px; background: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.25); color: #0d6efd;">
                                <i class="fas fa-check-circle fs-4 me-2"></i>
                                <div><strong>Success!</strong> ${data.message}</div>
                            </div>
                        `;
                        hForm.reset();
                    } else {
                        let errorMsg = data.errors ? data.errors.join("<br>") : "Failed to send message.";
                        hAlert.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center mb-4 shadow-sm" style="border-radius: 12px;">
                                <i class="fas fa-exclamation-circle fs-4 me-2 text-danger"></i>
                                <div><strong>Error:</strong><br>${errorMsg}</div>
                            </div>
                        `;
                    }
                })
                .catch(() => {
                    hBtn.disabled = false;
                    hBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Send Message';
                    hAlert.innerHTML = `
                        <div class="alert alert-danger mb-4" style="border-radius: 12px;">
                            Network error. Please try again.
                        </div>
                    `;
                });
            });
        }
    });
    </script>
</body>

</html>