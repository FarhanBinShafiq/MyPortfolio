document.addEventListener('DOMContentLoaded', () => {

    // 1. Highlight Active Link in Sidebar
    const currentPath = window.location.pathname.split('/').pop() || 'index.html';
    const sidebarLinks = document.querySelectorAll('.toc-link');

    sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // 2. Mobile Menu Toggle
    const toggleBtn = document.getElementById('mobileToggle');
    const menuOverlay = document.getElementById('mobileMenu');

    if (toggleBtn && menuOverlay) {
        toggleBtn.addEventListener('click', () => {
            menuOverlay.classList.toggle('open');
            const icon = toggleBtn.querySelector('i');
            if (menuOverlay.classList.contains('open')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // 3. 3D Tilt Effect (Desktop Only)
    const book = document.querySelector('.book-frame');
    const wrapper = document.querySelector('.book-wrapper');

    if (window.matchMedia("(min-width: 900px)").matches && book && wrapper) {
        wrapper.addEventListener('mousemove', (e) => {
            const x = e.clientX;
            const y = e.clientY;
            const midX = window.innerWidth / 2;
            const midY = window.innerHeight / 2;
            const rotateX = -((y - midY) / 60);
            const rotateY = (x - midX) / 60;
            book.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
        wrapper.addEventListener('mouseleave', () => {
            book.style.transform = `rotateX(0) rotateY(0)`;
        });
    }
});