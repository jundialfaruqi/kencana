(function() {
    const initCarousel = () => {
        const el = document.getElementById('banner-carousel-root');
        if (!el) return;

        const carousel = el.querySelector('.carousel');
        const items = el.querySelectorAll('.carousel-item');
        const indicators = el.querySelectorAll('.indicator-dot');
        let currentIndex = 0;
        const totalItems = items.length;

        if (totalItems === 0 || !carousel) return;

        // Clear existing interval if any
        if (window.bannerCarouselInterval) {
            clearInterval(window.bannerCarouselInterval);
        }

        const updateIndicators = (index) => {
            currentIndex = index;
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

        const scrollTo = (index) => {
            if (!items[index]) return;

            const item = items[index];
            carousel.scrollTo({
                left: item.offsetLeft,
                behavior: 'smooth'
            });
            updateIndicators(index);
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

        // Sync indicators with manual scroll
        let scrollTimeout;
        carousel.onscroll = () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const scrollLeft = carousel.scrollLeft;
                const width = carousel.offsetWidth;
                const newIndex = Math.round(scrollLeft / width);
                if (newIndex !== currentIndex && newIndex >= 0 && newIndex < totalItems) {
                    updateIndicators(newIndex);
                }
            }, 50);
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
        updateIndicators(0);
        startAutoplay();

        el.dataset.carouselInitialized = 'true';
    };

    // Listen for Livewire navigated (SPA navigate)
    document.addEventListener('livewire:navigated', initCarousel);

    // Listen for Livewire custom event
    window.addEventListener('banner-carousel-loaded', () => {
        setTimeout(initCarousel, 50);
    });

    // Handle re-initialization on Livewire commit (for updates/filters)
    document.addEventListener('livewire:init', () => {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                setTimeout(initCarousel, 50);
            });
        });
    });

    // Also init on DOMContentLoaded for initial load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCarousel);
    } else {
        initCarousel();
    }
})();
