// Navbar auto-hide on scroll
let lastScrollTop = 0;
let scrollThreshold = 10; // Minimum scroll distance to trigger hide/show

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    
    // Don't hide navbar if we're at the top of the page
    if (currentScroll <= 0) {
        navbar.classList.remove('hidden');
        navbar.classList.add('visible');
        return;
    }
    
    // Check scroll direction with threshold
    if (Math.abs(currentScroll - lastScrollTop) > scrollThreshold) {
        if (currentScroll > lastScrollTop) {
            // Scrolling down - hide navbar
            navbar.classList.add('hidden');
            navbar.classList.remove('visible');
        } else {
            // Scrolling up - show navbar
            navbar.classList.remove('hidden');
            navbar.classList.add('visible');
        }
        
        lastScrollTop = currentScroll;
    }
}, { passive: true });
