(function () {
  function initHeroCarousel() {
    var el = document.getElementById('hero-carousel-root');
    if (!el) return;
    el.dataset.heroCarouselInitialized = 'true';
  }
  document.addEventListener('livewire:navigated', function () {
    setTimeout(function () { initHeroCarousel(); }, 50);
  });
  window.addEventListener('hero-carousel-loaded', function () {
    setTimeout(function () { initHeroCarousel(); }, 50);
  });
  document.addEventListener('livewire:init', function () {
    if (window.Livewire && window.Livewire.hook) {
      window.Livewire.hook('commit', function (_ref) {
        var succeed = _ref.succeed;
        succeed(function () { setTimeout(function () { initHeroCarousel(); }, 50); });
      });
    }
  });
  if (document.readyState !== 'loading') {
    initHeroCarousel();
  } else {
    document.addEventListener('DOMContentLoaded', function () { initHeroCarousel(); }, { once: true });
  }
})(); 
