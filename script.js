document.addEventListener('DOMContentLoaded', () => {
    // 1. Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === "ArrowRight" && typeof nextPageUrl !== 'undefined' && nextPageUrl) window.location.href = nextPageUrl;
        if (e.key === "ArrowLeft" && typeof prevPageUrl !== 'undefined' && prevPageUrl) window.location.href = prevPageUrl;
    });

    // 2. Touch Swipe Navigation
    let touchStartX = 0;
    const frame = document.body;
    frame.addEventListener('touchstart', e => touchStartX = e.changedTouches[0].screenX);
    frame.addEventListener('touchend', e => {
        let touchEndX = e.changedTouches[0].screenX;
        // Swipe Left -> Next Page
        if (touchEndX < touchStartX - 50 && typeof nextPageUrl !== 'undefined' && nextPageUrl) window.location.href = nextPageUrl;
        // Swipe Right -> Prev Page
        if (touchEndX > touchStartX + 50 && typeof prevPageUrl !== 'undefined' && prevPageUrl) window.location.href = prevPageUrl;
    });

    // 3. Mobile Menu Toggle
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
});

// ... inside existing DOMContentLoaded ...

// 4. 3D Tilt Effect (Mouse Interaction)
const book = document.querySelector('.book-frame');
const wrapper = document.querySelector('.book-wrapper');

if (window.matchMedia("(min-width: 900px)").matches) {
    wrapper.addEventListener('mousemove', (e) => {
        const x = e.clientX;
        const y = e.clientY;

        // Calculate center of screen
        const midX = window.innerWidth / 2;
        const midY = window.innerHeight / 2;

        // Calculate rotation (Divide by 25 to keep effect subtle)
        const rotateX = -((y - midY) / 45);
        const rotateY = (x - midX) / 45;

        // Apply transformation
        book.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;

        // Dynamic Shadow (Shadow moves opposite to light source)
        const shadowX = (x - midX) / 10;
        const shadowY = (y - midY) / 10;
        book.style.boxShadow = `${-shadowX}px ${-shadowY + 30}px 70px rgba(0,0,0,0.5)`;
    });

    // Reset when mouse leaves
    wrapper.addEventListener('mouseleave', () => {
        book.style.transform = `rotateX(0) rotateY(0)`;
        book.style.boxShadow = `0 30px 70px rgba(0, 0, 0, 0.6)`;
    });
}


// ... inside existing DOMContentLoaded ...

// 5. Highlight Active Link in Sidebar
const currentPath = window.location.pathname;
const sidebarLinks = document.querySelectorAll('.toc-link');

sidebarLinks.forEach(link => {
    // If the link's href matches the current URL
    if (link.getAttribute('href') === currentPath.split('/').pop()) {
        link.classList.add('active');
    }
});