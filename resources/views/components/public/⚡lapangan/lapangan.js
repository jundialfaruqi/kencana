function initLapanganAnimations() {
    const cards = document.querySelectorAll('[data-animate-card]');
    let i = 0;
    cards.forEach((el) => {
        setTimeout(() => {
            el.classList.remove('opacity-0', 'translate-y-2');
        }, i * 40);
        i++;
    });
}
window.addEventListener('livewire:navigated', () => {
    initLapanganAnimations();
});
document.addEventListener('DOMContentLoaded', () => {
    initLapanganAnimations();
});
document.addEventListener('alpine:init', () => {
    initLapanganAnimations();
});
window.addEventListener('lapangan-loaded', () => {
    initLapanganAnimations();
});
