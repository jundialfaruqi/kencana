(function () {
  function initUpdateLapangan() {}
  function scheduleInit(count) {
    try {
      initUpdateLapangan();
    } catch (e) {
      if (count < 10) {
        setTimeout(function () { scheduleInit(count + 1); }, 100);
      }
    }
  }
  document.addEventListener('livewire:navigated', function () {
    setTimeout(function () { scheduleInit(0); }, 100);
  });
  document.addEventListener('livewire:init', function () {
    if (window.Livewire && window.Livewire.hook) {
      window.Livewire.hook('commit', function ({ succeed }) {
        succeed(function () { setTimeout(function () { scheduleInit(0); }, 100); });
      });
    }
  });
  if (document.readyState !== 'loading') {
    scheduleInit(0);
  } else {
    document.addEventListener('DOMContentLoaded', function () { scheduleInit(0); }, { once: true });
  }
})();
