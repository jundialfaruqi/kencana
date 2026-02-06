<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

new #[Layout('layouts::public.app')] #[Title('Profil Saya')] class extends Component
{
    public $user;
    public bool $ready = false;

    public function load()
    {
        $this->ready = true;
    }

    public function mount()
    {
        // Proteksi Auth: Jika tidak ada token, lempar ke login
        if (!Session::has('auth_token')) {
            return $this->redirect('/login', navigate: true);
        }

        $this->user = Session::get('user_data');

        // Proteksi Role: Jika admin atau superadmin, lempar ke dashboard
        if ($this->user && in_array($this->user['role'], ['admin', 'superadmin'])) {
            return $this->redirect('/dashboard', navigate: true);
        }
    }
};
