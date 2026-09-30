/**
 * DebugTIK Dashboard Logic
 * Auth & Dashboard interactions
 */

// Mode toggle (dark/light)
document.addEventListener('DOMContentLoaded', () => {
    const modeToggle = document.querySelector('[data-mode-toggle]');
    
    if (modeToggle) {
        modeToggle.addEventListener('click', () => {
            const currentMode = document.documentElement.getAttribute('data-theme') || 'light';
            const newMode = currentMode === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newMode);
            localStorage.setItem('debugtik-theme', newMode);
        });
    }

    // Sidebar active link highlight
    const sidebarLinks = document.querySelectorAll('[data-path]');
    const currentPath = window.location.pathname;

    sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath || 
            (currentPath.includes('dashboard') && link.getAttribute('data-path') === 'dasbor-guru')) {
            link.classList.add('bg-primary-container', 'text-on-primary-container', 'font-semibold', 'shadow-sm');
            link.classList.remove('text-on-surface-variant');
        }
    });

    // Search input focus handling
    const searchInput = document.querySelector('input[placeholder="Cari siswa, materi, modul..."]');
    if (searchInput) {
        searchInput.addEventListener('focus', () => {
            searchInput.parentElement.classList.add('ring-2', 'ring-primary');
        });
        searchInput.addEventListener('blur', () => {
            searchInput.parentElement.classList.remove('ring-2', 'ring-primary');
        });
    }

    // Notification badge click
    const notificationBtn = document.querySelector('button[type="button"][aria-label="Notifications"]');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', () => {
            alert('Notifications clicked - to be implemented');
        });
    }
});

// Export for potential external use
export { };
