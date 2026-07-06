import './register.css';

document.addEventListener('livewire:init', function () {
    Livewire.on('registration-success', function (params) {
        var data = Array.isArray(params) ? params[0] : params;
        var redirectUrl = data.redirectUrl || '/';
        var message = data.message || 'Pendaftaran berhasil.';

        var msgEl = document.getElementById('register-success-message');
        if (msgEl) { msgEl.textContent = message; }

        var modal = document.getElementById('register-success-modal');
        if (modal) { modal.classList.remove('hidden'); }

        var seconds = 5;
        var timerEl = document.getElementById('register-countdown');

        var interval = setInterval(function () {
            seconds--;
            if (timerEl) { timerEl.textContent = seconds; }

            if (seconds <= 0) {
                clearInterval(interval);
                if (window.Livewire && window.Livewire.navigate) {
                    Livewire.navigate(redirectUrl);
                } else {
                    window.location.href = redirectUrl;
                }
            }
        }, 1000);
    });
});

(function () {
    let currentStep = 1;

    function applyStep() {
        const step1 = document.getElementById('register-step-1');
        const step2 = document.getElementById('register-step-2');
        if (!step1 || !step2) return;

        if (currentStep === 1) {
            step1.classList.remove('hidden');
            step2.classList.add('hidden');
        } else {
            step1.classList.add('hidden');
            step2.classList.remove('hidden');
        }
    }

    function attachListeners() {
        const btnNext = document.getElementById('btn-next-step');
        const btnPrev = document.getElementById('btn-prev-step');
        
        if (btnNext && !btnNext.dataset.bound) {
            btnNext.addEventListener('click', function () {
                currentStep = 2;
                applyStep();
            });
            btnNext.dataset.bound = '1';
        }
        
        if (btnPrev && !btnPrev.dataset.bound) {
            btnPrev.addEventListener('click', function () {
                currentStep = 1;
                applyStep();
            });
            btnPrev.dataset.bound = '1';
        }
    }

    function checkErrorsAndApply() {
        const step1 = document.getElementById('register-step-1');
        const step2 = document.getElementById('register-step-2');
        if (!step1 || !step2) return;

        const hasStep1Errors = step1.querySelector('.input-warning') !== null;
        const hasStep2Errors = step2.querySelector('.input-warning') !== null;

        if (hasStep1Errors) {
            currentStep = 1;
        } else if (hasStep2Errors) {
            currentStep = 2;
        }
        
        applyStep();
        attachListeners();
    }

    // Observer to re-apply state when Livewire replaces the DOM
    const observer = new MutationObserver(function (mutations) {
        let shouldApply = false;
        mutations.forEach(function (mutation) {
            if (mutation.addedNodes.length > 0) {
                shouldApply = true;
            }
        });
        
        if (shouldApply) {
            const step1 = document.getElementById('register-step-1');
            if (step1 && step1.querySelector('.input-warning')) {
                currentStep = 1;
            }
            applyStep();
            attachListeners();
        }
    });

    // We start observing the container of the form
    function startObserver() {
        const container = document.querySelector('[wire\\:key="register-card"]');
        if (container) {
            // Disconnect old observer to avoid duplicates
            observer.disconnect();
            observer.observe(container, { childList: true, subtree: true });
        }
    }

    function init() {
        checkErrorsAndApply();
        startObserver();
    }

    if (document.readyState !== 'loading') {
        init();
    } else {
        document.addEventListener('DOMContentLoaded', init);
    }

    document.addEventListener('livewire:navigated', init);
})();
