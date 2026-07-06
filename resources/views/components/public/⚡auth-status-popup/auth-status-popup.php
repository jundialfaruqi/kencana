<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

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
        $this->showPopup = ! Session::has('auth_token');
    }

    public function refreshAuthStatus()
    {
        $this->checkAuthStatus();
    }

    public function hidePopup()
    {
        $this->showPopup = false;
    }

    public function render()
    {
        return view('components.public.⚡auth-status-popup.auth-status-popup');
    }
};
