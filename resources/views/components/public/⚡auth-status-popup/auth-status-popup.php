<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    public $showPopup = false;

    protected $listeners = ['refreshAuthStatus']; // Tambahkan baris ini

    public function mount()
    {
        $this->checkAuthStatus();
    }

    public function checkAuthStatus()
    {
        $this->showPopup = !Session::has('auth_token');
    }

    public function refreshAuthStatus() // Tambahkan metode ini
    {
        $this->checkAuthStatus();
    }

    public function render()
    {
        return view('components.public.⚡auth-status-popup.auth-status-popup');
    }
};
