(function () {
  function initBooking() {
    var root = document.querySelector('[wire\\:init="load"]');
    if (!root) return;
    root.dataset.bookingInitialized = 'true';

    try {
      var trigger = root.querySelector('[data-cal-trigger]');
      var popover = root.querySelector('#select-date-calendar');
      var prev = root.querySelector('[data-cal-prev]');
      var next = root.querySelector('[data-cal-next]');
      var panels = popover ? popover.querySelectorAll('[data-cal-panel]') : [];
      var labelCurr = popover ? popover.querySelector('[data-cal-label="curr"]') : null;
      var labelNext = popover ? popover.querySelector('[data-cal-label="next"]') : null;

      // cleanup previous bindings if any
      if (window.__bookingCal && window.__bookingCal.initialized) {
        try {
          var old = window.__bookingCal;
          if (old.trigger && old.onTriggerClick) {
            old.trigger.removeEventListener('click', old.onTriggerClick);
          }
          if (old.prev && old.onPrevClick) {
            old.prev.removeEventListener('click', old.onPrevClick);
          }
          if (old.next && old.onNextClick) {
            old.next.removeEventListener('click', old.onNextClick);
          }
          if (old.onDocClick) {
            document.removeEventListener('click', old.onDocClick, true);
          }
          if (old.calDateButtons && old.onCalDateClick) {
            try {
              old.calDateButtons.forEach(function (btn) {
                btn.removeEventListener('click', old.onCalDateClick);
              });
            } catch (_) {}
          }
          if (old.timeSlotButtons && old.onTimeSlotClick) {
            try {
              old.timeSlotButtons.forEach(function (btn) {
                btn.removeEventListener('click', old.onTimeSlotClick);
              });
            } catch (_) {}
          }
          if (old.dateButtons && old.onDateButtonClick) {
            try {
              old.dateButtons.forEach(function (btn) {
                btn.removeEventListener('click', old.onDateButtonClick);
              });
            } catch (_) {}
          }
        } catch (_) {}
      }

      var state = { open: false, idx: 0 };
      function render() {
        if (!popover) return;
        if (state.open) {
          popover.classList.remove('hidden');
        } else {
          popover.classList.add('hidden');
        }
        panels.forEach(function (p, i) {
          if (i === state.idx) {
            p.classList.remove('hidden');
          } else {
            p.classList.add('hidden');
          }
        });
        if (labelCurr && labelNext) {
          if (state.idx === 0) {
            labelCurr.classList.remove('hidden');
            labelNext.classList.add('hidden');
          } else {
            labelCurr.classList.add('hidden');
            labelNext.classList.remove('hidden');
          }
        }
        if (prev && next) {
          prev.classList.toggle('pointer-events-none', state.idx === 0);
          prev.classList.toggle('opacity-40', state.idx === 0);
          next.classList.toggle('pointer-events-none', state.idx === 1);
          next.classList.toggle('opacity-40', state.idx === 1);
        }
      }
      var onTriggerClick = function (e) {
        e.preventDefault();
        state.open = !state.open;
        updatePanelBySelected((window.__bookingCal && window.__bookingCal.selectedDate) ? window.__bookingCal.selectedDate : (container ? container.getAttribute('data-cal-selected') : null));
        render();
      };
      var onPrevClick = function (e) {
        e.preventDefault();
        if (state.idx > 0) {
          state.idx -= 1;
          render();
        }
      };
      var onNextClick = function (e) {
        e.preventDefault();
        if (state.idx < 1) {
          state.idx += 1;
          render();
        }
      };
      var onDocClick = function (e) {
        if (!state.open) return;
        var t = e.target;
        if (!popover.contains(t) && t !== trigger) {
          state.open = false;
          render();
        }
      };

      if (trigger && popover) {
        trigger.addEventListener('click', onTriggerClick);
        document.addEventListener('click', onDocClick, true);
      }
      if (prev) prev.addEventListener('click', onPrevClick);
      if (next) next.addEventListener('click', onNextClick);

      var calDateButtons = popover ? popover.querySelectorAll('[data-cal-date]') : [];
      var container = trigger ? trigger.closest('.relative') : null;
      function updatePanelBySelected(date) {
        try {
          if (!date || !container) return;
          var sm = date.slice(0, 7);
          var curr = container.getAttribute('data-cal-curr-month');
          var next = container.getAttribute('data-cal-next-month');
          if (sm && curr && next) {
            if (sm === curr) state.idx = 0;
            else if (sm === next) state.idx = 1;
          }
        } catch (_) {}
      }
      function updateCalendarSelected(date) {
        if (!date || !calDateButtons || calDateButtons.length === 0) return;
        calDateButtons.forEach(function (btn) {
          var d = btn.getAttribute('data-cal-date');
          var isSel = d === date;
          if (isSel) {
            btn.classList.add('bg-info', 'text-info-content');
            btn.classList.remove('bg-base-100', 'hover:bg-base-200');
          } else {
            btn.classList.remove('bg-info', 'text-info-content');
            btn.classList.add('bg-base-100');
          }
        });
      }
      var onCalDateClick = function (e) {
        var btn = e.currentTarget;
        var date = btn.getAttribute('data-cal-date');
        if (date) {
          if (!window.__bookingCal) window.__bookingCal = {};
          window.__bookingCal.selectedDate = date;
          updatePanelBySelected(date);
          render();
          updateCalendarSelected(date);
          var target = root.querySelector('.carousel [data-date="' + date + '"]');
          if (target) {
            try {
              target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } catch (_) {
              target.scrollIntoView();
            }
          }
        }
      };
      calDateButtons.forEach(function (btn) {
        btn.addEventListener('click', onCalDateClick);
      });

      var timeSlotButtons = root.querySelectorAll('[data-time-slot]');
      var onTimeSlotClick = function () {
        var date = (window.__bookingCal && window.__bookingCal.selectedDate) ? window.__bookingCal.selectedDate : (container ? container.getAttribute('data-cal-selected') : null);
        if (!date) return;
        var target = root.querySelector('.carousel [data-date="' + date + '"]');
        if (!target) return;
        var btn = target.closest('.carousel-item') ? target : target;
        try {
          btn.classList.add('bg-info', 'text-info-content', 'shadow-lg', 'shadow-info/20');
        } catch (_) {}
      };
      timeSlotButtons.forEach(function (btn) {
        btn.addEventListener('click', onTimeSlotClick);
      });

      var dateButtons = root.querySelectorAll('.carousel [data-date]');
      var onDateButtonClick = function (e) {
        var btn = e.currentTarget;
        var date = btn.getAttribute('data-date');
        if (!date) return;
        if (!window.__bookingCal) window.__bookingCal = {};
        window.__bookingCal.selectedDate = date;
        updatePanelBySelected(date);
        render();
        updateCalendarSelected(date);
      };
      dateButtons.forEach(function (btn) {
        btn.addEventListener('click', onDateButtonClick);
      });

      var containerSelected = (container && container.getAttribute('data-cal-selected')) || null;
      window.__bookingCal = {
        trigger: trigger,
        popover: popover,
        prev: prev,
        next: next,
        panels: panels,
        labelCurr: labelCurr,
        labelNext: labelNext,
        onTriggerClick: onTriggerClick,
        onPrevClick: onPrevClick,
        onNextClick: onNextClick,
        onDocClick: onDocClick,
        calDateButtons: calDateButtons,
        onCalDateClick: onCalDateClick,
        timeSlotButtons: timeSlotButtons,
        onTimeSlotClick: onTimeSlotClick,
        dateButtons: dateButtons,
        onDateButtonClick: onDateButtonClick,
        selectedDate: containerSelected || ((window.__bookingCal && window.__bookingCal.selectedDate) || null),
        initialized: true
      };
      updatePanelBySelected(window.__bookingCal.selectedDate);
      render();
      if (window.__bookingCal && window.__bookingCal.selectedDate) {
        var sel = window.__bookingCal.selectedDate;
        updateCalendarSelected(sel);
        var suppress =
          (typeof window.__bookingNoScrollUntil === 'number' && Date.now() < window.__bookingNoScrollUntil) ||
          (window.__bookingSuppressScroll === true);
        if (!suppress) {
          var el = root.querySelector('.carousel [data-date="' + sel + '"]');
          if (el) {
            try {
              el.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } catch (_) {
              el.scrollIntoView();
            }
          }
        } else {
          // allow future scrolls by clearing one-shot flag; time-based flag will expire on its own
          window.__bookingSuppressScroll = false;
        }
      }
    } catch (_) {}
  }
  document.addEventListener('livewire:navigated', function () {
    setTimeout(function () { initBooking(); }, 50);
  });
  window.addEventListener('booking-loaded', function () {
    setTimeout(function () { initBooking(); }, 50);
  });
  document.addEventListener('livewire:init', function () {
    if (window.Livewire && window.Livewire.hook) {
      window.Livewire.hook('commit', function (_ref) {
        var succeed = _ref.succeed;
        succeed(function () { setTimeout(function () { initBooking(); }, 50); });
      });
    }
  });
  if (document.readyState !== 'loading') {
    initBooking();
  } else {
    document.addEventListener('DOMContentLoaded', function () { initBooking(); }, { once: true });
  }
})();
