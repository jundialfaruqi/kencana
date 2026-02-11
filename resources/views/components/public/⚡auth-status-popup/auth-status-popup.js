document.addEventListener('livewire:navigated', () => {
    // Dispatch event global yang akan didengarkan oleh komponen Livewire
    Livewire.dispatch('refreshAuthStatus');
});
