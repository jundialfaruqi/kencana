(function () {
  var _initialized = false;

  function initUpdateLapangan() {
    if (_initialized) return;
    var root = document.getElementById('lapangan-update-root');
    if (!root) return;
    _initialized = true;

    setupAutoResizeTextarea(root);
  }

  function setupAutoResizeTextarea(root) {
    var textarea = root.querySelector('textarea[wire\\:model\\.blur="deskripsi"]');
    if (!textarea) return;

    function resize() {
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }

    textarea.addEventListener('input', resize);
    textarea.addEventListener('focus', resize);
    window.addEventListener('resize', resize);

    setTimeout(resize, 100);
  }

  document.addEventListener('livewire:navigated', function () {
    _initialized = false;
    setTimeout(initUpdateLapangan, 150);
  });

  if (document.readyState !== 'loading') {
    initUpdateLapangan();
  } else {
    document.addEventListener('DOMContentLoaded', initUpdateLapangan, { once: true });
  }
})();
