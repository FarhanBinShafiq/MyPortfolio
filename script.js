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