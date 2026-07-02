(function () {
  function initBooking() {
    var root = document.getElementById('booking-root');
    if (!root) return;
    root.dataset.bookingInitialized = 'true';

    var currentStep = parseInt(root.getAttribute('data-step') || '1');
    if (window.__lastBookingStep !== undefined && window.__lastBookingStep !== currentStep) {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    window.__lastBookingStep = currentStep;

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
          if (old.confirmBtns && old.onConfirmClick) {
            try {
              old.confirmBtns.forEach(function (btn) {
                btn.removeEventListener('click', old.onConfirmClick);
              });
            } catch (_) {}
          }
          if (old.closeBtns && old.onCloseClick) {
            try {
              old.closeBtns.forEach(function (btn) {
                btn.removeEventListener('click', old.onCloseClick);
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
      var closeBtns = popover ? popover.querySelectorAll('[data-cal-close]') : [];
      var onCloseClick = function (e) {
        e.preventDefault();
        state.open = false;
        render();
      };
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
        if (!date) return;
        if (calDateButtons && calDateButtons.length > 0) {
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
        
        var dateButtons = root.querySelectorAll('[data-date-container] [data-date]');
        if (dateButtons && dateButtons.length > 0) {
          dateButtons.forEach(function (btn) {
            var d = btn.getAttribute('data-date');
            var isSel = d === date;
            if (isSel) {
              btn.classList.add('bg-info', 'text-info-content', 'shadow-lg', 'shadow-info/20');
              btn.classList.remove('bg-base-100', 'hover:bg-base-200', 'text-base-content/70');
            } else {
              btn.classList.remove('bg-info', 'text-info-content', 'shadow-lg', 'shadow-info/20');
              btn.classList.add('bg-base-100', 'hover:bg-base-200', 'text-base-content/70');
            }
          });
        }

        var hiddenInput = document.getElementById('hidden-tanggal-input');
        if (hiddenInput && hiddenInput.value !== date) {
          hiddenInput.value = date;
          hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
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
          var target = root.querySelector('[data-date-container] [data-date="' + date + '"]');
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
      if (closeBtns && closeBtns.length > 0) {
        closeBtns.forEach(function (btn) { btn.addEventListener('click', onCloseClick); });
      }

      var timeSlotButtons = root.querySelectorAll('[data-time-slot]');
      var onTimeSlotClick = function () {
        var date = (window.__bookingCal && window.__bookingCal.selectedDate) ? window.__bookingCal.selectedDate : (container ? container.getAttribute('data-cal-selected') : null);
        if (!date) return;
        var target = root.querySelector('[data-date-container] [data-date="' + date + '"]');
        if (!target) return;
        var btn = target;
        try {
          btn.classList.add('bg-info', 'text-info-content', 'shadow-lg', 'shadow-info/20');
        } catch (_) {}
      };
      timeSlotButtons.forEach(function (btn) {
        btn.addEventListener('click', onTimeSlotClick);
      });

      var dateButtons = root.querySelectorAll('[data-date-container] [data-date]');
      var onDateButtonClick = function (e) {
        var btn = e.currentTarget;
        var date = btn.getAttribute('data-date');
        if (!date) return;
        // mark that a user-triggered date selection happened via carousel;
        // this explicitly requests auto-centering on the next init cycle only
        window.__bookingScrollDueToDate = true;
        if (!window.__bookingCal) window.__bookingCal = {};
        window.__bookingCal.selectedDate = date;
        updatePanelBySelected(date);
        render();
        updateCalendarSelected(date);
      };
      dateButtons.forEach(function (btn) {
        btn.addEventListener('click', onDateButtonClick);
      });

      var confirmBtns = root.querySelectorAll('[data-confirm-booking]');
      var onConfirmClick = function () {
        window.__bookingSuppressScroll = true;
        window.__bookingNoScrollUntil = Date.now() + 3000;
      };
      confirmBtns.forEach(function (btn) {
        btn.addEventListener('click', onConfirmClick);
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
        confirmBtns: confirmBtns,
        onConfirmClick: onConfirmClick,
        closeBtns: closeBtns,
        onCloseClick: onCloseClick,
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
        // Only auto-center the date in carousel when it was explicitly requested
        // by a user click on a carousel date (one-shot flag). Prevents unintended
        // scrolling on Livewire re-renders caused by other interactions.
        var requestedByDate = (window.__bookingScrollDueToDate === true);
        if (!suppress && requestedByDate) {
          var el = root.querySelector('[data-date-container] [data-date="' + sel + '"]');
          if (el) {
            try {
              el.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } catch (_) {
              el.scrollIntoView();
            }
          }
        }
        // clear one-shot flags to avoid future unintended scrolls
        if (requestedByDate) {
          window.__bookingScrollDueToDate = false;
        }
        if (suppress) {
          // allow future scrolls by clearing one-shot flag; time-based flag will expire on its own
          window.__bookingSuppressScroll = false;
        }
      }
    } catch (_) {}
  }
  document.addEventListener('livewire:navigated', function () {
    window.__lastBookingStep = undefined;
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
