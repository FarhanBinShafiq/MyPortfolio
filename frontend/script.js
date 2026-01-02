document.addEventListener("DOMContentLoaded", () => {
    // 1. MOBILE MENU TOGGLE
    const toggleBtn = document.getElementById('mobileToggle');
    const menuOverlay = document.getElementById('mobileMenu');

    if (toggleBtn && menuOverlay) {
        const toggleIcon = toggleBtn.querySelector('i');
        toggleBtn.addEventListener('click', () => {
            const isOpen = menuOverlay.classList.toggle('open');
            toggleIcon.className = isOpen ? 'fas fa-times' : 'fas fa-bars';
        });
    }

    // 2. ACTIVE LINK HIGHLIGHTING
    const currentPath = window.location.pathname.split("/").pop() || "index.html";
    const navLinks = document.querySelectorAll('.left-sidebar .toc-link, .mobile-menu-overlay .mobile-link');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) link.classList.add('active');
    });

    // 3. DESKTOP 3D TILT EFFECT
    if (window.innerWidth > 900) {
        const bookFrame = document.querySelector(".book-frame");
        const bookWrapper = document.querySelector(".book-wrapper");

        if (bookFrame && bookWrapper) {
            bookWrapper.addEventListener("mousemove", (e) => {
                let xAxis = (window.innerWidth / 2 - e.pageX) / 30;
                let yAxis = (window.innerHeight / 2 - e.pageY) / 30;
                bookFrame.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });

            bookWrapper.addEventListener("mouseleave", () => {
                bookFrame.style.transform = `rotateY(0deg) rotateX(0deg)`;
            });
        }
    }
});