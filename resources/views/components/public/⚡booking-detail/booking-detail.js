;(function () {
  function initDetail() {
    var card = document.getElementById('detail-card');
    if (!card) return;
    card.classList.add('transition', 'duration-700', 'ease-out');
    card.classList.add('ring-0');
    setTimeout(function () {
      card.classList.add('ring', 'ring-info/20');
    }, 50);
  }

  document.addEventListener('livewire:navigated', function () {
    setTimeout(function () { initDetail(); }, 50);
  });

  window.addEventListener('detail-loaded', function () {
    setTimeout(function () { initDetail(); }, 50);
  });

  document.addEventListener('livewire:init', function () {
    if (window.Livewire && window.Livewire.hook) {
      window.Livewire.hook('commit', function (_ref) {
        var succeed = _ref.succeed;
        succeed(function () { setTimeout(function () { initDetail(); }, 50); });
      });
    }
  });

  if (document.readyState !== 'loading') {
    initDetail();
  } else {
    document.addEventListener('DOMContentLoaded', function () { initDetail(); }, { once: true });
  }
})();
