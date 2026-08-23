    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation Library JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script src="js/main.js"></script>

    <?php if (isset($_SESSION['admin_logged_in']) || isset($_SESSION['patient_id'])): ?>
        <script src="js/theme-toggle.js"></script>
    <?php endif; ?>

