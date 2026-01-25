<?php

use Livewire\Component;

new class extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        sleep(1);
        $this->readyToLoad = true;
        $this->dispatch('map-ready');
    }
};
