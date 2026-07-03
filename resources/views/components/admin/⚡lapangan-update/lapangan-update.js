(function () {
  function initUpdateLapangan() {}

  document.addEventListener('livewire:navigated', function () {
    setTimeout(initUpdateLapangan, 150);
  });

  if (document.readyState !== 'loading') {
    initUpdateLapangan();
  } else {
    document.addEventListener('DOMContentLoaded', initUpdateLapangan, { once: true });
  }
})();
