document.addEventListener('alpine:init', () => {
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
                el.children[index].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
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
});
