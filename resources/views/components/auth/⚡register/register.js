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
