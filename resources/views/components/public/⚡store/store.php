<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts::public.app')] #[Title('Store')] class extends Component
{
    public $isLoading = true;

    public function loadStore()
    {
        // Simulasi loading data produk nanti
        sleep(1);
        $this->isLoading = false;
    }
};
