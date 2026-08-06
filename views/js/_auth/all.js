import Ctr from "../../code/src/mods/ctr";

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mainWrapper = document.getElementById('mainWrapper');

    // Check if mobile
    const isMobile = window.innerWidth <= 992;

    if (isMobile) {
        // Mobile: toggle sidebar open/close
        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('show');
        // Prevent body scroll
        document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    } else {
        // Desktop: toggle collapsed state
        sidebar.classList.toggle('collapsed');
        mainWrapper.classList.toggle('expanded');
    }
}

Ctr.click(".toogleSideBar", ()=>{
    toggleSidebar();
});

// Close sidebar on resize from mobile to desktop
window.addEventListener('resize', function () {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mainWrapper = document.getElementById('mainWrapper');

    if (window.innerWidth > 992) {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
        // Restore desktop state
        if (sidebar.classList.contains('collapsed')) {
            mainWrapper.classList.add('expanded');
        } else {
            mainWrapper.classList.remove('expanded');
        }
    }
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function (e) {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');
    const isMobile = window.innerWidth <= 992;

    if (isMobile && sidebar.classList.contains('mobile-open')) {
        if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
            toggleSidebar();
        }
    }
});

// Handle dropdown toggle for avatar
document.querySelector('.nav-avatar')?.addEventListener('click', function (e) {
    e.stopPropagation();
    const dropdown = this.nextElementSibling;
    if (dropdown) {
        dropdown.classList.toggle('show');
    }
});

// Close dropdown on outside click
document.addEventListener('click', function (e) {
    document.querySelectorAll('.dropdown-menu.show').forEach(function (dropdown) {
        if (!dropdown.previousElementSibling?.contains(e.target)) {
            dropdown.classList.remove('show');
        }
    });
});
document.addEventListener('keydown', function (e) {
    if (e.ctrlKey && e.key === 'b') {
        e.preventDefault();
        toggleSidebar();
    }
});