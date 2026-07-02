<?php

use Livewire\Component;

new class extends Component
{

    public $apiBase = '';

    public function mount()
    {
        $this->apiBase = rtrim(config('services.api.base_url'), '/');
    }


};
