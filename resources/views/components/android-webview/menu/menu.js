document.addEventListener('alpine:init', () => {
    // Banner Information Carousel
    Alpine.data('webviewBannerSlider', (total) => ({
        activeSlide: 0,
        totalSlides: total || 0,
        timer: null,
        init() {
            if (this.totalSlides > 1) {
                this.startAutoPlay();
            }
        },
        startAutoPlay() {
            this.stopAutoPlay();
            this.timer = setInterval(() => {
                this.next();
            }, 4000);
        },
        stopAutoPlay() {
            if (this.timer) {
                clearInterval(this.timer);
            }
        },
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            this.scrollToSlide(this.activeSlide);
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides;
            this.scrollToSlide(this.activeSlide);
        },
        goTo(index) {
            this.activeSlide = index;
            this.scrollToSlide(index);
            this.startAutoPlay();
        },
        scrollToSlide(index) {
            const el = this.$refs.slider;
            if (el && el.children[index]) {
                const target = el.children[index];
                el.scrollTo({
                    left: target.offsetLeft - el.offsetLeft,
                    behavior: 'smooth'
                });
            }
        },
        onScroll(e) {
            const el = e.target;
            const index = Math.round(el.scrollLeft / el.offsetWidth);
            if (index !== this.activeSlide && index >= 0 && index < this.totalSlides) {
                this.activeSlide = index;
            }
        }
    }));

    // Arena Carousel Slider
    Alpine.data('webviewArenaSlider', (total) => ({
        activeArena: 0,
        totalArenas: total || 0,
        goTo(index) {
            this.activeArena = index;
            const el = this.$refs.arenaSlider;
            if (el && el.children[index]) {
                const target = el.children[index];
                el.scrollTo({
                    left: target.offsetLeft - el.offsetLeft,
                    behavior: 'smooth'
                });
            }
        },
        onScroll(e) {
            const el = e.target;
            const cardWidth = el.firstElementChild ? el.firstElementChild.offsetWidth : el.offsetWidth;
            const index = Math.round(el.scrollLeft / cardWidth);
            if (index !== this.activeArena && index >= 0 && index < this.totalArenas) {
                this.activeArena = index;
            }
        }
    }));
});
