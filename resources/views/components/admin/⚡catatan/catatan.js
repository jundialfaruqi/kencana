(function () {
  function init() {}
  document.addEventListener('DOMContentLoaded', init);
  document.addEventListener('livewire:navigated', init);
  document.addEventListener('livewire:init', function () {
    if (window.Livewire && window.Livewire.hook) {
      window.Livewire.hook('commit', function ({ succeed }) {
        succeed(function () { init(); });
      });
    }
  });
  if (document.readyState !== 'loading') init();
})();
