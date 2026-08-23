// Dark Mode / Light Mode Theme Toggle Controller
function initThemeToggle() {
    const toggleButtons = document.querySelectorAll('.theme-toggle-btn');
    
    function updateToggleButtons() {
        const isDark = document.documentElement.classList.contains('dark-mode');
        toggleButtons.forEach((btn) => {
            const icon = btn.querySelector('.theme-toggle-icon');
            const text = btn.querySelector('.theme-toggle-text');
            
            if (isDark) {
                if (icon) {
                    icon.className = 'fas fa-sun theme-toggle-icon';
                    icon.style.color = '#ffc107';
                }
                if (text) {
                    text.textContent = 'Light Mode';
                }
            } else {
                if (icon) {
                    icon.className = 'fas fa-moon theme-toggle-icon';
                    icon.style.color = '';
                }
                if (text) {
                    text.textContent = 'Dark Mode';
                }
            }
        });
    }
    
    // Initial State Sync
    updateToggleButtons();
    
    // Toggle Event Binding
    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const isDark = document.documentElement.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateToggleButtons();
        });
    });
}

// DOM Initialization
if (document.readyState !== 'loading') {
    initThemeToggle();
} else {
    document.addEventListener('DOMContentLoaded', initThemeToggle);
}
