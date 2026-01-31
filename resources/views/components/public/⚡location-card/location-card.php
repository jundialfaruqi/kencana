<?php

use Livewire\Component;

new class extends Component
{
    public $readyToLoad = false;
    public $apiBase = '';

    public function mount()
    {
        $this->apiBase = rtrim(config('services.api.base_url'), '/');
    }

    public function load()
    {
        // sleep(1);
        $this->readyToLoad = true;
        $this->dispatch('map-ready');
    }
};
