<?php

use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Menu')] #[Layout('layouts::android-webview.app')] class extends Component
{
    public bool $showTermsModal = false;
    public bool $termsAgreed = false;

    public function mount(): void
    {
        // Tampilkan modal jika belum pernah disetujui pada sesi ini
        if (! Session::get('webview_menu_terms_agreed', false)) {
            $this->showTermsModal = true;
        }
    }

    public function acceptTerms(): void
    {
        if ($this->termsAgreed) {
            Session::put('webview_menu_terms_agreed', true);
            $this->showTermsModal = false;
        }
    }

    public function render()
    {
        return view('components.android-webview.menu.menu');
    }
};

