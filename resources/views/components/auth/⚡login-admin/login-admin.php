<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::login-admin.app')] #[Title('Login Admin')] class extends Component {
    public $ready = false;
    public $showPassword = false;

    public function load()
    {
        $this->ready = true;
    }
};
