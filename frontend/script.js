document.addEventListener("DOMContentLoaded", () => {
    // 1. ADVANCED PARTICLE ENGINE (DENSE & COLORFUL)
    const bubbleBox = document.createElement('div');
    bubbleBox.className = 'bubbles-container';
    const scanlines = document.createElement('div');
    scanlines.className = 'scanlines';
    document.body.appendChild(bubbleBox);
    document.body.appendChild(scanlines);

    const colors = ['#4285F4', '#EA4335', '#FBBC05', '#34A853', '#00d2ff', '#ff007c', '#9d50bb'];

    function createBubble() {
        const b = document.createElement('div');
        const size = Math.random() * 100 + 20 + "px"; // Big and small
        b.className = 'bubble';
        b.style.width = size;
        b.style.height = size;

        // Random Position
        b.style.left = Math.random() * 100 + "vw";

        // Random Color & Glow
        const color = colors[Math.floor(Math.random() * colors.length)];
        b.style.setProperty('--bubble-color', color);
        b.style.setProperty('--bubble-glow', color);

        // Random Depth (Blur & Opacity)
        const depth = Math.random();
        b.style.filter = `blur(${depth * 5}px)`;
        b.style.setProperty('--max-opacity', (0.4 - depth * 0.2).toString()); // Closer = clearer
        b.style.zIndex = Math.floor(depth * -5).toString(); // Depth sorting

        // Random Sway Motion
        b.style.setProperty('--sway', (Math.random() * 200 - 100) + "px");

        // Random Speed
        const duration = Math.random() * 15 + 15 + "s";
        b.style.animationDuration = duration;

        bubbleBox.appendChild(b);
        setTimeout(() => b.remove(), parseFloat(duration) * 1000);
    }

    // SPAWN INITIAL DENSITY (More bubbles for "More and More")
    for (let i = 0; i < 35; i++) createBubble();
    // Continuous High-Density Spawning
    setInterval(createBubble, 400);

    // 2. HACKER TEXT ANIMATION
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#$%^&*";
    window.hackText = (element) => {
        let iterations = 0;
        const originalText = element.dataset.value || element.innerText;
        const interval = setInterval(() => {
            element.innerText = originalText.split("")
                .map((letter, index) => {
                    if (index < iterations) return originalText[index];
                    return letters[Math.floor(Math.random() * letters.length)];
                }).join("");
            if (iterations >= originalText.length) clearInterval(interval);
            iterations += 1 / 2;
        }, 30);
    }

    // 3. 3D PANEL TILT (Desktop Only)
    const panel = document.querySelector(".glass-panel");
    const stage = document.querySelector(".main-stage");
    if (window.innerWidth > 1100 && panel && stage) {
        stage.addEventListener("mousemove", (e) => {
            const x = (window.innerWidth / 2 - e.pageX) / 70;
            const y = (e.pageY - window.innerHeight / 2) / 70;
            panel.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
        });
        stage.addEventListener("mouseleave", () => panel.style.transform = `rotateY(0deg) rotateX(0deg)`);
    }

    // 4. MOBILE MENU LOGIC
    const toggleBtn = document.getElementById('mobileToggle');
    const menu = document.getElementById('mobileMenu');
    if (toggleBtn && menu) {
        toggleBtn.addEventListener('click', () => {
            menu.classList.toggle('open');
            toggleBtn.innerHTML = menu.classList.contains('open') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
        });
    }

    // 5. ACTIVE LINK HIGHLIGHT
    const path = window.location.pathname.split("/").pop() || "index.html";
    document.querySelectorAll('.nav-link, .mobile-link').forEach(l => {
        if (l.getAttribute('href') === path) l.classList.add('active');
    });
});