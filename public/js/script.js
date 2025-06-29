//Button
const toggler = document.querySelector('.toggler-btn');

// Sidebar Elements
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebar-overlay');

// Toggle sidebar when clicking button
toggler.addEventListener('click', function () {
    sidebar.classList.toggle('toggle');
    if (window.innerWidth <= 768) {
        sidebarOverlay.classList.toggle('active');
    }
});

sidebarOverlay.addEventListener('click', function () {
    sidebar.classList.remove('toggle');
    sidebarOverlay.classList.remove('active');
});






