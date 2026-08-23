<?php
session_start();
include 'database/db.php';

// Contact Message Submission (Non-JS Fallback)
if (isset($_POST['send_message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $fields = ['name', 'email', 'subject', 'message'];
    $clean = [];
    foreach ($fields as $field) {
        $val = $$field;
        $clean_val = "";
        $val_len = 0;
        while (isset($val[$val_len])) {
            $val_len++;
        }
        for ($i = 0; $i < $val_len; $i++) {
            if ($val[$i] == "'") {
                $clean_val .= "\\'";
            } else {
                $clean_val .= $val[$i];
            }
        }
        $clean[$field] = $clean_val;
    }

    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('{$clean['name']}', '{$clean['email']}', '{$clean['subject']}', '{$clean['message']}')";

    if (mysqli_query($conn, $sql)) {
        header("Location: contact.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$page_title = "Contact - Smart Clinic";
$active_page = "contact";
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
            <h1 class="display-4 fw-bold" data-aos="fade-up">Contact Us</h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Success Popup Notification (Fallback) -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="success-popup">
        <i class="fas fa-check-circle"></i>
        <h4>Thank You!</h4>
        <p>Aapka message mil gaya hai, shukriya!</p>
        <button onclick="window.location.href='contact.php'">OK</button>
    </div>
    <div class="popup-overlay" onclick="window.location.href='contact.php'"></div>
    <?php endif; ?>

    <!-- Contact Details & Form Section -->
    <section class="contact py-5" id="contact">
        <div class="container">
            <div class="row">
                <!-- Contact Information Column -->
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h5 class="text-primary">Contact Us</h5>
                    <h2 class="display-5 fw-bold mb-4">Get In Touch</h2>
                    <p class="text-secondary mb-4">Have questions? We're here to help.</p>

                    <div class="contact-info">
                        <div class="d-flex mb-4">
                            <div class="contact-icon me-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h5>Visit Us</h5>
                                <p class="text-secondary mb-0">123 Medical Zone, Gulshan-e-Iqbal, Karachi, Pakistan</p>
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

                <!-- Contact Message Form Column -->
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="contact-form p-4 p-lg-5">
                        <h3 class="mb-4">Send Message</h3>
                        
                        <!-- AJAX Live Alert Container -->
                        <div id="contact-ajax-alert"></div>

                        <form id="contactForm" action="contact.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="c_name" placeholder="Your Name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" id="c_email" placeholder="Your Email" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="subject" id="c_subject" placeholder="Subject" required>
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="5" name="message" id="c_message" placeholder="Your Message" required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="send_message" id="contactSubmitBtn" class="btn btn-primary w-100 py-3">
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

    <!-- Google Maps Section -->
    <section class="map py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14476.326240092776!2d67.07849646877995!3d24.895183359672688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33ed404c00001%3A0x6b44a4f1073fbcf!2sGulshan-e-Iqbal%2C%20Karachi!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" width="100%" height="450"
                        style="border:0; border-radius: 20px;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/scripts.php'; ?>

    <!-- AJAX Form Submission Script -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("contactForm");
        const alertBox = document.getElementById("contact-ajax-alert");
        const submitBtn = document.getElementById("contactSubmitBtn");

        if (form) {
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Sending...';

                fetch("ajax/ajax_contact.php", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Send Message';

                    if (data.status === "success") {
                        alertBox.innerHTML = `
                            <div class="alert alert-success d-flex align-items-center mb-4 shadow-sm" role="alert" style="border-radius: 12px; background: rgba(13, 110, 253, 0.08); border: 1px solid rgba(13, 110, 253, 0.25); color: #0d6efd;">
                                <i class="fas fa-check-circle fs-4 me-2"></i>
                                <div><strong>Success!</strong> ${data.message}</div>
                            </div>
                        `;
                        form.reset();
                    } else {
                        let errorMsg = data.errors ? data.errors.join("<br>") : "Something went wrong.";
                        alertBox.innerHTML = `
                            <div class="alert alert-danger d-flex align-items-center mb-4 shadow-sm" role="alert" style="border-radius: 12px;">
                                <i class="fas fa-exclamation-circle fs-4 me-2 text-danger"></i>
                                <div><strong>Error:</strong><br>${errorMsg}</div>
                            </div>
                        `;
                    }
                })
                .catch(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Send Message';
                    alertBox.innerHTML = `
                        <div class="alert alert-danger mb-4" style="border-radius: 12px;">
                            An error occurred while sending your message. Please try again.
                        </div>
                    `;
                });
            });
        }
    });
    </script>
</body>

</html>