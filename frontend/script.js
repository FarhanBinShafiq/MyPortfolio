document.addEventListener("DOMContentLoaded", () => {

    // =========================================
    // 1. MOBILE MENU TOGGLE LOGIC (Centralized)
    // =========================================
    const toggleBtn = document.getElementById('mobileToggle');
    const menuOverlay = document.getElementById('mobileMenu');

    // Only run if elements exist on the page
    if (toggleBtn && menuOverlay) {
        // Find the icon element inside the button
        const toggleIcon = toggleBtn.querySelector('i');

        toggleBtn.addEventListener('click', () => {
            // Toggle the 'open' class defined in style.css
            // The toggle() method returns true if the class is added, false if removed
            const isOpen = menuOverlay.classList.toggle('open');

            // Swap the icon based on the menu state
            if (isOpen) {
                // Menu is now open, show 'X' icon
                toggleIcon.classList.remove('fa-bars');
                toggleIcon.classList.add('fa-times');
            } else {
                // Menu is now closed, show hamburger icon
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
            }
        });
    }


    // =========================================
    // 2. ACTIVE LINK HIGHLIGHTING
    // =========================================
    const currentPath = window.location.pathname.split("/").pop() || "index.html";

    // Target both sidebar links AND mobile menu links
    const navLinks = document.querySelectorAll('.left-sidebar .toc-link, .mobile-menu-overlay .mobile-link');

    navLinks.forEach(link => {
        // Strip any query params for comparison if necessary, usually href is fine here
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });


    // =========================================
    // 3. DESKTOP 3D TILT EFFECT
    // =========================================
    if (window.innerWidth > 900) {
        const bookFrame = document.querySelector(".book-frame");
        const bookWrapper = document.querySelector(".book-wrapper");

        if (bookFrame && bookWrapper) {
            bookWrapper.addEventListener("mousemove", (e) => {
                let xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                let yAxis = (window.innerHeight / 2 - e.pageY) / 25;
                bookFrame.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            });

            bookWrapper.addEventListener("mouseleave", () => {
                bookFrame.style.transform = `rotateY(0deg) rotateX(0deg)`;
            });
        }
    }
});