<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::public.app')] #[Title('Pesan Arena')] class extends Component
{
    public bool $ready = false;

    public function load()
    {
        sleep(1);
        $this->ready = true;
    }
};
