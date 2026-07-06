import './admin-login.css';

(function() {
    function initRecaptcha() {
        const anchor = document.getElementById('recaptcha-anchor');
        const spinner = document.getElementById('recaptcha-spinner');
        const checkmark = document.getElementById('recaptcha-checkmark');
        const submitBtn = document.getElementById('submit-btn');

        if (!anchor) return;

        // Prevent double binding
        if (anchor.dataset.bound) return;
        anchor.dataset.bound = "true";

        anchor.addEventListener('click', function() {
            // Hide checkbox, show spinner
            anchor.style.display = 'none';
            spinner.style.display = 'block';

            setTimeout(() => {
                // Hide spinner, show checkmark
                spinner.style.display = 'none';
                checkmark.style.style = ''; // Reset display style to show svg (which might be default inline-block/block)
                checkmark.setAttribute('style', 'display: block !important');
                
                // Enable submit button
                if (submitBtn) {
                    submitBtn.removeAttribute('disabled');
                    // Remove disabled styles
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }, 1500);
        });
    }

    // Bind on load and navigations
    document.addEventListener('DOMContentLoaded', initRecaptcha);
    document.addEventListener('livewire:navigated', initRecaptcha);
    
    // Also use MutationObserver for Livewire morphing updates
    const observer = new MutationObserver(() => {
        initRecaptcha();
    });
    observer.observe(document.body, { childList: true, subtree: true });
})();
