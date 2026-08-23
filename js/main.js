// Initialize AOS Animation Library (if loaded)
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 600,
        once: true,
        offset: 20
    });
}

// Navbar Scroll Effect
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// Mobile Navbar Toggle & Collapse Handler
document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.querySelector('.navbar-toggler');
    const menu = document.getElementById('navbarNav');
    
    if (toggler && menu) {
        toggler.addEventListener('click', function(e) {
            e.preventDefault();
            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(menu);
            if (menu.classList.contains('show')) {
                bsCollapse.hide();
            } else {
                bsCollapse.show();
            }
        });
        
        menu.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992 && menu.classList.contains('show')) {
                    const bsCollapse = bootstrap.Collapse.getInstance(menu);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    }
});

// Smooth Scrolling for In-Page Anchor Links
document.querySelectorAll('a[href^="#"]:not([data-bs-toggle])').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href.length > 1) {
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Global Appointment Cancellation Popup Handlers
showCancelPopup = function(id) {
    var btn = document.getElementById('confirmCancelBtn');
    if (btn) {
        btn.href = '?cancel_id=' + id;
    }
    var popup = document.getElementById('cancelPopup');
    var overlay = document.getElementById('popupOverlay');
    if (popup) popup.style.display = 'block';
    if (overlay) overlay.style.display = 'block';
};

hideCancelPopup = function() {
    var popup = document.getElementById('cancelPopup');
    var overlay = document.getElementById('popupOverlay');
    if (popup) popup.style.display = 'none';
    if (overlay) overlay.style.display = 'none';
};