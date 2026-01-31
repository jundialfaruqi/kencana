(function () {
  var STORAGE_KEY = 'lapangan-create:form';
  var FIELDS = [
    'nama_lapangan',
    'deskripsi',
    'alamat',
    'gmap',
    'np_telp',
    'status',
    'latitude',
    'longitude'
  ];

  function getRoot() {
    return document.getElementById('lapangan-create-root');
  }

  function readStore() {
    try {
      var raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return {};
      var obj = JSON.parse(raw);
      if (obj && typeof obj === 'object') return obj;
      return {};
    } catch (_) {
      return {};
    }
  }

  function writeStore(obj) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(obj || {}));
    } catch (_) {}
  }

  function clearStore() {
    try {
      localStorage.removeItem(STORAGE_KEY);
    } catch (_) {}
  }

  function restoreValues(root) {
    var store = readStore();
    FIELDS.forEach(function (field) {
      var selector = '[wire\\:model\\.live="' + field + '"]';
      var el = root.querySelector(selector);
      if (!el) return;
      if (el.type && el.type.toLowerCase() === 'file') return;
      var val = store[field];
      if (val === undefined || val === null) return;
      try {
        el.value = String(val);
        if (el.tagName === 'SELECT') {
          el.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
          el.dispatchEvent(new Event('input', { bubbles: true }));
        }
      } catch (_) {}
    });
  }

  function bindInputs(root) {
    var store = readStore();
    FIELDS.forEach(function (field) {
      var selector = '[wire\\:model\\.live="' + field + '"]';
      var el = root.querySelector(selector);
      if (!el) return;
      if (el.type && el.type.toLowerCase() === 'file') return;
      var handler = function () {
        store[field] = el.value;
        writeStore(store);
      };
      var evt = (el.tagName === 'SELECT') ? 'change' : 'input';
      el.addEventListener(evt, handler);
    });
  }

  function bindActions(root) {
    var cancels = root.querySelectorAll('[wire\\:click="cancel"]');
    if (cancels && cancels.length) {
      cancels.forEach(function (el) {
        el.addEventListener('click', function () {
          clearStore();
        });
      });
    }
    if (window.Livewire && typeof window.Livewire.on === 'function') {
      window.Livewire.on('form-reset', function () {
        clearStore();
      });
    }
  }

  function initCreateLapangan() {
    var root = getRoot();
    if (!root) return;
    restoreValues(root);
    bindInputs(root);
    bindActions(root);
  }

  function scheduleInit(count) {
    try {
      initCreateLapangan();
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
