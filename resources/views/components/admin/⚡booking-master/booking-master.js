(function () {
  function openModal(data) {
    var el = document.getElementById('cancelModal');
    if (!el) return;
    try {
      if (typeof el.showModal === 'function') {
        el.showModal();
      } else {
        el.classList.add('modal-open');
      }
    } catch (_) {}
    try {
      var fallback = (typeof window !== 'undefined' && window.__cancelBtnData) ? window.__cancelBtnData : {};
      var payload = Object.assign({}, fallback, data || {});
      var kodeEl = document.getElementById('cancelInfoKode');
      var tglEl = document.getElementById('cancelInfoTanggal');
      var jamEl = document.getElementById('cancelInfoJam');
      var userEl = document.getElementById('cancelInfoUser');
      var lapEl = document.getElementById('cancelInfoLapangan');
      if (kodeEl) kodeEl.textContent = payload.kode ? String(payload.kode) : '-';
      if (tglEl) tglEl.textContent = payload.tanggal ? String(payload.tanggal) : '-';
      var jamStr = '-';
      if (payload.jam) {
        var parts = String(payload.jam).split(' - ');
        if (parts.length === 2) {
          var a = parts[0].trim().substring(0, 5);
          var b = parts[1].trim().substring(0, 5);
          jamStr = a + ' - ' + b;
        } else {
          jamStr = String(payload.jam).substring(0, 5);
        }
      } else {
        var jm = payload.jam_mulai ? String(payload.jam_mulai).substring(0, 5) : '-';
        var js = payload.jam_selesai ? String(payload.jam_selesai).substring(0, 5) : '-';
        jamStr = jm + ' - ' + js;
      }
      if (jamEl) jamEl.textContent = jamStr;
      if (userEl) userEl.textContent = payload.user ? String(payload.user) : '-';
      if (lapEl) lapEl.textContent = payload.lapangan ? String(payload.lapangan) : '-';
    } catch (_) {}
  }

  function closeModal() {
    var el = document.getElementById('cancelModal');
    if (!el) return;
    try {
      if (typeof el.close === 'function') {
        el.close();
      } else {
        el.classList.remove('modal-open');
      }
    } catch (_) {}
    var t = document.getElementById('cancelReasonInput');
    if (t) t.value = '';
  }

  function bindLW() {
    if (window.Livewire && window.Livewire.on) {
      if (!window.__cancelModalBound) {
        window.addEventListener('modal-cancel-open', function (e) {
          var payload = (e && e.detail) ? e.detail : {};
          openModal(payload);
        }, { passive: true });
        window.addEventListener('modal-cancel-close', function () {
          closeModal();
        }, { passive: true });
        document.addEventListener('modal-cancel-open', function (e) {
          var payload = (e && e.detail) ? e.detail : {};
          openModal(payload);
        }, { passive: true });
        document.addEventListener('modal-cancel-close', function () {
          closeModal();
        }, { passive: true });
        window.Livewire.on('modal-cancel-open', function (payload) {
          openModal(payload || {});
        });
        window.Livewire.on('modal-cancel-close', function () {
          closeModal();
        });
        window.__cancelModalBound = true;
      }
    }
  }

  function bindButtons() {
    var btn = document.getElementById('cancelModalCloseBtn');
    if (btn && !btn.__bound) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        try { closeModal(); } catch (_) {}
      });
      btn.__bound = true;
    }
    var triggers = document.querySelectorAll('[data-cancel-btn]');
    triggers.forEach(function (t) {
      if (!t.__boundCancel) {
        t.addEventListener('click', function () {
          try {
            window.__cancelBtnData = {
              kode: t.dataset.kode || '-',
              tanggal: t.dataset.tanggal || '-',
              jam_mulai: t.dataset.jam_mulai || '-',
              jam_selesai: t.dataset.jam_selesai || '-',
              user: t.dataset.user || '-',
              lapangan: t.dataset.lapangan || '-',
            };
          } catch (_) {}
        }, { passive: true });
        t.__boundCancel = true;
      }
    });
  }

  function bindCopyBookingCode() {
    document.querySelectorAll('.copy-booking-code').forEach(function(element) {
      element.addEventListener('click', function() {
        const bookingCode = this.dataset.bookingCode;
        navigator.clipboard.writeText(bookingCode).then(function() {
          window.Livewire.dispatch('toast', {
            title: 'Berhasil',
            message: 'Kode booking berhasil disalin!',
            type: 'success',
          });
        }).catch(function(err) {
          console.error('Gagal menyalin teks: ', err);
        });
      });
    });
  }

  function init() {
    bindLW();
    bindButtons();
    bindCopyBookingCode();
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
