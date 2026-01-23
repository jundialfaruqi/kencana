<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::landing-page.app')] class extends Component
{
    public bool $ready = false;

    public function load()
    {
        $this->ready = true;
    }
};
