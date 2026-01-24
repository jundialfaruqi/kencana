(function() {
    const initCarousel = () => {
        const el = document.getElementById('banner-carousel-root');
        if (!el) return;

        // Reset if already initialized
        if (el.dataset.carouselInitialized) {
            // Clear existing interval if any
            if (window.bannerCarouselInterval) {
                clearInterval(window.bannerCarouselInterval);
            }
        }

        const carousel = el.querySelector('.carousel');
        const items = el.querySelectorAll('.carousel-item');
        const indicators = el.querySelectorAll('.indicator-dot');
        let currentIndex = 0;
        const totalItems = items.length;

        if (totalItems === 0 || !carousel) return;

        const scrollTo = (index) => {
            if (!items[index]) return;

            const item = items[index];
            carousel.scrollTo({
                left: item.offsetLeft,
                behavior: 'smooth'
            });

            currentIndex = index;
            updateIndicators();
        };

        const updateIndicators = () => {
            indicators.forEach((dot, i) => {
                if (i === currentIndex) {
                    dot.classList.add('bg-info');
                    dot.classList.remove('bg-white/30');
                } else {
                    dot.classList.remove('bg-info');
                    dot.classList.add('bg-white/30');
                }
            });
        };

        const next = () => {
            currentIndex = (currentIndex + 1) % totalItems;
            scrollTo(currentIndex);
        };

        const startAutoplay = () => {
            stopAutoplay();
            window.bannerCarouselInterval = setInterval(next, 5000);
        };

        const stopAutoplay = () => {
            if (window.bannerCarouselInterval) {
                clearInterval(window.bannerCarouselInterval);
            }
        };

        // Event Listeners for indicators
        indicators.forEach((dot, i) => {
            dot.onclick = (e) => {
                e.preventDefault();
                scrollTo(i);
                startAutoplay();
            };
        });

        // Navigation buttons
        const prevBtn = el.querySelector('.btn-prev');
        const nextBtn = el.querySelector('.btn-next');

        if (prevBtn) {
            prevBtn.onclick = () => {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                scrollTo(currentIndex);
                startAutoplay();
            };
        }

        if (nextBtn) {
            nextBtn.onclick = () => {
                next();
                startAutoplay();
            };
        }

        // Pause on hover
        el.onmouseenter = stopAutoplay;
        el.onmouseleave = startAutoplay;

        // Initial state
        updateIndicators();
        startAutoplay();

        el.dataset.carouselInitialized = 'true';
    };

    // Listen for Livewire event
    window.addEventListener('banner-carousel-loaded', () => {
        // Give a small delay for DOM to settle
        setTimeout(initCarousel, 50);
    });

    // Also try to init on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
})();
