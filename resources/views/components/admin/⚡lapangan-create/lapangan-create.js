(function () {
  var STORAGE_KEY = 'lapangan-create:form';
  var FIELDS = [
    'nama_lapangan',
    'deskripsi',
    'alamat',
    'gmap',
    'no_tlp',
    'status',
    'latitude',
    'longitude'
  ];

  // Match whichever wire:model modifier is in use
  function findEl(root, field) {
    return root.querySelector('[wire\\:model\\.blur="' + field + '"]')
        || root.querySelector('[wire\\:model\\.live="' + field + '"]')
        || root.querySelector('[wire\\:model="' + field + '"]');
  }

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
      var el = findEl(root, field);
      if (!el) return;
      if (el.type && el.type.toLowerCase() === 'file') return;
      var val = store[field];
      if (val === undefined || val === null) return;
      try {
        el.value = String(val);
        // Do NOT dispatch input/change events — that would trigger Livewire updates
      } catch (_) {}
    });
  }

  function bindInputs(root) {
    var store = readStore();
    FIELDS.forEach(function (field) {
      var el = findEl(root, field);
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

  var _initialized = false;

  function initCreateLapangan() {
    if (_initialized) return;
    var root = getRoot();
    if (!root) return;
    _initialized = true;
    restoreValues(root);
    bindInputs(root);
    bindActions(root);
  }

  // Run once on page load / SPA navigation — NOT on every Livewire commit
  document.addEventListener('livewire:navigated', function () {
    _initialized = false;
    setTimeout(initCreateLapangan, 150);
  });

  if (document.readyState !== 'loading') {
    initCreateLapangan();
  } else {
    document.addEventListener('DOMContentLoaded', initCreateLapangan, { once: true });
  }
})();
