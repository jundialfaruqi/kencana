// Add your JavaScript here
(function () {
  function openExportModalJS() {
    var el = document.getElementById('exportModal');
    if (!el) return;
    try {
      if (typeof el.showModal === 'function') {
        el.showModal();
      } else {
        el.classList.add('modal-open');
      }
    } catch (_) {}
  }

  function closeExportModalJS() {
    var el = document.getElementById('exportModal');
    if (!el) return;
    try {
      if (typeof el.close === 'function') {
        el.close();
      } else {
        el.classList.remove('modal-open');
      }
    } catch (_) {}
  }

  function bindLW() {
    if (window.Livewire && window.Livewire.on) {
      if (!window.__exportModalKhususBound) {
        window.addEventListener('modal-export-open', function () {
          openExportModalJS();
        }, { passive: true });
        window.addEventListener('modal-export-close', function () {
          closeExportModalJS();
        }, { passive: true });
        document.addEventListener('modal-export-open', function () {
          openExportModalJS();
        }, { passive: true });
        document.addEventListener('modal-export-close', function () {
          closeExportModalJS();
        }, { passive: true });
        window.Livewire.on('modal-export-open', function () {
          openExportModalJS();
        });
        window.Livewire.on('modal-export-close', function () {
          closeExportModalJS();
        });
        window.__exportModalKhususBound = true;
      }
    }
  }

  function init() {
    bindLW();
  }

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