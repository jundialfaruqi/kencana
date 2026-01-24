<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts.auth.app')] #[Title('Register')] class extends Component {
    public $ready = false;

    public function load()
    {
        $this->ready = true;
    }
};
