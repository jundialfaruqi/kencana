<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::landing-page.app')] #[Title('Pesan Arena')] class extends Component
{
    public bool $ready = false;

    public function load()
    {
        $this->ready = true;
    }
};
